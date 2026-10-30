@extends('layouts.admin')

@section('title', 'Editar Categoría - ' . $category->name)

@section('content')
<div style="max-width: 700px; margin: 0 auto 3rem;">
    <!-- Header -->
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.categories.index') }}" style="color: #94a3b8; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.35rem; margin-bottom: 0.75rem; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'">
            <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i> Volver a categorías
        </a>
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
            <div>
                <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff; margin-bottom: 0.25rem;">Editar Categoría</h1>
                <p style="color: #94a3b8; font-size: 0.9rem;">Modifica los detalles, slug y configuración de la categoría.</p>
            </div>
            <span style="background: rgba(249, 115, 22, 0.15); border: 1px solid rgba(249, 115, 22, 0.3); color: #fdba74; padding: 0.35rem 0.85rem; border-radius: 9999px; font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.4rem;">
                <i data-feather="package" style="width: 14px; height: 14px;"></i> {{ $category->products()->count() }} productos vinculados
            </span>
        </div>
    </div>

    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            <div style="font-weight: 700; margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="alert-triangle" style="width: 16px; height: 16px;"></i> Por favor revisa los errores:
            </div>
            <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.85rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem; box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.3);">
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                    Nombre de Categoría *
                </label>
                <input type="text" name="name" required value="{{ old('name', $category->name) }}" placeholder="Ej. Accesorios Gaming" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                    Slug (Identificador URL)
                </label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="ej-accesorios-gaming" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #cbd5e1; font-size: 0.9rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
                <span style="font-size: 0.75rem; color: #64748b; margin-top: 0.35rem; display: block;">Se usa para filtros en la URL de la tienda: /?category={{ $category->slug }}</span>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                    Descripción
                </label>
                <textarea name="description" rows="4" placeholder="Descripción breve de la categoría..." style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.9rem; outline: none; resize: vertical; transition: border-color 0.2s;" onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">{{ old('description', $category->description) }}</textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; gap: 0.75rem; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                <a href="{{ route('admin.categories.index') }}" class="pill-item" style="padding: 0.8rem 1.5rem; text-decoration: none; font-size: 0.9rem; font-weight: 600; display: inline-flex; align-items: center; justify-content: center;">
                    Cancelar
                </a>
                <button type="submit" class="pill-item active" style="padding: 0.8rem 1.75rem; font-weight: 800; font-size: 0.9rem; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem;">
                    <i data-feather="check" style="width: 16px; height: 16px;"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
