@extends('layouts.admin')

@section('title', 'Editar Producto - ' . $product->title)

@section('content')
<div style="max-width: 1100px; margin: 0 auto 4rem;">
    <!-- Top Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <a href="{{ route('admin.products.index') }}" style="color: #94a3b8; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.35rem; margin-bottom: 0.35rem; text-decoration: none;">
                <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i> Volver a productos
            </a>
            <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">Editar Producto</h1>
            <div style="font-size: 0.85rem; color: #64748b;">ID: #{{ $product->id }} • Slug: /{{ $product->slug }}</div>
        </div>

        <div style="display: flex; gap: 0.75rem;">
            <a href="{{ route('shop.show', $product->slug) }}" target="_blank" class="pill-item" style="padding: 0.65rem 1rem; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none;">
                <i data-feather="eye" style="width: 14px; height: 14px;"></i> Ver en Tienda
            </a>
        </div>
    </div>

    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 1rem 1.25rem; border-radius: 0.75rem; margin-bottom: 1.5rem;">
            <div style="font-weight: 700; margin-bottom: 0.25rem;">Por favor corrige los siguientes errores:</div>
            <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.85rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productEditForm">
        @csrf
        @method('PUT')

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
            
            <!-- LEFT MAIN COLUMN -->
            <div style="display: flex; flex-direction: column; gap: 1.75rem;">
                
                <!-- CARD 1: Title & Description -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                    <div style="margin-bottom: 1.5rem;">
                        <label for="title" style="display: block; font-size: 0.875rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                            Título del Producto *
                        </label>
                        <input type="text" name="title" id="title" required value="{{ old('title', $product->title) }}" placeholder="Título descriptivo..." style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="short_description" style="display: block; font-size: 0.875rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                            Descripción Corta
                        </label>
                        <input type="text" name="short_description" id="short_description" value="{{ old('short_description', $product->short_description) }}" placeholder="Resumen breve para tarjetas..." style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.9rem;">
                    </div>

                    <div>
                        <label for="description" style="display: block; font-size: 0.875rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                            Descripción Completa
                        </label>
                        <textarea name="description" id="description" rows="6" placeholder="Descripción detallada de especificaciones y beneficios..." style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.9rem; line-height: 1.5;">{{ old('description', $product->description) }}</textarea>
                    </div>
                </div>

                <!-- CARD 2: Existing & New Images (Shopify-style) -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                    <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 1rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i data-feather="image" style="color: #f97316; width: 18px; height: 18px;"></i> Galería Multimedia
                    </h3>

                    <!-- Existing Images -->
                    @if($product->images->count() > 0)
                        <div style="margin-bottom: 1.5rem;">
                            <label style="display: block; font-size: 0.8rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.75rem;">
                                Fotos Actuales ({{ $product->images->count() }})
                            </label>
                            <div style="display: flex; gap: 0.85rem; flex-wrap: wrap;">
                                @foreach($product->images as $img)
                                    <div style="position: relative; width: 95px; height: 95px; border-radius: 0.75rem; overflow: hidden; border: 1px solid rgba(255,255,255,0.15); background: #0f172a;">
                                        <img src="{{ $img->url }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @if($img->is_primary)
                                            <span style="position: absolute; bottom: 0.25rem; left: 0.25rem; background: #f97316; color: #ffffff; font-size: 0.65rem; padding: 0.1rem 0.35rem; border-radius: 0.25rem; font-weight: 700;">
                                                Principal
                                            </span>
                                        @endif
                                        <button type="button" onclick="if(confirm('¿Eliminar esta foto?')) { document.getElementById('delete-img-{{ $img->id }}').submit(); }" style="position: absolute; top: 0.3rem; right: 0.3rem; background: rgba(239, 68, 68, 0.9); color: white; border: none; width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                            &times;
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Upload More Dropzone -->
                    <div id="dropzoneEdit" onclick="document.getElementById('editImageFileInput').click()" style="border: 2px dashed rgba(249, 115, 22, 0.4); background: rgba(15, 23, 42, 0.6); border-radius: 1rem; padding: 1.75rem 1.5rem; text-align: center; cursor: pointer; transition: all 0.2s ease;">
                        <i data-feather="upload-cloud" style="width: 32px; height: 32px; color: #f97316; margin-bottom: 0.5rem;"></i>
                        <div style="font-weight: 700; color: #ffffff; font-size: 0.9rem;">Subir nuevas fotos para este producto</div>
                        <div style="color: #94a3b8; font-size: 0.75rem; margin-top: 0.2rem;">JPG, PNG, WEBP, GIF, JFIF, AVIF (Hasta 20MB)</div>
                        <input type="file" id="editImageFileInput" name="images[]" multiple accept="image/*" style="display: none;" onchange="handleEditFileSelection(this.files)" onclick="this.value=null; event.stopPropagation();">
                    </div>

                    <div id="editFilePreviewGrid" style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1rem;"></div>

                    <!-- Additional URLs -->
                    <div style="margin-top: 1.25rem; padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                        <label style="display: block; font-size: 0.825rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.35rem;">
                            Agregar más fotos por URL (Una por línea)
                        </label>
                        <textarea name="image_urls" rows="2" placeholder="https://ejemplo.com/fotos/otra-imagen.jpg" style="width: 100%; padding: 0.75rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.65rem; color: #ffffff; font-family: monospace; font-size: 0.8rem;"></textarea>
                    </div>
                </div>

                <!-- CARD 3: Pricing -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                    <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i data-feather="dollar-sign" style="color: #34d399; width: 18px; height: 18px;"></i> Precios
                    </h3>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div>
                            <label for="price" style="display: block; font-size: 0.875rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                                Precio de Venta ($) *
                            </label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #64748b; font-weight: 700;">$</span>
                                <input type="number" step="0.01" name="price" id="price" required value="{{ old('price', $product->price) }}" oninput="calculateDiscount()" style="width: 100%; padding: 0.85rem 1rem 0.85rem 2rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 1rem; font-weight: 700;">
                            </div>
                        </div>

                        <div>
                            <label for="sale_price" style="display: block; font-size: 0.875rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.5rem;">
                                Precio de Oferta ($) <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 400;">(Opcional)</span>
                            </label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #64748b; font-weight: 700;">$</span>
                                <input type="number" step="0.01" name="sale_price" id="sale_price" value="{{ old('sale_price', $product->sale_price) }}" oninput="calculateDiscount()" style="width: 100%; padding: 0.85rem 1rem 0.85rem 2rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 1rem; font-weight: 700;">
                            </div>
                        </div>
                    </div>

                    <div id="discountIndicator" style="display: none; margin-top: 1rem; padding: 0.65rem 1rem; background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.25); border-radius: 0.5rem; color: #34d399; font-size: 0.85rem; font-weight: 600;">
                    </div>
                </div>

                <!-- CARD 4: Inventory -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                    <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i data-feather="box" style="color: #fb923c; width: 18px; height: 18px;"></i> Inventario
                    </h3>

                    <div>
                        <label for="stock" style="display: block; font-size: 0.875rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                            Cantidad en Stock *
                        </label>
                        <input type="number" name="stock" id="stock" required min="0" value="{{ old('stock', $product->stock) }}" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; font-weight: 700;">
                        <span style="font-size: 0.8rem; color: #94a3b8; display: block; margin-top: 0.35rem;">Actualiza el stock disponible para evitar sobreventas.</span>
                    </div>
                </div>

            </div>

            <!-- RIGHT SIDEBAR COLUMN -->
            <div style="display: flex; flex-direction: column; gap: 1.75rem;">
                
                <!-- CARD: Product Status -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: #ffffff; margin-bottom: 1rem;">
                        Estado del Producto
                    </h3>

                    <select name="is_active" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.9rem; font-weight: 600; cursor: pointer;">
                        <option value="1" {{ $product->is_active ? 'selected' : '' }}>🟢 Activo (Publicado)</option>
                        <option value="0" {{ !$product->is_active ? 'selected' : '' }}>⚪ Borrador (Oculto)</option>
                    </select>
                    <p style="color: #94a3b8; font-size: 0.78rem; margin: 0.5rem 0 0;">Los productos activos aparecen inmediatamente en la tienda.</p>
                </div>

                <!-- CARD: Organization / Category -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: #ffffff; margin-bottom: 1rem;">
                        Organización
                    </h3>

                    <label style="display: block; font-size: 0.825rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Categoría *</label>
                    <select name="category_id" required style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.9rem; font-weight: 600; cursor: pointer;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>

                    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.06);">
                        <label style="display: flex; align-items: center; gap: 0.65rem; color: #ffffff; font-size: 0.875rem; font-weight: 600; cursor: pointer;">
                            <input type="checkbox" name="is_featured" value="1" {{ $product->is_featured ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #f97316;">
                            <span>⭐ Destacar en portada</span>
                        </label>
                        <p style="color: #94a3b8; font-size: 0.78rem; margin: 0.35rem 0 0 1.8rem;">Muestra este producto en el escaparate destacado.</p>
                    </div>
                </div>

                <!-- Action Buttons Box -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                    <button type="submit" class="pill-item active" style="width: 100%; padding: 0.95rem; font-size: 1rem; font-weight: 800; border: none; cursor: pointer; text-align: center; justify-content: center; box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);">
                        Guardar Cambios
                    </button>
                    
                    <a href="{{ route('admin.products.index') }}" style="width: 100%; padding: 0.75rem; font-size: 0.875rem; color: #94a3b8; text-align: center; text-decoration: none; border-radius: 0.65rem; transition: all 0.2s ease;" onmouseover="this.style.color='#ffffff'">
                        Cancelar
                    </a>
                </div>

            </div>

        </div>
    </form>
</div>

<!-- Hidden image delete forms -->
@foreach($product->images as $img)
    <form id="delete-img-{{ $img->id }}" action="{{ route('admin.products.images.destroy', $img->id) }}" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
@endforeach
@endsection

@section('scripts')
<script>
    let editUploadDataTransfer = new DataTransfer();
    const editFileInput = document.getElementById('editImageFileInput');
    const editGrid = document.getElementById('editFilePreviewGrid');

    function handleEditFileSelection(files) {
        if (!files || files.length === 0) return;

        Array.from(files).forEach(file => {
            const exists = Array.from(editUploadDataTransfer.files).some(
                f => f.name === file.name && f.size === file.size
            );
            if (!exists) {
                editUploadDataTransfer.items.add(file);
            }
        });

        editFileInput.files = editUploadDataTransfer.files;
        renderEditPreviews();
    }

    function removeEditFile(indexToRemove) {
        const newDt = new DataTransfer();
        Array.from(editUploadDataTransfer.files).forEach((file, idx) => {
            if (idx !== indexToRemove) {
                newDt.items.add(file);
            }
        });
        editUploadDataTransfer = newDt;
        editFileInput.files = editUploadDataTransfer.files;
        renderEditPreviews();
    }

    function renderEditPreviews() {
        editGrid.innerHTML = '';
        const files = Array.from(editUploadDataTransfer.files);
        if (files.length === 0) return;

        files.forEach((file, index) => {
            const card = document.createElement('div');
            card.style.cssText = 'position: relative; width: 85px; height: 85px; border-radius: 0.65rem; overflow: hidden; border: 1px solid rgba(249,115,22,0.5); background: #0f172a; box-shadow: 0 4px 10px rgba(0,0,0,0.3);';

            const img = document.createElement('img');
            img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; display: block;';

            const badge = document.createElement('span');
            badge.style.cssText = 'position: absolute; bottom: 0.15rem; left: 0.15rem; background: rgba(16,185,129,0.85); color: #fff; font-size: 0.6rem; padding: 0.05rem 0.3rem; border-radius: 0.2rem; font-weight: 700; pointer-events: none;';
            badge.textContent = 'Nueva';

            const btnDelete = document.createElement('button');
            btnDelete.type = 'button';
            btnDelete.title = 'Quitar esta foto';
            btnDelete.style.cssText = 'position: absolute; top: 0.25rem; right: 0.25rem; width: 20px; height: 20px; background: rgba(239, 68, 68, 0.95); color: #ffffff; border: 1px solid rgba(255,255,255,0.4); border-radius: 50%; font-size: 13px; font-weight: 800; line-height: 1; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s ease; box-shadow: 0 2px 6px rgba(0,0,0,0.5); z-index: 10; padding: 0;';
            btnDelete.innerHTML = '&times;';

            btnDelete.onmouseover = function() {
                btnDelete.style.transform = 'scale(1.15)';
                btnDelete.style.background = '#dc2626';
            };
            btnDelete.onmouseout = function() {
                btnDelete.style.transform = 'scale(1)';
                btnDelete.style.background = 'rgba(239, 68, 68, 0.95)';
            };

            btnDelete.onclick = function(e) {
                e.preventDefault();
                e.stopPropagation();
                removeEditFile(index);
            };

            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);

            card.appendChild(img);
            card.appendChild(badge);
            card.appendChild(btnDelete);
            editGrid.appendChild(card);
        });
    }

    // Drag & Drop
    const dropzoneEdit = document.getElementById('dropzoneEdit');
    if (dropzoneEdit && editFileInput) {
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzoneEdit.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzoneEdit.style.borderColor = '#f97316';
                dropzoneEdit.style.background = 'rgba(249, 115, 22, 0.15)';
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzoneEdit.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzoneEdit.style.borderColor = 'rgba(249, 115, 22, 0.4)';
                dropzoneEdit.style.background = 'rgba(15, 23, 42, 0.6)';
            }, false);
        });

        dropzoneEdit.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            if (dt && dt.files && dt.files.length > 0) {
                handleEditFileSelection(dt.files);
            }
        }, false);
    }

    function calculateDiscount() {
        const price = parseFloat(document.getElementById('price').value) || 0;
        const salePrice = parseFloat(document.getElementById('sale_price').value) || 0;
        const indicator = document.getElementById('discountIndicator');

        if (price > 0 && salePrice > 0 && salePrice < price) {
            const savings = price - salePrice;
            const pct = Math.round((savings / price) * 100);
            indicator.style.display = 'block';
            indicator.innerHTML = `✨ Oferta activa: ¡${pct}% de descuento! El cliente ahorra $${savings.toFixed(2)}`;
        } else {
            indicator.style.display = 'none';
        }
    }
    calculateDiscount();
</script>
@endsection
