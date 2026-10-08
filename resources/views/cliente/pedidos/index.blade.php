@extends('layouts.app')

@section('title', 'Mis Pedidos - Elvatrago')

@section('content')
<div class="main-container" style="padding-top: 2.5rem; padding-bottom: 5rem;">
    <!-- Encabezado -->
    <div style="margin-bottom: 2.5rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1.5rem;">
        <div>
            <h1 style="font-size: 2.25rem; font-weight: 800; color: #ffffff; letter-spacing: -0.02em; display: flex; align-items: center; gap: 0.75rem;">
                <i data-feather="package" style="color: #818cf8; width: 32px; height: 32px;"></i>
                Mis Pedidos
            </h1>
            <p style="color: #94a3b8; font-size: 1rem; margin-top: 0.35rem;">
                Consulta el estado de tus compras activas y revisa el historial de tus pedidos pasados ya recibidos.
            </p>
        </div>

        <a href="{{ route('shop.index') }}" class="btn-primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.25rem; font-size: 0.9rem;">
            <i data-feather="shopping-bag" style="width: 16px; height: 16px;"></i>
            Seguir Comprando
        </a>
    </div>

    <!-- Pestañas de Filtros (Historial vs Activos) -->
    <div style="display: flex; gap: 0.65rem; flex-wrap: wrap; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.08); padding-bottom: 1rem;">
        <a href="{{ route('client.orders.index', ['filter' => 'all']) }}" 
           style="padding: 0.6rem 1.25rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
                  background: {{ $filter === 'all' ? 'linear-gradient(135deg, #6366f1, #4f46e5)' : 'rgba(30, 41, 59, 0.6)' }};
                  border: 1px solid {{ $filter === 'all' ? 'transparent' : 'rgba(255, 255, 255, 0.08)' }};
                  color: {{ $filter === 'all' ? '#ffffff' : '#94a3b8' }};">
            Todos ({{ $counts['all'] }})
        </a>

        <a href="{{ route('client.orders.index', ['filter' => 'active']) }}" 
           style="padding: 0.6rem 1.25rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
                  background: {{ $filter === 'active' ? 'linear-gradient(135deg, #f59e0b, #d97706)' : 'rgba(30, 41, 59, 0.6)' }};
                  border: 1px solid {{ $filter === 'active' ? 'transparent' : 'rgba(255, 255, 255, 0.08)' }};
                  color: {{ $filter === 'active' ? '#ffffff' : '#94a3b8' }};">
            ⏳ En Proceso / En Camino ({{ $counts['active'] }})
        </a>

        <a href="{{ route('client.orders.index', ['filter' => 'completed']) }}" 
           style="padding: 0.6rem 1.25rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
                  background: {{ $filter === 'completed' ? 'linear-gradient(135deg, #10b981, #059669)' : 'rgba(30, 41, 59, 0.6)' }};
                  border: 1px solid {{ $filter === 'completed' ? 'transparent' : 'rgba(255, 255, 255, 0.08)' }};
                  color: {{ $filter === 'completed' ? '#ffffff' : '#94a3b8' }};">
            ✔ Recibidos / Pasados ({{ $counts['completed'] }})
        </a>

        @if($counts['cancelled'] > 0)
        <a href="{{ route('client.orders.index', ['filter' => 'cancelled']) }}" 
           style="padding: 0.6rem 1.25rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 700; text-decoration: none; transition: all 0.2s;
                  background: {{ $filter === 'cancelled' ? 'rgba(239, 68, 68, 0.3)' : 'rgba(30, 41, 59, 0.6)' }};
                  border: 1px solid {{ $filter === 'cancelled' ? 'rgba(239, 68, 68, 0.5)' : 'rgba(255, 255, 255, 0.08)' }};
                  color: {{ $filter === 'cancelled' ? '#fca5a5' : '#94a3b8' }};">
            Cancelados ({{ $counts['cancelled'] }})
        </a>
        @endif
    </div>

    <!-- Lista de Pedidos -->
    @if($orders->count() > 0)
        <div style="display: flex; flex-direction: column; gap: 1.75rem;">
            @foreach($orders as $order)
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3); transition: transform 0.2s ease, border-color 0.2s ease;">
                    
                    <!-- Barra superior de la tarjeta de pedido -->
                    <div style="background: rgba(15, 23, 42, 0.7); padding: 1.25rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.06); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                        <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap;">
                            <div>
                                <span style="font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700;">Nº Pedido</span>
                                <div style="font-size: 1.1rem; font-weight: 800; color: #818cf8;">{{ $order->order_number }}</div>
                            </div>

                            <div style="border-left: 1px solid rgba(255,255,255,0.1); padding-left: 1.5rem;">
                                <span style="font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700;">Fecha de Compra</span>
                                <div style="font-size: 0.95rem; font-weight: 600; color: #cbd5e1;">{{ $order->created_at->format('d/m/Y H:i') }}</div>
                            </div>

                            <div style="border-left: 1px solid rgba(255,255,255,0.1); padding-left: 1.5rem;">
                                <span style="font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; font-weight: 700;">Total Pagado</span>
                                <div style="font-size: 1.1rem; font-weight: 800; color: #34d399;">${{ number_format($order->total_amount, 2) }}</div>
                            </div>
                        </div>

                        <!-- Estado del Pedido -->
                        <div>
                            @if($order->status === 'completed')
                                <span style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.5); color: #34d399; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <i data-feather="check-circle" style="width: 14px; height: 14px;"></i> Recibido / Entregado
                                </span>
                            @elseif($order->status === 'processing')
                                <span style="background: rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.5); color: #60a5fa; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <i data-feather="truck" style="width: 14px; height: 14px;"></i> En Camino / Procesando
                                </span>
                            @elseif($order->status === 'pending')
                                <span style="background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(245, 158, 11, 0.5); color: #fbbf24; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <i data-feather="clock" style="width: 14px; height: 14px;"></i> Pendiente / En Preparación
                                </span>
                            @elseif($order->status === 'cancelled')
                                <span style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.5); color: #f87171; padding: 0.45rem 1rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <i data-feather="x-circle" style="width: 14px; height: 14px;"></i> Cancelado
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Cuerpo: Artículos comprados -->
                    <div style="padding: 1.5rem;">
                        <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                            @foreach($order->items as $item)
                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; padding: 0.75rem 1rem; background: rgba(15, 23, 42, 0.5); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.04);">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        @if($item->product && $item->product->primary_image_url)
                                            <img src="{{ $item->product->primary_image_url }}" alt="{{ $item->product_title }}" style="width: 52px; height: 52px; object-fit: cover; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1);">
                                        @else
                                            <div style="width: 52px; height: 52px; border-radius: 0.5rem; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: #64748b;">
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
                                            <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.15rem;">
                                                Cantidad: <strong style="color: #cbd5e1;">{{ $item->quantity }}</strong> &bull; Precio unitario: ${{ number_format($item->price, 2) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div style="font-weight: 800; font-size: 1rem; color: #ffffff;">
                                        ${{ number_format($item->price * $item->quantity, 2) }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Barra de acciones del pedido -->
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; padding-top: 1.25rem; border-top: 1px solid rgba(255, 255, 255, 0.06);">
                            <div style="font-size: 0.85rem; color: #94a3b8; display: flex; align-items: center; gap: 0.5rem;">
                                <i data-feather="map-pin" style="width: 14px; height: 14px; color: #818cf8;"></i>
                                <span>Envío a: <strong style="color: #cbd5e1;">{{ Str::limit($order->shipping_address, 45) }}</strong></span>
                            </div>

                            <div style="display: flex; gap: 0.75rem; align-items: center;">
                                <!-- Botón Detalle / Comprobante -->
                                <a href="{{ route('client.orders.show', $order->order_number) }}" 
                                   style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); color: #ffffff; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <i data-feather="file-text" style="width: 14px; height: 14px;"></i> Ver Comprobante
                                </a>

                                <!-- Si el pedido ya fue completado/recibido, permitir solicitar devolución si aplica -->
                                @if($order->status === 'completed')
                                    @php
                                        $existingReturn = $order->returnRequests->first();
                                    @endphp
                                    @if($existingReturn)
                                        <span style="font-size: 0.8rem; font-weight: 700; color: #fbbf24; background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.3); padding: 0.45rem 0.85rem; border-radius: 0.5rem; display: inline-flex; align-items: center; gap: 0.35rem;">
                                            <i data-feather="rotate-ccw" style="width: 13px; height: 13px;"></i> Devolución {{ strtoupper($existingReturn->status) }}
                                        </span>
                                    @else
                                        <a href="{{ route('returns.public.create') }}?order={{ $order->order_number }}" 
                                           style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.35); color: #fca5a5; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;">
                                            <i data-feather="rotate-ccw" style="width: 14px; height: 14px;"></i> Solicitar Devolución
                                        </a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Paginación -->
            <div style="margin-top: 1rem;">
                {{ $orders->links() }}
            </div>
        </div>
    @else
        <!-- Estado Vacío -->
        <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.5rem; padding: 4.5rem 2rem; text-align: center; color: #94a3b8;">
            <div style="width: 72px; height: 72px; border-radius: 50%; background: rgba(99, 102, 241, 0.15); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #818cf8; border: 1px solid rgba(99, 102, 241, 0.3);">
                <i data-feather="inbox" style="width: 36px; height: 36px;"></i>
            </div>
            
            <h3 style="font-size: 1.4rem; font-weight: 800; color: #ffffff; margin-bottom: 0.5rem;">
                @if($filter === 'completed')
                    No tienes pedidos recibidos todavía
                @elseif($filter === 'active')
                    No tienes pedidos en preparación o camino actualmente
                @else
                    Aún no has realizado pedidos
                @endif
            </h3>
            
            <p style="font-size: 0.95rem; max-width: 480px; margin: 0 auto 2rem; line-height: 1.5;">
                Explora nuestro catálogo de productos directos, añade tus favoritos al carrito y recíbelos en tu domicilio.
            </p>

            <a href="{{ route('shop.index') }}" class="btn-primary" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.85rem 1.75rem; font-size: 1rem;">
                <i data-feather="shopping-bag" style="width: 18px; height: 18px;"></i>
                Ir a la Tienda
            </a>
        </div>
    @endif
</div>
@endsection
