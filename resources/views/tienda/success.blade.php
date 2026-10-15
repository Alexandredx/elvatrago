@extends('layouts.app')

@section('title', 'Pedido Confirmado - GlobalClick')

@section('content')
<div style="max-width: 700px; margin: 4rem auto; padding: 0 1.5rem; text-align: center;">
    <div style="width: 80px; height: 80px; background: rgba(16, 185, 129, 0.15); border: 2px solid #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #34d399;">
        <i data-feather="check" style="width: 44px; height: 44px;"></i>
    </div>

    <h1 style="font-size: 2.25rem; font-weight: 800; color: #ffffff; margin-bottom: 0.5rem;">¡Pedido Realizado con Éxito!</h1>
    <p style="color: #94a3b8; font-size: 1.05rem; margin-bottom: 2rem;">
        Gracias por tu compra. Hemos registrado tu pedido y estamos preparando tu paquete.
    </p>

    <!-- Order Summary Card -->
    <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem; text-align: left; margin-bottom: 2.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; padding-bottom: 1rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); margin-bottom: 1.25rem;">
            <div>
                <span style="font-size: 0.8rem; color: #94a3b8; text-transform: uppercase;">Número de Orden</span>
                <div style="font-size: 1.25rem; font-weight: 800; color: #f97316;">{{ $order->order_number }}</div>
            </div>
            <span style="{{ $order->status_badge_style }} padding: 0.35rem 0.85rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.35rem;">
                <i data-feather="{{ $order->status_badge_icon }}" style="width: 14px; height: 14px;"></i>
                {{ $order->status_label }}
            </span>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem; font-size: 0.9rem; color: #cbd5e1;">
            <div>
                <strong>Cliente:</strong> {{ $order->customer_name }}<br>
                <strong>Email:</strong> {{ $order->customer_email }}<br>
                <strong>Teléfono:</strong> {{ $order->customer_phone }}
            </div>
            <div>
                <strong>Dirección de Envío:</strong><br>
                {{ $order->shipping_address }}<br><br>
                <strong>Medio de Pago:</strong><br>
                @if($order->payment_method === 'yape')
                    <span style="display: inline-flex; align-items: center; gap: 0.35rem; background: rgba(116, 34, 132, 0.3); border: 1px solid rgba(116, 34, 132, 0.6); color: #00d2c4; font-weight: 700; font-size: 0.8rem; padding: 0.2rem 0.55rem; border-radius: 0.4rem; margin-top: 0.2rem;">
                        <i data-feather="smartphone" style="width: 13px; height: 13px;"></i> Yape (BCP)
                    </span>
                @else
                    <span style="display: inline-flex; align-items: center; gap: 0.35rem; background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.5); color: #fdba74; font-weight: 700; font-size: 0.8rem; padding: 0.2rem 0.55rem; border-radius: 0.4rem; margin-top: 0.2rem;">
                        <i data-feather="credit-card" style="width: 13px; height: 13px;"></i> Tarjeta de Débito / Crédito
                    </span>
                @endif
                @if($order->payment_reference)
                    <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.3rem;">
                        {{ $order->payment_reference }}
                    </div>
                @endif
                @if($order->payment_id)
                    <div style="font-size: 0.75rem; color: #34d399; margin-top: 0.25rem; display: flex; align-items: center; gap: 0.25rem;">
                        <i data-feather="check-circle" style="width: 12px; height: 12px;"></i> Transacción Culqi: {{ $order->payment_id }}
                    </div>
                @endif
            </div>
        </div>

        <div style="font-weight: 700; color: #ffffff; margin-bottom: 0.75rem;">Detalle de Artículos:</div>
        <div style="display: flex; flex-direction: column; gap: 0.5rem; margin-bottom: 1.25rem;">
            @foreach($order->items as $item)
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: #94a3b8;">
                    <span>{{ $item->quantity }}x {{ $item->product_title }}</span>
                    <span style="color: #ffffff; font-weight: 600;">@money($item->price * $item->quantity)</span>
                </div>
            @endforeach
        </div>

        <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 800; color: #ffffff; padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.08);">
            <span>Total Pagado:</span>
            <span style="color: #34d399;">@money($order->total_amount)</span>
        </div>
    </div>

    <a href="{{ route('shop.index') }}" class="pill-item active" style="display: inline-block; padding: 0.85rem 2rem; font-size: 1rem;">
        Volver a la Tienda
    </a>
</div>
@endsection
