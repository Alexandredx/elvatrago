@extends('layouts.app')

@section('title', 'GlobalClick - Catálogo E-Commerce & Afiliados')

@section('content')
<!-- Hero Section -->
<div class="hero-section">
    <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(249, 115, 22, 0.15); border: 1px solid rgba(249, 115, 22, 0.3); color: #fdba74; padding: 0.35rem 1rem; border-radius: 9999px; font-size: 0.85rem; font-weight: 700; margin-bottom: 1.25rem;">
        <i data-feather="zap" style="width: 16px; height: 16px;"></i>
        <span>Catálogo Exclusivo GlobalClick</span>
    </div>
    <h1 class="hero-title">Encuentra todos los productos que necesites</h1>
    <p class="hero-subtitle">
        Descubre nuestra selección de tecnología, sonido, accesorios y Smart Living.
    </p>
</div>

<!-- Categories Filter Bar -->
<div class="filter-bar">
    <div class="pill-group">
        <span style="font-size: 0.85rem; font-weight: 700; color: #94a3b8; margin-right: 0.5rem;">Categorías:</span>
        <a href="{{ route('shop.index', array_merge(request()->except('category', 'page'))) }}" 
        style="font-size: 0.825rem; padding: 0.35rem 0.85rem; border-radius: 9999px; background: {{ !request('category') ? '#f97316' : 'rgba(255,255,255,0.05)' }}; color: #ffffff;">
            Todas
        </a>
        @foreach($categories as $cat)
            <a href="{{ route('shop.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}" 
            style="font-size: 0.825rem; padding: 0.35rem 0.85rem; border-radius: 9999px; background: {{ request('category') == $cat->slug ? '#f97316' : 'rgba(255,255,255,0.05)' }}; color: #ffffff; border: 1px solid rgba(255,255,255,0.08);">
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
                    <a href="{{ route('shop.show', $product->slug) }}" target="_blank" rel="noopener noreferrer">
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
                    <a href="{{ route('shop.show', $product->slug) }}" target="_blank" rel="noopener noreferrer">
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

                        @if($product->has_sizes && count($product->available_sizes) > 0)
                            <button type="button" 
                                    class="btn-action-card btn-direct" 
                                    onclick="openQuickSizeModal({{ $product->id }})" 
                                    title="{{ auth()->check() ? 'Seleccionar talla y comprar' : 'Inicia sesión para comprar' }}"
                                    style="background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);">
                                <i data-feather="tag" style="width: 14px; height: 14px;"></i> Elegir Talla
                            </button>
                        @else
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-action-card btn-direct" title="{{ auth()->check() ? 'Añadir al carrito y comprar' : 'Inicia sesión o regístrate para comprar' }}">
                                    <i data-feather="shopping-cart" style="width: 14px; height: 14px;"></i> Carrito
                                </button>
                            </form>
                        @endif
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

<!-- Modal de Selección Rápida de Talla -->
<div id="quickSizeModal" style="display: none; position: fixed; inset: 0; background: rgba(0, 0, 0, 0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); z-index: 9999; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: rgba(30, 41, 59, 0.95); border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 1.5rem; max-width: 480px; width: 100%; padding: 2rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6); position: relative;">
        <!-- Close Button -->
        <button type="button" onclick="closeQuickSizeModal()" style="position: absolute; top: 1.25rem; right: 1.25rem; width: 32px; height: 32px; background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 50%; color: #cbd5e1; font-size: 1.2rem; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;">
            &times;
        </button>

        <!-- Product Preview Header -->
        <div style="margin-bottom: 1.5rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
            <a id="modalProductLink" href="#" target="_blank" rel="noopener noreferrer" style="display: flex; gap: 1rem; align-items: center; text-decoration: none; color: inherit; transition: opacity 0.2s;" title="Ver ficha completa en nueva pestaña">
                <img id="modalProductImg" src="" alt="Producto" style="width: 72px; height: 72px; object-fit: cover; border-radius: 0.75rem; border: 1px solid rgba(255, 255, 255, 0.1);">
                <div style="flex: 1;">
                    <h3 id="modalProductTitle" style="font-size: 1.05rem; font-weight: 700; color: #ffffff; margin: 0 0 0.35rem; line-height: 1.3; display: flex; align-items: center; gap: 0.4rem;">
                        <span id="modalProductTitleText"></span>
                        <i data-feather="external-link" style="width: 14px; height: 14px; color: #f97316; flex-shrink: 0;"></i>
                    </h3>
                    <div style="font-size: 1.15rem; font-weight: 800; color: #f97316;" id="modalProductPrice"></div>
                </div>
            </a>
        </div>

        @guest
            <div style="background: rgba(249, 115, 22, 0.12); border: 1px dashed rgba(249, 115, 22, 0.35); border-radius: 1rem; padding: 1.25rem; text-align: center;">
                <i data-feather="lock" style="width: 24px; height: 24px; color: #f97316; margin-bottom: 0.5rem;"></i>
                <div style="font-size: 0.95rem; font-weight: 700; color: #ffffff; margin-bottom: 0.35rem;">Inicia sesión para comprar</div>
                <p style="color: #cbd5e1; font-size: 0.85rem; margin-bottom: 1rem;">Para añadir prendas con su talla al carrito y realizar tu pedido, necesitas iniciar sesión.</p>
                <div style="display: flex; gap: 0.75rem; justify-content: center;">
                    <a href="{{ route('login') }}" style="background: #f97316; color: #ffffff; font-weight: 700; padding: 0.6rem 1.2rem; border-radius: 0.6rem; font-size: 0.85rem;">Iniciar Sesión</a>
                    <a href="{{ route('register') }}" style="background: rgba(255, 255, 255, 0.1); color: #ffffff; font-weight: 700; padding: 0.6rem 1.2rem; border-radius: 0.6rem; font-size: 0.85rem;">Registrarse</a>
                </div>
            </div>
        @else
            <!-- Form to add to cart -->
            <form id="modalAddToCartForm" method="POST" action="">
                @csrf
                <input type="hidden" name="size" id="modalSelectedSize" value="">

                <div style="margin-bottom: 1.5rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                        <label style="font-size: 0.9rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.4rem;">
                            <i data-feather="check-square" style="width: 15px; height: 15px; color: #f97316;"></i> Selecciona tu Talla: *
                        </label>
                        <span id="modalSizeFeedback" style="font-size: 0.8rem; color: #f97316; font-weight: 700;">(Obligatorio)</span>
                    </div>

                    <!-- Size buttons chips container -->
                    <div id="modalSizesContainer" style="display: flex; flex-wrap: wrap; gap: 0.5rem;"></div>

                    <div id="modalSizeError" style="display: none; color: #f87171; font-size: 0.8rem; margin-top: 0.6rem; font-weight: 600;">
                        ⚠️ Por favor selecciona una talla antes de continuar.
                    </div>
                </div>

                <div style="display: flex; gap: 1rem; margin-bottom: 1.25rem;">
                    <div style="width: 110px;">
                        <label style="display: block; font-size: 0.75rem; color: #94a3b8; font-weight: 600; margin-bottom: 0.25rem;">Cantidad</label>
                        <input type="number" name="quantity" id="modalQuantity" value="1" min="1" max="99" style="width: 100%; padding: 0.75rem; background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 0.75rem; color: #ffffff; font-weight: 700; font-size: 0.95rem; text-align: center;">
                    </div>
                    <div style="flex: 1; display: flex; flex-direction: column; justify-content: flex-end;">
                        <button type="submit" style="width: 100%; padding: 0.85rem 1.25rem; background: var(--accent-gradient); border: none; border-radius: 0.75rem; color: #ffffff; font-weight: 800; font-size: 0.95rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 4px 14px rgba(249, 115, 22, 0.4);">
                            <i data-feather="shopping-cart"></i> Añadir e Ir al Carrito
                        </button>
                    </div>
                </div>
            </form>
        @endguest
    </div>
</div>
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

    const productsSizesMap = {
        @foreach($products as $prod)
            @if($prod->has_sizes && count($prod->available_sizes) > 0)
                {{ $prod->id }}: {
                    id: {{ $prod->id }},
                    title: @json($prod->title),
                    priceHtml: @json(format_price($prod->effective_price)),
                    image: @json($prod->primary_image_url),
                    stock: {{ $prod->stock > 0 ? $prod->stock : 999 }},
                    sizes: @json($prod->available_sizes),
                    addUrl: "{{ route('cart.add', $prod->id) }}",
                    showUrl: "{{ route('shop.show', $prod->slug) }}"
                },
            @endif
        @endforeach
    };

    let currentSelectedModalSize = null;

    function openQuickSizeModal(productId) {
        const prod = productsSizesMap[productId];
        if (!prod) return;

        const modal = document.getElementById('quickSizeModal');
        const img = document.getElementById('modalProductImg');
        const titleText = document.getElementById('modalProductTitleText');
        const link = document.getElementById('modalProductLink');
        const price = document.getElementById('modalProductPrice');
        const form = document.getElementById('modalAddToCartForm');
        const sizesContainer = document.getElementById('modalSizesContainer');
        const sizeInput = document.getElementById('modalSelectedSize');
        const feedback = document.getElementById('modalSizeFeedback');
        const errorMsg = document.getElementById('modalSizeError');
        const qtyInput = document.getElementById('modalQuantity');

        currentSelectedModalSize = null;
        if (sizeInput) sizeInput.value = '';
        if (feedback) feedback.textContent = '(Obligatorio)';
        if (errorMsg) errorMsg.style.display = 'none';
        if (qtyInput) {
            qtyInput.value = 1;
            qtyInput.max = prod.stock;
        }

        if (img) img.src = prod.image;
        if (titleText) titleText.textContent = prod.title;
        if (link) link.href = prod.showUrl;
        if (price) price.innerHTML = prod.priceHtml;
        if (form) form.action = prod.addUrl;

        if (sizesContainer) {
            sizesContainer.innerHTML = '';
            prod.sizes.forEach(size => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'modal-size-pill';
                btn.dataset.size = size;
                btn.textContent = size;
                btn.style.cssText = 'min-width: 48px; height: 42px; padding: 0 0.85rem; border-radius: 0.65rem; border: 1.5px solid rgba(255, 255, 255, 0.15); background: rgba(15, 23, 42, 0.6); color: #cbd5e1; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center; justify-content: center;';

                btn.onclick = function() {
                    selectModalSize(size, btn);
                };

                sizesContainer.appendChild(btn);
            });
        }

        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }

    function selectModalSize(size, btn) {
        currentSelectedModalSize = size;
        const sizeInput = document.getElementById('modalSelectedSize');
        const feedback = document.getElementById('modalSizeFeedback');
        const errorMsg = document.getElementById('modalSizeError');

        if (sizeInput) sizeInput.value = size;
        if (feedback) feedback.textContent = 'Talla ' + size + ' seleccionada ✓';
        if (errorMsg) errorMsg.style.display = 'none';

        document.querySelectorAll('.modal-size-pill').forEach(b => {
            b.style.borderColor = 'rgba(255, 255, 255, 0.15)';
            b.style.background = 'rgba(15, 23, 42, 0.6)';
            b.style.color = '#cbd5e1';
            b.style.boxShadow = 'none';
            b.style.transform = 'scale(1)';
        });

        btn.style.borderColor = '#f97316';
        btn.style.background = 'linear-gradient(135deg, rgba(249, 115, 22, 0.35) 0%, rgba(234, 88, 12, 0.5) 100%)';
        btn.style.color = '#ffffff';
        btn.style.boxShadow = '0 0 14px rgba(249, 115, 22, 0.45)';
        btn.style.transform = 'scale(1.06)';
    }

    function closeQuickSizeModal() {
        const modal = document.getElementById('quickSizeModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('quickSizeModal');
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    closeQuickSizeModal();
                }
            });
        }

        const form = document.getElementById('modalAddToCartForm');
        if (form) {
            form.addEventListener('submit', function(e) {
                const sizeInput = document.getElementById('modalSelectedSize');
                if (!sizeInput || !sizeInput.value) {
                    e.preventDefault();
                    const errorMsg = document.getElementById('modalSizeError');
                    if (errorMsg) errorMsg.style.display = 'block';
                    return false;
                }
            });
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeQuickSizeModal();
            }
        });
    });
</script>
@endsection
