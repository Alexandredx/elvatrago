<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            session()->put('url.intended', route('checkout.index'));
            return redirect()->route('login')->with('error', 'Debes iniciar sesión o registrarte para realizar el pedido.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $subtotal = $this->calculateCartSubtotal($cart);
        $user = auth()->user();

        return view('tienda.checkout', compact('cart', 'subtotal', 'user'));
    }

    public function process(Request $request)
    {
        if (!auth()->check()) {
            session()->put('url.intended', route('checkout.index'));
            return redirect()->route('login')->with('error', 'Debes iniciar sesión o registrarte para procesar tu pedido.');
        }

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
            'terms' => 'accepted',
        ], [
            'terms.accepted' => 'Debes declarar que eres mayor de edad y aceptar los Términos y Condiciones y la Política de Privacidad para continuar.',
        ]);

        $subtotal = $this->calculateCartSubtotal($cart);
        $currency = session('currency', 'PEN');
        $chargeAmount = $currency === 'PEN' ? round($subtotal * 3.75, 2) : (float) $subtotal;
        $orderNumber = 'ORD-' . strtoupper(Str::random(8));

        $order = DB::transaction(function () use ($cart, $validated, $chargeAmount, $orderNumber) {
            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $orderNumber,
                'customer_name' => $validated['customer_name'],
                'customer_email' => $validated['customer_email'],
                'customer_phone' => $validated['customer_phone'],
                'shipping_address' => $validated['shipping_address'],
                'total_amount' => $chargeAmount,
                'payment_method' => 'por_coordinar',
                'payment_reference' => 'Pedido registrado (pago por coordinar)',
                'payment_id' => null,
                'status' => 'confirmed',
            ]);

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

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('checkout.success', $order->order_number);
    }

    public function success($orderNumber)
    {
        $order = Order::with('items')->where('order_number', $orderNumber)->firstOrFail();
        return view('tienda.success', compact('order'));
    }

    protected function calculateCartSubtotal(array $cart): float
    {
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return (float) $subtotal;
    }
}
