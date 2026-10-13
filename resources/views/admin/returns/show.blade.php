@extends('layouts.admin')

@section('title', 'Gestionar Devolución ' . $return->return_number . ' - Admin')

@section('content')
<div style="max-width: 1000px; margin: 0 auto 3rem;">
    <!-- Breadcrumb & Header -->
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.returns.index') }}" style="color: #94a3b8; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem; margin-bottom: 0.5rem;">
            &larr; Volver a Solicitudes de Devolución
        </a>
        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff; display: flex; align-items: center; gap: 0.75rem;">
                    <i data-feather="rotate-ccw" style="color: #fb923c;"></i>
                    Solicitud: {{ $return->return_number }}
                </h1>
                <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 0.25rem;">
                    Registrada el {{ $return->created_at->format('d/m/Y \a \l\a\s H:i') }} (hace {{ $return->created_at->diffForHumans() }})
                </p>
            </div>

            <div>
                @if($return->status === 'pending')
                    <span style="background: rgba(245, 158, 11, 0.2); border: 1px solid rgba(245, 158, 11, 0.5); color: #fbbf24; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;">
                        ⏳ Pendiente de Revisión
                    </span>
                @elseif($return->status === 'approved')
                    <span style="background: rgba(59, 130, 246, 0.2); border: 1px solid rgba(59, 130, 246, 0.5); color: #60a5fa; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;">
                        ✓ Devolución Aprobada
                    </span>
                @elseif($return->status === 'completed')
                    <span style="background: rgba(16, 185, 129, 0.2); border: 1px solid rgba(16, 185, 129, 0.5); color: #34d399; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;">
                        ✔ Completada y Reembolsada
                    </span>
                @elseif($return->status === 'rejected')
                    <span style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.5); color: #f87171; padding: 0.5rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; text-transform: uppercase;">
                        ✕ Solicitud Rechazada
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Layout en 2 columnas -->
    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
        <!-- Columna Izquierda: Información del Reclamo & Orden -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- Motivo y Explicación del Cliente -->
            <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="alert-circle" style="color: #f59e0b; width: 18px; height: 18px;"></i>
                    Motivo de la Devolución
                </h2>

                <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 0.75rem; padding: 1.25rem; margin-bottom: 1.25rem;">
                    <div style="font-size: 0.8rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Razón Seleccionada:</div>
                    <div style="font-size: 1.1rem; font-weight: 700; color: #f8fafc;">
                        {{ $return->reason }}
                    </div>
                </div>

                <div>
                    <div style="font-size: 0.8rem; text-transform: uppercase; color: #94a3b8; font-weight: 700; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Detalles / Explicación del Cliente:</div>
                    <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 0.75rem; padding: 1.25rem; color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; white-space: pre-line;">
                        {{ $return->details ?: 'El cliente no especificó detalles adicionales.' }}
                    </div>
                </div>
            </div>

            <!-- Datos del Cliente -->
            <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="user" style="color: #f97316; width: 18px; height: 18px;"></i>
                    Información de Contacto del Cliente
                </h2>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div style="background: rgba(15, 23, 42, 0.7); padding: 1rem; border-radius: 0.75rem; border: 1px solid rgba(255, 255, 255, 0.05);">
                        <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Nombre Completo</div>
                        <div style="font-size: 0.95rem; font-weight: 700; color: #ffffff; margin-top: 0.25rem;">{{ $return->customer_name }}</div>
                    </div>

                    <div style="background: rgba(15, 23, 42, 0.7); padding: 1rem; border-radius: 0.75rem; border: 1px solid rgba(255, 255, 255, 0.05);">
                        <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Correo Electrónico</div>
                        <div style="font-size: 0.95rem; font-weight: 700; color: #38bdf8; margin-top: 0.25rem;">
                            <a href="mailto:{{ $return->customer_email }}" style="color: inherit; text-decoration: none;">{{ $return->customer_email }}</a>
                        </div>
                    </div>

                    @if($return->customer_phone)
                    <div style="background: rgba(15, 23, 42, 0.7); padding: 1rem; border-radius: 0.75rem; border: 1px solid rgba(255, 255, 255, 0.05); grid-column: span 2;">
                        <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 700;">Teléfono / WhatsApp</div>
                        <div style="font-size: 0.95rem; font-weight: 700; color: #ffffff; margin-top: 0.25rem;">{{ $return->customer_phone }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Orden Asociada -->
            @if($return->order)
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
                        <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                            <i data-feather="shopping-cart" style="color: #10b981; width: 18px; height: 18px;"></i>
                            Orden Asociada: {{ $return->order->order_number }}
                        </h2>
                        <a href="{{ route('admin.orders.show', $return->order->id) }}" style="color: #f97316; font-size: 0.85rem; font-weight: 600; text-decoration: none;">
                            Ver Orden Completa &rarr;
                        </a>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.25rem;">
                        @foreach($return->order->items as $item)
                            <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.85rem; background: rgba(15, 23, 42, 0.7); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                                <div>
                                    <div style="font-weight: 700; color: #ffffff; font-size: 0.9rem;">{{ $item->product_title }}</div>
                                    <div style="font-size: 0.8rem; color: #94a3b8;">Cantidad: {{ $item->quantity }} x ${{ number_format($item->price, 2) }}</div>
                                </div>
                                <div style="font-weight: 800; color: #ffffff;">
                                    ${{ number_format($item->price * $item->quantity, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div style="display: flex; justify-content: space-between; font-size: 1.1rem; font-weight: 800; color: #ffffff; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.08);">
                        <span>Total de la Orden Original:</span>
                        <span style="color: #34d399;">${{ number_format($return->order->total_amount, 2) }}</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Columna Derecha: Panel de Decisión y Estado -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <div style="background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 1.25rem; padding: 1.75rem; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);">
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="settings" style="width: 16px; height: 16px; color: #fb923c;"></i>
                    Gestionar Solicitud
                </h3>

                <form action="{{ route('admin.returns.update-status', $return->id) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <!-- Selección de Estado -->
                    <div style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; margin-bottom: 0.5rem;">
                            Estado de la Devolución
                        </label>
                        <select name="status" style="width: 100%; padding: 0.75rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-weight: 600; font-size: 0.9rem;">
                            <option value="pending" {{ $return->status === 'pending' ? 'selected' : '' }}>⏳ Pendiente</option>
                            <option value="approved" {{ $return->status === 'approved' ? 'selected' : '' }}>✓ Aprobada (Esperando producto)</option>
                            <option value="completed" {{ $return->status === 'completed' ? 'selected' : '' }}>✔ Completada / Reembolsada</option>
                            <option value="rejected" {{ $return->status === 'rejected' ? 'selected' : '' }}>✕ Rechazada</option>
                        </select>
                    </div>

                    <!-- Monto a Reembolsar -->
                    <div style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; margin-bottom: 0.5rem;">
                            Monto a Reembolsar ($)
                        </label>
                        <input type="number" step="0.01" name="refund_amount" value="{{ old('refund_amount', $return->refund_amount) }}" 
                               placeholder="0.00"
                               style="width: 100%; padding: 0.75rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #34d399; font-weight: 700; font-size: 1rem;">
                    </div>

                    <!-- Notas Internas Admin -->
                    <div style="margin-bottom: 1.5rem;">
                        <label style="display: block; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; margin-bottom: 0.5rem;">
                            Notas Internas del Admin
                        </label>
                        <textarea name="admin_notes" rows="4" placeholder="Ej: Se acordó recoger el producto el viernes. Reembolso emitido por transferencia."
                                  style="width: 100%; padding: 0.75rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.85rem; line-height: 1.5; resize: vertical;">{{ old('admin_notes', $return->admin_notes) }}</textarea>
                    </div>

                    <button type="submit" style="width: 100%; padding: 0.85rem; background: #f97316; border: none; border-radius: 0.75rem; color: #ffffff; font-weight: 700; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: background 0.2s;">
                        <i data-feather="save" style="width: 16px; height: 16px;"></i> Guardar Cambios
                    </button>
                </form>
            </div>

            <!-- Eliminar Solicitud -->
            <div style="background: rgba(239, 68, 68, 0.05); border: 1px solid rgba(239, 68, 68, 0.2); border-radius: 1.25rem; padding: 1.25rem; text-align: center;">
                <div style="font-size: 0.8rem; color: #fca5a5; margin-bottom: 0.75rem;">¿Deseas descartar o borrar este registro?</div>
                <form action="{{ route('admin.returns.destroy', $return->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta solicitud de devolución?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; padding: 0.5rem 1rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; cursor: pointer; width: 100%;">
                        Eliminar Registro
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
