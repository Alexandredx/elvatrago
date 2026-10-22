@extends('layouts.admin')

@section('title', 'Reclamación ' . $claim->claim_number . ' - Panel Admin')

@section('content')
<div style="margin-bottom: 2rem;">
    <a href="{{ route('admin.claims.index') }}" style="display: inline-flex; align-items: center; gap: 0.35rem; color: #94a3b8; font-size: 0.85rem; text-decoration: none; margin-bottom: 0.75rem;">
        <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i> Volver a la lista de reclamaciones
    </a>
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">Hoja de Reclamación: {{ $claim->claim_number }}</h1>
            <p style="color: #94a3b8; font-size: 0.9rem;">Registrado el {{ $claim->created_at->format('d/m/Y \a \l\a\s H:i') }} | Tipo: <strong>{{ strtoupper($claim->type) }}</strong></p>
        </div>
        <div>
            <a href="{{ route('legal.claims.success', $claim->claim_number) }}" target="_blank" style="background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.15); color: #ffffff; padding: 0.55rem 1rem; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem;">
                <i data-feather="printer" style="width: 14px; height: 14px;"></i> Ver Hoja Oficial
            </a>
        </div>
    </div>
</div>

<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem;">
    <!-- Columna Izquierda: Información del Reclamo -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        
        <!-- Tarjeta: Datos del Consumidor -->
        <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1rem; padding: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 0.5rem;">
                Datos del Consumidor Reclamante
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; font-size: 0.9rem;">
                <div>
                    <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Nombre Completo:</span>
                    <strong style="color: #ffffff;">{{ $claim->customer_name }}</strong>
                </div>
                <div>
                    <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Documento:</span>
                    <strong style="color: #ffffff;">{{ $claim->document_type }} - {{ $claim->document_number }}</strong>
                </div>
                <div>
                    <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Correo Electrónico:</span>
                    <a href="mailto:{{ $claim->customer_email }}" style="color: #38bdf8;">{{ $claim->customer_email }}</a>
                </div>
                <div>
                    <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Teléfono / WhatsApp:</span>
                    <strong style="color: #ffffff;">{{ $claim->customer_phone }}</strong>
                </div>
                <div style="grid-column: span 2;">
                    <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Domicilio:</span>
                    <span style="color: #cbd5e1;">{{ $claim->customer_address }}</span>
                </div>
                @if($claim->is_minor)
                    <div style="grid-column: span 2; background: rgba(245, 158, 11, 0.1); padding: 0.75rem; border-radius: 0.5rem; border: 1px solid rgba(245, 158, 11, 0.3); color: #fbbf24;">
                        <strong>Menor de edad:</strong> Representado por {{ $claim->parent_name }}
                    </div>
                @endif
            </div>
        </div>

        <!-- Tarjeta: Bien Contratado -->
        <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1rem; padding: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 0.5rem;">
                Identificación del Bien Contratado
            </h3>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; font-size: 0.9rem;">
                <div>
                    <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Naturaleza:</span>
                    <span style="text-transform: capitalize; color: #ffffff; font-weight: 600;">{{ $claim->contracted_good }}</span>
                </div>
                <div>
                    <span style="color: #94a3b8; font-size: 0.8rem; display: block;">N° de Pedido Relacionado:</span>
                    <span style="color: #fdba74; font-weight: 700;">{{ $claim->order_number ?? 'No consignado' }}</span>
                </div>
                <div>
                    <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Monto Reclamado:</span>
                    <span style="color: #34d399; font-weight: 700;">{{ $claim->amount_claimed ? '$' . number_format($claim->amount_claimed, 2) : 'No especificado' }}</span>
                </div>
                <div>
                    <span style="color: #94a3b8; font-size: 0.8rem; display: block;">Descripción del Producto:</span>
                    <span style="color: #cbd5e1;">{{ $claim->good_description ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Tarjeta: Detalle de los Hechos y Pedido Concreto -->
        <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1rem; padding: 1.5rem;">
            <h3 style="font-size: 1.1rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 0.5rem;">
                Detalle del Reclamo / Queja
            </h3>
            
            <div style="margin-bottom: 1.25rem;">
                <span style="color: #94a3b8; font-size: 0.8rem; display: block; margin-bottom: 0.35rem;">Descripción de los Hechos:</span>
                <div style="background: rgba(15, 23, 42, 0.7); padding: 1rem; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.05); color: #e2e8f0; line-height: 1.6; font-size: 0.95rem; white-space: pre-line;">
                    {{ $claim->details }}
                </div>
            </div>

            <div>
                <span style="color: #94a3b8; font-size: 0.8rem; display: block; margin-bottom: 0.35rem;">Pedido Concreto del Consumidor:</span>
                <div style="background: rgba(15, 23, 42, 0.7); padding: 1rem; border-radius: 0.5rem; border: 1px solid rgba(249,115,22,0.2); color: #fdba74; line-height: 1.6; font-size: 0.95rem; white-space: pre-line;">
                    {{ $claim->consumer_request }}
                </div>
            </div>
        </div>
    </div>

    <!-- Columna Derecha: Estado y Gestión de Respuesta Legal -->
    <div>
        <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1rem; padding: 1.5rem; position: sticky; top: 2rem;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; border-bottom: 1px solid rgba(255,255,255,0.06); padding-bottom: 0.5rem;">
                Gestión y Respuesta Legal
            </h3>

            <!-- Estado Actual -->
            <div style="margin-bottom: 1.25rem; padding: 0.85rem; border-radius: 0.5rem; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255,255,255,0.05);">
                <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase;">Estado Actual:</div>
                <div style="font-weight: 800; font-size: 1rem; color: {{ $claim->status_color }}; margin-top: 0.25rem;">
                    {{ $claim->status_label }}
                </div>
                @if($claim->responded_at)
                    <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.25rem;">
                        Respondido el: {{ $claim->responded_at->format('d/m/Y H:i') }}
                    </div>
                @endif
            </div>

            <!-- Formulario de Respuesta -->
            <form action="{{ route('admin.claims.update', $claim->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                        Actualizar Estado:
                    </label>
                    <select name="status" style="width: 100%; padding: 0.75rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.5rem; color: #ffffff; font-size: 0.9rem; outline: none; cursor: pointer;">
                        <option value="pending" {{ $claim->status === 'pending' ? 'selected' : '' }}>Pendiente de Atención</option>
                        <option value="in_process" {{ $claim->status === 'in_process' ? 'selected' : '' }}>En Proceso de Evaluación</option>
                        <option value="resolved" {{ $claim->status === 'resolved' ? 'selected' : '' }}>Resuelto / Procedente</option>
                        <option value="rejected" {{ $claim->status === 'rejected' ? 'selected' : '' }}>Improcedente / Rechazado</option>
                    </select>
                </div>

                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                        Respuesta Oficial de la Empresa:
                    </label>
                    <textarea name="admin_response" rows="7" placeholder="Escribe aquí los descargos, fundamentación o solución acordada que se notificará al consumidor..." style="width: 100%; padding: 0.75rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.5rem; color: #ffffff; font-size: 0.85rem; line-height: 1.6; outline: none; resize: vertical;">{{ old('admin_response', $claim->admin_response) }}</textarea>
                </div>

                <button type="submit" style="width: 100%; padding: 0.85rem; background: var(--accent-gradient); border: none; border-radius: 0.5rem; color: #ffffff; font-weight: 700; font-size: 0.95rem; cursor: pointer; box-shadow: 0 4px 14px rgba(249, 115, 22, 0.4);">
                    Guardar Respuesta Oficial
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
