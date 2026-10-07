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
                <input type="text" name="search" class="search-input" placeholder="Buscar productos, gadgets, ofertas..." value="{{ request('search') }}">
                @if(request('type'))
                    <input type="hidden" name="type" value="{{ request('type') }}">
                @endif
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
            </form>

            <!-- Navigation Action Buttons -->
            <div class="nav-actions">
                <!-- Currency Switcher -->
                @php
                    $currentCurrency = session('currency', 'USD');
                @endphp
                <div style="display: flex; align-items: center; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 9999px; padding: 2px; margin-right: 0.25rem;">
                    <a href="{{ route('currency.switch', 'USD') }}" 
                       style="padding: 0.3rem 0.65rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentCurrency === 'USD' ? 'background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #ffffff; box-shadow: 0 2px 8px rgba(99, 102, 241, 0.4);' : 'color: #94a3b8;' }}"
                       title="Cambiar a Dólares (USD)">
                       USD ($)
                    </a>
                    <a href="{{ route('currency.switch', 'PEN') }}" 
                       style="padding: 0.3rem 0.65rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; text-decoration: none; transition: all 0.2s ease; {{ $currentCurrency === 'PEN' ? 'background: linear-gradient(135deg, #10b981, #059669); color: #ffffff; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.4);' : 'color: #94a3b8;' }}"
                       title="Cambiar a Soles (PEN)">
                       PEN (S/.)
                    </a>
                </div>

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

                @auth
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-left: 0.5rem; border-left: 1px solid rgba(255,255,255,0.1); padding-left: 0.75rem;">
                        <span style="font-size: 0.85rem; font-weight: 700; color: #a5b4fc; display: flex; align-items: center; gap: 0.35rem;" title="Rol: {{ Auth::user()->isAdmin() ? 'Administrador' : 'Cliente' }}">
                            <i data-feather="{{ Auth::user()->isAdmin() ? 'shield' : 'user' }}" style="width: 14px; height: 14px; color: {{ Auth::user()->isAdmin() ? '#fb923c' : '#a5b4fc' }};"></i> 
                            {{ Auth::user()->name }}
                        </span>

                        <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                            @csrf
                            <button type="submit" title="Cerrar Sesión" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 0.45rem 0.75rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.35rem; transition: all 0.2s ease;">
                                <i data-feather="log-out" style="width: 14px; height: 14px;"></i> Salir
                            </button>
                        </form>
                    </div>
                @else
                    <div style="display: flex; align-items: center; gap: 0.5rem; margin-left: 0.5rem; border-left: 1px solid rgba(255,255,255,0.1); padding-left: 0.75rem;">
                        <a href="{{ route('login') }}" class="nav-btn btn-admin" style="font-size: 0.8rem; padding: 0.45rem 0.85rem;">
                            <i data-feather="log-in" style="width: 14px; height: 14px;"></i> Ingresar
                        </a>
                        <a href="{{ route('register') }}" class="nav-btn" style="background: rgba(99, 102, 241, 0.2); border: 1px solid rgba(99, 102, 241, 0.4); color: #a5b4fc; font-size: 0.8rem; padding: 0.45rem 0.85rem;">
                            <i data-feather="user-plus" style="width: 14px; height: 14px;"></i> Registro
                        </a>
                    </div>
                @endauth
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
            <div style="display: flex; gap: 1.5rem;">
                <a href="{{ route('shop.index', ['type' => 'direct']) }}" style="color: #34d399;">Venta Directa</a>
                <a href="{{ route('shop.index', ['type' => 'affiliate']) }}" style="color: #ff6b6b;">Catálogo Afiliados</a>
                <a href="{{ route('admin.dashboard') }}" style="color: #a855f7;">Administración</a>
            </div>
        </div>
    </footer>

    <script>
        feather.replace();
    </script>
    @yield('scripts')
</body>
</html>
