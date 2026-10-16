@extends('layouts.admin')

@section('title', 'Detalle y Confirmación de Orden ' . $order->order_number . ' - Admin')

@section('content')
<div style="max-width: 1050px; margin: 0 auto 3.5rem;">
    <!-- Navegación y Encabezado -->
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.orders.index') }}" style="color: #94a3b8; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; margin-bottom: 0.75rem;">
            <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i> Volver a lista de órdenes
        </a>
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <span style="font-size: 0.8rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; letter-spacing: 0.05em;">Gestión de Orden</span>
                <h1 style="font-size: 1.9rem; font-weight: 800; color: #ffffff; margin-top: 0.2rem;">
                    Orden: <span style="color: #f97316;">{{ $order->order_number }}</span>
                </h1>
                <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 0.25rem;">
                    Registrado el {{ $order->created_at->format('d/m/Y \a \l\a\s H:i') }}
                </p>
            </div>
            
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <span style="{{ $order->status_badge_style }} padding: 0.5rem 1.15rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 800; text-transform: uppercase; display: inline-flex; align-items: center; gap: 0.4rem;">
                    <i data-feather="{{ $order->status_badge_icon }}" style="width: 16px; height: 16px;"></i>
                    {{ $order->status_label }}
                </span>
            </div>
        </div>
    </div>

    <!-- Barra de Progreso del Pedido (5 Procesos) -->
    @php
        $currentStep = $order->status_step;
        $isCancelled = $order->status === 'cancelled';
        $steps = [
            1 => ['name' => '1. Pedido Confirmado', 'desc' => 'Pago aprobado y orden creada', 'icon' => 'check-circle'],
            2 => ['name' => '2. Revisado por personal', 'desc' => 'Revisión en almacén', 'icon' => 'user-check'],
            3 => ['name' => '3. Datos Confirmados', 'desc' => 'Datos de envío verificados', 'icon' => 'shield'],
            4 => ['name' => '4. Enviado', 'desc' => 'En ruta de entrega', 'icon' => 'truck'],
            5 => ['name' => '5. Entregado', 'desc' => 'Recibido por el cliente', 'icon' => 'home'],
        ];
        $progressPercent = $isCancelled ? 0 : max(0, min(100, (($currentStep - 1) / 4) * 100));
    @endphp

    <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem; margin-bottom: 2rem; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.3); overflow-x: auto;">
        <div style="font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #94a3b8; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-feather="activity" style="width: 14px; height: 14px; color: #f97316;"></i> Fases del Pedido
        </div>
        <div style="display: grid; grid-template-columns: repeat(5, minmax(130px, 1fr)); gap: 0.75rem; text-align: center; position: relative;">
            
            <!-- Barra de conexión -->
            <div style="position: absolute; top: 20px; left: 10%; right: 10%; height: 4px; background: rgba(255,255,255,0.08); z-index: 0; border-radius: 9999px;">
                <div style="height: 100%; background: linear-gradient(90deg, #10b981, #f97316); width: {{ $progressPercent }}%; border-radius: 9999px; transition: width 0.3s ease;"></div>
            </div>

            @foreach($steps as $num => $step)
                @php
                    $isPast = $currentStep > $num && !$isCancelled;
                    $isCurrent = $currentStep === $num && !$isCancelled;
                @endphp
                <div style="display: flex; flex-direction: column; align-items: center; position: relative; z-index: 1;">
                    <div style="width: 42px; height: 42px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 0.5rem; font-weight: 800; transition: all 0.25s ease;
                        @if($isCancelled)
                            background: #1e293b; color: #ef4444; border: 2px solid rgba(239, 68, 68, 0.4);
                        @elseif($isPast || ($isCurrent && $num === 5))
                            background: #10b981; color: #ffffff; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.35); border: 2px solid #34d399;
                        @elseif($isCurrent)
                            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); color: #ffffff; box-shadow: 0 0 16px rgba(249, 115, 22, 0.6); border: 2px solid #fdba74;
                        @else
                            background: #0f172a; color: #64748b; border: 2px solid rgba(255, 255, 255, 0.12);
                        @endif
                    ">
                        @if($isPast || ($isCurrent && $num === 5))
                            <i data-feather="check" style="width: 20px; height: 20px;"></i>
                        @else
                            <i data-feather="{{ $step['icon'] }}" style="width: 20px; height: 20px;"></i>
                        @endif
                    </div>

                    <div style="font-weight: 700; font-size: 0.8rem; line-height: 1.2; margin-bottom: 0.2rem;
                        @if($isCancelled) color: #94a3b8;
                        @elseif($isCurrent) color: #fb923c;
                        @elseif($isPast) color: #ffffff;
                        @else color: #64748b;
                        @endif
                    ">
                        {{ $step['name'] }}
                    </div>

                    <div style="font-size: 0.7rem; line-height: 1.2;
                        @if($isCancelled) color: #64748b;
                        @elseif($isCurrent) color: #fdba74;
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

    <!-- Sección de Acciones Rápidas del Administrador para Revisar y Confirmar Datos -->
    <div style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(245, 158, 11, 0.35); border-radius: 1.25rem; padding: 1.75rem; margin-bottom: 2rem; box-shadow: 0 8px 24px rgba(0,0,0,0.25);">
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.08);">
            <div style="display: flex; align-items: center; gap: 0.65rem;">
                <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(245, 158, 11, 0.2); color: #fbbf24; display: flex; align-items: center; justify-content: center;">
                    <i data-feather="check-square" style="width: 20px; height: 20px;"></i>
                </div>
                <div>
                    <h2 style="font-size: 1.2rem; font-weight: 800; color: #ffffff; margin: 0;">Revisión y Confirmación de Datos de Envío</h2>
                    <p style="font-size: 0.85rem; color: #94a3b8; margin: 0.15rem 0 0;">
                        Verifica que la dirección y contacto del cliente sean correctos para proceder al despacho.
                    </p>
                </div>
            </div>

            @if($order->status === 'data_confirmed')
                <div style="background: rgba(245, 158, 11, 0.15); border: 1px solid rgba(245, 158, 11, 0.4); color: #fbbf24; padding: 0.4rem 0.85rem; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.4rem;">
                    <i data-feather="check-circle" style="width: 16px; height: 16px;"></i>
                    ¡Datos de Envío Confirmados para el Usuario!
                </div>
            @endif
        </div>

        <div style="display: flex; flex-wrap: wrap; gap: 1rem; align-items: center;">
            <!-- Acción 1: Marcar como Revisado por personal -->
            @if(in_array($order->status, ['confirmed', 'pending']))
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="reviewed">
                    <button type="submit" style="padding: 0.75rem 1.25rem; background: rgba(168, 85, 247, 0.2); border: 1px solid rgba(168, 85, 247, 0.5); color: #c084fc; border-radius: 0.75rem; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i data-feather="user-check" style="width: 16px; height: 16px;"></i> Marcar como Revisado por Personal
                    </button>
                </form>
            @endif

            <!-- Acción 2: Confirmar Datos de Envío (Marca como Datos Confirmados) -->
            @if(in_array($order->status, ['confirmed', 'reviewed', 'pending']))
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="data_confirmed">
                    <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border: none; color: #ffffff; border-radius: 0.75rem; font-weight: 800; font-size: 0.95rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.35);">
                        <i data-feather="shield" style="width: 18px; height: 18px;"></i> ✓ Confirmar Datos de Envío (Datos Confirmados)
                    </button>
                </form>
            @endif

            <!-- Acción 3: Si ya está en datos confirmados, botón directo para marcar como Enviado -->
            @if($order->status === 'data_confirmed')
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" style="margin: 0;">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="status" value="shipped">
                    <button type="submit" style="padding: 0.75rem 1.35rem; background: rgba(6, 182, 212, 0.2); border: 1px solid rgba(6, 182, 212, 0.5); color: #22d3ee; border-radius: 0.75rem; font-weight: 700; font-size: 0.9rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                        <i data-feather="truck" style="width: 16px; height: 16px;"></i> 🚚 Marcar como Enviado (En Ruta)
                    </button>
                </form>
            @endif

            <!-- Botón para alternar formulario de edición de datos de envío si se corrigió algo -->
            <button type="button" onclick="document.getElementById('editShippingBox').style.display = document.getElementById('editShippingBox').style.display === 'none' ? 'block' : 'none';" style="padding: 0.75rem 1rem; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); color: #cbd5e1; border-radius: 0.75rem; font-weight: 600; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem;">
                <i data-feather="edit-2" style="width: 14px; height: 14px;"></i> Editar Datos de Envío
            </button>
        </div>

        <!-- Formulario desplegable para corregir / confirmar dirección o teléfono -->
        <div id="editShippingBox" style="display: none; margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px dashed rgba(255, 255, 255, 0.1);">
            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <input type="hidden" name="status" value="data_confirmed">

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem;">
                    <div>
                        <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.35rem;">Teléfono de Contacto</label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone) }}" style="width: 100%; padding: 0.65rem 0.85rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.5rem; color: #ffffff; font-size: 0.9rem;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.35rem;">Dirección Exacta de Envío</label>
                        <input type="text" name="shipping_address" value="{{ old('shipping_address', $order->shipping_address) }}" style="width: 100%; padding: 0.65rem 0.85rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.5rem; color: #ffffff; font-size: 0.9rem;">
                    </div>
                </div>

                <button type="submit" style="padding: 0.65rem 1.25rem; background: #f59e0b; border: none; color: #000000; border-radius: 0.5rem; font-weight: 800; font-size: 0.85rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem;">
                    <i data-feather="check" style="width: 14px; height: 14px;"></i> Guardar Cambios y Confirmar Datos
                </button>
            </form>
        </div>
    </div>

    <!-- Contenido Principal: Dos Columnas -->
    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
        
        <!-- Columna Izquierda: Información del Cliente y Productos -->
        <div style="display: flex; flex-direction: column; gap: 1.75rem;">
            
            <!-- Datos del Cliente y Envío -->
            <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="user" style="color: #f97316; width: 18px; height: 18px;"></i>
                    Información del Cliente y Despacho
                </h2>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; background: rgba(15,23,42,0.6); padding: 1.25rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.04); font-size: 0.9rem; line-height: 1.6; color: #cbd5e1;">
                    <div>
                        <strong style="color: #ffffff;">Cliente:</strong> {{ $order->customer_name }}<br>
                        <strong style="color: #ffffff;">Email:</strong> {{ $order->customer_email }}<br>
                        <strong style="color: #ffffff;">Teléfono:</strong> {{ $order->customer_phone ?: 'No registrado' }}
                    </div>
                    <div>
                        <strong style="color: #ffffff;">Dirección de Entrega:</strong><br>
                        <span style="color: #fdba74;">{{ $order->shipping_address }}</span><br><br>
                        <strong style="color: #ffffff;">Medio de Pago:</strong> 
                        <span style="color: {{ $order->payment_method === 'yape' ? '#00d2c4' : '#fdba74' }}; font-weight: 700;">{{ $order->payment_method_name }}</span>
                        @if($order->payment_reference)
                            <div style="font-size: 0.8rem; color: #94a3b8;">{{ $order->payment_reference }}</div>
                        @endif
                        @if($order->payment_id)
                            <div style="font-size: 0.75rem; color: #34d399; margin-top: 0.25rem;">
                                Transacción Culqi: {{ $order->payment_id }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Productos Comprados -->
            <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="shopping-bag" style="color: #f97316; width: 18px; height: 18px;"></i>
                    Productos de la Orden ({{ $order->items->count() }})
                </h2>

                <div style="display: flex; flex-direction: column; gap: 0.85rem; margin-bottom: 1.5rem;">
                    @foreach($order->items as $item)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.85rem 1rem; background: rgba(15,23,42,0.6); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                            <div style="display: flex; align-items: center; gap: 1rem;">
                                @if($item->product && $item->product->primary_image_url)
                                    <img src="{{ $item->product->primary_image_url }}" alt="" style="width: 48px; height: 48px; object-fit: cover; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1);">
                                @else
                                    <div style="width: 48px; height: 48px; border-radius: 0.5rem; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; color: #64748b;">
                                        <i data-feather="package" style="width: 22px; height: 22px;"></i>
                                    </div>
                                @endif

                                <div>
                                    <div style="font-weight: 700; color: #ffffff; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem;">
                                        <span>{{ $item->product_title }}</span>
                                        @if(!empty($item->size))
                                            <span style="background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.4); color: #fdba74; font-size: 0.75rem; font-weight: 700; padding: 0.1rem 0.45rem; border-radius: 0.3rem;">
                                                Talla: {{ $item->size }}
                                            </span>
                                        @endif
                                    </div>
                                    <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.15rem;">
                                        Cantidad: <strong style="color: #cbd5e1;">{{ $item->quantity }}</strong> &bull; Precio unitario: ${{ number_format($item->price, 2) }}
                                    </div>
                                </div>
                            </div>

                            <div style="font-weight: 800; color: #ffffff; font-size: 1rem;">
                                ${{ number_format($item->price * $item->quantity, 2) }}
                            </div>
                        </div>
                    @endforeach
                </div>

                <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 800; color: #ffffff; padding-top: 1.25rem; border-top: 1px solid rgba(255,255,255,0.08);">
                    <span>Total de la Orden:</span>
                    <span style="color: #34d399;">${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
        </div>

        <!-- Columna Derecha: Control Manual de Estado -->
        <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem; position: sticky; top: 2rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="sliders" style="width: 16px; height: 16px; color: #f97316;"></i>
                Cambio Manual de Estado
            </h3>

            <p style="font-size: 0.8rem; color: #94a3b8; margin-bottom: 1.25rem; line-height: 1.4;">
                Selecciona manualmente el estado de la orden si requieres forzar una transición específica:
            </p>

            <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div style="margin-bottom: 1.25rem;">
                    <select name="status" style="width: 100%; padding: 0.85rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-weight: 700; font-size: 0.9rem; outline: none;">
                        <option value="confirmed" {{ in_array($order->status, ['confirmed', 'pending']) ? 'selected' : '' }}>1. Pedido Confirmado</option>
                        <option value="reviewed" {{ $order->status === 'reviewed' ? 'selected' : '' }}>2. Revisado por el personal</option>
                        <option value="data_confirmed" {{ $order->status === 'data_confirmed' ? 'selected' : '' }}>3. Datos Confirmados</option>
                        <option value="shipped" {{ in_array($order->status, ['shipped', 'processing']) ? 'selected' : '' }}>4. Enviado (En ruta)</option>
                        <option value="delivered" {{ in_array($order->status, ['delivered', 'completed']) ? 'selected' : '' }}>5. Entregado</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ Cancelado</option>
                    </select>
                </div>

                <button type="submit" class="pill-item active" style="width: 100%; padding: 0.85rem; font-weight: 800; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <i data-feather="save" style="width: 16px; height: 16px;"></i> Guardar Estado
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
