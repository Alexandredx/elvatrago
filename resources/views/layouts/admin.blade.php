<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin - Elvatrago')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @yield('styles')
</head>
<body style="background: #090d16;">
    <div class="admin-container">
        <!-- Admin Sidebar -->
        <aside class="admin-sidebar">
            <a href="{{ route('shop.index') }}" class="logo-brand" style="margin-bottom: 2rem;">
                <i data-feather="shopping-bag"></i>
                <span>ELVATRAGO</span>
            </a>

            <div style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">
                Navegación Admin
            </div>

            <nav style="display: flex; flex-direction: column; gap: 0.35rem; margin-bottom: auto;">
                <a href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.75rem; color: {{ request()->routeIs('admin.dashboard') ? '#ffffff' : '#94a3b8' }}; background: {{ request()->routeIs('admin.dashboard') ? 'rgba(99, 102, 241, 0.2)' : 'transparent' }}; font-weight: 600; font-size: 0.9rem;">
                    <i data-feather="grid"></i> Dashboard
                </a>

                <a href="{{ route('admin.products.index') }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.75rem; color: {{ request()->routeIs('admin.products.*') ? '#ffffff' : '#94a3b8' }}; background: {{ request()->routeIs('admin.products.*') ? 'rgba(99, 102, 241, 0.2)' : 'transparent' }}; font-weight: 600; font-size: 0.9rem;">
                    <i data-feather="package"></i> Productos
                </a>

                <a href="{{ route('admin.categories.index') }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.75rem; color: {{ request()->routeIs('admin.categories.*') ? '#ffffff' : '#94a3b8' }}; background: {{ request()->routeIs('admin.categories.*') ? 'rgba(99, 102, 241, 0.2)' : 'transparent' }}; font-weight: 600; font-size: 0.9rem;">
                    <i data-feather="tag"></i> Categorías
                </a>

                <a href="{{ route('admin.orders.index') }}" style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; border-radius: 0.75rem; color: {{ request()->routeIs('admin.orders.*') ? '#ffffff' : '#94a3b8' }}; background: {{ request()->routeIs('admin.orders.*') ? 'rgba(99, 102, 241, 0.2)' : 'transparent' }}; font-weight: 600; font-size: 0.9rem;">
                    <i data-feather="shopping-cart"></i> Pedidos
                </a>

                <a href="{{ route('admin.returns.index') }}" style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; border-radius: 0.75rem; color: {{ request()->routeIs('admin.returns.*') ? '#ffffff' : '#94a3b8' }}; background: {{ request()->routeIs('admin.returns.*') ? 'rgba(99, 102, 241, 0.2)' : 'transparent' }}; font-weight: 600; font-size: 0.9rem;">
                    <span style="display: flex; align-items: center; gap: 0.75rem;">
                        <i data-feather="rotate-ccw"></i> Solicitud de Devolución
                    </span>
                    @php
                        $pendingReturnsCount = \App\Models\ReturnRequest::where('status', 'pending')->count();
                    @endphp
                    @if($pendingReturnsCount > 0)
                        <span style="background: rgba(245, 158, 11, 0.25); color: #fbbf24; border: 1px solid rgba(245, 158, 11, 0.4); font-size: 0.7rem; font-weight: 800; padding: 0.1rem 0.45rem; border-radius: 9999px;">
                            {{ $pendingReturnsCount }}
                        </span>
                    @endif
                </a>
            </nav>


            <div style="padding-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.08); display: flex; flex-direction: column; gap: 0.75rem;">
                <div style="font-size: 0.825rem; font-weight: 700; color: #a5b4fc; display: flex; align-items: center; gap: 0.4rem;">
                    <i data-feather="shield" style="width: 14px; height: 14px; color: #fb923c;"></i>
                    {{ Auth::user()->name }} (Admin)
                </div>

                <a href="{{ route('shop.index') }}" style="display: flex; align-items: center; gap: 0.5rem; color: #34d399; font-size: 0.85rem; font-weight: 600;">
                    <i data-feather="external-link"></i> Ver Tienda Pública &rarr;
                </a>

                <form action="{{ route('logout') }}" method="POST" style="margin-top: 0.25rem;">
                    @csrf
                    <button type="submit" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 0.45rem 0.75rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.35rem; width: 100%; justify-content: center;">
                        <i data-feather="log-out" style="width: 14px; height: 14px;"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-content">
            <!-- Alert Messages -->
            @if(session('success'))
                <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.4); color: #34d399; padding: 0.85rem 1.25rem; border-radius: 0.75rem; display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <i data-feather="check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; padding: 0.85rem 1.25rem; border-radius: 0.75rem; display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem;">
                    <i data-feather="alert-circle"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        feather.replace();
    </script>
    @yield('scripts')
</body>
</html>
