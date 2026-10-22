<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GlobalClick - Tienda E-Commerce & Afiliados')</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    <!-- Early Theme Detection (Evita parpadeos) -->
    <script>
        (function() {
            try {
                var savedTheme = localStorage.getItem('globalclick_theme') || localStorage.getItem('elvatrago_theme') || 'dark';
                if (savedTheme === 'light') {
                    document.documentElement.setAttribute('data-theme', 'light');
                }
            } catch(e) {}
        })();
    </script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @yield('styles')
</head>
<body>
    <!-- Navbar Header -->
    <nav class="glass-nav">
        <div class="nav-container">
            <a href="{{ route('shop.index') }}" class="logo-brand">
                <i data-feather="shopping-bag"></i>
                <span>GlobalClick</span>
            </a>

            <!-- Search Bar -->
            <form action="{{ route('shop.index') }}" method="GET" class="search-form">
                <i data-feather="search" class="search-icon"></i>
                <input type="text" name="search" class="search-input" placeholder="Buscar productos en la tienda..." value="{{ request('search') }}">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
            </form>

            <!-- Navigation Action Buttons -->
            <div class="nav-actions">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-btn btn-admin">
                            <i data-feather="layout"></i>
                            <span>Panel Admin</span>
                        </a>
                    @endif
                @endauth

                @php
                    $cartCount = count(session('cart', []));
                @endphp
                <a href="{{ route('cart.index') }}" class="nav-btn btn-cart">
                    <i data-feather="shopping-cart"></i>
                    <span>Carrito</span>
                    @if($cartCount > 0)
                        <span class="cart-badge">{{ $cartCount }}</span>
                    @endif
                </a>

                <!-- Opción Pedidos (Historial y compras del cliente) -->
                <a href="{{ route('client.orders.index') }}" class="nav-btn" style="background: {{ request()->routeIs('client.orders.*') ? 'rgba(249, 115, 22, 0.25)' : 'rgba(30, 41, 59, 0.8)' }}; border: 1px solid {{ request()->routeIs('client.orders.*') ? 'rgba(249, 115, 22, 0.5)' : 'rgba(255, 255, 255, 0.12)' }}; color: {{ request()->routeIs('client.orders.*') ? '#ffffff' : '#f1f5f9' }}; display: flex; align-items: center; gap: 0.5rem; padding: 0.55rem 0.95rem; border-radius: 9999px; font-weight: 600; font-size: 0.85rem; text-decoration: none; transition: all 0.2s ease;">
                    <i data-feather="package" style="width: 16px; height: 16px; color: #fb923c;"></i>
                    <span>Pedidos</span>
                    @auth
                        @php
                            $userOrdersCount = \App\Models\Order::where(function($q) {
                                $q->where('user_id', Auth::id())
                                  ->orWhere('customer_email', Auth::user()->email);
                            })->count();
                        @endphp
                        @if($userOrdersCount > 0)
                            <span style="background: #f97316; color: #ffffff; font-size: 0.7rem; font-weight: 800; padding: 0.1rem 0.45rem; border-radius: 9999px; min-width: 18px; text-align: center;">
                                {{ $userOrdersCount }}
                            </span>
                        @endif
                    @endauth
                </a>

                <!-- Sección de Usuario y Configuración (Tuerquita al lado del usuario) -->
                <div style="display: flex; align-items: center; gap: 0.65rem; margin-left: 0.5rem; border-left: 1px solid rgba(255,255,255,0.1); padding-left: 0.75rem;">
                    @auth
                        <span style="font-size: 0.85rem; font-weight: 700; color: #fdba74; display: flex; align-items: center; gap: 0.35rem;" title="Rol: {{ Auth::user()->isAdmin() ? 'Administrador' : 'Cliente' }}">
                            <i data-feather="{{ Auth::user()->isAdmin() ? 'shield' : 'user' }}" style="width: 14px; height: 14px; color: {{ Auth::user()->isAdmin() ? '#fb923c' : '#fdba74' }};"></i> 
                            {{ Auth::user()->name }}
                        </span>
                    @else
                        <a href="{{ route('login') }}" class="nav-btn btn-admin" style="font-size: 0.8rem; padding: 0.45rem 0.85rem;">
                            <i data-feather="log-in" style="width: 14px; height: 14px;"></i> Ingresar
                        </a>
                        <a href="{{ route('register') }}" class="nav-btn" style="background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.4); color: #fdba74; font-size: 0.8rem; padding: 0.45rem 0.85rem;">
                            <i data-feather="user-plus" style="width: 14px; height: 14px;"></i> Registro
                        </a>
                    @endauth

                    <!-- Tuerquita de Configuración -->
                    <div class="settings-dropdown-wrapper" id="settingsDropdownWrapper">
                        <button type="button" 
                                id="btnSettingsDropdown" 
                                class="btn-gear-only" 
                                aria-expanded="false" 
                                aria-haspopup="true"
                                title="Configuración">
                            <i data-feather="settings" class="settings-gear-icon"></i>
                        </button>

                        <!-- Menú flotante con las opciones de Configuración -->
                        <div id="settingsDropdownMenu" class="settings-dropdown-popover" style="display: none;">
                            <div class="settings-dropdown-popover-header">
                                <i data-feather="settings" style="width: 13px; height: 13px; color: #fb923c;"></i>
                                <span>Configuración</span>
                            </div>
                            <div class="settings-dropdown-popover-content">
                                <!-- Opción 1: Cambio de moneda -->
                                <a href="{{ route('settings.currency') }}" class="settings-dropdown-link-item">
                                    <div class="settings-link-left">
                                        <div class="settings-link-icon-box">
                                            <i data-feather="dollar-sign" style="width: 15px; height: 15px;"></i>
                                        </div>
                                        <div class="settings-link-info">
                                            <span class="settings-link-title">Cambio de moneda</span>
                                            <span class="settings-link-subtitle">Actual: {{ session('currency', 'PEN') === 'USD' ? 'Dólares ($)' : 'Soles (S/.)' }}</span>
                                        </div>
                                    </div>
                                    <i data-feather="chevron-right" class="settings-link-arrow"></i>
                                </a>

                                <!-- Opción 2: Modo Claro / Oscuro -->
                                <div class="settings-dropdown-link-item settings-theme-toggle-item" 
                                     id="btnToggleTheme" 
                                     onclick="toggleThemeMode()" 
                                     role="button" 
                                     tabindex="0"
                                     title="Alternar entre modo claro y modo oscuro">
                                    <div class="settings-link-left">
                                        <div class="settings-link-icon-box theme-icon-box" id="themeIconContainer">
                                            <i data-feather="moon" id="themeIconFeather" style="width: 15px; height: 15px;"></i>
                                        </div>
                                        <div class="settings-link-info">
                                            <span class="settings-link-title">Tema Visual</span>
                                            <span class="settings-link-subtitle" id="themeSubtitleLabel">Modo Oscuro</span>
                                        </div>
                                    </div>
                                    <!-- Switch Toggle visual interactivo -->
                                    <div class="theme-switch-control" id="themeSwitchControl">
                                        <div class="theme-switch-knob"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @auth
                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" title="Cerrar Sesión" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 0.45rem 0.75rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.35rem; transition: all 0.2s ease;">
                                <i data-feather="log-out" style="width: 14px; height: 14px;"></i> Salir
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Alert Messages -->
    <div style="max-width: 1280px; margin: 1rem auto 0; padding: 0 1.5rem;">
        @if(session('success'))
            <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399; padding: 0.85rem 1.25rem; border-radius: 0.75rem; display: flex; align-items: center; gap: 0.75rem;">
                <i data-feather="check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; padding: 0.85rem 1.25rem; border-radius: 0.75rem; display: flex; align-items: center; gap: 0.75rem;">
                <i data-feather="alert-circle"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif
    </div>

    <!-- Main Content Body -->
    <main style="flex: 1;">
        @yield('content')
    </main>

    <!-- Comprehensive Legal & E-Commerce Footer -->
    <footer style="background: rgba(11, 15, 25, 0.95); border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 3.5rem; padding-bottom: 2rem; margin-top: 4rem;">
        <div style="max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;">
            
            <!-- Footer Multi-Columns Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(230px, 1fr)); gap: 2.5rem; margin-bottom: 3rem;">
                
                <!-- Columna 1: Marca y Razón Social -->
                <div>
                    <a href="{{ route('shop.index') }}" class="logo-brand" style="display: inline-flex; margin-bottom: 1rem;">
                        <i data-feather="shopping-bag" style="color: #f97316;"></i>
                        <span>GlobalClick</span>
                    </a>
                    <p style="color: #94a3b8; font-size: 0.85rem; line-height: 1.6; margin-bottom: 1.25rem;">
                        Plataforma oficial de comercio electrónico. Ofrecemos compras 100% protegidas, estricto apego a la legislación de protección al consumidor y despacho directo a nivel nacional.
                    </p>
                    <div style="font-size: 0.78rem; color: #64748b; line-height: 1.5;">
                        <strong style="color: #cbd5e1;">GlobalClick</strong><br>
                        Tienda Virtual & Comercio Minorista<br>
                        Lima, República del Perú
                    </div>
                </div>

                <!-- Columna 2: Navegación de la Tienda -->
                <div>
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: #ffffff; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1.25rem;">
                        Comprar & Servicios
                    </h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.65rem; font-size: 0.875rem;">
                        <li><a href="{{ route('shop.index') }}" style="color: #cbd5e1; transition: color 0.2s;" onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#cbd5e1'">Catálogo de Productos</a></li>
                        <li><a href="{{ route('cart.index') }}" style="color: #cbd5e1; transition: color 0.2s;" onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#cbd5e1'">Carrito de Compras</a></li>
                        <li><a href="{{ route('client.orders.index') }}" style="color: #cbd5e1; transition: color 0.2s;" onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#cbd5e1'">Seguimiento de Mis Pedidos</a></li>
                        <li><a href="{{ route('returns.public.create') }}" style="color: #fb923c; transition: color 0.2s;" onmouseover="this.style.color='#fdba74'" onmouseout="this.style.color='#fb923c'">Solicitud de Devolución Online</a></li>
                        <li><a href="{{ route('settings.currency') }}" style="color: #cbd5e1; transition: color 0.2s;" onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#cbd5e1'">Configuración de Moneda (USD / PEN)</a></li>
                    </ul>
                </div>

                <!-- Columna 3: Centro Legal y Políticas -->
                <div>
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: #ffffff; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1.25rem;">
                        Políticas y Legal
                    </h4>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.65rem; font-size: 0.875rem;">
                        <li><a href="{{ route('legal.index') }}" style="color: #cbd5e1; font-weight: 600; transition: color 0.2s;" onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#cbd5e1'">Centro de Políticas (General)</a></li>
                        <li><a href="{{ route('legal.terms') }}" style="color: #cbd5e1; transition: color 0.2s;" onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#cbd5e1'">Términos y Condiciones de Uso</a></li>
                        <li><a href="{{ route('legal.privacy') }}" style="color: #cbd5e1; transition: color 0.2s;" onmouseover="this.style.color='#10b981'" onmouseout="this.style.color='#cbd5e1'">Política de Privacidad y Datos</a></li>
                        <li><a href="{{ route('legal.returns') }}" style="color: #cbd5e1; transition: color 0.2s;" onmouseover="this.style.color='#60a5fa'" onmouseout="this.style.color='#cbd5e1'">Política de Envíos y Devoluciones</a></li>
                        <li><a href="{{ route('legal.cookies') }}" style="color: #cbd5e1; transition: color 0.2s;" onmouseover="this.style.color='#c084fc'" onmouseout="this.style.color='#cbd5e1'">Política de Cookies</a></li>
                    </ul>
                </div>

                <!-- Columna 4: Libro de Reclamaciones e INDECOPI -->
                <div>
                    <h4 style="font-size: 0.95rem; font-weight: 700; color: #ffffff; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 1.25rem;">
                        Protección al Consumidor
                    </h4>
                    
                    <!-- Botón Destacado Libro de Reclamaciones -->
                    <a href="{{ route('legal.claims') }}" style="background: rgba(249, 115, 22, 0.12); border: 1px solid rgba(249, 115, 22, 0.35); border-radius: 0.85rem; padding: 1rem 1.15rem; display: flex; align-items: center; gap: 0.85rem; text-decoration: none; margin-bottom: 1rem; transition: all 0.2s ease;" onmouseover="this.style.background='rgba(249,115,22,0.2)'; this.style.borderColor='#f97316';" onmouseout="this.style.background='rgba(249,115,22,0.12)'; this.style.borderColor='rgba(249,115,22,0.35)';">
                        <div style="width: 40px; height: 40px; border-radius: 0.5rem; background: #f97316; color: #ffffff; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i data-feather="book-open" style="width: 20px; height: 20px;"></i>
                        </div>
                        <div>
                            <div style="font-size: 0.85rem; font-weight: 800; color: #ffffff;">Libro de Reclamaciones</div>
                            <div style="font-size: 0.72rem; color: #fdba74;">Virtual conforme a Ley N° 29571</div>
                        </div>
                    </a>

                    <div style="font-size: 0.78rem; color: #94a3b8; line-height: 1.5;">
                        Atención directa a clientes y resolución de controversias en nuestra plataforma digital.
                    </div>
                </div>

            </div>

            <!-- Badges de Seguridad y Métodos de Pago -->
            <div style="border-top: 1px solid rgba(255, 255, 255, 0.06); border-bottom: 1px solid rgba(255, 255, 255, 0.06); padding: 1.25rem 0; margin-bottom: 1.5rem; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
                <div style="display: flex; align-items: center; gap: 1.5rem; flex-wrap: wrap; font-size: 0.8rem; color: #94a3b8;">
                    <div style="display: flex; align-items: center; gap: 0.4rem; color: #34d399;">
                        <i data-feather="shield-check" style="width: 16px; height: 16px;"></i>
                        <span>Cifrado SSL 256-Bit</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.4rem; color: #60a5fa;">
                        <i data-feather="lock" style="width: 16px; height: 16px;"></i>
                        <span>Pagos Protegidos PCI-DSS</span>
                    </div>
                    <div style="display: flex; align-items: center; gap: 0.4rem; color: #fdba74;">
                        <i data-feather="check" style="width: 16px; height: 16px;"></i>
                        <span>Garantía de Satisfacción</span>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 0.65rem; flex-wrap: wrap;">
                    <span style="font-size: 0.75rem; color: #64748b; font-weight: 700; text-transform: uppercase;">Aceptamos:</span>
                    <span style="background: rgba(255,255,255,0.06); padding: 0.25rem 0.55rem; border-radius: 0.35rem; font-size: 0.75rem; font-weight: 700; color: #ffffff;">VISA</span>
                    <span style="background: rgba(255,255,255,0.06); padding: 0.25rem 0.55rem; border-radius: 0.35rem; font-size: 0.75rem; font-weight: 700; color: #ffffff;">MASTERCARD</span>
                    <span style="background: rgba(116, 34, 132, 0.25); border: 1px solid rgba(116, 34, 132, 0.5); padding: 0.25rem 0.55rem; border-radius: 0.35rem; font-size: 0.75rem; font-weight: 800; color: #00d2c4;">YAPE BCP</span>
                </div>
            </div>

            <!-- Copyright and Legal Disclaimer Bar -->
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; font-size: 0.8rem; color: #64748b;">
                <div>
                    &copy; {{ date('Y') }} <strong>GlobalClick</strong> — Todos los derechos reservados.
                </div>
                <div style="display: flex; gap: 1.25rem; align-items: center; flex-wrap: wrap;">
                    <a href="{{ route('legal.terms') }}" style="color: #94a3b8; text-decoration: none;">Términos</a>
                    <a href="{{ route('legal.privacy') }}" style="color: #94a3b8; text-decoration: none;">Privacidad</a>
                    <a href="{{ route('legal.claims') }}" style="color: #f97316; font-weight: 700; text-decoration: none;">Libro de Reclamaciones</a>
                    @auth
                        @if(Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" style="color: #fb923c;">Panel Admin</a>
                        @endif
                    @endauth
                </div>
            </div>

        </div>
    </footer>

    <!-- Banner Flotante de Consentimiento de Cookies -->
    <div id="cookieConsentBanner" style="display: none; position: fixed; bottom: 1.5rem; left: 1.5rem; right: 1.5rem; max-width: 600px; margin: 0 auto; background: rgba(15, 23, 42, 0.92); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border: 1px solid rgba(249, 115, 22, 0.3); border-radius: 1.25rem; padding: 1.25rem 1.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.6); z-index: 9999; animation: slideUpCookie 0.4s ease-out;">
        <div style="display: flex; align-items: flex-start; gap: 1rem;">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: rgba(249, 115, 22, 0.15); color: #f97316; display: flex; align-items: center; justify-content: center; flex-shrink: 0; margin-top: 0.15rem;">
                <i data-feather="disc" style="width: 18px; height: 18px;"></i>
            </div>
            <div style="flex: 1;">
                <div style="font-size: 0.9rem; font-weight: 700; color: #ffffff; margin-bottom: 0.35rem;">
                    Uso de Cookies y Preferencias
                </div>
                <p style="font-size: 0.8rem; color: #94a3b8; line-height: 1.5; margin: 0 0 0.85rem;">
                    Utilizamos cookies técnicas necesarias y de personalización (tema visual y selector de divisa USD/PEN) para garantizar el funcionamiento seguro de la tienda. Puedes revisar los detalles en nuestra 
                    <a href="{{ route('legal.cookies') }}" style="color: #fdba74; text-decoration: underline; font-weight: 600;">Política de Cookies</a>.
                </p>
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <button type="button" onclick="acceptCookies('all')" style="background: var(--accent-gradient); border: none; color: #ffffff; font-size: 0.8rem; font-weight: 700; padding: 0.45rem 1rem; border-radius: 0.5rem; cursor: pointer; box-shadow: 0 2px 8px rgba(249, 115, 22, 0.4);">
                        Aceptar Todas
                    </button>
                    <button type="button" onclick="acceptCookies('essential')" style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); color: #cbd5e1; font-size: 0.8rem; font-weight: 600; padding: 0.45rem 0.85rem; border-radius: 0.5rem; cursor: pointer;">
                        Solo Necesarias
                    </button>
                </div>
            </div>
            <button type="button" onclick="acceptCookies('essential')" aria-label="Cerrar aviso de cookies" style="background: none; border: none; color: #64748b; cursor: pointer; padding: 0.25rem;">
                <i data-feather="x" style="width: 16px; height: 16px;"></i>
            </button>
        </div>
    </div>

    <style>
    @keyframes slideUpCookie {
        from { transform: translateY(40px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    </style>

    <script>
        feather.replace();

        // Función para actualizar los elementos visuales del tema (icono, texto)
        function updateThemeUI(theme) {
            const subtitle = document.getElementById('themeSubtitleLabel');
            const iconContainer = document.getElementById('themeIconContainer');
            
            if (theme === 'light') {
                if (subtitle) subtitle.textContent = 'Modo Claro';
                if (iconContainer) {
                    iconContainer.innerHTML = '<i data-feather="sun" style="width: 15px; height: 15px;"></i>';
                    iconContainer.classList.add('is-light-theme');
                }
            } else {
                if (subtitle) subtitle.textContent = 'Modo Oscuro';
                if (iconContainer) {
                    iconContainer.innerHTML = '<i data-feather="moon" style="width: 15px; height: 15px;"></i>';
                    iconContainer.classList.remove('is-light-theme');
                }
            }
            if (window.feather) feather.replace();
        }

        // Alternar entre modo claro y modo oscuro
        function toggleThemeMode() {
            const currentTheme = document.documentElement.getAttribute('data-theme');
            const newTheme = currentTheme === 'light' ? 'dark' : 'light';
            
            if (newTheme === 'light') {
                document.documentElement.setAttribute('data-theme', 'light');
                try { localStorage.setItem('globalclick_theme', 'light'); } catch(e) {}
            } else {
                document.documentElement.removeAttribute('data-theme');
                try { localStorage.setItem('globalclick_theme', 'dark'); } catch(e) {}
            }
            
            updateThemeUI(newTheme);
        }

        // Control del desplegable de configuración (Tuerquita)
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar estado del tema visual
            const currentTheme = document.documentElement.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
            updateThemeUI(currentTheme);

            const btnSettings = document.getElementById('btnSettingsDropdown');
            const settingsMenu = document.getElementById('settingsDropdownMenu');
            const settingsWrapper = document.getElementById('settingsDropdownWrapper');

            if (btnSettings && settingsMenu) {
                btnSettings.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isHidden = settingsMenu.style.display === 'none' || settingsMenu.style.display === '';
                    if (isHidden) {
                        settingsMenu.style.display = 'block';
                        btnSettings.classList.add('is-open');
                        btnSettings.setAttribute('aria-expanded', 'true');
                    } else {
                        settingsMenu.style.display = 'none';
                        btnSettings.classList.remove('is-open');
                        btnSettings.setAttribute('aria-expanded', 'false');
                    }
                });

                // Cerrar al hacer clic fuera
                document.addEventListener('click', function(e) {
                    if (settingsWrapper && !settingsWrapper.contains(e.target)) {
                        settingsMenu.style.display = 'none';
                        btnSettings.classList.remove('is-open');
                        btnSettings.setAttribute('aria-expanded', 'false');
                    }
                });

                // Cerrar con Escape
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        settingsMenu.style.display = 'none';
                        btnSettings.classList.remove('is-open');
                        btnSettings.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            // Detección y visualización del banner de Cookies
            try {
                const cookieConsent = localStorage.getItem('globalclick_cookies_consent');
                const cookieBanner = document.getElementById('cookieConsentBanner');
                if (!cookieConsent && cookieBanner) {
                    setTimeout(() => {
                        cookieBanner.style.display = 'block';
                    }, 800);
                }
            } catch(e) {}
        });

        // Función para aceptar y guardar consentimiento de cookies
        function acceptCookies(preference) {
            try {
                localStorage.setItem('globalclick_cookies_consent', preference);
                const cookieBanner = document.getElementById('cookieConsentBanner');
                if (cookieBanner) {
                    cookieBanner.style.opacity = '0';
                    cookieBanner.style.transform = 'translateY(20px)';
                    cookieBanner.style.transition = 'all 0.3s ease';
                    setTimeout(() => {
                        cookieBanner.style.display = 'none';
                    }, 300);
                }
            } catch(e) {}
        }
    </script>
    @yield('scripts')
</body>
</html>
