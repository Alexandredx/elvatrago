@extends('layouts.app')

@section('title', 'Pedido Confirmado - GlobalClick')

@section('content')
<div style="max-width: 700px; margin: 4rem auto; padding: 0 1.5rem; text-align: center;">
    <div style="width: 80px; height: 80px; background: rgba(16, 185, 129, 0.15); border: 2px solid #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #34d399;">
        <i data-feather="check" style="width: 44px; height: 44px;"></i>
    </div>

    <h1 style="font-size: 2.25rem; font-weight: 800; color: #ffffff; margin-bottom: 0.5rem; display: flex; align-items: center; justify-content: center; gap: 0.6rem;">
        ¡Pedido Confirmado!
    </h1>
    <p style="color: #94a3b8; font-size: 1.05rem; margin-bottom: 2rem;">
        ¡Muchas gracias por tu compra! Tu pago ha sido aprobado exitosamente y tu pedido ha quedado registrado como <strong style="color: #38bdf8;">Pedido Confirmado</strong>.
    </p>

    <!-- Barra de Seguimiento del Pedido (5 Fases) -->
    @php
        $currentStep = $order->status_step;
        $steps = [
            1 => ['name' => '1. Pedido Confirmado', 'desc' => 'Pago aprobado y orden registrada', 'icon' => 'check-circle'],
            2 => ['name' => '2. Revisado por el personal', 'desc' => 'Verificación por el administrador', 'icon' => 'user-check'],
            3 => ['name' => '3. Datos Confirmados', 'desc' => 'Datos de envío y entrega confirmados', 'icon' => 'shield'],
            4 => ['name' => '4. Enviado', 'desc' => 'En camino con la mensajería', 'icon' => 'truck'],
            5 => ['name' => '5. Entregado', 'desc' => 'Recibido en tu domicilio', 'icon' => 'home'],
        ];
        $progressPercent = max(0, min(100, (($currentStep - 1) / 4) * 100));
    @endphp

    <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem 1rem; margin-bottom: 2rem; overflow-x: auto;">
        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; margin-bottom: 1.25rem; text-align: left; display: flex; align-items: center; gap: 0.5rem;">
            <i data-feather="clock" style="width: 14px; height: 14px; color: #f97316;"></i> Estado del Seguimiento
        </div>
        <div style="display: grid; grid-template-columns: repeat(5, minmax(110px, 1fr)); gap: 0.5rem; text-align: center; position: relative;">
            <!-- Barra conectora -->
            <div style="position: absolute; top: 19px; left: 8%; right: 8%; height: 3px; background: rgba(255,255,255,0.08); z-index: 0; border-radius: 9999px;">
                <div style="height: 100%; background: linear-gradient(90deg, #10b981, #f97316); width: {{ $progressPercent }}%; border-radius: 9999px;"></div>
            </div>

            @foreach($steps as $num => $step)
                @php
                    $isPast = $currentStep > $num;
                    $isCurrent = $currentStep === $num;
                @endphp
                <div style="display: flex; flex-direction: column; align-items: center; position: relative; z-index: 1;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem; font-weight: 800;
                        @if($isPast)
                            background: #10b981; color: #ffffff; border: 2px solid #34d399;
                        @elseif($isCurrent)
                            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: #ffffff; box-shadow: 0 0 16px rgba(249, 115, 22, 0.6); border: 2px solid #fdba74;
                        @else
                            background: #0f172a; color: #64748b; border: 2px solid rgba(255, 255, 255, 0.12);
                        @endif
                    ">
                        @if($isPast)
                            <i data-feather="check" style="width: 18px; height: 18px;"></i>
                        @else
                            <i data-feather="{{ $step['icon'] }}" style="width: 18px; height: 18px;"></i>
                        @endif
                    </div>
                    <div style="font-weight: 700; font-size: 0.78rem; line-height: 1.2; margin-bottom: 0.2rem;
                        @if($isCurrent) color: #fb923c;
                        @elseif($isPast) color: #ffffff;
                        @else color: #64748b;
                        @endif
                    ">
                        {{ $step['name'] }}
                    </div>
                    <div style="font-size: 0.68rem; line-height: 1.2;
                        @if($isCurrent) color: #fdba74;
                        @elseif($isPast) color: #94a3b8;
                        @else color: #475569;
                        @endif
                    ">
                        {{ $step['desc'] }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

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
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: #94a3b8; align-items: center;">
                    <div>
                        <span>{{ $item->quantity }}x {{ $item->product_title }}</span>
                        @if(!empty($item->size))
                            <span style="background: rgba(249, 115, 22, 0.2); color: #fdba74; font-size: 0.75rem; font-weight: 700; padding: 0.1rem 0.45rem; border-radius: 0.3rem; margin-left: 0.4rem; display: inline-block;">
                                Talla: {{ $item->size }}
                            </span>
                        @endif
                    </div>
                    <span style="color: #ffffff; font-weight: 600;">@money($item->price * $item->quantity)</span>
                </div>
            @endforeach
        </div>

        <div style="display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 800; color: #ffffff; padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.08);">
            <span>Total Pagado:</span>
            <span style="color: #34d399;">@money($order->total_amount)</span>
        </div>
    </div>

    <!-- Botones de Acción -->
    <div style="display: flex; justify-content: center; align-items: center; gap: 1rem; flex-wrap: wrap;">
        <a href="{{ route('client.orders.show', $order->order_number) }}" class="pill-item active" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.85rem 1.75rem; font-size: 0.95rem; text-decoration: none;">
            <i data-feather="file-text" style="width: 16px; height: 16px;"></i> Ver Seguimiento del Pedido
        </a>

        <a href="{{ route('client.orders.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.85rem 1.75rem; font-size: 0.95rem; background: rgba(30, 41, 59, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 9999px; color: #ffffff; text-decoration: none; font-weight: 700;">
            <i data-feather="package" style="width: 16px; height: 16px;"></i> Mis Pedidos
        </a>

        <a href="{{ route('shop.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.85rem 1.5rem; font-size: 0.95rem; color: #94a3b8; text-decoration: none; font-weight: 600;">
            <i data-feather="shopping-bag" style="width: 16px; height: 16px;"></i> Ir a la Tienda
        </a>
    </div>
</div>
@endsection
