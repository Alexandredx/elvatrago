@extends('layouts.app')

@section('title', 'Constancia de Reclamación - ' . $claim->claim_number)

@section('content')
<div class="main-container" style="max-width: 820px; margin: 0 auto; padding: 3rem 1.5rem 5rem;">
    <!-- Success Banner -->
    <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); border-radius: 1.25rem; padding: 2rem; text-align: center; margin-bottom: 2.5rem;">
        <div style="width: 64px; height: 64px; border-radius: 50%; background: #10b981; color: #ffffff; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; box-shadow: 0 0 25px rgba(16, 185, 129, 0.5);">
            <i data-feather="check" style="width: 34px; height: 34px;"></i>
        </div>
        <h1 style="font-size: 2rem; font-weight: 800; color: #ffffff; margin-bottom: 0.5rem;">
            ¡Reclamación Registrada Exitosamente!
        </h1>
        <p style="color: #cbd5e1; font-size: 1rem; max-width: 580px; margin: 0 auto; line-height: 1.6;">
            Se ha generado formalmente tu Hoja de Reclamación Virtual. Te hemos remitido una copia digital y nuestro equipo legal responderá en un plazo máximo de <strong>15 días hábiles</strong>.
        </p>
    </div>

    <!-- Printable Official Sheet Box -->
    <div id="printArea" style="background: #ffffff; color: #1e293b; border-radius: 1rem; padding: 2.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.4); margin-bottom: 2rem; border: 1px solid #e2e8f0;">
        
        <!-- Document Header -->
        <div style="display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #0f172a; padding-bottom: 1.25rem; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 1rem;">
            <div>
                <div style="font-size: 1.35rem; font-weight: 800; color: #0f172a; letter-spacing: -0.01em;">
                    GLOBALCLICK
                </div>
                <div style="font-size: 0.85rem; color: #64748b;">Tienda Virtual & Comercio Digital Minorista</div>
                <div style="font-size: 0.85rem; color: #64748b;">Lima, República del Perú</div>
            </div>
            <div style="text-align: right; background: #f8fafc; border: 1px solid #cbd5e1; padding: 0.75rem 1.25rem; border-radius: 0.5rem;">
                <div style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Hoja de Reclamación N°</div>
                <div style="font-size: 1.25rem; font-weight: 800; color: #f97316;">{{ $claim->claim_number }}</div>
                <div style="font-size: 0.75rem; color: #64748b;">Fecha: {{ $claim->created_at->format('d/m/Y H:i') }}</div>
            </div>
        </div>

        <div style="text-align: center; margin-bottom: 1.5rem;">
            <span style="font-size: 1.1rem; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em; background: #0f172a; color: #ffffff; padding: 0.35rem 1.25rem; border-radius: 9999px;">
                Libro de Reclamaciones Virtual - {{ strtoupper($claim->type) }}
            </span>
        </div>

        <!-- 1. Datos del Consumidor -->
        <div style="margin-bottom: 1.5rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 1rem;">
            <div style="font-size: 0.85rem; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 0.75rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.35rem;">
                1. Identificación del Consumidor Reclamante
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 0.75rem; font-size: 0.875rem;">
                <div><strong>Nombre / Razón Social:</strong><br>{{ $claim->customer_name }}</div>
                <div><strong>Documento:</strong><br>{{ $claim->document_type }} - {{ $claim->document_number }}</div>
                <div><strong>Teléfono:</strong><br>{{ $claim->customer_phone }}</div>
                <div><strong>Email:</strong><br>{{ $claim->customer_email }}</div>
                <div style="grid-column: span 2;"><strong>Domicilio:</strong><br>{{ $claim->customer_address }}</div>
                @if($claim->is_minor)
                    <div style="grid-column: span 2; color: #d97706;"><strong>Apoderado (Menor de edad):</strong> {{ $claim->parent_name }}</div>
                @endif
            </div>
        </div>

        <!-- 2. Bien Contratado -->
        <div style="margin-bottom: 1.5rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 1rem;">
            <div style="font-size: 0.85rem; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 0.75rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.35rem;">
                2. Identificación del Bien Contratado
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 0.75rem; font-size: 0.875rem;">
                <div><strong>Tipo de Bien:</strong><br>{{ ucfirst($claim->contracted_good) }}</div>
                <div><strong>Orden N°:</strong><br>{{ $claim->order_number ?? 'No especificado' }}</div>
                <div><strong>Monto Reclamado:</strong><br>{{ $claim->amount_claimed ? '$' . number_format($claim->amount_claimed, 2) : 'No especificado' }}</div>
                @if($claim->good_description)
                    <div style="grid-column: span 2;"><strong>Descripción:</strong><br>{{ $claim->good_description }}</div>
                @endif
            </div>
        </div>

        <!-- 3. Detalle y Pedido -->
        <div style="margin-bottom: 1.5rem; border: 1px solid #e2e8f0; border-radius: 0.5rem; padding: 1rem;">
            <div style="font-size: 0.85rem; font-weight: 800; color: #0f172a; text-transform: uppercase; margin-bottom: 0.75rem; border-bottom: 1px solid #e2e8f0; padding-bottom: 0.35rem;">
                3. Detalle de la Reclamación y Pedido
            </div>
            <div style="margin-bottom: 1rem; font-size: 0.875rem;">
                <strong>Detalle de los Hechos ({{ ucfirst($claim->type) }}):</strong>
                <p style="margin-top: 0.35rem; line-height: 1.6; background: #f8fafc; padding: 0.75rem; border-radius: 0.35rem; border: 1px solid #e2e8f0;">
                    {{ $claim->details }}
                </p>
            </div>
            <div style="font-size: 0.875rem;">
                <strong>Pedido Concreto del Consumidor:</strong>
                <p style="margin-top: 0.35rem; line-height: 1.6; background: #f8fafc; padding: 0.75rem; border-radius: 0.35rem; border: 1px solid #e2e8f0;">
                    {{ $claim->consumer_request }}
                </p>
            </div>
        </div>

        <!-- Legal Footer Notice -->
        <div style="background: #f1f5f9; padding: 0.85rem 1rem; border-radius: 0.5rem; font-size: 0.75rem; color: #475569; line-height: 1.5;">
            * La formulación del reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el INDECOPI.<br>
            * El proveedor deberá dar respuesta al reclamo o queja en un plazo no mayor a quince (15) días hábiles improrrogables.
        </div>
    </div>

    <!-- Actions Buttons -->
    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
        <button type="button" onclick="window.print()" style="background: rgba(255, 255, 255, 0.1); border: 1px solid rgba(255, 255, 255, 0.2); color: #ffffff; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 700; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; gap: 0.5rem;">
            <i data-feather="printer" style="width: 18px; height: 18px;"></i>
            <span>Imprimir o Guardar PDF</span>
        </button>

        <a href="{{ route('shop.index') }}" style="background: var(--accent-gradient); color: #ffffff; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 700; font-size: 0.95rem; text-decoration: none; display: flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 14px rgba(249, 115, 22, 0.4);">
            <i data-feather="shopping-bag" style="width: 18px; height: 18px;"></i>
            <span>Volver a la Tienda</span>
        </a>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printArea, #printArea * {
        visibility: visible;
    }
    #printArea {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        box-shadow: none !important;
        border: none !important;
    }
}
</style>
@endsection
