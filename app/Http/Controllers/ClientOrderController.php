<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientOrderController extends Controller
{
    /**
     * Muestra el listado de pedidos comprados e historial de pedidos pasados del cliente.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $filter = $request->get('filter', 'all'); // 'all', 'active', 'completed', 'cancelled'

        $baseQuery = Order::with(['items.product.images', 'returnRequests'])
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhere('customer_email', $user->email);
            })
            ->latest();

        // Conteo de pedidos para las pestañas
        $activeStatuses = ['confirmed', 'reviewed', 'data_confirmed', 'shipped', 'pending', 'processing'];
        $completedStatuses = ['delivered', 'completed'];

        $counts = [
            'all' => (clone $baseQuery)->count(),
            'active' => (clone $baseQuery)->whereIn('status', $activeStatuses)->count(),
            'completed' => (clone $baseQuery)->whereIn('status', $completedStatuses)->count(),
            'cancelled' => (clone $baseQuery)->where('status', 'cancelled')->count(),
        ];

        // Aplicar filtro si se seleccionó
        if ($filter === 'active') {
            $baseQuery->whereIn('status', $activeStatuses);
        } elseif ($filter === 'completed') {
            $baseQuery->whereIn('status', $completedStatuses);
        } elseif ($filter === 'cancelled') {
            $baseQuery->where('status', 'cancelled');
        }

        $orders = $baseQuery->paginate(8)->withQueryString();

        return view('cliente.pedidos.index', compact('orders', 'counts', 'filter'));
    }

    /**
     * Muestra el detalle completo de un pedido específico del cliente.
     */
    public function show($orderNumber)
    {
        $user = Auth::user();

        $order = Order::with(['items.product.images', 'returnRequests'])
            ->where('order_number', $orderNumber)
            ->where(function ($query) use ($user) {
                // Si es admin puede ver cualquier orden, si es cliente solo la suya
                if (!$user->isAdmin()) {
                    $query->where('user_id', $user->id)
                          ->orWhere('customer_email', $user->email);
                }
            })
            ->firstOrFail();

        return view('cliente.pedidos.show', compact('order'));
    }
}
