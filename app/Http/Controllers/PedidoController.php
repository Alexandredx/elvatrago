<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'all');

        $baseQuery = Order::with('items')->latest();

        $counts = [
            'all' => (clone $baseQuery)->count(),
            'to_review' => (clone $baseQuery)->whereIn('status', ['confirmed', 'reviewed', 'pending'])->count(),
            'data_confirmed' => (clone $baseQuery)->where('status', 'data_confirmed')->count(),
            'shipped' => (clone $baseQuery)->whereIn('status', ['shipped', 'processing'])->count(),
            'delivered' => (clone $baseQuery)->whereIn('status', ['delivered', 'completed'])->count(),
            'cancelled' => (clone $baseQuery)->where('status', 'cancelled')->count(),
        ];

        if ($filter === 'to_review') {
            $baseQuery->whereIn('status', ['confirmed', 'reviewed', 'pending']);
        } elseif ($filter === 'data_confirmed') {
            $baseQuery->where('status', 'data_confirmed');
        } elseif ($filter === 'shipped') {
            $baseQuery->whereIn('status', ['shipped', 'processing']);
        } elseif ($filter === 'delivered') {
            $baseQuery->whereIn('status', ['delivered', 'completed']);
        } elseif ($filter === 'cancelled') {
            $baseQuery->where('status', 'cancelled');
        }

        $orders = $baseQuery->paginate(15)->withQueryString();

        return view('pedidos.index', compact('orders', 'counts', 'filter'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user']);
        return view('pedidos.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:confirmed,reviewed,data_confirmed,shipped,delivered,pending,processing,completed,cancelled',
            'shipping_address' => 'nullable|string',
            'customer_phone' => 'nullable|string|max:50',
        ]);

        $data = ['status' => $request->status];

        if ($request->filled('shipping_address')) {
            $data['shipping_address'] = $request->shipping_address;
        }

        if ($request->filled('customer_phone')) {
            $data['customer_phone'] = $request->customer_phone;
        }

        $order->update($data);

        $msg = match($request->status) {
            'data_confirmed' => '¡Datos de envío confirmados exitosamente! La orden ahora está marcada como "Datos Confirmados" para el usuario.',
            'reviewed' => 'El pedido ha sido marcado como "Revisado por el personal".',
            'shipped' => 'El pedido ha sido marcado como "Enviado".',
            'delivered' => 'El pedido ha sido marcado como "Entregado".',
            'cancelled' => 'El pedido ha sido cancelado.',
            default => 'Estado de la orden actualizado exitosamente.',
        };

        return back()->with('success', $msg);
    }
}
