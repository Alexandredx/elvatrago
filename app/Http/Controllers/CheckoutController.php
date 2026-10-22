<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CulqiPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index(CulqiPaymentService $culqi)
    {
        if (!auth()->check()) {
            session()->put('url.intended', route('checkout.index'));
            return redirect()->route('login')->with('error', 'Debes iniciar sesión o registrarte para realizar el pedido.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $user = auth()->user();
        $culqiPublicKey = $culqi->getPublicKey();

        return view('tienda.checkout', compact('cart', 'subtotal', 'user', 'culqiPublicKey'));
    }

    public function process(Request $request, CulqiPaymentService $culqi)
    {
        if (!auth()->check()) {
            session()->put('url.intended', route('checkout.index'));
            return redirect()->route('login')->with('error', 'Debes iniciar sesión o registrarte para procesar tu pedido.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $rules = [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:tarjeta,yape',
            'terms' => 'accepted',
        ];

        if ($request->input('payment_method') === 'tarjeta') {
            $rules['card_number'] = 'required|string|min:15|max:25';
            $rules['card_holder'] = 'required|string|max:255';
            $rules['card_expiry'] = 'required|string|max:10';
            $rules['card_cvv'] = 'required|string|min:3|max:4';
        } else {
            $rules['yape_phone'] = 'required|string|min:9|max:15';
            $rules['yape_code'] = 'required|string|min:4|max:20';
        }

        $request->validate($rules, [
            'payment_method.required' => 'Debes seleccionar un método de pago.',
            'payment_method.in' => 'El método de pago debe ser Tarjeta o Yape.',
            'terms.accepted' => 'Debes declarar que eres mayor de edad y aceptar los Términos y Condiciones y la Política de Privacidad para continuar.',
            'card_number.required' => 'Ingresa el número de tu tarjeta.',
            'card_holder.required' => 'Ingresa el titular de la tarjeta.',
            'card_expiry.required' => 'Ingresa la fecha de vencimiento (MM/AA).',
            'card_cvv.required' => 'Ingresa el código CVV.',
            'yape_phone.required' => 'Ingresa el número celular de Yape.',
            'yape_code.required' => 'Ingresa el código o número de operación de Yape.',
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $orderNumber = 'ORD-' . strtoupper(Str::random(8));
        $currency = session('currency', 'PEN');
        $chargeAmount = $currency === 'PEN' ? round($subtotal * 3.75, 2) : (float) $subtotal;

        // Procesar pago seguro contra la API de Culqi
        $paymentResult = $culqi->process(
            method: $request->payment_method,
            paymentData: $request->only(['card_number', 'card_holder', 'card_expiry', 'card_cvv', 'yape_phone', 'yape_code', 'token_id']),
            amount: $chargeAmount,
            currency: $currency,
            email: $request->customer_email,
            orderNumber: $orderNumber,
            customerData: [
                'name' => $request->customer_name,
                'phone' => $request->customer_phone,
                'address' => $request->shipping_address,
            ]
        );

        if (!$paymentResult['success']) {
            return back()->withInput()->with('error', $paymentResult['message']);
        }

        // Create Order
        $order = Order::create([
            'user_id' => auth()->id(),
            'order_number' => $orderNumber,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'total_amount' => $chargeAmount,
            'payment_method' => $request->payment_method,
            'payment_reference' => $paymentResult['reference'],
            'payment_id' => $paymentResult['charge_id'],
            'status' => 'confirmed',
        ]);

        // Create Order Items & reduce stock
        foreach ($cart as $key => $item) {
            $productId = $item['product_id'] ?? $key;
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'product_title' => $item['title'],
                'size' => $item['size'] ?? null,
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            $product = Product::find($productId);
            if ($product) {
                $product->decrement('stock', $item['quantity']);
            }
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success($orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        return view('tienda.success', compact('order'));
    }
}
