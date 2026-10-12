@extends('layouts.app')

@section('title', 'Elvatrago - Catálogo E-Commerce & Afiliados')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(99, 102, 241, 0.15); border: 1px solid rgba(99, 102, 241, 0.3); color: #a5b4fc; padding: 0.35rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; margin-bottom: 1.25rem;">
        <i data-feather="zap" style="width: 16px; height: 16px;"></i>
        <span>Catálogo Exclusivo Elvatrago</span>
    </div>
    <h1 class="hero-title">Encuentra los Mejores Productos & Novedades</h1>
    <p class="hero-subtitle">
        Descubre nuestra selección de tecnología, sonido, accesorios y Smart Living con los mejores precios del mercado.
    </p>
</div>

<!-- Categories Filter Bar -->
<div class="filter-bar">
    <div class="pill-group">
        <span style="font-size: 0.85rem; font-weight: 700; color: #94a3b8; margin-right: 0.5rem;">Categorías:</span>
        <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'))) }}" 
           style="font-size: 0.825rem; padding: 0.35rem 0.85rem; border-radius: 9999px; background: {{ !request('category') ? '#4f46e5' : 'rgba(255,255,255,0.05)' }}; color: #ffffff;">
            Todas
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('shop.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}" 
               style="font-size: 0.825rem; padding: 0.35rem 0.85rem; border-radius: 9999px; background: {{ request('category') == $cat->slug ? '#4f46e5' : 'rgba(255,255,255,0.05)' }}; color: #ffffff; border: 1px solid rgba(255,255,255,0.08);">
                {{ $cat->name }} ({{ $cat->products_count }})
            </a>
        @endforeach
    </div>

    <!-- Sorting Dropdown -->
    <form action="{{ route('shop.index') }}" method="GET" style="display: flex; align-items: center; gap: 0.5rem;">
        @foreach(request()->except('sort', 'page') as $key => $val)
            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
        @endforeach
        <span style="font-size: 0.85rem; color: #94a3b8; font-weight: 600;">Ordenar por:</span>
        <select name="sort" onchange="this.form.submit()" style="background: #1e293b; color: #f8fafc; border: 1px solid rgba(255,255,255,0.1); padding: 0.4rem 0.85rem; border-radius: 0.5rem; font-size: 0.85rem; cursor: pointer;">
            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Más recientes</option>
            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Precio: Menor a Mayor</option>
            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Precio: Mayor a Menor</option>
        </select>
    </form>
</div>

<!-- Products Grid -->
@if($products->count() > 0)
    <div class="products-grid">
        @foreach($products as $product)
            <div class="product-card">
                <!-- Thumbnail -->
                <div class="product-card-thumb">
                    <a href="{{ route('shop.show', $product->slug) }}">
                        <img id="cardImg-{{ $product->id }}" src="{{ $product->primary_image_url }}" alt="{{ $product->title }}" loading="lazy">
                    </a>

                    @if($product->images->count() > 1)
                        <!-- Flechas de navegación para tarjetas de catálogo -->
                        <button type="button" 
                                class="card-thumb-arrow thumb-arrow-prev" 
                                onclick="event.preventDefault(); event.stopPropagation(); cycleCardImage({{ $product->id }}, -1)"
                                aria-label="Foto anterior" 
                                title="Foto anterior">
                            <i data-feather="chevron-left" style="width: 14px; height: 14px;"></i>
                        </button>
                        <button type="button" 
                                class="card-thumb-arrow thumb-arrow-next" 
                                onclick="event.preventDefault(); event.stopPropagation(); cycleCardImage({{ $product->id }}, 1)"
                                aria-label="Siguiente foto" 
                                title="Siguiente foto">
                            <i data-feather="chevron-right" style="width: 14px; height: 14px;"></i>
                        </button>
                        <div class="card-thumb-counter">
                            <span id="cardImgIdx-{{ $product->id }}">1</span>/{{ $product->images->count() }}
                        </div>
                    @endif
                </div>

                <!-- Card Body -->
                <div class="product-card-body">
                    <div class="product-category-name">{{ $product->category->name ?? 'General' }}</div>
                    <a href="{{ route('shop.show', $product->slug) }}">
                        <h3 class="product-title">{{ $product->title }}</h3>
                    </a>
                    <p class="product-desc">{{ $product->short_description ?? Str::limit(strip_tags($product->description), 80) }}</p>

                    <!-- Price & Actions -->
                    <div class="product-card-footer">
                        <div class="price-box">
                            <span class="price-current">@money($product->effective_price)</span>
                            @if($product->sale_price && $product->sale_price < $product->price)
                                <span class="price-old">@money($product->price)</span>
                            @endif
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-action-card btn-direct">
                                <i data-feather="shopping-cart" style="width: 14px; height: 14px;"></i> Carrito
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div style="max-width: 1280px; margin: 0 auto 4rem; padding: 0 1.5rem; display: flex; justify-content: center;">
        {{ $products->links() }}
    </div>
@else
    <div style="text-align: center; padding: 4rem 1.5rem; background: rgba(30, 41, 59, 0.4); border-radius: 1.5rem; max-width: 600px; margin: 2rem auto 4rem;">
        <i data-feather="inbox" style="width: 48px; height: 48px; color: #64748b; margin-bottom: 1rem;"></i>
        <h3 style="font-size: 1.25rem; color: #ffffff; margin-bottom: 0.5rem;">No se encontraron productos</h3>
        <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 1.5rem;">Intenta cambiar el término de búsqueda o quitar los filtros aplicados.</p>
        <a href="{{ route('shop.index') }}" class="pill-item active" style="display: inline-block;">Ver todo el catálogo</a>
    </div>
@endif
@endsection

@section('scripts')
<script>
    const cardImagesMap = {
        @foreach($products as $prod)
            @if($prod->images->count() > 1)
                {{ $prod->id }}: @json($prod->images->map(fn($img) => $img->url)),
            @endif
        @endforeach
    };
    const cardIndices = {};

    function cycleCardImage(productId, step) {
        const images = cardImagesMap[productId];
        if (!images || images.length <= 1) return;

        if (typeof cardIndices[productId] === 'undefined') {
            cardIndices[productId] = 0;
        }

        let newIdx = cardIndices[productId] + step;
        if (newIdx < 0) newIdx = images.length - 1;
        if (newIdx >= images.length) newIdx = 0;

        cardIndices[productId] = newIdx;

        const imgEl = document.getElementById('cardImg-' + productId);
        if (imgEl) {
            imgEl.style.opacity = '0.4';
            setTimeout(() => {
                imgEl.src = images[newIdx];
                imgEl.style.opacity = '1';
            }, 100);
        }

        const idxEl = document.getElementById('cardImgIdx-' + productId);
        if (idxEl) {
            idxEl.textContent = newIdx + 1;
        }
    }
</script>
@endsection
