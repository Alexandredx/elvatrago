@extends('layouts.app')

@section('title', 'Términos y Condiciones de Uso - GlobalClick')

@section('content')
<div class="main-container" style="max-width: 960px; margin: 0 auto; padding: 3rem 1.5rem 5rem;">
    <!-- Breadcrumb & Back -->
    <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <a href="{{ route('legal.index') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; color: #94a3b8; font-size: 0.9rem; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#94a3b8'">
            <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
            <span>Volver al Centro Legal</span>
        </a>
        <span style="font-size: 0.8rem; color: #64748b;">Última actualización: {{ date('d/m/Y') }}</span>
    </div>

    <!-- Header Section -->
    <div style="border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding-bottom: 2rem; margin-bottom: 2.5rem;">
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(249, 115, 22, 0.15); border: 1px solid rgba(249, 115, 22, 0.3); color: #fdba74; padding: 0.3rem 0.85rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; margin-bottom: 1rem;">
            <i data-feather="file-text" style="width: 14px; height: 14px;"></i>
            <span>Marco Jurídico de Contratación</span>
        </div>
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #ffffff; letter-spacing: -0.02em; line-height: 1.2;">
            Términos y Condiciones de Uso y Venta
        </h1>
        <p style="color: #94a3b8; font-size: 1.05rem; margin-top: 0.75rem; line-height: 1.6;">
            Por favor, lee detenidamente estos Términos y Condiciones antes de utilizar nuestra plataforma y realizar pedidos. Al navegar, registrarte o comprar en GlobalClick, aceptas plenamente las condiciones aquí estipuladas.
        </p>
    </div>

    <!-- Legal Content Body -->
    <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.5rem; padding: 2.5rem; color: #cbd5e1; font-size: 0.975rem; line-height: 1.8;">
        
        <!-- Sección 1 -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">1.</span> Identificación del Titular y Objeto
            </h2>
            <p>
                El presente sitio web y plataforma de comercio electrónico es operado por <strong>GlobalClick</strong> (en adelante, "La Empresa"), con domicilio legal y actividades comerciales en la República del Perú. La plataforma tiene como finalidad la exhibición, comercialización directa y distribución de productos tecnológicos, accesorios, sonido y artículos para el hogar, así como enlaces informativos de catálogo.
            </p>
        </section>

        <!-- Sección 2: Mayoría de edad (Vital para evitar nulidad de contratos) -->
        <section style="margin-bottom: 2.5rem; background: rgba(249, 115, 22, 0.08); border-left: 4px solid #f97316; padding: 1.25rem 1.5rem; border-radius: 0 0.75rem 0.75rem 0;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">2.</span> Capacidad Legal y Mayoría de Edad (18+)
            </h2>
            <p style="margin-bottom: 0.5rem;">
                Para registrar una cuenta de usuario, realizar compras, formalizar transacciones comerciales y efectuar pagos en esta plataforma, <strong>el usuario declara y garantiza ser mayor de dieciocho (18) años</strong> y contar con plena capacidad jurídica para celebrar contratos legalmente vinculantes.
            </p>
            <p style="font-size: 0.9rem; color: #fdba74;">
                La Empresa no asume responsabilidad alguna por compras o transacciones realizadas por personas que incumplan este requisito o que utilicen datos falsos de terceros.
            </p>
        </section>

        <!-- Sección 3: Cuentas y Responsabilidad del Usuario -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">3.</span> Registro de Usuario y Seguridad de la Cuenta
            </h2>
            <p>
                El usuario es el único responsable de mantener la confidencialidad de sus credenciales de acceso (correo electrónico y contraseña). Toda actividad realizada desde una cuenta autenticada se considerará efectuada válidamente por su titular. En caso de sospecha de acceso no autorizado, el usuario debe notificarlo de inmediato a través de nuestros canales de atención o registrar su reporte en la plataforma.
            </p>
        </section>

        <!-- Sección 4: Precios, Monedas y Errores Involuntarios -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">4.</span> Precios, Monedas y Cláusula de Error Tipográfico
            </h2>
            <p style="margin-bottom: 0.75rem;">
                Todos los precios de los productos están expresados en Soles Peruanos (PEN - S/.) o Dólares Americanos (USD - $), según la moneda activa en la sesión del usuario. Los precios incluyen los impuestos de ley aplicables al momento de la venta.
            </p>
            <div style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.05); padding: 1rem 1.25rem; border-radius: 0.75rem; font-size: 0.9rem;">
                <strong style="color: #ffffff;">Cláusula de Salvaguarda ante Error Manifiesto:</strong>
                A pesar de nuestros controles exhaustivos, si por un error técnico, mecanográfico o involuntario un producto fuese listado con un precio manifiestamente irrisorio o erróneo (por ejemplo, S/. 0.00 o con omisión notoria de ceros), La Empresa se reserva el derecho de cancelar la orden y notificar de inmediato al cliente, procediendo con el reembolso total del importe abonado sin que ello genere penalidades ni indemnizaciones.
            </div>
        </section>

        <!-- Sección 5: Métodos de Pago y Prevención de Fraude -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">5.</span> Pasarelas de Pago y Prevención de Fraude
            </h2>
            <p style="margin-bottom: 0.75rem;">
                GlobalClick acepta pagos mediante:
            </p>
            <ul style="padding-left: 1.5rem; margin-bottom: 0.75rem;">
                <li><strong>Tarjetas de Débito y Crédito:</strong> Procesadas bajo protocolos seguros con tokenización y cumplimiento PCI-DSS.</li>
                <li><strong>Billeteras Digitales (Yape / Transferencia BCP):</strong> Requiere validación del código de aprobación o número de operación emitido por el aplicativo bancario.</li>
            </ul>
            <p>
                Por razones de seguridad nacional e internacional contra el fraude electrónico, La Empresa podrá someter las operaciones a verificaciones aleatorias y reservarse el derecho de anular pedidos con indicios razonables de usurpación de identidad o fondos de procedencia ilícita.
            </p>
        </section>

        <!-- Sección 6: Envíos y Entrega -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">6.</span> Despacho, Tiempos de Entrega y Recepción
            </h2>
            <p style="margin-bottom: 0.75rem;">
                Los productos serán entregados en la dirección física especificada por el comprador durante el proceso de checkout. Es responsabilidad exclusiva del cliente proveer una dirección exacta, completa y con referencias claras.
            </p>
            <p>
                La entrega se considerará válidamente completada cuando el paquete sea recepcionado en el domicilio indicado, requiriéndose la firma de cargo y/o constatación de documento de identidad de quien reciba el pedido.
            </p>
        </section>

        <!-- Sección 7: Devoluciones y Garantías -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">7.</span> Política de Devoluciones y Garantía Legal
            </h2>
            <p style="margin-bottom: 0.75rem;">
                El cliente cuenta con un plazo de <strong>siete (7) a quince (15) días calendario</strong> a partir de la recepción del bien para solicitar devoluciones por defecto de fabricación o inconformidad justificada, conforme a los términos detallados en nuestra <a href="{{ route('legal.returns') }}" style="color: #fb923c; text-decoration: underline;">Política de Envíos y Devoluciones</a> y a través del canal oficial de <a href="{{ route('returns.public.create') }}" style="color: #34d399; text-decoration: underline;">Solicitud de Devolución</a>.
            </p>
        </section>

        <!-- Sección 8: Limitación de Responsabilidad -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">8.</span> Exención y Limitación de Responsabilidad
            </h2>
            <p>
                La Empresa no será responsable por daños indirectos, incidentales o lucro cesante derivados del uso o imposibilidad de uso del sitio web, ni por fallas en las redes de telecomunicaciones, servidores ajenos, ciberataques imprevisibles, huelgas de operadores logísticos o eventos calificados legalmente como caso fortuito o fuerza mayor.
            </p>
        </section>

        <!-- Sección 9: Propiedad Intelectual -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">9.</span> Propiedad Intelectual e Industrial
            </h2>
            <p>
                Todo el software, código fuente, logotipos, diseños gráficos, interfaces, textos, fotografías y elementos audiovisuales que componen la plataforma son de propiedad exclusiva de La Empresa o se encuentran debidamente autorizados por sus legítimos titulares. Queda estrictamente prohibida su copia, distribución o ingeniería inversa sin consentimiento previo y por escrito.
            </p>
        </section>

        <!-- Sección 10: Jurisdicción y Ley Aplicable -->
        <section>
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">10.</span> Jurisdicción y Resolución de Disputas
            </h2>
            <p style="margin-bottom: 0.75rem;">
                Estos Términos y Condiciones se rigen por las leyes de la República del Perú. Para la resolución de cualquier controversia emanada de su interpretación o cumplimiento, las partes se someten a los juzgados y tribunales del Distrito Judicial de Lima, sin perjuicio de los mecanismos administrativos de protección al consumidor previstos en el Código de Protección y Defensa del Consumidor (Ley N° 29571) ante el INDECOPI.
            </p>
            <p style="font-size: 0.9rem; color: #94a3b8;">
                Para reclamos formales, ponemos a su disposición nuestro <a href="{{ route('legal.claims') }}" style="color: #fb923c; font-weight: 700;">Libro de Reclamaciones Virtual</a>.
            </p>
        </section>

    </div>
</div>
@endsection
