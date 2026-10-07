<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $orders = Order::with('items')->latest()->paginate(15);
        return view('pedidos.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('items.product');
        return view('pedidos.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);
        return back()->with('success', 'Estado de la orden actualizado.');
    }
}
