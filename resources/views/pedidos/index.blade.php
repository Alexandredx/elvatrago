@extends('layouts.admin')

@section('title', 'Gestión de Órdenes - Admin')

@section('content') 
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">Órdenes de Venta Directa</h1>
    <p style="color: #94a3b8; font-size: 0.9rem;">Revisa y actualiza los pedidos de ventas directas realizados en la tienda.</p>
</div>

<div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
        <thead>
            <tr style="background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.75rem; text-transform: uppercase; color: #94a3b8;">
                <th style="padding: 1rem 1.25rem;">Nº Orden</th>
                <th style="padding: 1rem 1.25rem;">Cliente</th>
                <th style="padding: 1rem 1.25rem;">Total</th>
                <th style="padding: 1rem 1.25rem;">Estado</th>
                <th style="padding: 1rem 1.25rem;">Fecha</th>
                <th style="padding: 1rem 1.25rem; text-align: center;">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                    <td style="padding: 1rem 1.25rem; font-weight: 800; color: #f97316;">
                        {{ $order->order_number }}
                    </td>
                    <td style="padding: 1rem 1.25rem;">
                        <div style="font-weight: 700; color: #ffffff;">{{ $order->customer_name }}</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">{{ $order->customer_email }}</div>
                    </td>
                    <td style="padding: 1rem 1.25rem; font-weight: 800; color: #34d399;">
                        ${{ number_format($order->total_amount, 2) }}
                        <div style="margin-top: 0.25rem;">
                            <span style="font-size: 0.7rem; font-weight: 700; color: {{ $order->payment_method === 'yape' ? '#00d2c4' : '#fdba74' }}; background: {{ $order->payment_method === 'yape' ? 'rgba(116, 34, 132, 0.3)' : 'rgba(249, 115, 22, 0.15)' }}; padding: 0.1rem 0.4rem; border-radius: 0.25rem;">
                                {{ $order->payment_method === 'yape' ? 'Yape' : 'Tarjeta' }}
                            </span>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.25rem;">
                        <span style="{{ $order->status_badge_style }} padding: 0.35rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.3rem;">
                            <i data-feather="{{ $order->status_badge_icon }}" style="width: 13px; height: 13px;"></i>
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td style="padding: 1rem 1.25rem; color: #94a3b8; font-size: 0.85rem;">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </td>
                    <td style="padding: 1rem 1.25rem; text-align: center;">
                        <a href="{{ route('admin.orders.show', $order->id) }}" style="background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.4); color: #fdba74; padding: 0.35rem 0.75rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600;">
                            Ver Detalle
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="padding: 1rem 1.25rem;">
        {{ $orders->links() }}
    </div>
</div>
@endsection
