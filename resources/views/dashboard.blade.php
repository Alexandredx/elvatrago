@extends('layouts.admin')

@section('title', 'Dashboard Admin - GlobalClick')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">Dashboard de la Tienda</h1>
        <p style="color: #94a3b8; font-size: 0.9rem;">Resumen de inventario, catálogo de productos y pedidos recibidos.</p>
    </div>
    
    <div style="display: flex; gap: 0.75rem;">
        <a href="{{ route('admin.products.create') }}" class="pill-item active" style="padding: 0.65rem 1.25rem; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-feather="plus" style="width: 16px; height: 16px;"></i> + Agregar Producto
        </a>
    </div>
</div>

<!-- KPI Stats Grid -->
<div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
    <div class="stat-card">
        <div class="stat-label">Total Productos</div>
        <div class="stat-value" style="color: #f97316;">{{ $totalProducts }}</div>
        <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.35rem;">En inventario local</div>
    </div>
    
    <div class="stat-card">
        <div class="stat-label">Productos Activos</div>
        <div class="stat-value" style="color: #34d399;">{{ $activeProducts }}</div>
        <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.35rem;">Visibles en la tienda</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Poco Stock (&le; 5 un.)</div>
        <div class="stat-value" style="color: {{ $lowStockProducts > 0 ? '#f59e0b' : '#94a3b8' }};">{{ $lowStockProducts }}</div>
        <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.35rem;">Por reabastecer</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Total Pedidos</div>
        <div class="stat-value" style="color: #ea580c;">{{ $totalOrders }}</div>
        <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.35rem;">Órdenes procesadas</div>
    </div>

    <div class="stat-card">
        <div class="stat-label">Ingresos Totales</div>
        <div class="stat-value" style="color: #10b981;">${{ number_format($totalRevenue, 2) }}</div>
        <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.35rem;">Ventas completadas</div>
    </div>

    <a href="{{ route('admin.returns.index') }}" class="stat-card" style="text-decoration: none; border-color: {{ $pendingReturns > 0 ? 'rgba(245, 158, 11, 0.4)' : 'rgba(255, 255, 255, 0.08)' }};">
        <div class="stat-label" style="display: flex; justify-content: space-between; align-items: center;">
            <span>Devoluciones</span>
            @if($pendingReturns > 0)
                <span style="background: rgba(245, 158, 11, 0.2); color: #fbbf24; font-size: 0.65rem; padding: 0.15rem 0.45rem; border-radius: 9999px; font-weight: 800;">PENDIENTE</span>
            @endif
        </div>
        <div class="stat-value" style="color: {{ $pendingReturns > 0 ? '#fbbf24' : '#fb923c' }};">{{ $pendingReturns }}</div>
        <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.35rem;">Solicitudes pendientes &rarr;</div>
    </a>
</div>


<!-- Grid with Recent Activity -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 2rem;">
    
    <!-- Left: Recent Orders -->
    <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="shopping-cart" style="color: #34d399;"></i> Últimos Pedidos Recibidos
            </h3>
            <a href="{{ route('admin.orders.index') }}" style="font-size: 0.8rem; color: #f97316; font-weight: 600;">Ver todos &rarr;</a>
        </div>

        @if($recentOrders->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                @foreach($recentOrders as $order)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.85rem 1rem; background: rgba(15, 23, 42, 0.6); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                        <div>
                            <div style="font-size: 0.875rem; font-weight: 700; color: #ffffff;">{{ $order->order_number }} • {{ $order->customer_name }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $order->customer_email }} • {{ $order->created_at->format('d/m/Y H:i') }}</div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 0.9rem; font-weight: 800; color: #34d399;">${{ number_format($order->total_amount, 2) }}</div>
                            <span class="badge badge-direct" style="font-size: 0.65rem;">{{ strtoupper($order->status) }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 2rem 1rem; color: #64748b;">
                <i data-feather="inbox" style="width: 36px; height: 36px; margin-bottom: 0.5rem;"></i>
                <p style="font-size: 0.85rem;">No hay pedidos registrados todavía.</p>
            </div>
        @endif
    </div>

    <!-- Right: Latest Products -->
    <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="package" style="color: #f97316;"></i> Productos en Catálogo
            </h3>
            <a href="{{ route('admin.products.index') }}" style="font-size: 0.8rem; color: #f97316; font-weight: 600;">Ver todos &rarr;</a>
        </div>

        @if($latestProducts->count() > 0)
            <div style="display: flex; flex-direction: column; gap: 0.85rem;">
                @foreach($latestProducts as $prod)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 1rem; background: rgba(15, 23, 42, 0.6); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <img src="{{ $prod->primary_image_url }}" alt="" style="width: 42px; height: 42px; object-fit: cover; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1);">
                            <div>
                                <div style="font-size: 0.875rem; font-weight: 700; color: #ffffff;">{{ Str::limit($prod->title, 28) }}</div>
                                <div style="font-size: 0.75rem; color: #94a3b8;">{{ $prod->category->name ?? 'Sin Categoría' }}</div>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-size: 0.85rem; font-weight: 700; color: #ffffff;">${{ number_format($prod->effective_price, 2) }}</div>
                            <div style="font-size: 0.75rem; color: {{ $prod->stock > 0 ? '#34d399' : '#f87171' }}; font-weight: 600;">{{ $prod->stock }} un. en stock</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="text-align: center; padding: 2rem 1rem; color: #64748b;">
                <p style="font-size: 0.85rem;">No hay productos creados.</p>
            </div>
        @endif
    </div>
</div>
@endsection
