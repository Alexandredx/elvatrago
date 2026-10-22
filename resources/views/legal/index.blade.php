@extends('layouts.app')

@section('title', 'Centro Legal y Políticas de la Tienda - GlobalClick')

@section('content')
<div class="main-container" style="max-width: 1200px; margin: 0 auto; padding: 3rem 1.5rem 5rem;">
    <!-- Hero Header -->
    <div style="text-align: center; margin-bottom: 3.5rem;">
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(249, 115, 22, 0.15); border: 1px solid rgba(249, 115, 22, 0.3); color: #fdba74; padding: 0.35rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; margin-bottom: 1.25rem;">
            <i data-feather="shield" style="width: 16px; height: 16px;"></i>
            <span>Seguridad, Transparencia y Cumplimiento Normativo</span>
        </div>
        <h1 style="font-size: 2.75rem; font-weight: 800; color: #ffffff; letter-spacing: -0.025em; line-height: 1.2; margin-bottom: 1rem;">
            Centro de Políticas Legales
        </h1>
        <p style="color: #94a3b8; font-size: 1.1rem; max-width: 680px; margin: 0 auto; line-height: 1.6;">
            En GlobalClick protegemos tus derechos como consumidor y garantizamos transacciones comerciales 100% transparentes, seguras y apegadas a la legislación vigente.
        </p>
    </div>

    <!-- Políticas Cards Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.75rem; margin-bottom: 4rem;">
        
        <!-- Tarjeta 1: Términos y Condiciones -->
        <a href="{{ route('legal.terms') }}" style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem; display: flex; flex-direction: column; transition: all 0.3s ease; text-decoration: none; position: relative; overflow: hidden; group" onmouseover="this.style.borderColor='rgba(249,115,22,0.4)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.transform='translateY(0)';">
            <div style="width: 52px; height: 52px; border-radius: 0.85rem; background: rgba(249, 115, 22, 0.15); border: 1px solid rgba(249, 115, 22, 0.3); display: flex; align-items: center; justify-content: center; color: #fb923c; margin-bottom: 1.5rem;">
                <i data-feather="file-text" style="width: 26px; height: 26px;"></i>
            </div>
            <h3 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.75rem;">Términos y Condiciones</h3>
            <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem; flex: 1;">
                Condiciones de compra, pasarelas de pago, mayoría de edad requerida (18+), límites de responsabilidad legal y derechos de propiedad intelectual.
            </p>
            <div style="display: flex; align-items: center; gap: 0.5rem; color: #fb923c; font-weight: 700; font-size: 0.9rem;">
                <span>Leer términos completos</span>
                <i data-feather="arrow-right" style="width: 16px; height: 16px;"></i>
            </div>
        </a>

        <!-- Tarjeta 2: Política de Privacidad -->
        <a href="{{ route('legal.privacy') }}" style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem; display: flex; flex-direction: column; transition: all 0.3s ease; text-decoration: none; position: relative; overflow: hidden;" onmouseover="this.style.borderColor='rgba(16,185,129,0.4)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.transform='translateY(0)';">
            <div style="width: 52px; height: 52px; border-radius: 0.85rem; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); display: flex; align-items: center; justify-content: center; color: #34d399; margin-bottom: 1.5rem;">
                <i data-feather="lock" style="width: 26px; height: 26px;"></i>
            </div>
            <h3 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.75rem;">Política de Privacidad</h3>
            <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem; flex: 1;">
                Protección de tus datos personales conforme a la Ley N° 29733 y normativas internacionales (GDPR). Finalidad, cifrado y ejercicio de derechos ARCO.
            </p>
            <div style="display: flex; align-items: center; gap: 0.5rem; color: #34d399; font-weight: 700; font-size: 0.9rem;">
                <span>Ver política de datos</span>
                <i data-feather="arrow-right" style="width: 16px; height: 16px;"></i>
            </div>
        </a>

        <!-- Tarjeta 3: Envíos, Garantías y Devoluciones -->
        <a href="{{ route('legal.returns') }}" style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem; display: flex; flex-direction: column; transition: all 0.3s ease; text-decoration: none; position: relative; overflow: hidden;" onmouseover="this.style.borderColor='rgba(59,130,246,0.4)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.transform='translateY(0)';">
            <div style="width: 52px; height: 52px; border-radius: 0.85rem; background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.3); display: flex; align-items: center; justify-content: center; color: #60a5fa; margin-bottom: 1.5rem;">
                <i data-feather="rotate-ccw" style="width: 26px; height: 26px;"></i>
            </div>
            <h3 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.75rem;">Envíos y Devoluciones</h3>
            <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem; flex: 1;">
                Tiempos de despacho, política de devolución de 7 a 15 días, garantía de fábrica, procedimiento de solicitud y métodos de reembolso monetario.
            </p>
            <div style="display: flex; align-items: center; gap: 0.5rem; color: #60a5fa; font-weight: 700; font-size: 0.9rem;">
                <span>Consultar garantías</span>
                <i data-feather="arrow-right" style="width: 16px; height: 16px;"></i>
            </div>
        </a>

        <!-- Tarjeta 4: Política de Cookies -->
        <a href="{{ route('legal.cookies') }}" style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem; display: flex; flex-direction: column; transition: all 0.3s ease; text-decoration: none; position: relative; overflow: hidden;" onmouseover="this.style.borderColor='rgba(168,85,247,0.4)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='rgba(255,255,255,0.08)'; this.style.transform='translateY(0)';">
            <div style="width: 52px; height: 52px; border-radius: 0.85rem; background: rgba(168, 85, 247, 0.15); border: 1px solid rgba(168, 85, 247, 0.3); display: flex; align-items: center; justify-content: center; color: #c084fc; margin-bottom: 1.5rem;">
                <i data-feather="disc" style="width: 26px; height: 26px;"></i>
            </div>
            <h3 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.75rem;">Política de Cookies</h3>
            <p style="color: #94a3b8; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem; flex: 1;">
                Qué cookies utilizamos (técnicas de sesión, selector de moneda USD/PEN, tema visual) y cómo puedes administrarlas o desactivarlas en cualquier momento.
            </p>
            <div style="display: flex; align-items: center; gap: 0.5rem; color: #c084fc; font-weight: 700; font-size: 0.9rem;">
                <span>Información de cookies</span>
                <i data-feather="arrow-right" style="width: 16px; height: 16px;"></i>
            </div>
        </a>

        <!-- Tarjeta 5: Libro de Reclamaciones Virtual -->
        <a href="{{ route('legal.claims') }}" style="background: linear-gradient(135deg, rgba(30, 41, 59, 0.8), rgba(249, 115, 22, 0.08)); border: 1px solid rgba(249, 115, 22, 0.25); border-radius: 1.25rem; padding: 2rem; display: flex; flex-direction: column; transition: all 0.3s ease; text-decoration: none; position: relative; overflow: hidden; grid-column: span 1 / -1;" onmouseover="this.style.borderColor='rgba(249,115,22,0.6)'; this.style.transform='translateY(-4px)';" onmouseout="this.style.borderColor='rgba(249,115,22,0.25)'; this.style.transform='translateY(0)';">
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.25rem;">
                <div style="width: 52px; height: 52px; border-radius: 0.85rem; background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.4); display: flex; align-items: center; justify-content: center; color: #fb923c;">
                    <i data-feather="book-open" style="width: 26px; height: 26px;"></i>
                </div>
                <span style="background: rgba(249, 115, 22, 0.2); color: #fdba74; font-size: 0.8rem; font-weight: 700; padding: 0.35rem 0.85rem; border-radius: 9999px; border: 1px solid rgba(249, 115, 22, 0.3);">
                    Conforme a Ley N° 29571
                </span>
            </div>
            <h3 style="font-size: 1.45rem; font-weight: 700; color: #ffffff; margin-bottom: 0.75rem;">Libro de Reclamaciones Virtual</h3>
            <p style="color: #cbd5e1; font-size: 0.95rem; line-height: 1.6; margin-bottom: 1.5rem; max-width: 800px;">
                Conforme a lo establecido en el Código de Protección y Defensa del Consumidor, ponemos a disposición de nuestros usuarios nuestra plataforma oficial de atención de Reclamos y Quejas, con generación de Hoja de Reclamación y plazo de respuesta garantizado.
            </p>
            <div style="display: flex; align-items: center; gap: 0.5rem; color: #fb923c; font-weight: 700; font-size: 0.95rem;">
                <span>Ingresar al Libro de Reclamaciones</span>
                <i data-feather="arrow-right" style="width: 18px; height: 18px;"></i>
            </div>
        </a>

    </div>

    <!-- Banner de Garantías Legales y Seguridad -->
    <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.5rem; padding: 2.5rem; margin-bottom: 4rem;">
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #ffffff; margin-bottom: 1.75rem; text-align: center;">
            Pilares de Seguridad y Protección al Comprador
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 2rem;">
            <div style="display: flex; gap: 1rem;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(16, 185, 129, 0.15); color: #34d399; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-feather="shield-check" style="width: 22px; height: 22px;"></i>
                </div>
                <div>
                    <h4 style="font-size: 1.05rem; font-weight: 700; color: #ffffff; margin-bottom: 0.35rem;">Cifrado SSL 256-Bit</h4>
                    <p style="font-size: 0.85rem; color: #94a3b8; line-height: 1.5;">Toda la navegación y transmisión de datos de pago viaja cifrada bajo protocolos seguros de alta tecnología.</p>
                </div>
            </div>

            <div style="display: flex; gap: 1rem;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(59, 130, 246, 0.15); color: #60a5fa; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-feather="credit-card" style="width: 22px; height: 22px;"></i>
                </div>
                <div>
                    <h4 style="font-size: 1.05rem; font-weight: 700; color: #ffffff; margin-bottom: 0.35rem;">Pagos Seguros y Verificados</h4>
                    <p style="font-size: 0.85rem; color: #94a3b8; line-height: 1.5;">Integración con pasarelas certificadas PCI-DSS y validación bancaria directa para Yape y tarjetas de débito/crédito.</p>
                </div>
            </div>

            <div style="display: flex; gap: 1rem;">
                <div style="width: 44px; height: 44px; border-radius: 50%; background: rgba(249, 115, 22, 0.15); color: #fb923c; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                    <i data-feather="check-circle" style="width: 22px; height: 22px;"></i>
                </div>
                <div>
                    <h4 style="font-size: 1.05rem; font-weight: 700; color: #ffffff; margin-bottom: 0.35rem;">Garantía de Satisfacción</h4>
                    <p style="font-size: 0.85rem; color: #94a3b8; line-height: 1.5;">Si tu producto presenta defectos de fabricación, gestionamos la reposición o el reembolso completo de tu dinero.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Canales de Atención Legal y Contacto -->
    <div style="text-align: center; background: rgba(30, 41, 59, 0.3); border: 1px dashed rgba(255, 255, 255, 0.15); border-radius: 1.25rem; padding: 2rem;">
        <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">¿Tienes consultas sobre nuestras políticas o protección de datos?</h3>
        <p style="font-size: 0.9rem; color: #94a3b8; margin-bottom: 1.25rem;">
            Puedes registrar cualquier solicitud, queja o reclamo directamente a través de nuestro canal oficial.
        </p>
        <a href="{{ route('legal.claims') }}" style="display: inline-flex; align-items: center; gap: 0.75rem; background: rgba(249, 115, 22, 0.15); border: 1px solid rgba(249, 115, 22, 0.3); padding: 0.65rem 1.25rem; border-radius: 0.75rem; color: #fdba74; font-weight: 600; font-size: 0.95rem; text-decoration: none; transition: all 0.2s;" onmouseover="this.style.background='rgba(249,115,22,0.25)';" onmouseout="this.style.background='rgba(249,115,22,0.15)';">
            <i data-feather="book-open" style="width: 18px; height: 18px;"></i>
            <span>Ir al Libro de Reclamaciones Virtual</span>
        </a>
    </div>
</div>
@endsection
