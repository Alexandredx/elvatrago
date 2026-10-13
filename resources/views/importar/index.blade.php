@extends('layouts.admin')

@section('title', 'Importar Catálogo (AliExpress & Temu) - Admin')

@section('content')
<div style="margin-bottom: 2rem; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff; display: flex; align-items: center; gap: 0.75rem;">
            <i data-feather="download-cloud" style="color: #f97316; width: 32px; height: 32px;"></i>
            Buscador & Importador de Catálogo (AliExpress & Temu)
        </h1>
        <p style="color: #94a3b8; font-size: 0.95rem; margin-top: 0.35rem;">
            Explora las tendencias mundiales e importa productos verificados directamente a tu catálogo público con un solo clic.
            <span style="background: rgba(249, 115, 22, 0.2); color: #fdba74; border: 1px solid rgba(249, 115, 22, 0.4); padding: 0.2rem 0.65rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; margin-left: 0.5rem;">
                {{ count($externalCatalog) }} Productos Disponibles
            </span>
        </p>
    </div>

    <a href="{{ route('admin.products.index') }}" class="btn-admin" style="padding: 0.65rem 1.25rem; font-size: 0.9rem; display: flex; align-items: center; gap: 0.5rem; text-decoration: none;">
        <i data-feather="package"></i> Ver Mis Productos ({{ \App\Models\Product::count() }})
    </a>
</div>

<!-- Custom Direct URL Import Box -->
<div style="background: linear-gradient(135deg, rgba(249, 115, 22, 0.15), rgba(245, 158, 11, 0.15)); border: 1px solid rgba(249, 115, 22, 0.35); padding: 1.5rem; border-radius: 1.25rem; margin-bottom: 2rem;">
    <h2 style="font-size: 1.15rem; font-weight: 800; color: #ffffff; margin-bottom: 0.35rem; display: flex; align-items: center; gap: 0.5rem;">
        <i data-feather="link-2" style="color: #fdba74;"></i> 🔗 Importar Cualquier Producto por Enlace Directo (AliExpress o Temu)
    </h2>
    <p style="color: #94a3b8; font-size: 0.875rem; margin-bottom: 1.25rem;">
        ¿Tienes el enlace de un producto específico de AliExpress o Temu? Pega la URL aquí para agregarlo instantáneamente a tu catálogo público de la tienda:
    </p>

    <form action="{{ route('admin.import.store') }}" method="POST" style="display: grid; grid-template-columns: 2fr 1.2fr 1fr 160px; gap: 0.75rem; align-items: end;">
        @csrf
        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.35rem;">URL del Producto de AliExpress / Temu *</label>
            <input type="url" name="external_url" required placeholder="https://es.aliexpress.com/item/100500..." style="width: 100%; padding: 0.65rem 0.85rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.6rem; color: #ffffff; font-size: 0.85rem;">
        </div>

        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.35rem;">Título Personalizado (Opcional)</label>
            <input type="text" name="title" placeholder="Ej. Proyector Portátil Smart 4K" style="width: 100%; padding: 0.65rem 0.85rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.6rem; color: #ffffff; font-size: 0.85rem;">
        </div>

        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.35rem;">Categoría</label>
            <select name="category_slug" style="width: 100%; padding: 0.65rem 0.85rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.6rem; color: #ffffff; font-size: 0.85rem;">
                @foreach($categories as $cat)
                    <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <button type="submit" style="width: 100%; padding: 0.65rem; background: var(--accent-gradient); border: none; border-radius: 0.6rem; color: #ffffff; font-weight: 800; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.35rem; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.4);">
                <i data-feather="plus-circle" style="width: 16px; height: 16px;"></i> Importar URL
            </button>
        </div>
    </form>
</div>

<!-- Filter & Search Controls Bar -->
<div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); padding: 1.25rem; border-radius: 1.25rem; margin-bottom: 2rem; display: flex; flex-direction: column; gap: 1.25rem;">
    
    <!-- Platform Switcher Tabs -->
    <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
            <span style="font-size: 0.85rem; font-weight: 700; color: #94a3b8; align-self: center; margin-right: 0.5rem;">Plataforma:</span>
            
            <a href="{{ route('admin.import.index', array_merge(request()->except('platform', 'page'), ['platform' => 'all'])) }}" 
               class="pill-item {{ request('platform', 'all') == 'all' ? 'active' : '' }}" style="font-size: 0.85rem;">
               <i data-feather="globe" style="width: 14px; height: 14px; vertical-align: middle;"></i> Todas las Plataformas
            </a>

            <a href="{{ route('admin.import.index', array_merge(request()->except('platform', 'page'), ['platform' => 'aliexpress'])) }}" 
               class="pill-item {{ request('platform') == 'aliexpress' ? 'active' : '' }}" style="border-color: rgba(255, 71, 71, 0.4); font-size: 0.85rem;">
               <i data-feather="external-link" style="width: 14px; height: 14px; vertical-align: middle; color: #ff6b6b;"></i> AliExpress Direct
            </a>

            <a href="{{ route('admin.import.index', array_merge(request()->except('platform', 'page'), ['platform' => 'temu'])) }}" 
               class="pill-item {{ request('platform') == 'temu' ? 'active' : '' }}" style="border-color: rgba(255, 106, 0, 0.4); font-size: 0.85rem;">
               <i data-feather="external-link" style="width: 14px; height: 14px; vertical-align: middle; color: #fb923c;"></i> Temu Global
            </a>
        </div>

        <!-- Search Bar -->
        <form action="{{ route('admin.import.index') }}" method="GET" style="display: flex; gap: 0.5rem; flex: 1; max-width: 380px;">
            @if(request('platform')) <input type="hidden" name="platform" value="{{ request('platform') }}"> @endif
            @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
            <input type="text" name="search" placeholder="Buscar en catálogo externo..." value="{{ request('search') }}" style="width: 100%; padding: 0.55rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.875rem;">
            <button type="submit" style="background: #f97316; border: none; color: white; padding: 0.55rem 1rem; border-radius: 0.75rem; cursor: pointer; font-weight: 600; font-size: 0.875rem;">Buscar</button>
        </form>
    </div>

    <!-- Category Pills -->
    <div style="display: flex; align-items: center; gap: 0.5rem; flex-wrap: wrap; border-top: 1px solid rgba(255,255,255,0.06); padding-top: 0.85rem;">
        <span style="font-size: 0.85rem; font-weight: 700; color: #94a3b8; margin-right: 0.5rem;">Categoría:</span>
        <a href="{{ route('admin.import.index', array_merge(request()->except('category', 'page'), ['category' => 'all'])) }}" 
           style="font-size: 0.8rem; padding: 0.35rem 0.85rem; border-radius: 9999px; background: {{ request('category', 'all') == 'all' ? '#f97316' : 'rgba(255,255,255,0.05)' }}; color: #ffffff;">
            Todas
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('admin.import.index', array_merge(request()->except('category', 'page'), ['category' => $cat->slug])) }}" 
               style="font-size: 0.8rem; padding: 0.35rem 0.85rem; border-radius: 9999px; background: {{ request('category') == $cat->slug ? '#f97316' : 'rgba(255,255,255,0.05)' }}; color: #ffffff; border: 1px solid rgba(255,255,255,0.08);">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>
</div>

<!-- Catalog Results Grid -->
@if(count($externalCatalog) > 0)
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.75rem; margin-bottom: 4rem;">
        @foreach($externalCatalog as $item)
            @php
                $isImported = in_array($item['external_url'], $importedUrls);
                $margin = round((($item['sale_price'] - $item['supplier_price']) / $item['supplier_price']) * 100);
            @endphp

            <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid {{ $isImported ? 'rgba(16, 185, 129, 0.3)' : 'rgba(255, 255, 255, 0.08)' }}; border-radius: 1.25rem; overflow: hidden; display: flex; flex-direction: column; position: relative; transition: all 0.3s ease;">
                
                <!-- Thumb & Platform Badge -->
                <div style="position: relative; width: 100%; height: 220px; background: #0f172a;">
                    <img src="{{ $item['image_url'] }}" alt="{{ $item['title'] }}" style="width: 100%; height: 100%; object-fit: cover;">
                    
                    <div style="position: absolute; top: 0.75rem; left: 0.75rem; display: flex; gap: 0.35rem;">
                        @if($item['platform_name'] === 'aliexpress')
                            <span class="badge badge-aliexpress" style="font-size: 0.7rem; box-shadow: 0 4px 10px rgba(0,0,0,0.5);">AliExpress</span>
                        @else
                            <span class="badge badge-temu" style="font-size: 0.7rem; box-shadow: 0 4px 10px rgba(0,0,0,0.5);">Temu</span>
                        @endif
                    </div>

                    @if($isImported)
                        <div style="position: absolute; top: 0.75rem; right: 0.75rem; background: rgba(16, 185, 129, 0.9); color: white; padding: 0.25rem 0.65rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 800; display: flex; align-items: center; gap: 0.25rem;">
                            <i data-feather="check" style="width: 12px; height: 12px;"></i> Importado
                        </div>
                    @endif
                </div>

                <!-- Body Info -->
                <div style="padding: 1.25rem; display: flex; flex-direction: column; flex: 1;">
                    <div style="font-size: 0.75rem; font-weight: 700; color: #fdba74; text-transform: uppercase; margin-bottom: 0.35rem;">
                        {{ str_replace('-', ' ', Str::title($item['category_slug'])) }}
                    </div>

                    <h3 style="font-size: 1rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem; line-height: 1.35; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $item['title'] }}
                    </h3>

                    <p style="font-size: 0.825rem; color: #94a3b8; margin-bottom: 1rem; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        {{ $item['short_description'] }}
                    </p>

                    <!-- Financial breakdown box -->
                    <div style="background: rgba(15, 23, 42, 0.6); padding: 0.85rem; border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.06); margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-size: 0.7rem; color: #64748b; font-weight: 600;">Costo Proveedor:</div>
                            <div style="font-size: 0.9rem; color: #94a3b8; font-weight: 700;">${{ number_format($item['supplier_price'], 2) }}</div>
                        </div>

                        <div>
                            <div style="font-size: 0.7rem; color: #64748b; font-weight: 600;">Precio Venta Tienda:</div>
                            <div style="font-size: 1.1rem; color: #34d399; font-weight: 800;">${{ number_format($item['sale_price'], 2) }}</div>
                        </div>

                        <div style="background: rgba(16, 185, 129, 0.15); color: #34d399; padding: 0.2rem 0.5rem; border-radius: 0.5rem; font-size: 0.75rem; font-weight: 800;">
                            +{{ $margin }}%
                        </div>
                    </div>

                    <!-- Import Action Button -->
                    <div style="margin-top: auto;">
                        @if($isImported)
                            <button disabled style="width: 100%; padding: 0.75rem; background: rgba(16, 185, 129, 0.15); border: 1px solid rgba(16, 185, 129, 0.3); color: #34d399; border-radius: 0.75rem; font-weight: 700; font-size: 0.9rem; cursor: not-allowed; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                <i data-feather="check-circle" style="width: 16px; height: 16px;"></i> Ya en tu Catálogo Público
                            </button>
                        @else
                            <form action="{{ route('admin.import.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="title" value="{{ $item['title'] }}">
                                <input type="hidden" name="category_slug" value="{{ $item['category_slug'] }}">
                                <input type="hidden" name="price" value="{{ $item['price'] }}">
                                <input type="hidden" name="sale_price" value="{{ $item['sale_price'] }}">
                                <input type="hidden" name="platform_name" value="{{ $item['platform_name'] }}">
                                <input type="hidden" name="external_url" value="{{ $item['external_url'] }}">
                                <input type="hidden" name="image_url" value="{{ $item['image_url'] }}">
                                <input type="hidden" name="short_description" value="{{ $item['short_description'] }}">
                                <input type="hidden" name="description" value="{{ $item['description'] }}">

                                <button type="submit" style="width: 100%; padding: 0.75rem; background: var(--accent-gradient); border: none; border-radius: 0.75rem; color: #ffffff; font-weight: 800; font-size: 0.9rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 4px 14px rgba(249, 115, 22, 0.35); transition: all 0.25s ease;">
                                    <i data-feather="zap" style="width: 16px; height: 16px;"></i> ⚡ Importar a mi Catálogo
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        @endforeach
    </div>
@else
    <div style="text-align: center; padding: 4rem 1.5rem; background: rgba(30, 41, 59, 0.4); border-radius: 1.5rem; max-width: 600px; margin: 2rem auto 4rem;">
        <i data-feather="inbox" style="width: 48px; height: 48px; color: #64748b; margin-bottom: 1rem;"></i>
        <h3 style="font-size: 1.25rem; color: #ffffff; margin-bottom: 0.5rem;">No se encontraron productos en el catálogo externo</h3>
        <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 1.5rem;">Prueba cambiando los filtros de plataforma, categoría o borrando el término de búsqueda.</p>
        <a href="{{ route('admin.import.index') }}" class="pill-item active" style="display: inline-block;">Ver todo el catálogo externo</a>
    </div>
@endif
@endsection
