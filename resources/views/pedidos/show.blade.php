@extends('layouts.admin')

@section('title', 'Detalle de Orden ' . $order->order_number . ' - Admin')

@section('content')
<div style="max-width: 900px; margin: 0 auto 3rem;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.orders.index') }}" style="color: #94a3b8; font-size: 0.85rem;">&larr; Volver a lista de órdenes</a>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem; flex-wrap: wrap; gap: 1rem;">
            <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff; margin: 0;">Detalle de Orden: {{ $order->order_number }}</h1>
            <span style="{{ $order->status_badge_style }} padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.35rem;">
                <i data-feather="{{ $order->status_badge_icon }}" style="width: 14px; height: 14px;"></i>
                {{ $order->status_label }}
            </span>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem; align-items: start;">
        <!-- Left: Items & Customer Details -->
        <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem;">
            <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem;">Información del Cliente</h2>
            <div style="font-size: 0.95rem; color: #cbd5e1; line-height: 1.6; margin-bottom: 2rem; background: rgba(15,23,42,0.6); padding: 1.25rem; border-radius: 0.75rem;">
                <strong>Nombre:</strong> {{ $order->customer_name }}<br>
                <strong>Email:</strong> {{ $order->customer_email }}<br>
                <strong>Teléfono:</strong> {{ $order->customer_phone }}<br>
                <strong>Dirección de Envío:</strong> {{ $order->shipping_address }}<br>
                <strong>Medio de Pago:</strong> <span style="color: {{ $order->payment_method === 'yape' ? '#00d2c4' : '#fdba74' }}; font-weight: 700;">{{ $order->payment_method_name }}</span>
                @if($order->payment_reference)
                    <span style="font-size: 0.85rem; color: #94a3b8;">({{ $order->payment_reference }})</span>
                @endif
                @if($order->payment_id)
                    <br><strong>ID Culqi:</strong> <code style="color: #34d399; font-size: 0.8rem; background: rgba(0,0,0,0.3); padding: 0.15rem 0.4rem; border-radius: 0.3rem;">{{ $order->payment_id }}</code>
                @endif
            </div>

            <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem;">Productos Comprados</h2>
            <div style="display: flex; flex-direction: column; gap: 0.85rem; margin-bottom: 1.5rem;">
                @foreach($order->items as $item)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.85rem; background: rgba(15,23,42,0.6); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                        <div>
                            <div style="font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                                <span>{{ $item->product_title }}</span>
                                @if(!empty($item->size))
                                    <span style="background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.4); color: #fdba74; font-size: 0.75rem; font-weight: 700; padding: 0.1rem 0.45rem; border-radius: 0.3rem;">
                                        Talla: {{ $item->size }}
                                    </span>
                                @endif
                            </div>
                            <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.2rem;">Cantidad: {{ $item->quantity }} x ${{ number_format($item->price, 2) }}</div>
                        </div>
                        <div style="font-weight: 800; color: #ffffff;">
                            ${{ number_format($item->price * $item->quantity, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 800; color: #ffffff; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.08);">
                <span>Total de la Orden:</span>
                <span style="color: #34d399;">${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>

        <!-- Right: Status Update Box -->
        <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem;">Actualizar Estado</h3>

            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div style="margin-bottom: 1.25rem;">
                    <select name="status" style="width: 100%; padding: 0.8rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-weight: 600;">
                        <option value="confirmed" {{ in_array($order->status, ['confirmed', 'pending']) ? 'selected' : '' }}>1. Pedido Confirmado</option>
                        <option value="reviewed" {{ $order->status === 'reviewed' ? 'selected' : '' }}>2. Revisado por el personal</option>
                        <option value="data_confirmed" {{ $order->status === 'data_confirmed' ? 'selected' : '' }}>3. Confirmación de sus datos</option>
                        <option value="shipped" {{ in_array($order->status, ['shipped', 'processing']) ? 'selected' : '' }}>4. Enviado (En ruta)</option>
                        <option value="delivered" {{ in_array($order->status, ['delivered', 'completed']) ? 'selected' : '' }}>5. Entregado</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelado</option>
                    </select>
                </div>

                <button type="submit" class="pill-item active" style="width: 100%; padding: 0.8rem; font-weight: 800; border: none; cursor: pointer;">
                    Guardar Estado
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
