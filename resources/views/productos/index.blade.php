@extends('layouts.admin')

@section('title', 'Productos - Admin')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">Productos</h1>
        <p style="color: #94a3b8; font-size: 0.9rem;">Gestiona y publica tus productos manuales para venta directa en la tienda.</p>
    </div>
    
    <a href="{{ route('admin.products.create') }}" class="pill-item active" style="padding: 0.75rem 1.35rem; font-size: 0.9rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4);">
        <i data-feather="plus" style="width: 16px; height: 16px;"></i> + Agregar Producto
    </a>
</div>

<!-- Filters Bar -->
<div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); padding: 1rem 1.25rem; border-radius: 1rem; margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
    <form action="{{ route('admin.products.index') }}" method="GET" style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center; width: 100%; max-width: 800px;">
        <!-- Search Input -->
        <div style="position: relative; flex: 1; min-width: 220px;">
            <input type="text" name="search" placeholder="Buscar por título..." value="{{ request('search') }}" style="width: 100%; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); padding: 0.55rem 1rem 0.55rem 2.25rem; border-radius: 0.65rem; color: #ffffff; font-size: 0.875rem;">
            <i data-feather="search" style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); width: 15px; height: 15px; color: #64748b;"></i>
        </div>

        <!-- Category Filter -->
        <select name="category" onchange="this.form.submit()" style="background: #0f172a; border: 1px solid rgba(255,255,255,0.12); padding: 0.55rem 0.85rem; border-radius: 0.65rem; color: #cbd5e1; font-size: 0.85rem; cursor: pointer;">
            <option value="">Todas las Categorías</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
        </select>

        <!-- Status Filter -->
        <select name="status" onchange="this.form.submit()" style="background: #0f172a; border: 1px solid rgba(255,255,255,0.12); padding: 0.55rem 0.85rem; border-radius: 0.65rem; color: #cbd5e1; font-size: 0.85rem; cursor: pointer;">
            <option value="">Todos los Estados</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Activo</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Borrador</option>
        </select>

        <button type="submit" style="background: #4f46e5; border: none; color: white; padding: 0.55rem 1rem; border-radius: 0.65rem; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
            Filtrar
        </button>

        @if(request()->hasAny(['search', 'category', 'status']))
            <a href="{{ route('admin.products.index') }}" style="color: #94a3b8; font-size: 0.85rem; text-decoration: underline; margin-left: 0.5rem;">Limpiar</a>
        @endif
    </form>
</div>

<!-- Table -->
<div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; overflow: hidden;">
    @if($products->count() > 0)
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.75rem; text-transform: uppercase; color: #94a3b8; letter-spacing: 0.05em;">
                    <th style="padding: 1rem 1.25rem;">Producto</th>
                    <th style="padding: 1rem 1.25rem;">Estado</th>
                    <th style="padding: 1rem 1.25rem;">Categoría</th>
                    <th style="padding: 1rem 1.25rem;">Inventario</th>
                    <th style="padding: 1rem 1.25rem;">Precio</th>
                    <th style="padding: 1rem 1.25rem; text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05); transition: background 0.15s ease;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                        <!-- Product Title and Image -->
                        <td style="padding: 1rem 1.25rem;">
                            <div style="display: flex; align-items: center; gap: 0.85rem;">
                                <img src="{{ $product->primary_image_url }}" alt="" style="width: 48px; height: 48px; object-fit: cover; border-radius: 0.6rem; border: 1px solid rgba(255,255,255,0.1); background: #0f172a;">
                                <div>
                                    <div style="font-weight: 700; color: #ffffff; font-size: 0.925rem;">{{ $product->title }}</div>
                                    <div style="font-size: 0.75rem; color: #64748b; margin-top: 0.15rem;">slug: /{{ $product->slug }}</div>
                                </div>
                            </div>
                        </td>

                        <!-- Status -->
                        <td style="padding: 1rem 1.25rem;">
                            @if($product->is_active)
                                <span style="background: rgba(16, 185, 129, 0.15); color: #34d399; border: 1px solid rgba(16, 185, 129, 0.3); padding: 0.25rem 0.6rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.3rem;">
                                    <span style="width: 6px; height: 6px; background: #34d399; border-radius: 50%;"></span> Activo
                                </span>
                            @else
                                <span style="background: rgba(148, 163, 184, 0.15); color: #94a3b8; border: 1px solid rgba(148, 163, 184, 0.3); padding: 0.25rem 0.6rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.3rem;">
                                    <span style="width: 6px; height: 6px; background: #94a3b8; border-radius: 50%;"></span> Borrador
                                </span>
                            @endif
                        </td>

                        <!-- Category -->
                        <td style="padding: 1rem 1.25rem; color: #cbd5e1; font-weight: 500;">
                            {{ $product->category->name ?? 'Sin Categoría' }}
                        </td>

                        <!-- Inventory -->
                        <td style="padding: 1rem 1.25rem;">
                            @if($product->stock > 5)
                                <span style="color: #34d399; font-weight: 700; font-size: 0.875rem;">{{ $product->stock }} disponibles</span>
                            @elseif($product->stock > 0)
                                <span style="color: #fbbf24; font-weight: 700; font-size: 0.875rem;">{{ $product->stock }} en stock (bajo)</span>
                            @else
                                <span style="color: #f87171; font-weight: 700; font-size: 0.875rem;">Agotado (0)</span>
                            @endif
                        </td>

                        <!-- Price -->
                        <td style="padding: 1rem 1.25rem;">
                            <div style="font-weight: 700; color: #ffffff; font-size: 0.95rem;">
                                ${{ number_format($product->effective_price, 2) }}
                            </div>
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <div style="font-size: 0.75rem; color: #64748b; text-decoration: line-through;">
                                    ${{ number_format($product->price, 2) }}
                                </div>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td style="padding: 1rem 1.25rem; text-align: center;">
                            <div style="display: flex; justify-content: center; align-items: center; gap: 0.5rem;">
                                <a href="{{ route('shop.show', $product->slug) }}" target="_blank" title="Ver en tienda" style="background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.1); color: #cbd5e1; padding: 0.4rem 0.55rem; border-radius: 0.5rem; font-size: 0.8rem; display: inline-flex; align-items: center;">
                                    <i data-feather="external-link" style="width: 14px; height: 14px;"></i>
                                </a>

                                <a href="{{ route('admin.products.edit', $product->id) }}" title="Editar" style="background: rgba(99, 102, 241, 0.2); border: 1px solid rgba(99, 102, 241, 0.4); color: #a5b4fc; padding: 0.4rem 0.75rem; border-radius: 0.5rem; font-size: 0.8rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.35rem;">
                                    <i data-feather="edit-2" style="width: 14px; height: 14px;"></i> Editar
                                </a>

                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('¿Seguro de que deseas eliminar permanentemente este producto?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Eliminar" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 0.4rem 0.55rem; border-radius: 0.5rem; cursor: pointer; font-size: 0.8rem; display: inline-flex; align-items: center;">
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
    @else
        <div style="text-align: center; padding: 4rem 1.5rem;">
            <i data-feather="package" style="width: 48px; height: 48px; color: #64748b; margin-bottom: 1rem;"></i>
            <h3 style="font-size: 1.25rem; color: #ffffff; margin-bottom: 0.5rem;">No se encontraron productos</h3>
            <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 1.5rem;">Agrega tus primeros productos de forma manual para comenzar a vender.</p>
            <a href="{{ route('admin.products.create') }}" class="pill-item active" style="display: inline-flex; align-items: center; gap: 0.5rem;">
                <i data-feather="plus" style="width: 16px; height: 16px;"></i> Crear Primer Producto
            </a>
        </div>
    @endif
</div>
@endsection

