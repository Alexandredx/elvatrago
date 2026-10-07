@extends('layouts.admin')

@section('title', 'Editar Producto - Admin')

@section('content')
<div style="max-width: 900px; margin: 0 auto 3rem;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.products.index') }}" style="color: #94a3b8; font-size: 0.85rem;">&larr; Volver a la lista de productos</a>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff; margin-top: 0.5rem;">Editar Producto: {{ $product->title }}</h1>
    </div>

    <!-- Existing Images Preview Box -->
    <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem; margin-bottom: 2rem;">
        <h3 style="font-size: 1rem; font-weight: 700; color: #ffffff; margin-bottom: 1rem;">Fotos de Referencia Actuales</h3>
        
        @if($product->images->count() > 0)
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                @foreach($product->images as $img)
                    <div style="position: relative; width: 100px; height: 100px; border-radius: 0.75rem; overflow: hidden; border: 1px solid rgba(255,255,255,0.15);">
                        <img src="{{ $img->url }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <form action="{{ route('admin.products.images.destroy', $img->id) }}" method="POST" style="position: absolute; top: 0.25rem; right: 0.25rem;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: rgba(239, 68, 68, 0.85); color: white; border: none; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                &times;
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: #94a3b8; font-size: 0.85rem;">Sin imágenes aún.</p>
        @endif
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem;">
        @csrf
        @method('PUT')

        <!-- Product Type Switcher -->
        <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(99, 102, 241, 0.3); padding: 1.25rem; border-radius: 1rem; margin-bottom: 2rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 700; color: #ffffff; margin-bottom: 0.75rem;">
                Modalidad del Producto *
            </label>

            <div style="display: flex; gap: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #cbd5e1; font-weight: 600;">
                    <input type="radio" name="type" value="direct" id="type_direct" {{ $product->type === 'direct' ? 'checked' : '' }} onchange="toggleTypeFields()" style="accent-color: #6366f1; width: 18px; height: 18px;">
                    <span style="color: #34d399;">🛍️ Venta Directa</span>
                </label>

                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #cbd5e1; font-weight: 600;">
                    <input type="radio" name="type" value="affiliate" id="type_affiliate" {{ $product->type === 'affiliate' ? 'checked' : '' }} onchange="toggleTypeFields()" style="accent-color: #ff6b6b; width: 18px; height: 18px;">
                    <span style="color: #ff6b6b;">🚀 Redirección Afiliado</span>
                </label>
            </div>
        </div>

        <!-- Title & Category -->
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Título del Producto *</label>
                <input type="text" name="title" required value="{{ old('title', $product->title) }}" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
            </div>

            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Categoría *</label>
                <select name="category_id" required style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Affiliate Specific Fields -->
        <div id="affiliate_fields" style="display: none; background: rgba(255, 71, 71, 0.08); border: 1px solid rgba(255, 71, 71, 0.25); padding: 1.25rem; border-radius: 0.75rem; margin-bottom: 1.25rem;">
            <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #ff6b6b; margin-bottom: 0.5rem;">Enlace de Afiliado (URL Externa de Redirección) *</label>
                    <input type="url" name="external_url" id="external_url_input" value="{{ old('external_url', $product->external_url) }}" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #ff6b6b; margin-bottom: 0.5rem;">Plataforma</label>
                    <select name="platform_name" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
                        <option value="affiliate" {{ in_array($product->platform_name, ['affiliate', 'aliexpress']) ? 'selected' : '' }}>Afiliado General</option>
                        <option value="partner" {{ in_array($product->platform_name, ['partner', 'temu']) ? 'selected' : '' }}>Socio Externo</option>
                        <option value="amazon" {{ $product->platform_name === 'amazon' ? 'selected' : '' }}>Amazon</option>
                        <option value="other" {{ $product->platform_name === 'other' ? 'selected' : '' }}>Otra Plataforma</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Prices & Stock -->
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Precio Normal ($) *</label>
                <input type="number" step="0.01" name="price" required value="{{ old('price', $product->price) }}" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
            </div>

            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Precio Oferta ($)</label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
            </div>

            <div id="stock_field">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #34d399; margin-bottom: 0.5rem;">Stock Disponible</label>
                <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
            </div>
        </div>

        <!-- Descriptions -->
        <div style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Descripción Corta</label>
            <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Descripción Completa</label>
            <textarea name="description" rows="4" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Add New Reference Images -->
        <div style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255,255,255,0.08); padding: 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 700; color: #ffffff; margin-bottom: 0.75rem;">Agregar Más Fotos de Referencia</h3>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 0.35rem;">Subir Nuevos Archivos de Imagen</label>
                <input type="file" name="images[]" multiple accept="image/*" style="width: 100%; padding: 0.5rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.5rem; color: #ffffff;">
            </div>

            <div>
                <label style="display: block; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 0.35rem;">Nuevas URLs de Imagen (Una por línea)</label>
                <textarea name="image_urls" rows="3" style="width: 100%; padding: 0.8rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.5rem; color: #ffffff; font-family: monospace; font-size: 0.85rem;"></textarea>
            </div>
        </div>

        <!-- Options -->
        <div style="display: flex; gap: 2rem; margin-bottom: 2rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; color: #ffffff; font-size: 0.9rem; cursor: pointer;">
                <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #6366f1;">
                Destacar en Portada
            </label>
        </div>

        <button type="submit" class="pill-item active" style="width: 100%; padding: 0.9rem; font-size: 1rem; font-weight: 800; border: none; cursor: pointer;">
            Actualizar Producto
        </button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    function toggleTypeFields() {
        const isAffiliate = document.getElementById('type_affiliate').checked;
        document.getElementById('affiliate_fields').style.display = isAffiliate ? 'block' : 'none';
        document.getElementById('stock_field').style.display = isAffiliate ? 'none' : 'block';
        document.getElementById('external_url_input').required = isAffiliate;
    }
    toggleTypeFields();
</script>
@endsection
