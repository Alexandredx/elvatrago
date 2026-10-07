@extends('layouts.admin')

@section('title', 'Crear Producto - Admin')

@section('content')
<div style="max-width: 900px; margin: 0 auto 3rem;">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.products.index') }}" style="color: #94a3b8; font-size: 0.85rem;">&larr; Volver a la lista de productos</a>
        <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff; margin-top: 0.5rem;">Crear Nuevo Producto</h1>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem;">
        @csrf

        <!-- Product Type Switcher -->
        <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(99, 102, 241, 0.3); padding: 1.25rem; border-radius: 1rem; margin-bottom: 2rem;">
            <label style="display: block; font-size: 0.9rem; font-weight: 700; color: #ffffff; margin-bottom: 0.75rem;">
                Modalidad del Producto *
            </label>

            <div style="display: flex; gap: 1.5rem;">
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #cbd5e1; font-weight: 600;">
                    <input type="radio" name="type" value="direct" id="type_direct" checked onchange="toggleTypeFields()" style="accent-color: #6366f1; width: 18px; height: 18px;">
                    <span style="color: #34d399;">🛍️ Venta Directa</span>
                </label>

                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; color: #cbd5e1; font-weight: 600;">
                    <input type="radio" name="type" value="affiliate" id="type_affiliate" onchange="toggleTypeFields()" style="accent-color: #ff6b6b; width: 18px; height: 18px;">
                    <span style="color: #ff6b6b;">🚀 Redirección Afiliado</span>
                </label>
            </div>
        </div>

        <!-- Title & Category -->
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Título del Producto *</label>
                <input type="text" name="title" required value="{{ old('title') }}" placeholder="Ej. Auriculares Inalámbricos SoundPulse Pro" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
            </div>

            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Categoría *</label>
                <select name="category_id" required style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Affiliate Specific Fields (External URL & Platform Name) -->
        <div id="affiliate_fields" style="display: none; background: rgba(255, 71, 71, 0.08); border: 1px solid rgba(255, 71, 71, 0.25); padding: 1.25rem; border-radius: 0.75rem; margin-bottom: 1.25rem;">
            <div style="display: grid; grid-template-columns: 3fr 1fr; gap: 1rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #ff6b6b; margin-bottom: 0.5rem;">Enlace de Afiliado (URL Externa de Redirección) *</label>
                    <input type="url" name="external_url" id="external_url_input" placeholder="https://ejemplo.com/item/12345.html" value="{{ old('external_url') }}" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
                </div>

                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #ff6b6b; margin-bottom: 0.5rem;">Plataforma</label>
                    <select name="platform_name" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
                        <option value="affiliate">Afiliado General</option>
                        <option value="partner">Socio Externo</option>
                        <option value="amazon">Amazon</option>
                        <option value="other">Otra Plataforma</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Prices & Stock -->
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Precio Normal ($) *</label>
                <input type="number" step="0.01" name="price" required value="{{ old('price') }}" placeholder="129.99" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
            </div>

            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Precio Oferta ($) (Opcional)</label>
                <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" placeholder="89.99" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
            </div>

            <div id="stock_field">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #34d399; margin-bottom: 0.5rem;">Stock Disponible (Venta Directa)</label>
                <input type="number" name="stock" value="{{ old('stock', 10) }}" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
            </div>
        </div>

        <!-- Descriptions -->
        <div style="margin-bottom: 1.25rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Descripción Corta</label>
            <input type="text" name="short_description" value="{{ old('short_description') }}" placeholder="Resumen breve para tarjetas de catálogo..." style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Descripción Completa del Producto</label>
            <textarea name="description" rows="4" placeholder="Especificaciones detalladas, características y material..." style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">{{ old('description') }}</textarea>
        </div>

        <!-- Reference Images Section -->
        <div style="background: rgba(15, 23, 42, 0.5); border: 1px solid rgba(255,255,255,0.08); padding: 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            <h3 style="font-size: 1rem; font-weight: 700; color: #ffffff; margin-bottom: 0.75rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="image" style="color: #6366f1;"></i> Fotos de Referencia del Producto
            </h3>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 0.35rem;">Opción A: Subir Archivos de Imagen</label>
                <input type="file" name="images[]" multiple accept="image/*" style="width: 100%; padding: 0.5rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.5rem; color: #ffffff;">
            </div>

            <div>
                <label style="display: block; font-size: 0.85rem; color: #cbd5e1; margin-bottom: 0.35rem;">Opción B: Pegar URLs de Imágenes (Una URL por línea)</label>
                <textarea name="image_urls" rows="3" placeholder="https://images.unsplash.com/photo-123456...&#10;https://images.unsplash.com/photo-789012..." style="width: 100%; padding: 0.8rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.5rem; color: #ffffff; font-family: monospace; font-size: 0.85rem;"></textarea>
            </div>
        </div>

        <!-- Options -->
        <div style="display: flex; gap: 2rem; margin-bottom: 2rem;">
            <label style="display: flex; align-items: center; gap: 0.5rem; color: #ffffff; font-size: 0.9rem; cursor: pointer;">
                <input type="checkbox" name="is_featured" value="1" style="width: 18px; height: 18px; accent-color: #6366f1;">
                Destacar en Portada
            </label>
        </div>

        <button type="submit" class="pill-item active" style="width: 100%; padding: 0.9rem; font-size: 1rem; font-weight: 800; border: none; cursor: pointer;">
            Guardar Producto
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
