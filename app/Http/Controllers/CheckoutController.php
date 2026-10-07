<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        return view('tienda.checkout', compact('cart', 'subtotal'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Tu carrito está vacío.');
        }

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:50',
            'shipping_address' => 'required|string',
        ]);

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        // Create Order
        $order = Order::create([
            'order_number' => 'ORD-' . strtoupper(Str::random(8)),
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'shipping_address' => $request->shipping_address,
            'total_amount' => $subtotal,
            'status' => 'pending',
        ]);

        // Create Order Items & reduce stock
        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'product_title' => $item['title'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);

            $product = Product::find($id);
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
