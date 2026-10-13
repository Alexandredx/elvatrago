@extends('layouts.app')

@section('title', 'Comprobante de Pedido ' . $order->order_number . ' - GlobalClick')

@section('content')
<div class="main-container" style="padding-top: 2.5rem; padding-bottom: 5rem; max-width: 960px; margin: 0 auto;">
    
    <!-- Enlace Volver -->
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('client.orders.index') }}" style="color: #94a3b8; font-size: 0.9rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
            &larr; Volver a Mis Pedidos
        </a>
    </div>

    <!-- Encabezado con estado -->
    <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.5rem; padding: 2rem; margin-bottom: 2rem; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3);">
        <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
            <div>
                <span style="font-size: 0.8rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; letter-spacing: 0.05em;">Comprobante de Compra</span>
                <h1 style="font-size: 2rem; font-weight: 800; color: #ffffff; margin-top: 0.25rem;">
                    Pedido: <span style="color: #fb923c;">{{ $order->order_number }}</span>
                </h1>
                <p style="color: #94a3b8; font-size: 0.9rem; margin-top: 0.35rem;">
                    Realizado el {{ $order->created_at->format('d/m/Y \a \l\a\s H:i') }}
                </p>
            </div>

            <div>
                @if($order->status === 'completed')
                    <span style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.5); color: #34d399; padding: 0.5rem 1.25rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.4rem;">
                        <i data-feather="check-circle" style="width: 16px; height: 16px;"></i> Recibido / Entregado
                    </span>
                @elseif($order->status === 'processing')
                    <span style="background: rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.5); color: #60a5fa; padding: 0.5rem 1.25rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.4rem;">
                        <i data-feather="truck" style="width: 16px; height: 16px;"></i> En Camino / Procesando
                    </span>
                @elseif($order->status === 'pending')
                    <span style="background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(245, 158, 11, 0.5); color: #fbbf24; padding: 0.5rem 1.25rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.4rem;">
                        <i data-feather="clock" style="width: 16px; height: 16px;"></i> En Preparación
                    </span>
                @elseif($order->status === 'cancelled')
                    <span style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.5); color: #f87171; padding: 0.5rem 1.25rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.4rem;">
                        <i data-feather="x-circle" style="width: 16px; height: 16px;"></i> Cancelado
                    </span>
                @endif
            </div>
        </div>

        <!-- Barra de Progreso del Pedido -->
        <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 1rem; padding: 1.5rem;">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; text-align: center; position: relative;">
                
                <!-- Paso 1: Pedido Registrado -->
                <div>
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #10b981; color: #ffffff; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem; font-weight: 800;">
                        <i data-feather="check" style="width: 20px; height: 20px;"></i>
                    </div>
                    <div style="font-weight: 700; color: #ffffff; font-size: 0.9rem;">1. Pedido Confirmado</div>
                    <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.2rem;">Pago y orden registrados</div>
                </div>

                <!-- Paso 2: En Preparación / Camino -->
                <div>
                    @php
                        $step2Done = in_array($order->status, ['processing', 'completed']);
                    @endphp
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: {{ $step2Done ? '#10b981' : ($order->status === 'pending' ? '#f59e0b' : 'rgba(255,255,255,0.1)') }}; color: #ffffff; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem; font-weight: 800;">
                        @if($step2Done)
                            <i data-feather="check" style="width: 20px; height: 20px;"></i>
                        @else
                            <i data-feather="package" style="width: 18px; height: 18px;"></i>
                        @endif
                    </div>
                    <div style="font-weight: 700; color: {{ $step2Done || $order->status === 'pending' ? '#ffffff' : '#64748b' }}; font-size: 0.9rem;">
                        2. En Despacho
                    </div>
                    <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.2rem;">
                        {{ $step2Done ? 'Empacado y enviado' : 'Preparando tus artículos' }}
                    </div>
                </div>

                <!-- Paso 3: Recibido / Entregado -->
                <div>
                    @php
                        $step3Done = $order->status === 'completed';
                    @endphp
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: {{ $step3Done ? '#10b981' : 'rgba(255,255,255,0.1)' }}; color: #ffffff; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem; font-weight: 800;">
                        @if($step3Done)
                            <i data-feather="check" style="width: 20px; height: 20px;"></i>
                        @else
                            <i data-feather="home" style="width: 18px; height: 18px;"></i>
                        @endif
                    </div>
                    <div style="font-weight: 700; color: {{ $step3Done ? '#ffffff' : '#64748b' }}; font-size: 0.9rem;">
                        3. Entregado
                    </div>
                    <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.2rem;">
                        {{ $step3Done ? 'Pedido recibido con éxito' : 'Por entregar en destino' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Artículos y Dirección de Entrega -->
    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
        
        <!-- Artículos Comprados -->
        <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
            <h2 style="font-size: 1.2rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="shopping-bag" style="color: #f97316; width: 20px; height: 20px;"></i>
                Artículos Comprados ({{ $order->items->count() }})
            </h2>

            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                @foreach($order->items as $item)
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 1rem; background: rgba(15, 23, 42, 0.6); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.04);">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            @if($item->product && $item->product->primary_image_url)
                                <img src="{{ $item->product->primary_image_url }}" alt="" style="width: 58px; height: 58px; object-fit: cover; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1);">
                            @else
                                <div style="width: 58px; height: 58px; border-radius: 0.5rem; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: #64748b;">
                                    <i data-feather="package" style="width: 24px; height: 24px;"></i>
                                </div>
                            @endif

                            <div>
                                <div style="font-weight: 700; color: #ffffff; font-size: 0.95rem;">
                                    @if($item->product)
                                        <a href="{{ route('shop.show', $item->product->slug) }}" style="color: inherit; text-decoration: none;">
                                            {{ $item->product_title }}
                                        </a>
                                    @else
                                        {{ $item->product_title }}
                                    @endif
                                </div>
                                <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.2rem;">
                                    {{ $item->quantity }} x ${{ number_format($item->price, 2) }}
                                </div>
                            </div>
                        </div>

                        <div style="font-weight: 800; font-size: 1.05rem; color: #ffffff;">
                            ${{ number_format($item->price * $item->quantity, 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Resumen de Costos -->
            <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem; display: flex; flex-direction: column; gap: 0.5rem; font-size: 0.95rem;">
                <div style="display: flex; justify-content: space-between; color: #94a3b8;">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between; color: #94a3b8;">
                    <span>Envío</span>
                    <span style="color: #34d399; font-weight: 700;">GRATIS</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 800; color: #ffffff; padding-top: 0.75rem; border-top: 1px solid rgba(255,255,255,0.08);">
                    <span>Total Pagado:</span>
                    <span style="color: #34d399;">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Datos de Entrega y Devoluciones -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Datos de Entrega -->
            <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
                <h3 style="font-size: 1.05rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="map-pin" style="color: #fb923c; width: 18px; height: 18px;"></i>
                    Dirección de Entrega
                </h3>

                <div style="background: rgba(15, 23, 42, 0.6); padding: 1rem; border-radius: 0.75rem; font-size: 0.9rem; line-height: 1.6; color: #cbd5e1; border: 1px solid rgba(255,255,255,0.04);">
                    <strong style="color: #ffffff;">{{ $order->customer_name }}</strong><br>
                    {{ $order->shipping_address }}<br>
                    <span style="color: #94a3b8; font-size: 0.85rem;">Teléfono: {{ $order->customer_phone ?: 'No registrado' }}</span><br>
                    <span style="color: #94a3b8; font-size: 0.85rem;">Email: {{ $order->customer_email }}</span>
                </div>
            </div>

            <!-- Sección de Devolución -->
            <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
                <h3 style="font-size: 1.05rem; font-weight: 700; color: #ffffff; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="rotate-ccw" style="color: #f59e0b; width: 18px; height: 18px;"></i>
                    Devoluciones y Garantía
                </h3>

                @php
                    $returnReq = $order->returnRequests->first();
                @endphp

                @if($returnReq)
                    <div style="background: rgba(15, 23, 42, 0.6); padding: 1rem; border-radius: 0.75rem; border: 1px solid rgba(245,158,11,0.3); font-size: 0.85rem;">
                        <div style="color: #fbbf24; font-weight: 700; margin-bottom: 0.35rem;">
                            Solicitud {{ $returnReq->return_number }}
                        </div>
                        <div style="color: #cbd5e1;">
                            Estado: <strong style="text-transform: uppercase;">{{ $returnReq->status }}</strong>
                        </div>
                        <div style="color: #94a3b8; margin-top: 0.25rem;">
                            Motivo: {{ $returnReq->reason }}
                        </div>
                        @if($returnReq->admin_notes)
                            <div style="margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px solid rgba(255,255,255,0.08); color: #fdba74;">
                                <strong>Nota del soporte:</strong> {{ $returnReq->admin_notes }}
                            </div>
                        @endif
                    </div>
                @else
                    <p style="font-size: 0.85rem; color: #94a3b8; line-height: 1.5; margin-bottom: 1rem;">
                        Si recibiste tu producto y presentas algún inconveniente o deseas devolverlo, puedes solicitar una devolución.
                    </p>
                    <a href="{{ route('returns.public.create') }}?order={{ $order->order_number }}" 
                       style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; padding: 0.75rem; background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); color: #fca5a5; border-radius: 0.75rem; font-size: 0.85rem; font-weight: 700; text-decoration: none;">
                        <i data-feather="rotate-ccw" style="width: 15px; height: 15px;"></i> Solicitar Devolución
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
