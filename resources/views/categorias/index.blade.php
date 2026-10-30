@extends('layouts.admin')

@section('title', 'Gestión de Categorías - Admin')

@section('content')
<div style="margin-bottom: 2rem;">
    <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">Gestión de Categorías</h1>
    <p style="color: #94a3b8; font-size: 0.9rem;">Organiza tus productos por departamentos, familias y catálogos.</p>
</div>

@if ($errors->any())
    <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
        <div style="font-weight: 700; margin-bottom: 0.25rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-feather="alert-triangle" style="width: 16px; height: 16px;"></i> Ocurrió un error al procesar la categoría:
        </div>
        <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.85rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
    <!-- Categories List Table -->
    <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; overflow: hidden; box-shadow: 0 4px 20px -2px rgba(0,0,0,0.25);">
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
                @forelse($categories as $cat)
                    <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05); transition: background 0.15s;" onmouseover="this.style.background='rgba(255,255,255,0.02)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 1rem 1.25rem; font-weight: 700; color: #ffffff;">
                            <div style="display: flex; align-items: center; gap: 0.6rem;">
                                <div style="width: 32px; height: 32px; border-radius: 8px; background: rgba(249, 115, 22, 0.15); border: 1px solid rgba(249, 115, 22, 0.25); display: flex; align-items: center; justify-content: center; color: #fb923c;">
                                    <i data-feather="tag" style="width: 15px; height: 15px;"></i>
                                </div>
                                <div>
                                    <div>{{ $cat->name }}</div>
                                    @if($cat->description)
                                        <div style="font-size: 0.75rem; color: #64748b; font-weight: normal; max-width: 260px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $cat->description }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="padding: 1rem 1.25rem; color: #cbd5e1; font-family: monospace; font-size: 0.85rem;">
                            {{ $cat->slug }}
                        </td>
                        <td style="padding: 1rem 1.25rem;">
                            <span style="background: rgba(249, 115, 22, 0.2); color: #fdba74; padding: 0.25rem 0.65rem; border-radius: 9999px; font-weight: 700; font-size: 0.8rem; display: inline-flex; align-items: center; gap: 0.35rem;">
                                <i data-feather="package" style="width: 12px; height: 12px;"></i> {{ $cat->products_count }}
                            </span>
                        </td>
                        <td style="padding: 1rem 1.25rem; text-align: center;">
                            <div style="display: inline-flex; align-items: center; gap: 0.5rem;">
                                <!-- Botón Editar -->
                                <button type="button" 
                                        onclick="openEditCategoryModal({
                                            id: {{ $cat->id }},
                                            name: @js($cat->name),
                                            slug: @js($cat->slug),
                                            description: @js($cat->description ?? ''),
                                            updateUrl: '{{ route('admin.categories.update', $cat->id) }}',
                                            editUrl: '{{ route('admin.categories.edit', $cat->id) }}'
                                        })"
                                        title="Editar categoría"
                                        style="background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.3); color: #93c5fd; padding: 0.4rem 0.65rem; border-radius: 0.5rem; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;"
                                        onmouseover="this.style.background='rgba(59, 130, 246, 0.25)'"
                                        onmouseout="this.style.background='rgba(59, 130, 246, 0.15)'">
                                    <i data-feather="edit-2" style="width: 14px; height: 14px;"></i>
                                </button>

                                <!-- Botón Eliminar -->
                                <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar la categoría &quot;{{ $cat->name }}&quot;?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            title="Eliminar categoría"
                                            style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 0.4rem 0.65rem; border-radius: 0.5rem; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s;"
                                            onmouseover="this.style.background='rgba(239, 68, 68, 0.25)'"
                                            onmouseout="this.style.background='rgba(239, 68, 68, 0.15)'">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 2.5rem; text-align: center; color: #64748b;">
                            <i data-feather="tag" style="width: 32px; height: 32px; margin-bottom: 0.5rem; opacity: 0.5;"></i>
                            <div>No hay categorías registradas aún.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Quick Create Form -->
    <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem; box-shadow: 0 4px 20px -2px rgba(0,0,0,0.25);">
        <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
            <i data-feather="plus-circle" style="width: 18px; height: 18px; color: #f97316;"></i> Nueva Categoría
        </h3>

        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Nombre de Categoría *</label>
                <input type="text" name="name" required placeholder="Ej. Accesorios Gaming" style="width: 100%; padding: 0.75rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Descripción</label>
                <textarea name="description" rows="3" placeholder="Descripción breve..." style="width: 100%; padding: 0.75rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; outline: none; resize: vertical; transition: border-color 0.2s;" onfocus="this.style.borderColor='#f97316'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'"></textarea>
            </div>

            <button type="submit" class="pill-item active" style="width: 100%; padding: 0.8rem; font-weight: 800; border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                <i data-feather="plus" style="width: 16px; height: 16px;"></i> Crear Categoría
            </button>
        </form>
    </div>
</div>

<!-- Modal para Editar Categoría -->
<div id="editCategoryModal" style="display: none; position: fixed; inset: 0; background: rgba(3, 7, 18, 0.75); backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center; padding: 1.5rem; opacity: 0; transition: opacity 0.2s ease;">
    <div id="editCategoryModalContent" style="background: #111827; border: 1px solid rgba(255, 255, 255, 0.12); border-radius: 1.25rem; width: 100%; max-width: 540px; padding: 2rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.6); transform: scale(0.95); transition: transform 0.2s ease;">
        
        <!-- Modal Header -->
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding-bottom: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="width: 38px; height: 38px; border-radius: 10px; background: rgba(59, 130, 246, 0.15); border: 1px solid rgba(59, 130, 246, 0.3); display: flex; align-items: center; justify-content: center; color: #60a5fa;">
                    <i data-feather="edit-2" style="width: 18px; height: 18px;"></i>
                </div>
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 800; color: #ffffff; margin: 0;">Editar Categoría</h3>
                    <p style="font-size: 0.8rem; color: #94a3b8; margin: 0;">Actualiza el nombre, slug o descripción</p>
                </div>
            </div>
            <button type="button" onclick="closeEditCategoryModal()" style="background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #94a3b8; width: 32px; height: 32px; border-radius: 0.5rem; cursor: pointer; display: flex; align-items: center; justify-content: center;" onmouseover="this.style.color='#ffffff'" onmouseout="this.style.color='#94a3b8'">
                <i data-feather="x" style="width: 16px; height: 16px;"></i>
            </button>
        </div>

        <!-- Modal Form -->
        <form id="editCategoryForm" method="POST" action="">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                    Nombre de Categoría *
                </label>
                <input type="text" id="editModalName" name="name" required placeholder="Ej. Accesorios Gaming" style="width: 100%; padding: 0.8rem 1rem; background: #090d16; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
            </div>

            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                    Slug (URL amigable)
                </label>
                <input type="text" id="editModalSlug" name="slug" placeholder="slug-de-la-categoria" style="width: 100%; padding: 0.8rem 1rem; background: #090d16; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #94a3b8; font-size: 0.85rem; font-family: monospace; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'">
                <span style="font-size: 0.75rem; color: #64748b; margin-top: 0.35rem; display: block;">Se usa en la URL de filtros de la tienda. Si lo dejas vacío se actualizará con el nuevo nombre.</span>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                    Descripción
                </label>
                <textarea id="editModalDescription" name="description" rows="3" placeholder="Descripción breve..." style="width: 100%; padding: 0.8rem 1rem; background: #090d16; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.9rem; outline: none; resize: vertical; transition: border-color 0.2s;" onfocus="this.style.borderColor='#3b82f6'" onblur="this.style.borderColor='rgba(255,255,255,0.15)'"></textarea>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; gap: 0.75rem; padding-top: 1.25rem; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                <a id="editModalFullPageLink" href="#" style="font-size: 0.8rem; color: #64748b; text-decoration: none; display: inline-flex; align-items: center; gap: 0.35rem;" onmouseover="this.style.color='#94a3b8'" onmouseout="this.style.color='#64748b'">
                    <i data-feather="external-link" style="width: 12px; height: 12px;"></i> Página completa
                </a>
                
                <div style="display: flex; gap: 0.75rem;">
                    <button type="button" onclick="closeEditCategoryModal()" class="pill-item" style="padding: 0.65rem 1.25rem; font-size: 0.875rem; font-weight: 600; border: none; cursor: pointer;">
                        Cancelar
                    </button>
                    <button type="submit" class="pill-item active" style="padding: 0.65rem 1.5rem; font-size: 0.875rem; font-weight: 800; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; background: #3b82f6;">
                        <i data-feather="check" style="width: 16px; height: 16px;"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function openEditCategoryModal(data) {
        const modal = document.getElementById('editCategoryModal');
        const modalContent = document.getElementById('editCategoryModalContent');
        const form = document.getElementById('editCategoryForm');
        
        form.action = data.updateUrl;
        document.getElementById('editModalName').value = data.name || '';
        document.getElementById('editModalSlug').value = data.slug || '';
        document.getElementById('editModalDescription').value = data.description || '';
        
        const fullPageLink = document.getElementById('editModalFullPageLink');
        if (fullPageLink && data.editUrl) {
            fullPageLink.href = data.editUrl;
        }

        modal.style.display = 'flex';
        // Trigger reflow for smooth animation
        setTimeout(() => {
            modal.style.opacity = '1';
            modalContent.style.transform = 'scale(1)';
            document.getElementById('editModalName').focus();
        }, 10);

        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }

    function closeEditCategoryModal() {
        const modal = document.getElementById('editCategoryModal');
        const modalContent = document.getElementById('editCategoryModalContent');
        
        modal.style.opacity = '0';
        modalContent.style.transform = 'scale(0.95)';
        
        setTimeout(() => {
            modal.style.display = 'none';
        }, 200);
    }

    // Cerrar al hacer clic fuera del contenido o presionar Escape
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('editCategoryModal');
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                closeEditCategoryModal();
            }
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && modal.style.display === 'flex') {
                closeEditCategoryModal();
            }
        });
    });
</script>
@endsection
