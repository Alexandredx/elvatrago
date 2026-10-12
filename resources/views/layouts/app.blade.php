<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Elvatrago - Tienda E-Commerce & Afiliados')</title>
    
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
                var savedTheme = localStorage.getItem('elvatrago_theme') || 'dark';
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
                <span>ELVATRAGO</span>
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
                <a href="{{ route('client.orders.index') }}" class="nav-btn" style="background: {{ request()->routeIs('client.orders.*') ? 'rgba(99, 102, 241, 0.25)' : 'rgba(30, 41, 59, 0.8)' }}; border: 1px solid {{ request()->routeIs('client.orders.*') ? 'rgba(99, 102, 241, 0.5)' : 'rgba(255, 255, 255, 0.12)' }}; color: {{ request()->routeIs('client.orders.*') ? '#ffffff' : '#f1f5f9' }}; display: flex; align-items: center; gap: 0.5rem; padding: 0.55rem 0.95rem; border-radius: 9999px; font-weight: 600; font-size: 0.85rem; text-decoration: none; transition: all 0.2s ease;">
                    <i data-feather="package" style="width: 16px; height: 16px; color: #818cf8;"></i>
                    <span>Pedidos</span>
                    @auth
                        @php
                            $userOrdersCount = \App\Models\Order::where(function($q) {
                                $q->where('user_id', Auth::id())
                                  ->orWhere('customer_email', Auth::user()->email);
                            })->count();
                        @endphp
                        @if($userOrdersCount > 0)
                            <span style="background: #6366f1; color: #ffffff; font-size: 0.7rem; font-weight: 800; padding: 0.1rem 0.45rem; border-radius: 9999px; min-width: 18px; text-align: center;">
                                {{ $userOrdersCount }}
                            </span>
                        @endif
                    @endauth
                </a>

                <!-- Sección de Usuario y Configuración (Tuerquita al lado del usuario) -->
                <div style="display: flex; align-items: center; gap: 0.65rem; margin-left: 0.5rem; border-left: 1px solid rgba(255,255,255,0.1); padding-left: 0.75rem;">
                    @auth
                        <span style="font-size: 0.85rem; font-weight: 700; color: #a5b4fc; display: flex; align-items: center; gap: 0.35rem;" title="Rol: {{ Auth::user()->isAdmin() ? 'Administrador' : 'Cliente' }}">
                            <i data-feather="{{ Auth::user()->isAdmin() ? 'shield' : 'user' }}" style="width: 14px; height: 14px; color: {{ Auth::user()->isAdmin() ? '#fb923c' : '#a5b4fc' }};"></i> 
                            {{ Auth::user()->name }}
                        </span>
                    @else
                        <a href="{{ route('login') }}" class="nav-btn btn-admin" style="font-size: 0.8rem; padding: 0.45rem 0.85rem;">
                            <i data-feather="log-in" style="width: 14px; height: 14px;"></i> Ingresar
                        </a>
                        <a href="{{ route('register') }}" class="nav-btn" style="background: rgba(99, 102, 241, 0.2); border: 1px solid rgba(99, 102, 241, 0.4); color: #a5b4fc; font-size: 0.8rem; padding: 0.45rem 0.85rem;">
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
                                <i data-feather="settings" style="width: 13px; height: 13px; color: #818cf8;"></i>
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
                                            <span class="settings-link-subtitle">Actual: {{ session('currency', 'USD') === 'PEN' ? 'Soles (S/.)' : 'Dólares ($)' }}</span>
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

    <!-- Footer -->
    <footer>
        <div style="max-width: 1280px; margin: 0 auto; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
            <div>
                <span style="font-weight: 700; color: #f8fafc;">Elvatrago E-Commerce</span> &copy; {{ date('Y') }} — Todos los derechos reservados.
            </div>
            <div style="display: flex; gap: 1.5rem; align-items: center; flex-wrap: wrap;">
                <a href="{{ route('shop.index') }}" style="color: #cbd5e1;">Catálogo</a>
                <a href="{{ route('cart.index') }}" style="color: #34d399;">Carrito</a>
                <a href="{{ route('returns.public.create') }}" style="color: #818cf8; text-decoration: none;">Solicitud de Devolución</a>
                <a href="{{ route('admin.dashboard') }}" style="color: #a855f7;">Administración</a>
            </div>
        </div>
    </footer>

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
                try { localStorage.setItem('elvatrago_theme', 'light'); } catch(e) {}
            } else {
                document.documentElement.removeAttribute('data-theme');
                try { localStorage.setItem('elvatrago_theme', 'dark'); } catch(e) {}
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
        });
    </script>
    @yield('scripts')
</body>
</html>
