@extends('layouts.app')

@section('title', 'Política de Cookies - GlobalClick')

@section('content')
<div class="main-container" style="max-width: 960px; margin: 0 auto; padding: 3rem 1.5rem 5rem;">
    <!-- Breadcrumb & Back -->
    <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <a href="{{ route('legal.index') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; color: #94a3b8; font-size: 0.9rem; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#c084fc'" onmouseout="this.style.color='#94a3b8'">
            <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
            <span>Volver al Centro Legal</span>
        </a>
        <span style="font-size: 0.8rem; color: #64748b;">Transparencia Digital y Tecnologías Web</span>
    </div>

    <!-- Header Section -->
    <div style="border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding-bottom: 2rem; margin-bottom: 2.5rem;">
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(168, 85, 247, 0.15); border: 1px solid rgba(168, 85, 247, 0.3); color: #d8b4fe; padding: 0.3rem 0.85rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; margin-bottom: 1rem;">
            <i data-feather="disc" style="width: 14px; height: 14px;"></i>
            <span>Cookies y Almacenamiento Local</span>
        </div>
        <h1 style="font-size: 2.5rem; font-weight: 800; color: #ffffff; letter-spacing: -0.02em; line-height: 1.2;">
            Política de Cookies y Privacidad Técnica
        </h1>
        <p style="color: #94a3b8; font-size: 1.05rem; margin-top: 0.75rem; line-height: 1.6;">
            Te explicamos con total claridad qué son las cookies, cuáles utilizamos en GlobalClick para hacer posible tu experiencia de compra y cómo puedes controlarlas en cualquier momento.
        </p>
    </div>

    <!-- Content Body -->
    <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.5rem; padding: 2.5rem; color: #cbd5e1; font-size: 0.975rem; line-height: 1.8;">
        
        <!-- Sección 1: Qué son -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #c084fc;">1.</span> ¿Qué son las Cookies y el Almacenamiento Local?
            </h2>
            <p>
                Una cookie es un pequeño archivo de texto que los sitios web descargan en tu navegador o dispositivo cuando los visitas. Las tecnologías similares, como el almacenamiento web local (<code>localStorage</code> y <code>sessionStorage</code>), permiten que el sitio web recuerde tus preferencias de navegación y mantenga la seguridad e integridad de tus sesiones de compra.
            </p>
        </section>

        <!-- Sección 2: Qué cookies usamos -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #c084fc;">2.</span> Tipos de Cookies que Empleamos
            </h2>
            
            <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                <!-- Necesarias -->
                <div style="background: rgba(15, 23, 42, 0.6); padding: 1.25rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                        <strong style="color: #ffffff; font-size: 1.05rem;">A. Cookies Técnicas y Esenciales (Obligatorias)</strong>
                        <span style="background: rgba(16, 185, 129, 0.2); color: #34d399; font-size: 0.75rem; padding: 0.15rem 0.5rem; border-radius: 0.25rem; font-weight: 700;">Requeridas</span>
                    </div>
                    <p style="font-size: 0.9rem; color: #94a3b8; margin: 0;">
                        Son indispensables para el funcionamiento correcto de la tienda: permiten mantener los productos en tu carrito de compra mientras navegas, gestionar tu sesión de usuario autenticada y proteger los formularios mediante tokens CSRF contra ataques cibernéticos. No pueden desactivarse en nuestros sistemas.
                    </p>
                </div>

                <!-- Preferencias -->
                <div style="background: rgba(15, 23, 42, 0.6); padding: 1.25rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.5rem;">
                        <strong style="color: #ffffff; font-size: 1.05rem;">B. Cookies de Personalización y Preferencias</strong>
                        <span style="background: rgba(59, 130, 246, 0.2); color: #60a5fa; font-size: 0.75rem; padding: 0.15rem 0.5rem; border-radius: 0.25rem; font-weight: 700;">Experiencia</span>
                    </div>
                    <p style="font-size: 0.9rem; color: #94a3b8; margin: 0;">
                        Permiten recordar tus elecciones personales, como el selector de divisa (USD / PEN), la configuración de tema visual (Modo Oscuro / Modo Claro) para evitar parpadeos al cargar páginas, y el estado de aceptación de políticas.
                    </p>
                </div>
            </div>
        </section>

        <!-- Sección 3: Compromiso de No Rastreo Intrusivo -->
        <section style="margin-bottom: 2.5rem; background: rgba(168, 85, 247, 0.08); border-left: 4px solid #a855f7; padding: 1.25rem 1.5rem; border-radius: 0 0.75rem 0.75rem 0;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                Compromiso de Privacidad: Sin Venta de Perfiles a Terceros
            </h2>
            <p style="font-size: 0.95rem; margin: 0;">
                En GlobalClick <strong>no instalamos cookies espías ni comercializamos tu historial de navegación con redes de publicidad invasivas</strong>. Toda tecnología de almacenamiento en nuestra plataforma tiene fines operativos y de seguridad comercial legítima.
            </p>
        </section>

        <!-- Sección 4: Cómo desactivarlas -->
        <section style="margin-bottom: 2.5rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 0.85rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #c084fc;">3.</span> ¿Cómo Administrar o Borrar las Cookies en tu Navegador?
            </h2>
            <p style="margin-bottom: 0.75rem;">
                Puedes restringir, bloquear o borrar las cookies configurando las opciones de tu navegador web en cualquier momento. A continuación te indicamos cómo hacerlo en los principales navegadores:
            </p>
            <ul style="padding-left: 1.5rem; font-size: 0.925rem;">
                <li><strong>Google Chrome:</strong> Configuración &gt; Privacidad y seguridad &gt; Cookies y otros datos de sitios.</li>
                <li><strong>Mozilla Firefox:</strong> Opciones &gt; Privacidad y seguridad &gt; Cookies y datos del sitio.</li>
                <li><strong>Apple Safari:</strong> Preferencias &gt; Privacidad &gt; Bloquear todas las cookies.</li>
                <li><strong>Microsoft Edge:</strong> Configuración &gt; Permisos del sitio &gt; Cookies y datos del sitio.</li>
            </ul>
        </section>

        <!-- Sección 5: Reset de Consentimiento -->
        <section style="background: rgba(15, 23, 42, 0.6); padding: 1.5rem; border-radius: 1rem; border: 1px solid rgba(255,255,255,0.08); text-align: center;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">Tus Preferencias Actuales de Cookies</h3>
            <p style="font-size: 0.9rem; color: #94a3b8; margin-bottom: 1.25rem;">
                Si deseas restablecer tus preferencias de cookies en esta tienda, puedes hacerlo con el botón a continuación:
            </p>
            <button type="button" onclick="resetCookiePreferences()" style="background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.4); color: #fdba74; font-weight: 700; padding: 0.65rem 1.25rem; border-radius: 0.5rem; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; font-size: 0.9rem;">
                <i data-feather="refresh-cw" style="width: 16px; height: 16px;"></i>
                Restablecer Preferencias de Cookies
            </button>
            <div id="resetFeedback" style="display: none; margin-top: 0.75rem; font-size: 0.85rem; color: #34d399;">
                ¡Preferencias restablecidas! El aviso de cookies volverá a mostrarse.
            </div>
        </section>

    </div>
</div>

<script>
function resetCookiePreferences() {
    try {
        localStorage.removeItem('globalclick_cookies_consent');
        const feedback = document.getElementById('resetFeedback');
        if (feedback) feedback.style.display = 'block';
        setTimeout(() => {
            window.location.reload();
        }, 1200);
    } catch(e) {}
}
</script>
@endsection
