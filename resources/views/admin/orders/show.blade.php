@extends('layouts.admin')

@section('title', 'Detalle de Orden ' . $order->order_number . ' - Admin')

@section('content')
<div style="max-width: 900px; margin: 0 auto 3rem;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.orders.index') }}" style="color: #94a3b8; font-size: 0.85rem;">&larr; Volver a lista de órdenes</a>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff; margin-top: 0.5rem;">Detalle de Orden: {{ $order->order_number }}</h1>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 300px; gap: 2rem; align-items: start;">
        <!-- Left: Items & Customer Details -->
        <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem;">
            <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem;">Información del Cliente</h2>
            <div style="font-size: 0.95rem; color: #cbd5e1; line-height: 1.6; margin-bottom: 2rem; background: rgba(15,23,42,0.6); padding: 1.25rem; border-radius: 0.75rem;">
                <strong>Nombre:</strong> {{ $order->customer_name }}<br>
                <strong>Email:</strong> {{ $order->customer_email }}<br>
                <strong>Teléfono:</strong> {{ $order->customer_phone }}<br>
                <strong>Dirección de Envío:</strong> {{ $order->shipping_address }}
            </div>

            <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem;">Productos Comprados</h2>
            <div style="display: flex; flex-direction: column; gap: 0.85rem; margin-bottom: 1.5rem;">
                @foreach($order->items as $item)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.85rem; background: rgba(15,23,42,0.6); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                        <div>
                            <div style="font-weight: 700; color: #ffffff;">{{ $item->product_title }}</div>
                            <div style="font-size: 0.8rem; color: #94a3b8;">Cantidad: {{ $item->quantity }} x ${{ number_format($item->price, 2) }}</div>
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
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending (Pendiente)</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing (En proceso)</option>
                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed (Completado)</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled (Cancelado)</option>
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
