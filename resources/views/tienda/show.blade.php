@extends('layouts.app')

@section('title', $product->title . ' - GlobalClick')

@section('content')
<div style="max-width: 1280px; margin: 2rem auto 4rem; padding: 0 1.5rem;">
    <!-- Breadcrumb -->
    <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #94a3b8; margin-bottom: 2rem;">
        <a href="{{ route('shop.index') }}" style="color: #cbd5e1;">Inicio</a>
        <i data-feather="chevron-right" style="width: 14px; height: 14px;"></i>
        <a href="{{ route('shop.index', ['category' => $product->category->slug ?? '']) }}" style="color: #cbd5e1;">{{ $product->category->name ?? 'General' }}</a>
        <i data-feather="chevron-right" style="width: 14px; height: 14px;"></i>
        <span style="color: #f97316; font-weight: 600;">{{ $product->title }}</span>
    </div>

    <!-- Product Layout Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 3rem; margin-bottom: 4rem;">
        
        <!-- Left: Image Gallery & Reference Photos -->
        <div>
            <!-- Main Featured Image Container with Arrows & Zoom -->
            <div class="product-gallery-main" id="productGalleryMain" style="width: 100%; height: 480px; min-height: 440px; background: #0f172a; border-radius: 1.25rem; border: 1px solid rgba(255, 255, 255, 0.1); overflow: hidden; position: relative; margin-bottom: 1rem; cursor: zoom-in;" onclick="handleGalleryClick()">
                <img id="mainProductImg" src="{{ $product->primary_image_url }}" alt="{{ $product->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: opacity 0.2s ease, transform 0.3s ease;">

                @if($product->has_video)
                    <!-- Container for Embedded/Local Video inside Main Gallery Box -->
                    <div id="productVideoMainContainer" style="display: none; position: absolute; inset: 0; background: #000; z-index: 5;">
                        @if($product->video_type === 'file' || $product->video_type === 'file_url')
                            <video id="galleryMainVideoPlayer" src="{{ $product->video_embed_url }}" controls style="width: 100%; height: 100%; object-fit: contain; background: #000;"></video>
                        @else
                            <iframe id="galleryMainVideoIframe" src="" data-src="{{ $product->video_embed_url }}" style="width: 100%; height: 100%; border: none; background: #000;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        @endif
                    </div>

                    <!-- Botón Flotante para cambiar a Video -->
                    <button type="button" 
                            id="toggleVideoFloatBtn"
                            class="gallery-video-toggle-btn" 
                            onclick="event.stopPropagation(); toggleVideoOrPhoto();" 
                            title="Ver Video del Producto"
                            style="position: absolute; top: 1rem; left: 1rem; z-index: 10; display: inline-flex; align-items: center; gap: 0.4rem; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(8px); border: 1px solid rgba(249, 115, 22, 0.5); color: #ffffff; padding: 0.4rem 0.85rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; cursor: pointer; box-shadow: 0 4px 12px rgba(0,0,0,0.4); transition: all 0.2s;">
                        <i data-feather="play" id="toggleVideoFloatIcon" style="width: 13px; height: 13px; fill: #f97316; stroke: #f97316;"></i>
                        <span id="toggleVideoFloatBtnText">Ver Video</span>
                    </button>
                @endif

                <!-- Botón Lupa para Agrandar Imagen -->
                <button type="button" 
                        id="galleryZoomBtn"
                        class="gallery-zoom-btn" 
                        onclick="event.stopPropagation(); openImageLightbox();" 
                        aria-label="Agrandar imagen" 
                        title="Agrandar imagen">
                    <i data-feather="zoom-in"></i>
                    <span>Ampliar</span>
                </button>

                @if($product->images->count() > 1)
                    <!-- Flecha Anterior -->
                    <button type="button" 
                            id="galleryArrowPrev"
                            class="gallery-arrow-btn arrow-prev" 
                            onclick="event.stopPropagation(); changeImage(-1)" 
                            aria-label="Foto anterior" 
                            title="Foto anterior">
                        <i data-feather="chevron-left"></i>
                    </button>

                    <!-- Flecha Siguiente -->
                    <button type="button" 
                            id="galleryArrowNext"
                            class="gallery-arrow-btn arrow-next" 
                            onclick="event.stopPropagation(); changeImage(1)" 
                            aria-label="Siguiente foto" 
                            title="Siguiente foto">
                        <i data-feather="chevron-right"></i>
                    </button>

                    <!-- Contador de Fotos -->
                    <div class="gallery-photo-counter" id="galleryCounterBox">
                        <i data-feather="image" style="width: 12px; height: 12px; opacity: 0.8;"></i>
                        <span id="galleryCurrentIdx">1</span> / {{ $product->images->count() }}
                    </div>
                @endif
            </div>

            <!-- Thumbnails Carousel / Grid -->
            @if($product->images->count() > 1 || $product->has_video)
                <div id="thumbnailsContainer" style="display: flex; gap: 0.75rem; overflow-x: auto; padding-bottom: 0.5rem; align-items: center;">
                    @foreach($product->images as $index => $img)
                        <div onclick="switchImage('{{ $img->url }}', this, {{ $index }})" 
                             data-index="{{ $index }}"
                             class="thumb-image-item"
                             style="width: 80px; height: 80px; background: #0f172a; border-radius: 0.75rem; border: 2px solid {{ $loop->first ? '#f97316' : 'rgba(255,255,255,0.1)' }}; overflow: hidden; cursor: pointer; flex-shrink: 0; transition: all 0.2s ease;">
                            <img src="{{ $img->url }}" alt="Foto referencial" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @endforeach

                    @if($product->has_video)
                        <!-- Video Thumbnail Button -->
                        <div id="videoThumbBtn" 
                             onclick="switchToVideoMode(this)" 
                             class="thumb-video-item"
                             title="Reproducir Video del Producto"
                             style="position: relative; width: 80px; height: 80px; background: linear-gradient(135deg, rgba(249,115,22,0.2) 0%, rgba(15,23,42,0.95) 100%); border-radius: 0.75rem; border: 2px solid rgba(249,115,22,0.5); overflow: hidden; cursor: pointer; flex-shrink: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.25rem; transition: all 0.2s ease;">
                            <div style="width: 30px; height: 30px; border-radius: 50%; background: #f97316; display: flex; align-items: center; justify-content: center; box-shadow: 0 0 10px rgba(249,115,22,0.5);">
                                <i data-feather="play" style="width: 14px; height: 14px; fill: #ffffff; stroke: #ffffff; margin-left: 2px;"></i>
                            </div>
                            <span style="font-size: 0.65rem; font-weight: 800; color: #ffffff; text-transform: uppercase; letter-spacing: 0.05em;">Video</span>
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <!-- Right: Product Info & Buy/Redirect Actions -->
        <div style="display: flex; flex-direction: column;">
            <div style="font-size: 0.85rem; font-weight: 700; color: #f97316; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
                {{ $product->category->name ?? 'General' }}
            </div>
            
            <h1 style="font-size: 2.25rem; font-weight: 800; color: #ffffff; margin-bottom: 1rem; line-height: 1.25;">
                {{ $product->title }}
            </h1>

            <!-- Price Box -->
            <div style="display: flex; align-items: baseline; gap: 1rem; background: rgba(30, 41, 59, 0.6); padding: 1.25rem; border-radius: 1rem; border: 1px solid rgba(255, 255, 255, 0.08); margin-bottom: 1.5rem;">
                <span style="font-size: 2.25rem; font-weight: 800; color: #ffffff;">
                    @money($product->effective_price)
                </span>

                @if($product->sale_price && $product->sale_price < $product->price)
                    <span style="font-size: 1.25rem; color: #64748b; text-decoration: line-through;">
                        @money($product->price)
                    </span>
                    @php
                        $discount = round((($product->price - $product->sale_price) / $product->price) * 100);
                    @endphp
                    <span style="background: rgba(239, 68, 68, 0.2); color: #fca5a5; border: 1px solid rgba(239, 68, 68, 0.3); padding: 0.25rem 0.6rem; border-radius: 0.5rem; font-size: 0.85rem; font-weight: 700;">
                        -{{ $discount }}% DESCUENTO
                    </span>
                @endif
            </div>

            <!-- Short Description -->
            @if($product->short_description)
                <p style="font-size: 1rem; color: #cbd5e1; line-height: 1.6; margin-bottom: 2rem;">
                    {{ $product->short_description }}
                </p>
            @endif

            <!-- ACTION BUTTONS: Direct vs Affiliate -->
            <!-- ACTION BUTTONS: Add to Cart Form for all products -->
            <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255, 255, 255, 0.08); padding: 1.5rem; border-radius: 1.25rem; margin-bottom: 2rem;">
                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                    <span style="color: #94a3b8; font-size: 0.9rem;">Disponibilidad:</span>
                    <span style="color: #34d399; font-weight: 700; display: flex; align-items: center; gap: 0.35rem;">
                        <i data-feather="check" style="width: 16px; height: 16px;"></i> En Stock
                    </span>
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" id="addToCartForm">
                    @csrf

                    @if($product->has_sizes && count($product->available_sizes) > 0)
                        <div style="margin-bottom: 1.25rem; padding-bottom: 1.25rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.65rem;">
                                <label style="font-size: 0.875rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.4rem;">
                                    <i data-feather="check-square" style="width: 15px; height: 15px; color: #f97316;"></i> Selecciona tu Talla: *
                                </label>
                                <span id="selectedSizeLabel" style="font-size: 0.8rem; color: #f97316; font-weight: 700;">(Obligatorio)</span>
                            </div>

                            <input type="hidden" name="size" id="productSelectedSize" value="">

                            <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;" id="sizePillsContainer">
                                @foreach($product->available_sizes as $sizeOption)
                                    <button type="button" 
                                            class="size-pill-btn" 
                                            data-size="{{ $sizeOption }}"
                                            onclick="selectProductSize('{{ $sizeOption }}', this)"
                                            style="min-width: 48px; height: 42px; padding: 0 0.85rem; border-radius: 0.65rem; border: 1.5px solid rgba(255, 255, 255, 0.15); background: rgba(15, 23, 42, 0.6); color: #cbd5e1; font-weight: 700; font-size: 0.9rem; cursor: pointer; transition: all 0.2s ease; display: inline-flex; align-items: center; justify-content: center;">
                                        {{ $sizeOption }}
                                    </button>
                                @endforeach
                            </div>
                            <div id="sizeAlertMsg" style="display: none; color: #f87171; font-size: 0.8rem; margin-top: 0.5rem; font-weight: 600;">
                                ⚠️ Por favor selecciona una talla antes de añadir al carrito.
                            </div>
                        </div>
                    @endif

                    <div style="display: flex; gap: 1rem;">
                        <div style="width: 100px;">
                            <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock > 0 ? $product->stock : 999 }}" style="width: 100%; padding: 0.85rem; background: #1e293b; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 1rem; font-weight: 700; text-align: center;">
                        </div>

                        <button type="submit" style="flex: 1; padding: 0.85rem 1.5rem; background: var(--accent-gradient); border: none; border-radius: 0.75rem; color: #ffffff; font-weight: 700; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; box-shadow: 0 4px 14px rgba(249, 115, 22, 0.4); transition: all 0.3s ease;">
                            <i data-feather="shopping-cart"></i> Añadir al Carrito
                        </button>
                    </div>
                </form>

                @guest
                    <div style="margin-top: 0.85rem; padding: 0.65rem 0.85rem; background: rgba(249, 115, 22, 0.1); border: 1px dashed rgba(249, 115, 22, 0.35); border-radius: 0.75rem; font-size: 0.825rem; color: #fdba74; display: flex; align-items: center; gap: 0.5rem;">
                        <i data-feather="lock" style="width: 14px; height: 14px; flex-shrink: 0;"></i>
                        <span>Para añadir al carrito debes <a href="{{ route('login') }}" style="color: #ffffff; font-weight: 700; text-decoration: underline;">iniciar sesión</a> o <a href="{{ route('register') }}" style="color: #ffffff; font-weight: 700; text-decoration: underline;">registrarte</a>.</span>
                    </div>
                @endguest
            </div>

            <!-- Features list -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; font-size: 0.85rem; color: #94a3b8;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="shield" style="color: #10b981; width: 16px; height: 16px;"></i> Compra 100% Protegida
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="truck" style="color: #f97316; width: 16px; height: 16px;"></i> Envíos a todo el país
                </div>
            </div>
        </div>
    </div>

    <!-- Long Description Section -->
    @if($product->description)
        <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); padding: 2rem; border-radius: 1.25rem; margin-bottom: 4rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="file-text" style="color: #f97316;"></i> Descripción Detallada del Producto
            </h2>
            <div style="color: #cbd5e1; line-height: 1.7; font-size: 0.95rem;">
                {!! nl2br(e($product->description)) !!}
            </div>
        </div>
    @endif

    <!-- Video Showcase Section -->
    @if($product->has_video)
        <div id="videoShowcaseSection" style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(249, 115, 22, 0.25); padding: 2rem; border-radius: 1.25rem; margin-bottom: 4rem; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem;">
                <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 0.6rem;">
                    <span style="display: inline-flex; align-items: center; justify-content: center; width: 34px; height: 34px; background: rgba(249, 115, 22, 0.2); border-radius: 50%; color: #f97316;">
                        <i data-feather="video" style="width: 18px; height: 18px;"></i>
                    </span>
                    Demostración en Video del Producto
                </h2>
                <span style="font-size: 0.8rem; color: #cbd5e1; background: rgba(15, 23, 42, 0.7); padding: 0.35rem 0.85rem; border-radius: 9999px; border: 1px solid rgba(255, 255, 255, 0.1); display: inline-flex; align-items: center; gap: 0.4rem;">
                    <i data-feather="play-circle" style="width: 14px; height: 14px; color: #f97316;"></i>
                    Visualiza los detalles, acabados y movimiento en vivo
                </span>
            </div>
            
            <div style="position: relative; width: 100%; max-width: 900px; margin: 0 auto; aspect-ratio: 16/9; background: #000; border-radius: 1rem; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.12); box-shadow: 0 20px 40px rgba(0,0,0,0.5);">
                @if($product->video_type === 'file' || $product->video_type === 'file_url')
                    <video controls preload="metadata" style="width: 100%; height: 100%; object-fit: contain; background: #000;">
                        <source src="{{ $product->video_embed_url }}">
                        Tu navegador no soporta la reproducción de video.
                    </video>
                @else
                    <iframe src="{{ $product->video_embed_url }}" style="width: 100%; height: 100%; border: none; background: #000;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @endif
            </div>
        </div>
    @endif

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 800; color: #ffffff; margin-bottom: 1.5rem;">Productos Relacionados</h2>
            <div class="products-grid" style="margin-bottom: 0; padding: 0;">
                @foreach($relatedProducts as $rel)
                    <div class="product-card">
                        <div class="product-card-thumb">
                            <a href="{{ route('shop.show', $rel->slug) }}" target="_blank" rel="noopener noreferrer">
                                <img src="{{ $rel->primary_image_url }}" alt="{{ $rel->title }}">
                            </a>
                        </div>
                        <div class="product-card-body">
                            <a href="{{ route('shop.show', $rel->slug) }}" target="_blank" rel="noopener noreferrer" style="text-decoration: none; color: inherit;">
                                <h3 class="product-title">{{ $rel->title }}</h3>
                            </a>
                            <div class="product-card-footer">
                                <span class="price-current">@money($rel->effective_price)</span>
                                <a href="{{ route('shop.show', $rel->slug) }}" target="_blank" rel="noopener noreferrer" class="btn-action-card btn-direct">Ver producto</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <!-- Lightbox Modal para Agrandar Imagen -->
    <div id="imageLightboxModal" class="image-lightbox-modal" style="display: none;" onclick="handleLightboxBackdropClick(event)">
        <!-- Barra superior del modal -->
        <div class="lightbox-toolbar">
            <div class="lightbox-title-info">
                <span style="font-weight: 700; color: #ffffff;">{{ $product->title }}</span>
                @if($product->images->count() > 1)
                    <span style="color: #94a3b8; font-size: 0.85rem; margin-left: 0.5rem;" id="lightboxCounter">(1 de {{ $product->images->count() }})</span>
                @endif
            </div>

            <div class="lightbox-actions">
                <!-- Controles de Zoom -->
                <button type="button" class="lightbox-btn" onclick="event.stopPropagation(); zoomInModal();" title="Acercar (+)">
                    <i data-feather="plus"></i>
                </button>
                <button type="button" class="lightbox-btn" onclick="event.stopPropagation(); zoomOutModal();" title="Alejar (-)">
                    <i data-feather="minus"></i>
                </button>
                <button type="button" class="lightbox-btn" onclick="event.stopPropagation(); resetZoomModal();" title="Restablecer tamaño">
                    <i data-feather="maximize-2"></i>
                </button>
                <!-- Botón Cerrar -->
                <button type="button" class="lightbox-btn btn-close-lightbox" onclick="event.stopPropagation(); closeImageLightbox();" title="Cerrar (Esc o clic afuera)">
                    <i data-feather="x"></i>
                </button>
            </div>
        </div>

        <!-- Contenedor de la Imagen Agrandada -->
        <div class="lightbox-image-wrapper" onmousemove="handleImageMouseMove(event)">
            @if($product->images->count() > 1)
                <!-- Flecha Anterior en Modal -->
                <button type="button" class="lightbox-nav-arrow arrow-left" onclick="changeImage(-1, event)" title="Foto anterior (←)">
                    <i data-feather="chevron-left"></i>
                </button>
            @endif

            <div class="lightbox-img-viewport" id="lightboxViewport">
                <img id="lightboxImg" 
                     src="{{ $product->primary_image_url }}" 
                     alt="{{ $product->title }}" 
                     onclick="toggleZoomClick(event)" 
                     onmousemove="handleImageMouseMove(event)"
                     title="Haz clic para agrandar toda la imagen">
            </div>

            @if($product->images->count() > 1)
                <!-- Flecha Siguiente en Modal -->
                <button type="button" class="lightbox-nav-arrow arrow-right" onclick="changeImage(1, event)" title="Siguiente foto (→)">
                    <i data-feather="chevron-right"></i>
                </button>
            @endif
        </div>

        <!-- Indicador inferior de ayuda -->
        <div class="lightbox-caption">
            <span>Haz clic en la imagen para acercar/ver detalles &bull; Haz clic fuera de la imagen para salir &bull; Teclas ← → para cambiar foto &bull; Esc para cerrar</span>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    const productImages = @json($product->images->map(fn($img) => $img->url));
    let currentImageIndex = 0;
    let modalZoomLevel = 1.0;
    let isVideoMode = false;
    const hasProductVideo = {{ $product->has_video ? 'true' : 'false' }};

    function handleGalleryClick() {
        if (isVideoMode) {
            // En modo video, permitir interacción nativa con los controles de video
            return;
        }
        openImageLightbox();
    }

    function toggleVideoOrPhoto() {
        if (isVideoMode) {
            exitVideoMode();
        } else {
            switchToVideoMode();
        }
    }

    function switchToVideoMode(thumbEl) {
        if (!hasProductVideo) return;
        isVideoMode = true;

        const mainImg = document.getElementById('mainProductImg');
        const videoContainer = document.getElementById('productVideoMainContainer');
        const toggleBtn = document.getElementById('toggleVideoFloatBtn');
        const zoomBtn = document.getElementById('galleryZoomBtn');
        const arrowPrev = document.getElementById('galleryArrowPrev');
        const arrowNext = document.getElementById('galleryArrowNext');
        const counterBox = document.getElementById('galleryCounterBox');
        const mainGallery = document.getElementById('productGalleryMain');

        if (mainImg) mainImg.style.display = 'none';
        if (videoContainer) videoContainer.style.display = 'block';
        if (zoomBtn) zoomBtn.style.display = 'none';
        if (arrowPrev) arrowPrev.style.display = 'none';
        if (arrowNext) arrowNext.style.display = 'none';
        if (counterBox) counterBox.style.display = 'none';
        if (mainGallery) mainGallery.style.cursor = 'default';

        // Iniciar reproducción
        const iframe = document.getElementById('galleryMainVideoIframe');
        if (iframe && !iframe.src) {
            iframe.src = iframe.getAttribute('data-src') || '';
        }
        const videoPlayer = document.getElementById('galleryMainVideoPlayer');
        if (videoPlayer) {
            videoPlayer.play().catch(() => {});
        }

        // Actualizar botón flotante
        if (toggleBtn) {
            toggleBtn.innerHTML = '<i data-feather="image" style="width: 13px; height: 13px; fill: #f97316; stroke: #f97316;"></i><span id="toggleVideoFloatBtnText">Ver Fotos</span>';
            if (window.feather) feather.replace();
        }

        // Actualizar bordes de thumbnails
        const thumbContainer = document.getElementById('thumbnailsContainer');
        if (thumbContainer) {
            const thumbs = thumbContainer.querySelectorAll('.thumb-image-item');
            thumbs.forEach(t => t.style.borderColor = 'rgba(255,255,255,0.1)');
        }
        const videoThumb = document.getElementById('videoThumbBtn');
        if (videoThumb) {
            videoThumb.style.borderColor = '#f97316';
            videoThumb.style.boxShadow = '0 0 12px rgba(249, 115, 22, 0.4)';
            videoThumb.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
        }
    }

    function exitVideoMode() {
        if (!isVideoMode) return;
        isVideoMode = false;

        const mainImg = document.getElementById('mainProductImg');
        const videoContainer = document.getElementById('productVideoMainContainer');
        const toggleBtn = document.getElementById('toggleVideoFloatBtn');
        const zoomBtn = document.getElementById('galleryZoomBtn');
        const arrowPrev = document.getElementById('galleryArrowPrev');
        const arrowNext = document.getElementById('galleryArrowNext');
        const counterBox = document.getElementById('galleryCounterBox');
        const mainGallery = document.getElementById('productGalleryMain');

        if (mainImg) mainImg.style.display = 'block';
        if (videoContainer) videoContainer.style.display = 'none';
        if (zoomBtn) zoomBtn.style.display = 'inline-flex';
        if (arrowPrev) arrowPrev.style.display = 'flex';
        if (arrowNext) arrowNext.style.display = 'flex';
        if (counterBox) counterBox.style.display = 'inline-flex';
        if (mainGallery) mainGallery.style.cursor = 'zoom-in';

        // Pausar video o limpiar iframe
        const videoPlayer = document.getElementById('galleryMainVideoPlayer');
        if (videoPlayer) {
            videoPlayer.pause();
        }
        const iframe = document.getElementById('galleryMainVideoIframe');
        if (iframe) {
            iframe.src = '';
        }

        // Reset botón flotante
        if (toggleBtn) {
            toggleBtn.innerHTML = '<i data-feather="play" id="toggleVideoFloatIcon" style="width: 13px; height: 13px; fill: #f97316; stroke: #f97316;"></i><span id="toggleVideoFloatBtnText">Ver Video</span>';
            if (window.feather) feather.replace();
        }

        // Reset thumbnail video border
        const videoThumb = document.getElementById('videoThumbBtn');
        if (videoThumb) {
            videoThumb.style.borderColor = 'rgba(249,115,22,0.5)';
            videoThumb.style.boxShadow = 'none';
        }
    }

    function updateMainImage(index) {
        if (isVideoMode) {
            exitVideoMode();
        }

        if (!productImages || productImages.length === 0) return;
        
        // Loop circularmente
        if (index < 0) {
            currentImageIndex = productImages.length - 1;
        } else if (index >= productImages.length) {
            currentImageIndex = 0;
        } else {
            currentImageIndex = index;
        }

        const currentUrl = productImages[currentImageIndex];

        // Actualizar imagen principal en la página
        const mainImg = document.getElementById('mainProductImg');
        if (mainImg) {
            mainImg.style.opacity = '0.35';
            setTimeout(() => {
                mainImg.src = currentUrl;
                mainImg.style.opacity = '1';
            }, 120);
        }

        // Actualizar imagen en el modal agrandado
        const lbImg = document.getElementById('lightboxImg');
        if (lbImg) {
            lbImg.src = currentUrl;
        }

        // Actualizar contador
        const counterEl = document.getElementById('galleryCurrentIdx');
        if (counterEl) {
            counterEl.textContent = currentImageIndex + 1;
        }

        const lbCounterEl = document.getElementById('lightboxCounter');
        if (lbCounterEl) {
            lbCounterEl.textContent = `(${currentImageIndex + 1} de ${productImages.length})`;
        }

        // Actualizar thumbnails
        const thumbContainer = document.getElementById('thumbnailsContainer');
        if (thumbContainer) {
            const thumbs = thumbContainer.querySelectorAll('.thumb-image-item');
            for (let i = 0; i < thumbs.length; i++) {
                thumbs[i].style.borderColor = (i === currentImageIndex) ? '#f97316' : 'rgba(255,255,255,0.1)';
            }
            if (thumbs[currentImageIndex]) {
                thumbs[currentImageIndex].scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        }
    }

    function changeImage(direction, event) {
        if (event) {
            event.stopPropagation();
        }
        if (isVideoMode) {
            exitVideoMode();
        }
        resetZoomModal();
        updateMainImage(currentImageIndex + direction);
    }

    function switchImage(src, element, index) {
        if (isVideoMode) {
            exitVideoMode();
        }
        updateMainImage(index);
    }

    // Modal Lightbox / Zoom
    function openImageLightbox() {
        const modal = document.getElementById('imageLightboxModal');
        const lbImg = document.getElementById('lightboxImg');
        const currentUrl = productImages && productImages.length > 0 ? productImages[currentImageIndex] : (document.getElementById('mainProductImg') ? document.getElementById('mainProductImg').src : '');
        
        if (lbImg && currentUrl) {
            lbImg.src = currentUrl;
        }
        resetZoomModal();

        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden'; // bloquear scroll
            if (window.feather) feather.replace();
        }
    }

    function closeImageLightbox() {
        const modal = document.getElementById('imageLightboxModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
            resetZoomModal();
        }
    }

    // Al hacer clic fuera de la imagen (fondo, bordes, wrapper, etc.), salir del modal
    function handleLightboxBackdropClick(event) {
        // Si hace clic en la imagen directamente, no salimos (la imagen maneja zoom para ver detalles)
        if (event.target.id === 'lightboxImg') {
            return;
        }
        // Si hace clic en flechas de navegación o botones del modal, dejar que hagan su acción
        if (event.target.closest('.lightbox-nav-arrow') || 
            event.target.closest('.lightbox-btn') || 
            event.target.closest('button')) {
            return;
        }
        // Cualquier otro clic es "afuera de la imagen" -> cerrar y salir inmediatamente
        closeImageLightbox();
    }

    function applyModalZoom() {
        const lbImg = document.getElementById('lightboxImg');
        const viewport = document.getElementById('lightboxViewport');
        if (lbImg) {
            lbImg.style.transform = `scale(${modalZoomLevel})`;
            if (modalZoomLevel > 1.05) {
                lbImg.classList.add('is-zoomed');
                lbImg.style.cursor = 'zoom-out';
            } else {
                lbImg.classList.remove('is-zoomed');
                lbImg.style.cursor = 'zoom-in';
                lbImg.style.transformOrigin = 'center center';
            }
        }
        if (viewport) {
            if (modalZoomLevel > 1.05) {
                viewport.classList.add('is-zoomed');
            } else {
                viewport.classList.remove('is-zoomed');
            }
        }
    }

    function zoomInModal() {
        modalZoomLevel = Math.min(modalZoomLevel + 0.4, 3.2);
        applyModalZoom();
    }

    function zoomOutModal() {
        modalZoomLevel = Math.max(modalZoomLevel - 0.4, 1.0);
        applyModalZoom();
    }

    function resetZoomModal() {
        modalZoomLevel = 1.0;
        const lbImg = document.getElementById('lightboxImg');
        if (lbImg) {
            lbImg.style.transformOrigin = 'center center';
        }
        applyModalZoom();
    }

    // Al hacer clic en la imagen: alternar entre agrandada completa (zoom 2.4x) y tamaño normal
    function toggleZoomClick(event) {
        event.stopPropagation();
        const lbImg = document.getElementById('lightboxImg');
        const wrapper = document.querySelector('.lightbox-image-wrapper');
        if (!lbImg) return;

        if (modalZoomLevel > 1.05) {
            // Ya está ampliada: regresar a tamaño normal
            resetZoomModal();
        } else {
            // Agrandar toda la imagen
            const container = wrapper || lbImg.parentElement;
            const rect = container.getBoundingClientRect();
            const x = Math.max(0, Math.min(100, ((event.clientX - rect.left) / rect.width) * 100));
            const y = Math.max(0, Math.min(100, ((event.clientY - rect.top) / rect.height) * 100));
            
            lbImg.style.transformOrigin = `${x}% ${y}%`;
            modalZoomLevel = 2.4;
            applyModalZoom();
        }
    }

    // Mover el punto de enfoque al pasar el mouse sobre la imagen ampliada para ver cada detalle
    function handleImageMouseMove(event) {
        if (modalZoomLevel <= 1.05) return;
        const lbImg = document.getElementById('lightboxImg');
        const wrapper = document.querySelector('.lightbox-image-wrapper');
        if (!lbImg) return;

        const container = wrapper || lbImg.parentElement;
        const rect = container.getBoundingClientRect();
        const x = Math.max(0, Math.min(100, ((event.clientX - rect.left) / rect.width) * 100));
        const y = Math.max(0, Math.min(100, ((event.clientY - rect.top) / rect.height) * 100));
        lbImg.style.transformOrigin = `${x}% ${y}%`;
    }

    // Rueda del mouse (scroll) para acercar / alejar dentro del modal
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('imageLightboxModal');
        if (modal) {
            modal.addEventListener('wheel', function(e) {
                if (modal.style.display !== 'none') {
                    e.preventDefault();
                    if (e.deltaY < 0) {
                        zoomInModal();
                    } else {
                        zoomOutModal();
                    }
                }
            }, { passive: false });
        }
    });

    // Navegación con teclado (Flechas y Escape)
    document.addEventListener('keydown', function(e) {
        const modal = document.getElementById('imageLightboxModal');
        const isModalOpen = modal && modal.style.display !== 'none';

        if (e.key === 'Escape') {
            if (isModalOpen) {
                closeImageLightbox();
            }
        } else if (e.key === 'ArrowLeft') {
            if (productImages.length > 1) {
                changeImage(-1);
            }
        } else if (e.key === 'ArrowRight') {
            if (productImages.length > 1) {
                changeImage(1);
            }
        } else if (isModalOpen && (e.key === '+' || e.key === '=')) {
            zoomInModal();
        } else if (isModalOpen && (e.key === '-' || e.key === '_')) {
            zoomOutModal();
        }
    });

    // Manejador de selección de tallas
    function selectProductSize(size, btn) {
        const sizeInput = document.getElementById('productSelectedSize');
        const sizeLabel = document.getElementById('selectedSizeLabel');
        const alertMsg = document.getElementById('sizeAlertMsg');

        if (sizeInput) sizeInput.value = size;
        if (sizeLabel) sizeLabel.textContent = 'Talla ' + size + ' seleccionada ✓';
        if (alertMsg) alertMsg.style.display = 'none';

        document.querySelectorAll('.size-pill-btn').forEach(b => {
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

    const addToCartForm = document.getElementById('addToCartForm');
    if (addToCartForm) {
        addToCartForm.addEventListener('submit', function(e) {
            const sizeInput = document.getElementById('productSelectedSize');
            if (sizeInput && !sizeInput.value) {
                e.preventDefault();
                const alertMsg = document.getElementById('sizeAlertMsg');
                if (alertMsg) {
                    alertMsg.style.display = 'block';
                    alertMsg.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return false;
            }
        });
    }
</script>
@endsection
