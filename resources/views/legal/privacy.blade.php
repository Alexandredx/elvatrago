@extends('layouts.app')

@section('title', 'Política de Privacidad y Protección de Datos - GlobalClick')

@section('content')
<div class="main-container" style="max-width: 960px; margin: 0 auto; padding: 3rem 1.5rem 5rem;">
    <!-- Breadcrumb & Back -->
    <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <a href="{{ route('legal.index') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; color: #94a3b8; font-size: 0.9rem; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='#94a3b8'">
            <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
            <span>Volver al Centro Legal</span>
        </a>
        <span style="font-size: 0.8rem; color: #64748b;">Conforme a la Ley N° 29733 y normativa internacional</span>
    </div>

    <!-- Header Section -->
    <div style="border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding-bottom: 2rem; margin-bottom: 2.5rem;">
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; padding: 0.3rem 0.85rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; margin-bottom: 1rem;">
            <i data-feather="lock" style="width: 14px; height: 14px;"></i>
            <span>Protección de Datos Personales</span>
        </div>
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #ffffff; letter-spacing: -0.02em; line-height: 1.2;">
            Política de Privacidad y Tratamiento de Datos
        </h1>
        <p style="color: #94a3b8; font-size: 1.05rem; margin-top: 0.75rem; line-height: 1.6;">
            En GlobalClick garantizamos la confidencialidad, integridad y seguridad de la información personal de nuestros usuarios. A continuación, detallamos de forma transparente cómo recopilamos, utilizamos y protegemos tus datos.
        </p>
    </div>

    <!-- Privacy Content Body -->
    <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.5rem; padding: 2.5rem; color: #cbd5e1; font-size: 0.975rem; line-height: 1.8;">
        
        <!-- Sección 1 -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #10b981;">1.</span> Responsable del Banco de Datos Personales
            </h2>
            <p>
                El responsable del tratamiento de los datos personales recopilados a través de este sitio web es <strong>GlobalClick</strong> (en adelante, "La Empresa"), con domicilio legal en Lima, Perú. Los datos personales son almacenados en bancos de datos automatizados que cumplen con las medidas técnicas, organizativas y legales exigidas por la Ley N° 29733 (Ley de Protección de Datos Personales) y su Reglamento.
            </p>
        </section>

        <!-- Sección 2 -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #10b981;">2.</span> Información que Recopilamos
            </h2>
            <p style="margin-bottom: 0.75rem;">Para operar nuestros servicios de comercio electrónico, solicitamos únicamente la información indispensable:</p>
            <ul style="padding-left: 1.5rem; margin-bottom: 0.75rem;">
                <li><strong>Datos identificativos:</strong> Nombre completo, documento de identidad (DNI, CE, Pasaporte o RUC).</li>
                <li><strong>Datos de contacto:</strong> Correo electrónico, número de teléfono o celular y dirección de entrega.</li>
                <li><strong>Datos transaccionales:</strong> Historial de compras, productos solicitados y comprobantes de pago.</li>
                <li><strong>Datos técnicos y de navegación:</strong> Dirección IP anonimizada, preferencias de sesión (tema visual claro/oscuro y selector de moneda).</li>
            </ul>
            <div style="background: rgba(16, 185, 129, 0.1); border: 1px solid rgba(16, 185, 129, 0.25); padding: 0.85rem 1.25rem; border-radius: 0.75rem; font-size: 0.9rem; color: #a7f3d0;">
                <i data-feather="check-shield" style="width: 16px; height: 16px; display: inline-block; vertical-align: middle; margin-right: 0.35rem;"></i>
                <strong>No almacenamos datos sensibles de tarjetas:</strong> Los datos críticos de tarjetas bancarias (CVV, fecha completa de vencimiento) se transmiten directamente a través de pasarelas de pago cifradas con tokenización y nunca son guardados en nuestros servidores.
            </div>
        </section>

        <!-- Sección 3 -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #10b981;">3.</span> Finalidad del Tratamiento de Datos
            </h2>
            <p style="margin-bottom: 0.75rem;">Los datos personales serán utilizados exclusivamente para los siguientes propósitos:</p>
            <ol style="padding-left: 1.5rem; margin-bottom: 0.75rem;">
                <li>Procesar, validar y facturar tus compras y órdenes de pedido.</li>
                <li>Coordinar el despacho logístico y la entrega física en tu domicilio.</li>
                <li>Notificar el estado de tus órdenes, guías de despacho y comprobantes electrónicos.</li>
                <li>Gestionar solicitudes de garantía, devoluciones y reembolsos.</li>
                <li>Atender reclamaciones o quejas a través del Libro de Reclamaciones Virtual.</li>
                <li>Prevención de fraudes electrónicos y suplantación de identidad.</li>
            </ol>
            <p style="font-size: 0.9rem; color: #94a3b8;">
                <strong>Garantía de no comercialización:</strong> GlobalClick jamás venderá, alquilará ni comercializará tus datos personales a empresas de publicidad ni a terceros.
            </p>
        </section>

        <!-- Sección 4 -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #10b981;">4.</span> Terceros Encargados del Tratamiento
            </h2>
            <p>
                Para el estricto cumplimiento del servicio contratado, tus datos pueden ser compartidos de forma controlada con proveedores de servicios esenciales (terceros encargados), tales como:
            </p>
            <ul style="padding-left: 1.5rem; margin-top: 0.5rem;">
                <li><strong>Empresas de mensajería y courier logístico:</strong> Exclusivamente nombre, teléfono y dirección de entrega para hacer llegar el pedido.</li>
                <li><strong>Pasarelas de procesamiento de pago (Culqi / BCP Yape):</strong> Para procesar transacciones bancarias autorizadas por el cliente.</li>
                <li><strong>Autoridades tributarias o judiciales:</strong> Únicamente en caso de requerimiento legal formal y fundado en ley.</li>
            </ul>
        </section>

        <!-- Sección 5: Derechos ARCO -->
        <section style="margin-bottom: 2.5rem; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); padding: 1.75rem; border-radius: 1rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #10b981;">5.</span> Ejercicio de Derechos ARCO
            </h2>
            <p style="margin-bottom: 0.85rem;">
                De acuerdo a la legislación vigente, todo usuario tiene derecho a ejercer en cualquier momento sus derechos de <strong>Acceso, Rectificación, Cancelación y Oposición (ARCO)</strong> respecto de sus datos personales.
            </p>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem; margin-bottom: 1.25rem;">
                <div style="background: rgba(30, 41, 59, 0.5); padding: 0.85rem; border-radius: 0.5rem;">
                    <strong style="color: #34d399; font-size: 0.9rem;">Acceso:</strong>
                    <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">Conocer qué datos personales tuyos poseemos y su finalidad.</div>
                </div>
                <div style="background: rgba(30, 41, 59, 0.5); padding: 0.85rem; border-radius: 0.5rem;">
                    <strong style="color: #34d399; font-size: 0.9rem;">Rectificación:</strong>
                    <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">Actualizar o corregir datos incompletos o erróneos.</div>
                </div>
                <div style="background: rgba(30, 41, 59, 0.5); padding: 0.85rem; border-radius: 0.5rem;">
                    <strong style="color: #34d399; font-size: 0.9rem;">Cancelación:</strong>
                    <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">Solicitar la supresión o eliminación de tus datos personales.</div>
                </div>
                <div style="background: rgba(30, 41, 59, 0.5); padding: 0.85rem; border-radius: 0.5rem;">
                    <strong style="color: #34d399; font-size: 0.9rem;">Oposición:</strong>
                    <div style="font-size: 0.8rem; color: #94a3b8; margin-top: 0.25rem;">Oponerte al uso de tus datos para motivos legítimos específicos.</div>
                </div>
            </div>
            <p style="font-size: 0.9rem; color: #cbd5e1;">
                Para ejercer cualquiera de estos derechos, el titular de los datos puede registrar su solicitud formal a través de nuestro <a href="{{ route('legal.claims') }}" style="color: #34d399; font-weight: 700; text-decoration: underline;">Libro de Reclamaciones Virtual</a>, indicando sus nombres completos, documento de identidad y pedido concreto. Las solicitudes serán atendidas dentro del plazo máximo legal establecido.
            </p>
        </section>

        <!-- Sección 6: Seguridad -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #10b981;">6.</span> Medidas de Seguridad Técnicas
            </h2>
            <p>
                Implementamos estándares de seguridad de nivel bancario, que incluyen cifrado SSL/TLS de 256 bits en todas las comunicaciones, almacenamiento seguro de contraseñas mediante algoritmos hash irreversibles (Bcrypt), cortafuegos perimetrales y copias de seguridad continuas para impedir el acceso no autorizado o la pérdida de datos.
            </p>
        </section>

        <!-- Sección 7: Conservación -->
        <section>
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #10b981;">7.</span> Plazo de Conservación de Datos
            </h2>
            <p>
                Los datos personales se conservarán mientras se mantenga la relación contractual y el usuario conserve su cuenta activa, y posteriormente durante el plazo legal obligatorio establecido por la normativa tributaria y de protección al consumidor (hasta 5 años para comprobantes de pago y auditoría fiscal).
            </p>
        </section>

    </div>
</div>
@endsection
