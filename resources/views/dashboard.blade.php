@extends('layouts.admin')

@section('title', 'Dashboard Admin - Elvatrago')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">Dashboard & Analíticas</h1>
        <p style="color: #94a3b8; font-size: 0.9rem;">Resumen general de productos, ventas directas y clics en afiliados.</p>
    </div>
    
    <a href="{{ route('admin.products.create') }}" class="pill-item active" style="padding: 0.65rem 1.25rem; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;">
        <i data-feather="plus" style="width: 16px; height: 16px;"></i> Crear Nuevo Producto
    </a>
</div>

<!-- KPI Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-label">Total Productos</div>
        <div class="stat-value" style="color: #6366f1;">{{ $totalProducts }}</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-label">Ventas Directas</div>
        <div class="stat-value" style="color: #34d399;">{{ $directProducts }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Productos Afiliados</div>
        <div class="stat-value" style="color: #fb923c;">{{ $affiliateProducts }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Clics Redirección Afiliados</div>
        <div class="stat-value" style="color: #ff6b6b;">{{ $totalClicks }}</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Ingresos por Ventas Directas</div>
        <div class="stat-value" style="color: #10b981;">${{ number_format($totalRevenue, 2) }}</div>
    </div>
</div>

<!-- Grid with Recent Activity -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
    
    <!-- Left: Recent Click Logs -->
    <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
        <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-feather="mouse-pointer" style="color: #ff6b6b;"></i> Últimos Clics en Enlaces de Afiliados
        </h3>

        @if($recentClickLogs->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                @foreach($recentClickLogs as $log)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem; background: rgba(15, 23, 42, 0.6); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <img src="{{ $log->product->primary_image_url ?? '' }}" alt="" style="width: 40px; height: 40px; object-fit: cover; border-radius: 0.5rem;">
                            <div>
                                <div style="font-size: 0.875rem; font-weight: 700; color: #ffffff;">{{ $log->product->title ?? 'Producto eliminado' }}</div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">IP: {{ $log->ip_address }}</div>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <span class="badge badge-aliexpress" style="font-size: 0.65rem;">Afiliado</span>
                            <div style="font-size: 0.7rem; color: #64748b; margin-top: 0.2rem;">{{ $log->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: #94a3b8; font-size: 0.9rem;">No hay registros de clics aún.</p>
        @endif
    </div>

    <!-- Right: Top Clicked Products & Recent Orders -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        
        <!-- Top Clicked -->
        <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="trending-up" style="color: #fb923c;"></i> Afiliados Más Populares
            </h3>

            <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                @foreach($topAffiliates as $aff)
                    <div style="display: flex; align-items: center; justify-content: space-between; font-size: 0.9rem;">
                        <span style="color: #cbd5e1; font-weight: 600;">{{ Str::limit($aff->title, 35) }}</span>
                        <span style="background: rgba(99, 102, 241, 0.2); color: #a5b4fc; padding: 0.25rem 0.65rem; border-radius: 9999px; font-weight: 700; font-size: 0.8rem;">
                            {{ $aff->click_logs_count }} clics
                        </span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Orders -->
        <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="shopping-bag" style="color: #34d399;"></i> Últimas Órdenes Directas
            </h3>

            @if($recentOrders->count() > 0)
                <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                    @foreach($recentOrders as $order)
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem; background: rgba(15, 23, 42, 0.6); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                            <div>
                                <div style="font-size: 0.875rem; font-weight: 700; color: #ffffff;">{{ $order->order_number }} - {{ $order->customer_name }}</div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">${{ number_format($order->total_amount, 2) }} • {{ $order->created_at->format('d/m/Y') }}</div>
                            </div>
                            <a href="{{ route('admin.orders.show', $order->id) }}" style="font-size: 0.8rem; color: #6366f1; font-weight: 600;">Ver detalle</a>
                        </div>
                    @endforeach
                </div>
            @else
                <p style="color: #94a3b8; font-size: 0.9rem;">No hay órdenes aún.</p>
            @endif
        </div>
    </div>
</div>
@endsection
