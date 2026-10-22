@extends('layouts.app')

@section('title', 'Política de Envíos y Devoluciones - GlobalClick')

@section('content')
<div class="main-container" style="max-width: 960px; margin: 0 auto; padding: 3rem 1.5rem 5rem;">
    <!-- Breadcrumb & Back -->
    <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <a href="{{ route('legal.index') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; color: #94a3b8; font-size: 0.9rem; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#60a5fa'" onmouseout="this.style.color='#94a3b8'">
            <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
            <span>Volver al Centro Legal</span>
        </a>
        <span style="font-size: 0.8rem; color: #64748b;">Garantía de Satisfacción y Protección al Consumidor</span>
    </div>

    <!-- Header Section -->
    <div style="border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding-bottom: 2rem; margin-bottom: 2.5rem;">
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.3); color: #93c5fd; padding: 0.3rem 0.85rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; margin-bottom: 1rem;">
            <i data-feather="truck" style="width: 14px; height: 14px;"></i>
            <span>Logística, Garantías y Reembolsos</span>
        </div>
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #ffffff; letter-spacing: -0.02em; line-height: 1.2;">
            Política de Envíos, Garantías y Devoluciones
        </h1>
        <p style="color: #94a3b8; font-size: 1.05rem; margin-top: 0.75rem; line-height: 1.6;">
            En GlobalClick nos comprometemos a brindarte productos de máxima calidad y una experiencia de compra transparente y respaldada legalmente.
        </p>
    </div>

    <!-- Quick CTA Banner -->
    <div style="background: linear-gradient(135deg, rgba(59, 130, 246, 0.15), rgba(30, 41, 59, 0.8)); border: 1px solid rgba(59, 130, 246, 0.3); border-radius: 1.25rem; padding: 1.75rem; margin-bottom: 2.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.25rem;">
        <div>
            <h3 style="font-size: 1.2rem; font-weight: 700; color: #ffffff; margin-bottom: 0.25rem;">¿Necesitas gestionar una devolución ahora?</h3>
            <p style="font-size: 0.9rem; color: #cbd5e1; margin: 0;">Puedes iniciar el trámite digital en menos de 2 minutos ingresando el número de tu orden.</p>
        </div>
        <a href="{{ route('returns.public.create') }}" style="background: #3b82f6; color: #ffffff; padding: 0.75rem 1.5rem; border-radius: 0.75rem; font-weight: 700; font-size: 0.95rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 14px rgba(59, 130, 246, 0.4); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <i data-feather="rotate-ccw" style="width: 16px; height: 16px;"></i>
            <span>Ir al Formulario de Devolución</span>
        </a>
    </div>

    <!-- Content Body -->
    <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.5rem; padding: 2.5rem; color: #cbd5e1; font-size: 0.975rem; line-height: 1.8;">
        
        <!-- Sección 1: Plazos -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #60a5fa;">1.</span> Plazo para Solicitar Devoluciones
            </h2>
            <p>
                Todo cliente que adquiera productos en GlobalClick tiene derecho a solicitar la devolución o cambio de su producto dentro de un plazo máximo de <strong>quince (15) días calendario</strong> contados a partir del día siguiente de la recepción física del pedido en su domicilio.
            </p>
        </section>

        <!-- Sección 2: Condiciones -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #60a5fa;">2.</span> Requisitos y Condiciones de Aceptación
            </h2>
            <p style="margin-bottom: 0.75rem;">Para que una devolución sea aprobada, el bien debe cumplir con los siguientes estándares:</p>
            <ul style="padding-left: 1.5rem; margin-bottom: 0.75rem;">
                <li>El producto debe encontrarse sin señales de uso, suciedad, desgaste o deterioro ocasionado por el comprador.</li>
                <li>Debe incluir su empaque original de fábrica, sellos, códigos de barra, etiquetas, cables, cargadores, manuales y accesorios completos.</li>
                <li>Presentar el número de orden generado en la compra (ej. <code>ORD-XXXXXXXX</code>) o comprobante digital.</li>
            </ul>
        </section>

        <!-- Sección 3: Motivos Válidos -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #60a5fa;">3.</span> Motivos de Devolución Cubiertos por la Garantía
            </h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1rem;">
                <div style="background: rgba(15, 23, 42, 0.6); padding: 1.25rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                    <strong style="color: #ffffff; display: block; margin-bottom: 0.35rem;">Falla o Defecto de Fábrica</strong>
                    <span style="font-size: 0.85rem; color: #94a3b8;">El producto no enciende, no carga o presenta problemas funcionales intrínsecos de fabricación.</span>
                </div>
                <div style="background: rgba(15, 23, 42, 0.6); padding: 1.25rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                    <strong style="color: #ffffff; display: block; margin-bottom: 0.35rem;">Daño en el Transporte</strong>
                    <span style="font-size: 0.85rem; color: #94a3b8;">Rotura o daño visible originado por la manipulación del courier. Debe notificarse dentro de las primeras 48h.</span>
                </div>
                <div style="background: rgba(15, 23, 42, 0.6); padding: 1.25rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                    <strong style="color: #ffffff; display: block; margin-bottom: 0.35rem;">Producto Erróneo o Incompleto</strong>
                    <span style="font-size: 0.85rem; color: #94a3b8;">El artículo entregado difiere sustancialmente en modelo, color o talla respecto al pedido realizado.</span>
                </div>
            </div>
        </section>

        <!-- Sección 4: Exclusiones -->
        <section style="margin-bottom: 2.5rem; background: rgba(239, 68, 68, 0.08); border-left: 4px solid #ef4444; padding: 1.25rem 1.5rem; border-radius: 0 0.75rem 0.75rem 0;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #ef4444;">4.</span> Exclusiones de la Garantía
            </h2>
            <p style="margin-bottom: 0.5rem;">No procederá la devolución ni la cobertura de garantía cuando el desperfecto sea imputable a:</p>
            <ul style="padding-left: 1.5rem; color: #fca5a5; font-size: 0.9rem;">
                <li>Uso indebido, golpes, caídas, exposición a temperaturas extremas o humedad no especificada.</li>
                <li>Sobrecargas o variaciones irregulares en el voltaje de la red eléctrica del usuario.</li>
                <li>Intervención, desarme o reparación por personas o servicios técnicos no autorizados.</li>
            </ul>
        </section>

        <!-- Sección 5: Procedimiento y Reembolsos -->
        <section>
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #60a5fa;">5.</span> Procedimiento de Reembolso
            </h2>
            <p style="margin-bottom: 0.75rem;">
                Una vez recepcionado el producto en nuestro centro de inspección y verificada la conformidad de los requisitos en un plazo de dos (2) a tres (3) días hábiles, se procederá conforme a la elección del cliente:
            </p>
            <ol style="padding-left: 1.5rem; margin-bottom: 0.75rem;">
                <li><strong>Reemplazo inmediato:</strong> Despacho prioritario de una unidad completamente nueva y sellada sin costo de envío adicional.</li>
                <li><strong>Reembolso dinerario:</strong> Devolución del 100% del importe pagado al mismo medio de pago (tarjeta de crédito/débito o reversión Yape). El tiempo de acreditación dependerá de la entidad bancaria del usuario (habitualmente de 3 a 7 días hábiles).</li>
            </ol>
        </section>

    </div>
</div>
@endsection
