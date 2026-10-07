@extends('layouts.app')

@section('title', $product->title . ' - Elvatrago')

@section('content')
<div style="max-width: 1280px; margin: 2rem auto 4rem; padding: 0 1.5rem;">
    <!-- Breadcrumb -->
    <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.85rem; color: #94a3b8; margin-bottom: 2rem;">
        <a href="{{ route('shop.index') }}" style="color: #cbd5e1;">Inicio</a>
        <i data-feather="chevron-right" style="width: 14px; height: 14px;"></i>
        <a href="{{ route('shop.index', ['category' => $product->category->slug ?? '']) }}" style="color: #cbd5e1;">{{ $product->category->name ?? 'General' }}</a>
        <i data-feather="chevron-right" style="width: 14px; height: 14px;"></i>
        <span style="color: #6366f1; font-weight: 600;">{{ $product->title }}</span>
    </div>

    <!-- Product Layout Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 3rem; margin-bottom: 4rem;">
        
        <!-- Left: Image Gallery & Reference Photos -->
        <div>
            <!-- Main Featured Image -->
            <div style="width: 100%; height: 420px; background: #0f172a; border-radius: 1.25rem; border: 1px solid rgba(255, 255, 255, 0.1); overflow: hidden; position: relative; margin-bottom: 1rem;">
                <img id="mainProductImg" src="{{ $product->primary_image_url }}" alt="{{ $product->title }}" style="width: 100%; height: 100%; object-fit: cover; transition: all 0.3s ease;">
                
                @if(auth()->check() && auth()->user()->isAdmin())
                    <div style="position: absolute; top: 1rem; left: 1rem;">
                        @if($product->isDirect())
                            <span class="badge badge-direct" style="font-size: 0.85rem; padding: 0.35rem 0.85rem;">
                                <i data-feather="check-circle" style="width: 14px; height: 14px;"></i> Stock Venta Directa
                            </span>
                        @else
                            <span class="badge badge-aliexpress" style="font-size: 0.85rem; padding: 0.35rem 0.85rem;">
                                <i data-feather="external-link" style="width: 14px; height: 14px;"></i> Oferta Afiliada
                            </span>
                        @endif
                    </div>
                @endif
            </div>

            <!-- Thumbnails Carousel / Grid -->
            @if($product->images->count() > 1)
                <div style="display: flex; gap: 0.75rem; overflow-x: auto; padding-bottom: 0.5rem;">
                    @foreach($product->images as $img)
                        <div onclick="switchImage('{{ $img->url }}', this)" 
                             style="width: 80px; height: 80px; background: #0f172a; border-radius: 0.75rem; border: 2px solid {{ $loop->first ? '#6366f1' : 'rgba(255,255,255,0.1)' }}; overflow: hidden; cursor: pointer; flex-shrink: 0; transition: all 0.2s ease;">
                            <img src="{{ $img->url }}" alt="Foto referencial" style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right: Product Info & Buy/Redirect Actions -->
        <div style="display: flex; flex-direction: column;">
            <div style="font-size: 0.85rem; font-weight: 700; color: #6366f1; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">
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

                <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display: flex; gap: 1rem;">
                    @csrf
                    <div style="width: 100px;">
                        <input type="number" name="quantity" value="1" min="1" max="{{ $product->stock > 0 ? $product->stock : 999 }}" style="width: 100%; padding: 0.85rem; background: #1e293b; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 1rem; font-weight: 700; text-align: center;">
                    </div>

                    <button type="submit" style="flex: 1; padding: 0.85rem 1.5rem; background: var(--accent-gradient); border: none; border-radius: 0.75rem; color: #ffffff; font-weight: 700; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 0.5rem; cursor: pointer; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.4); transition: all 0.3s ease;">
                        <i data-feather="shopping-cart"></i> Añadir al Carrito
                    </button>
                </form>
            </div>

            <!-- Features list -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; font-size: 0.85rem; color: #94a3b8;">
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="shield" style="color: #10b981; width: 16px; height: 16px;"></i> Compra 100% Protegida
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="truck" style="color: #6366f1; width: 16px; height: 16px;"></i> Envíos a todo el país
                </div>
            </div>
        </div>
    </div>

    <!-- Long Description Section -->
    @if($product->description)
        <div style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); padding: 2rem; border-radius: 1.25rem; margin-bottom: 4rem;">
            <h2 style="font-size: 1.35rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="file-text" style="color: #6366f1;"></i> Descripción Detallada del Producto
            </h2>
            <div style="color: #cbd5e1; line-height: 1.7; font-size: 0.95rem;">
                {!! nl2br(e($product->description)) !!}
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
                            <a href="{{ route('shop.show', $rel->slug) }}">
                                <img src="{{ $rel->primary_image_url }}" alt="{{ $rel->title }}">
                            </a>
                        </div>
                        <div class="product-card-body">
                            <h3 class="product-title">{{ $rel->title }}</h3>
                            <div class="product-card-footer">
                                <span class="price-current">@money($rel->effective_price)</span>
                                <a href="{{ route('shop.show', $rel->slug) }}" class="btn-action-card btn-direct">Ver producto</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    function switchImage(src, element) {
        document.getElementById('mainProductImg').src = src;
        const thumbs = element.parentElement.children;
        for (let t of thumbs) {
            t.style.borderColor = 'rgba(255,255,255,0.1)';
        }
        element.style.borderColor = '#6366f1';
    }
</script>
@endsection
