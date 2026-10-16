@extends('layouts.admin')

@section('title', 'Gestión de Órdenes - Admin')

@section('content') 
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff; display: flex; align-items: center; gap: 0.65rem;">
            <i data-feather="package" style="color: #f97316; width: 28px; height: 28px;"></i>
            Órdenes de Venta Directa
        </h1>
        <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 0.25rem;">
            Revisa pedidos entrantes, confirma datos de envío y actualiza el seguimiento para los clientes.
        </p>
    </div>
</div>

<!-- Pestañas de Filtros de Estado -->
<div style="display: flex; gap: 0.65rem; flex-wrap: wrap; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 1rem;">
    <a href="{{ route('admin.orders.index', ['filter' => 'all']) }}" 
       style="padding: 0.55rem 1.15rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
              background: {{ $filter === 'all' ? 'linear-gradient(135deg, #f97316, #ea580c)' : 'rgba(30, 41, 59, 0.6)' }};
              border: 1px solid {{ $filter === 'all' ? 'transparent' : 'rgba(255, 255, 255, 0.08)' }};
              color: {{ $filter === 'all' ? '#ffffff' : '#94a3b8' }};">
        Todos ({{ $counts['all'] }})
    </a>

    <a href="{{ route('admin.orders.index', ['filter' => 'to_review']) }}" 
       style="padding: 0.55rem 1.15rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
              background: {{ $filter === 'to_review' ? 'linear-gradient(135deg, #3b82f6, #2563eb)' : 'rgba(30, 41, 59, 0.6)' }};
              border: 1px solid {{ $filter === 'to_review' ? 'transparent' : 'rgba(255, 255, 255, 0.08)' }};
              color: {{ $filter === 'to_review' ? '#ffffff' : '#94a3b8' }};">
        ⏳ Por Revisar / Confirmar ({{ $counts['to_review'] }})
    </a>

    <a href="{{ route('admin.orders.index', ['filter' => 'data_confirmed']) }}" 
       style="padding: 0.55rem 1.15rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
              background: {{ $filter === 'data_confirmed' ? 'linear-gradient(135deg, #f59e0b, #d97706)' : 'rgba(30, 41, 59, 0.6)' }};
              border: 1px solid {{ $filter === 'data_confirmed' ? 'transparent' : 'rgba(255, 255, 255, 0.08)' }};
              color: {{ $filter === 'data_confirmed' ? '#ffffff' : '#94a3b8' }};">
        🛡 Datos Confirmados ({{ $counts['data_confirmed'] }})
    </a>

    <a href="{{ route('admin.orders.index', ['filter' => 'shipped']) }}" 
       style="padding: 0.55rem 1.15rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
              background: {{ $filter === 'shipped' ? 'linear-gradient(135deg, #06b6d4, #0891b2)' : 'rgba(30, 41, 59, 0.6)' }};
              border: 1px solid {{ $filter === 'shipped' ? 'transparent' : 'rgba(255, 255, 255, 0.08)' }};
              color: {{ $filter === 'shipped' ? '#ffffff' : '#94a3b8' }};">
        🚚 Enviados ({{ $counts['shipped'] }})
    </a>

    <a href="{{ route('admin.orders.index', ['filter' => 'delivered']) }}" 
       style="padding: 0.55rem 1.15rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
              background: {{ $filter === 'delivered' ? 'linear-gradient(135deg, #10b981, #059669)' : 'rgba(30, 41, 59, 0.6)' }};
              border: 1px solid {{ $filter === 'delivered' ? 'transparent' : 'rgba(255, 255, 255, 0.08)' }};
              color: {{ $filter === 'delivered' ? '#ffffff' : '#94a3b8' }};">
        ✔ Entregados ({{ $counts['delivered'] }})
    </a>

    @if($counts['cancelled'] > 0)
    <a href="{{ route('admin.orders.index', ['filter' => 'cancelled']) }}" 
       style="padding: 0.55rem 1.15rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
              background: {{ $filter === 'cancelled' ? 'rgba(239, 68, 68, 0.3)' : 'rgba(30, 41, 59, 0.6)' }};
              border: 1px solid {{ $filter === 'cancelled' ? 'rgba(239, 68, 68, 0.5)' : 'rgba(255, 255, 255, 0.08)' }};
              color: {{ $filter === 'cancelled' ? '#fca5a5' : '#94a3b8' }};">
        Cancelados ({{ $counts['cancelled'] }})
    </a>
    @endif
</div>

<!-- Tabla de Órdenes -->
<div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3);">
    @if($orders->count() > 0)
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
        <thead>
            <tr style="background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.75rem; text-transform: uppercase; color: #94a3b8;">
                <th style="padding: 1.1rem 1.25rem;">Nº Orden</th>
                <th style="padding: 1.1rem 1.25rem;">Cliente y Dirección</th>
                <th style="padding: 1.1rem 1.25rem;">Total</th>
                <th style="padding: 1.1rem 1.25rem;">Estado</th>
                <th style="padding: 1.1rem 1.25rem;">Fecha</th>
                <th style="padding: 1.1rem 1.25rem; text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05); transition: background 0.15s ease;">
                    <td style="padding: 1.1rem 1.25rem; font-weight: 800; color: #f97316;">
                        <a href="{{ route('admin.orders.show', $order->id) }}" style="color: inherit; text-decoration: none;">
                            {{ $order->order_number }}
                        </a>
                        <div style="font-size: 0.75rem; color: #94a3b8; font-weight: normal; margin-top: 0.2rem;">
                            {{ $order->items->count() }} artículo(s)
                        </div>
                    </td>
                    <td style="padding: 1.1rem 1.25rem;">
                        <div style="font-weight: 700; color: #ffffff;">{{ $order->customer_name }}</div>
                        <div style="font-size: 0.8rem; color: #94a3b8;">{{ $order->customer_phone ?: 'Sin teléfono' }} &bull; {{ $order->customer_email }}</div>
                        <div style="font-size: 0.75rem; color: #fdba74; margin-top: 0.25rem; max-width: 280px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="{{ $order->shipping_address }}">
                            <i data-feather="map-pin" style="width: 11px; height: 11px; vertical-align: middle;"></i> {{ $order->shipping_address }}
                        </div>
                    </td>
                    <td style="padding: 1.1rem 1.25rem; font-weight: 800; color: #34d399;">
                        ${{ number_format($order->total_amount, 2) }}
                        <div style="margin-top: 0.25rem;">
                            <span style="font-size: 0.7rem; font-weight: 700; color: {{ $order->payment_method === 'yape' ? '#00d2c4' : '#fdba74' }}; background: {{ $order->payment_method === 'yape' ? 'rgba(116, 34, 132, 0.3)' : 'rgba(249, 115, 22, 0.15)' }}; padding: 0.1rem 0.4rem; border-radius: 0.25rem;">
                                {{ $order->payment_method === 'yape' ? 'Yape' : 'Tarjeta' }}
                            </span>
                        </div>
                    </td>
                    <td style="padding: 1.1rem 1.25rem;">
                        <span style="{{ $order->status_badge_style }} padding: 0.35rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.3rem;">
                            <i data-feather="{{ $order->status_badge_icon }}" style="width: 13px; height: 13px;"></i>
                            {{ $order->status_label }}
                        </span>
                    </td>
                    <td style="padding: 1.1rem 1.25rem; color: #94a3b8; font-size: 0.85rem;">
                        {{ $order->created_at->format('d/m/Y') }}<br>
                        <span style="font-size: 0.75rem; color: #64748b;">{{ $order->created_at->format('H:i') }}</span>
                    </td>
                    <td style="padding: 1.1rem 1.25rem; text-align: center;">
                        <div style="display: flex; gap: 0.5rem; justify-content: center; align-items: center; flex-wrap: wrap;">
                            <!-- Botón Rápido: Confirmar Datos de Envío si aún no se han confirmado -->
                            @if(in_array($order->status, ['confirmed', 'reviewed', 'pending']))
                                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" style="margin: 0;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="data_confirmed">
                                    <button type="submit" style="background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(245, 158, 11, 0.5); color: #fbbf24; padding: 0.35rem 0.65rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 700; cursor: pointer; display: inline-flex; align-items: center; gap: 0.25rem;" title="Confirmar datos de envío directamente">
                                        <i data-feather="shield" style="width: 12px; height: 12px;"></i> Confirmar Datos
                                    </button>
                                </form>
                            @endif

                            <a href="{{ route('admin.orders.show', $order->id) }}" style="background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.4); color: #fdba74; padding: 0.35rem 0.75rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.3rem;">
                                <i data-feather="eye" style="width: 13px; height: 13px;"></i> Ver Detalle
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="padding: 1.25rem;">
        {{ $orders->links() }}
    </div>
    @else
    <div style="text-align: center; padding: 4rem 2rem; color: #94a3b8;">
        <i data-feather="inbox" style="width: 44px; height: 44px; color: #64748b; margin-bottom: 1rem;"></i>
        <h3 style="font-size: 1.2rem; color: #ffffff; margin-bottom: 0.35rem;">No se encontraron órdenes</h3>
        <p style="font-size: 0.9rem;">No hay órdenes registradas bajo el filtro seleccionado.</p>
    </div>
    @endif
</div>
@endsection
