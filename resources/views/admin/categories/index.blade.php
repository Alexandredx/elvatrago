@extends('layouts.admin')

@section('title', 'Gestión de Categorías - Admin')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">Gestión de Categorías</h1>
    <p style="color: #94a3b8; font-size: 0.9rem;">Organiza tus productos por departamentos y familias.</p>
</div>

<div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
    <!-- Categories List Table -->
    <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
            <thead>
                <tr style="background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.75rem; text-transform: uppercase; color: #94a3b8;">
                    <th style="padding: 1rem 1.25rem;">Categoría</th>
                    <th style="padding: 1rem 1.25rem;">Slug</th>
                    <th style="padding: 1rem 1.25rem;">Productos</th>
                    <th style="padding: 1rem 1.25rem; text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                    <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                        <td style="padding: 1rem 1.25rem; font-weight: 700; color: #ffffff;">
                            {{ $cat->name }}
                        </td>
                        <td style="padding: 1rem 1.25rem; color: #cbd5e1;">
                            {{ $cat->slug }}
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            <span style="background: rgba(99, 102, 241, 0.2); color: #a5b4fc; padding: 0.25rem 0.65rem; border-radius: 9999px; font-weight: 700; font-size: 0.8rem;">
                                {{ $cat->products_count }} productos
                            </span>
                        </td>
                        <td style="padding: 1rem 1.25rem; text-align: center;">
                            <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta categoría?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 0.35rem 0.65rem; border-radius: 0.5rem; cursor: pointer;">
                                    <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Quick Create Form -->
    <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
        <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem;">Nueva Categoría</h3>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Nombre de Categoría *</label>
                <input type="text" name="name" required placeholder="Ej. Accesorios Gaming" style="width: 100%; padding: 0.75rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Descripción</label>
                <textarea name="description" rows="3" placeholder="Descripción breve..." style="width: 100%; padding: 0.75rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff;"></textarea>
            </div>

            <button type="submit" class="pill-item active" style="width: 100%; padding: 0.8rem; font-weight: 800; border: none; cursor: pointer;">
                Crear Categoría
            </button>
        </form>
    </div>
</div>
@endsection
