@extends('layouts.admin')

@section('title', 'Gestión de Productos - Admin')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">Gestión de Productos</h1>
        <p style="color: #94a3b8; font-size: 0.9rem;">Administra productos de Venta Directa y Productos Afiliados.</p>
    </div>
    
    <a href="{{ route('admin.products.create') }}" class="pill-item active" style="padding: 0.65rem 1.25rem; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem;">
        <i data-feather="plus" style="width: 16px; height: 16px;"></i> + Agregar Producto
    </a>
</div>

<!-- Filters -->
<div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); padding: 1rem 1.25rem; border-radius: 1rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <div style="display: flex; gap: 0.5rem;">
        <a href="{{ route('admin.products.index') }}" class="pill-item {{ !request('type') ? 'active' : '' }}" style="font-size: 0.8rem; padding: 0.35rem 0.85rem;">
            Todos
        </a>
        <a href="{{ route('admin.products.index', ['type' => 'direct']) }}" class="pill-item {{ request('type') == 'direct' ? 'active' : '' }}" style="font-size: 0.8rem; padding: 0.35rem 0.85rem;">
            Venta Directa
        </a>
        <a href="{{ route('admin.products.index', ['type' => 'affiliate']) }}" class="pill-item {{ request('type') == 'affiliate' ? 'active' : '' }}" style="font-size: 0.8rem; padding: 0.35rem 0.85rem;">
            Redirección Afiliados
        </a>
    </div>

    <form action="{{ route('admin.products.index') }}" method="GET" style="display: flex; gap: 0.5rem;">
        <input type="text" name="search" placeholder="Buscar por nombre..." value="{{ request('search') }}" style="background: #0f172a; border: 1px solid rgba(255,255,255,0.1); padding: 0.4rem 0.85rem; border-radius: 0.5rem; color: #ffffff; font-size: 0.85rem;">
        <button type="submit" style="background: #4f46e5; border: none; color: white; padding: 0.4rem 0.85rem; border-radius: 0.5rem; cursor: pointer; font-size: 0.85rem;">Buscar</button>
    </form>
</div>

<!-- Table -->
<div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; overflow: hidden;">
    <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
        <thead>
            <tr style="background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.75rem; text-transform: uppercase; color: #94a3b8;">
                <th style="padding: 1rem 1.25rem;">Producto</th>
                <th style="padding: 1rem 1.25rem;">Categoría</th>
                <th style="padding: 1rem 1.25rem;">Tipo / Plataforma</th>
                <th style="padding: 1rem 1.25rem;">Precio</th>
                <th style="padding: 1rem 1.25rem;">Stock / Clics</th>
                <th style="padding: 1rem 1.25rem; text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                    <td style="padding: 1rem 1.25rem;">
                        <div style="display: flex; align-items: center; gap: 0.85rem;">
                            <img src="{{ $product->primary_image_url }}" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1);">
                            <div>
                                <div style="font-weight: 700; color: #ffffff;">{{ $product->title }}</div>
                                <div style="font-size: 0.75rem; color: #64748b;">Slug: {{ $product->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.25rem; color: #cbd5e1;">
                        {{ $product->category->name ?? 'Sin Categoría' }}
                    </td>
                    <td style="padding: 1rem 1.25rem;">
                        @if($product->isDirect())
                            <span class="badge badge-direct" style="font-size: 0.7rem;">Directo</span>
                        @else
                            <span class="badge badge-aliexpress" style="font-size: 0.7rem;">Afiliado</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.25rem; font-weight: 700; color: #ffffff;">
                        ${{ number_format($product->effective_price, 2) }}
                    </td>
                    <td style="padding: 1rem 1.25rem; color: #cbd5e1;">
                        @if($product->isDirect())
                            <span style="color: {{ $product->stock > 0 ? '#34d399' : '#fca5a5' }}; font-weight: 700;">{{ $product->stock }} un.</span>
                        @else
                            <span style="color: #a5b4fc; font-weight: 700;">{{ $product->click_logs_count }} clics</span>
                        @endif
                    </td>
                    <td style="padding: 1rem 1.25rem; text-align: center;">
                        <div style="display: flex; justify-content: center; gap: 0.5rem;">
                            <a href="{{ route('admin.products.edit', $product->id) }}" style="background: rgba(99, 102, 241, 0.2); border: 1px solid rgba(99, 102, 241, 0.4); color: #a5b4fc; padding: 0.35rem 0.65rem; border-radius: 0.5rem; font-size: 0.8rem;">
                                <i data-feather="edit-2" style="width: 14px; height: 14px;"></i> Editar
                            </a>

                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Seguro de eliminar este producto?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 0.35rem 0.65rem; border-radius: 0.5rem; cursor: pointer; font-size: 0.8rem;">
                                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="padding: 1rem 1.25rem;">
        {{ $products->links() }}
    </div>
</div>
@endsection
