@extends('layouts.admin')

@section('title', 'Agregar Producto - Shopify Style')

@section('content')
<div style="max-width: 1100px; margin: 0 auto 4rem;">
    <!-- Top Header -->
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <div>
            <a href="{{ route('admin.products.index') }}" style="color: #94a3b8; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.35rem; margin-bottom: 0.35rem; text-decoration: none;">
                <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i> Volver a productos
            </a>
            <h1 style="font-size: 1.85rem; font-weight: 800; color: #ffffff;">Agregar Producto</h1>
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

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
        @csrf

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 2rem; align-items: start;">
            
            <!-- LEFT MAIN COLUMN -->
            <div style="display: flex; flex-direction: column; gap: 1.75rem;">
                
                <!-- CARD 1: Title & Description -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                    <div style="margin-bottom: 1.5rem;">
                        <label for="title" style="display: block; font-size: 0.875rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                            Título del Producto *
                        </label>
                        <input type="text" name="title" id="title" required value="{{ old('title') }}" placeholder="Ej. Camiseta Oversize de Algodón Pima, Audífonos Bluetooth Pro..." style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem;">
                    </div>

                    <div style="margin-bottom: 1.5rem;">
                        <label for="short_description" style="display: block; font-size: 0.875rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                            Descripción Corta
                        </label>
                        <input type="text" name="short_description" id="short_description" value="{{ old('short_description') }}" placeholder="Frase destacada para la tarjeta del producto en la tienda..." style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.9rem;">
                    </div>

                    <div>
                        <label for="description" style="display: block; font-size: 0.875rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                            Descripción Completa
                        </label>
                        <textarea name="description" id="description" rows="6" placeholder="Describe las características principales, materiales, dimensiones, modos de uso y ventajas de este producto..." style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.9rem; line-height: 1.5;">{{ old('description') }}</textarea>
                    </div>
                </div>

                <!-- CARD 2: Multimedia / Images (Shopify-style) -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                        <div>
                            <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                <i data-feather="image" style="color: #f97316; width: 18px; height: 18px;"></i> Archivos Multimedia
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0.25rem 0 0;">Sube fotos desde tu dispositivo o ingresa enlaces directos.</p>
                        </div>
                    </div>

                    <!-- Upload Dropzone -->
                    <div id="dropzoneCreate" onclick="document.getElementById('imageFileInput').click()" style="border: 2px dashed rgba(249, 115, 22, 0.4); background: rgba(15, 23, 42, 0.6); border-radius: 1rem; padding: 2rem 1.5rem; text-align: center; cursor: pointer; transition: all 0.2s ease;" onmouseover="this.style.borderColor='#f97316'; this.style.background='rgba(249, 115, 22, 0.08)'" onmouseout="this.style.borderColor='rgba(249, 115, 22, 0.4)'; this.style.background='rgba(15, 23, 42, 0.6)'">
                        <i data-feather="upload-cloud" style="width: 40px; height: 40px; color: #f97316; margin-bottom: 0.75rem;"></i>
                        <div style="font-weight: 700; color: #ffffff; font-size: 0.95rem; margin-bottom: 0.25rem;">Haz clic para subir fotos o arrastra archivos aquí</div>
                        <div style="color: #94a3b8; font-size: 0.8rem;">Formatos soportados: JPG, PNG, WEBP, GIF, JFIF, AVIF. Hasta 20MB por archivo.</div>
                        <input type="file" id="imageFileInput" name="images[]" multiple accept="image/*" style="display: none;" onchange="handleFileSelection(this.files)" onclick="this.value=null; event.stopPropagation();">
                    </div>

                    <!-- Live Preview Thumbnails Container -->
                    <div id="filePreviewGrid" style="display: flex; flex-wrap: wrap; gap: 0.75rem; margin-top: 1rem;"></div>

                    <!-- Alternative: Image URLs -->
                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                        <label style="display: block; font-size: 0.825rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.35rem;">
                            ¿Tienes enlaces web de fotos? (Una URL por línea)
                        </label>
                        <textarea name="image_urls" rows="2" placeholder="https://ejemplo.com/fotos/producto-1.jpg&#10;https://ejemplo.com/fotos/producto-2.jpg" style="width: 100%; padding: 0.75rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.65rem; color: #ffffff; font-family: monospace; font-size: 0.8rem;">{{ old('image_urls') }}</textarea>
                    </div>

                    <!-- Video del Producto (Opcional) -->
                    <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid rgba(255, 255, 255, 0.08);">
                        <div style="margin-bottom: 0.75rem;">
                            <label style="font-size: 0.95rem; font-weight: 700; color: #ffffff; display: flex; align-items: center; gap: 0.5rem;">
                                <i data-feather="video" style="color: #f97316; width: 17px; height: 17px;"></i> Video Demostrativo del Producto <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 400;">(Opcional)</span>
                            </label>
                            <p style="color: #94a3b8; font-size: 0.78rem; margin: 0.2rem 0 0;">Permite a tus clientes ver el producto en video (sube un archivo o pega un enlace de YouTube/Vimeo).</p>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; align-items: start;">
                            <!-- Option A: Video URL -->
                            <div>
                                <label style="display: block; font-size: 0.825rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.35rem;">
                                    Enlace de Video (YouTube, Vimeo o MP4 web)
                                </label>
                                <input type="url" name="video_url" id="videoUrlInput" value="{{ old('video_url') }}" placeholder="https://www.youtube.com/watch?v=..." oninput="previewVideoUrl(this.value)" style="width: 100%; padding: 0.75rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.65rem; color: #ffffff; font-size: 0.85rem;">
                                <span style="font-size: 0.73rem; color: #64748b; margin-top: 0.25rem; display: block;">Ej. YouTube, Vimeo o MP4 directo.</span>
                            </div>

                            <!-- Option B: Upload Video File -->
                            <div>
                                <label style="display: block; font-size: 0.825rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.35rem;">
                                    O sube un archivo de video (MP4, WebM)
                                </label>
                                <input type="file" name="video_file" id="videoFileInput" accept="video/mp4,video/webm,video/ogg,video/quicktime" onchange="previewVideoFile(this)" style="width: 100%; padding: 0.65rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.65rem; color: #ffffff; font-size: 0.8rem;">
                                <span style="font-size: 0.73rem; color: #64748b; margin-top: 0.25rem; display: block;">MP4, WebM o MOV (Hasta 100MB).</span>
                            </div>
                        </div>

                        <!-- Live Video Preview Box -->
                        <div id="videoPreviewContainer" style="display: none; margin-top: 1rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(249, 115, 22, 0.4); border-radius: 0.85rem; padding: 1rem;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                                <span style="font-size: 0.85rem; font-weight: 700; color: #34d399; display: flex; align-items: center; gap: 0.35rem;">
                                    <i data-feather="play-circle" style="width: 16px; height: 16px;"></i> Previsualización del Video
                                </span>
                                <button type="button" onclick="clearVideoPreview()" style="background: rgba(239, 68, 68, 0.2); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; font-size: 0.75rem; padding: 0.25rem 0.6rem; border-radius: 0.4rem; cursor: pointer;">
                                    Quitar Video
                                </button>
                            </div>
                            <div id="videoPlayerWrapper" style="position: relative; width: 100%; max-width: 500px; aspect-ratio: 16/9; background: #000; border-radius: 0.5rem; overflow: hidden; margin: 0 auto;"></div>
                        </div>
                    </div>
                </div>

                <!-- CARD 3: Pricing (Shopify-style) -->
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
                                <input type="number" step="0.01" name="price" id="price" required value="{{ old('price') }}" placeholder="0.00" oninput="calculateDiscount()" style="width: 100%; padding: 0.85rem 1rem 0.85rem 2rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 1rem; font-weight: 700;">
                            </div>
                        </div>

                        <div>
                            <label for="sale_price" style="display: block; font-size: 0.875rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.5rem;">
                                Precio de Oferta ($) <span style="font-size: 0.75rem; color: #94a3b8; font-weight: 400;">(Opcional)</span>
                            </label>
                            <div style="position: relative;">
                                <span style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #64748b; font-weight: 700;">$</span>
                                <input type="number" step="0.01" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" placeholder="0.00" oninput="calculateDiscount()" style="width: 100%; padding: 0.85rem 1rem 0.85rem 2rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 1rem; font-weight: 700;">
                            </div>
                        </div>
                    </div>

                    <div id="discountIndicator" style="display: none; margin-top: 1rem; padding: 0.65rem 1rem; background: rgba(52, 211, 153, 0.1); border: 1px solid rgba(52, 211, 153, 0.25); border-radius: 0.5rem; color: #34d399; font-size: 0.85rem; font-weight: 600;">
                    </div>
                </div>

                <!-- CARD 4: Inventory / Stock (Shopify-style) -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                    <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                        <i data-feather="box" style="color: #fb923c; width: 18px; height: 18px;"></i> Inventario
                    </h3>

                    <div>
                        <label for="stock" style="display: block; font-size: 0.875rem; font-weight: 700; color: #ffffff; margin-bottom: 0.5rem;">
                            Cantidad en Stock *
                        </label>
                        <input type="number" name="stock" id="stock" required min="0" value="{{ old('stock', 10) }}" placeholder="10" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; font-weight: 700;">
                        <span style="font-size: 0.8rem; color: #94a3b8; display: block; margin-top: 0.35rem;">Controla el número de unidades disponibles para venta inmediata.</span>
                    </div>
                </div>

                <!-- CARD 5: Tallas y Variantes de Ropa / Calzado -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 0.75rem;">
                        <div>
                            <h3 style="font-size: 1.05rem; font-weight: 800; color: #ffffff; margin: 0; display: flex; align-items: center; gap: 0.5rem;">
                                <i data-feather="tag" style="color: #f97316; width: 18px; height: 18px;"></i> Tallas de Producto (Ropa, Calzado, etc.)
                            </h3>
                            <p style="color: #94a3b8; font-size: 0.8rem; margin: 0.25rem 0 0;">Configura si este producto requiere que el cliente elija una talla antes de añadirlo al carrito.</p>
                        </div>
                        <label style="display: inline-flex; align-items: center; cursor: pointer; gap: 0.5rem; background: rgba(15, 23, 42, 0.6); padding: 0.4rem 0.85rem; border-radius: 0.6rem; border: 1px solid rgba(255,255,255,0.1);">
                            <input type="checkbox" name="has_sizes" id="hasSizesToggle" value="1" {{ old('has_sizes') ? 'checked' : '' }} onchange="toggleSizeOptions(this.checked)" style="width: 17px; height: 17px; accent-color: #f97316; cursor: pointer;">
                            <span style="font-size: 0.875rem; font-weight: 700; color: #ffffff;">Habilitar Tallas</span>
                        </label>
                    </div>

                    <div id="sizesConfigSection" style="display: {{ old('has_sizes') ? 'block' : 'none' }}; border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1.25rem;">
                        <div style="margin-bottom: 1.25rem;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.5rem;">
                                Tipo de Prenda / Preset de Tallas:
                            </label>
                            <select name="size_type" id="sizeTypeSelect" onchange="handleSizeTypeChange(this.value)" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; font-weight: 600;">
                                <option value="polo" {{ old('size_type') == 'polo' ? 'selected' : '' }}>👕 Polos / Camisetas / Casacas (S, M, L, XL, XXL)</option>
                                <option value="zapatillas" {{ old('size_type') == 'zapatillas' ? 'selected' : '' }}>👟 Calzado / Zapatillas (36, 37, 38, 39, 40, 41, 42, 43, 44, 45)</option>
                                <option value="pantalon" {{ old('size_type') == 'pantalon' ? 'selected' : '' }}>👖 Pantalones / Jeans (28, 30, 32, 34, 36, 38)</option>
                                <option value="custom" {{ old('size_type') == 'custom' ? 'selected' : '' }}>⚙️ Personalizado (Escribir tallas libres)</option>
                            </select>
                        </div>

                        <div id="customSizesGroup" style="display: {{ old('size_type') == 'custom' ? 'block' : 'none' }}; margin-bottom: 1rem;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.5rem;">
                                Tallas Personalizadas (Separadas por comas)
                            </label>
                            <input type="text" name="custom_sizes" id="customSizesInput" value="{{ old('custom_sizes') }}" oninput="renderSizeBadges()" placeholder="Ej. XS, S, M, L, XL, 3XL ó 34, 36, 38, 40" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.9rem;">
                        </div>

                        <div>
                            <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 600; margin-bottom: 0.4rem;">Previsualización de tallas para el cliente:</div>
                            <div id="sizesPreviewBadges" style="display: flex; flex-wrap: wrap; gap: 0.45rem;"></div>
                        </div>
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
                        <option value="1" selected>🟢 Activo (Publicado)</option>
                        <option value="0">⚪ Borrador (Oculto)</option>
                    </select>
                    <p style="color: #94a3b8; font-size: 0.78rem; margin: 0.5rem 0 0;">Los productos activos son visibles de inmediato en el catálogo de tu tienda.</p>
                </div>

                <!-- CARD: Organization / Category -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
                    <h3 style="font-size: 0.95rem; font-weight: 800; color: #ffffff; margin-bottom: 1rem;">
                        Organización
                    </h3>

                    <label style="display: block; font-size: 0.825rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Categoría *</label>
                    <select name="category_id" required style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.9rem; font-weight: 600; cursor: pointer;">
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>

                    <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.06);">
                        <label style="display: flex; align-items: center; gap: 0.65rem; color: #ffffff; font-size: 0.875rem; font-weight: 600; cursor: pointer;">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }} style="width: 18px; height: 18px; accent-color: #f97316;">
                            <span>⭐ Destacar en portada</span>
                        </label>
                        <p style="color: #94a3b8; font-size: 0.78rem; margin: 0.35rem 0 0 1.8rem;">Muestra este producto en la sección principal destacada.</p>
                    </div>
                </div>

                <!-- Action Buttons Box -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem;">
                    <button type="submit" class="pill-item active" style="width: 100%; padding: 0.95rem; font-size: 1rem; font-weight: 800; border: none; cursor: pointer; text-align: center; justify-content: center; box-shadow: 0 4px 15px rgba(249, 115, 22, 0.4);">
                        Guardar Producto
                    </button>
                    
                    <a href="{{ route('admin.products.index') }}" style="width: 100%; padding: 0.75rem; font-size: 0.875rem; color: #94a3b8; text-align: center; text-decoration: none; border-radius: 0.65rem; transition: all 0.2s ease;" onmouseover="this.style.color='#ffffff'">
                        Cancelar
                    </a>
                </div>

            </div>

        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    let uploadDataTransfer = new DataTransfer();
    const fileInput = document.getElementById('imageFileInput');
    const filePreviewGrid = document.getElementById('filePreviewGrid');

    function handleFileSelection(files) {
        if (!files || files.length === 0) return;

        Array.from(files).forEach(file => {
            // Evitar duplicados exactos (mismo nombre y tamaño)
            const exists = Array.from(uploadDataTransfer.files).some(
                f => f.name === file.name && f.size === file.size
            );
            if (!exists) {
                uploadDataTransfer.items.add(file);
            }
        });

        fileInput.files = uploadDataTransfer.files;
        renderPreviews();
    }

    function removeFile(indexToRemove) {
        const newDt = new DataTransfer();
        Array.from(uploadDataTransfer.files).forEach((file, idx) => {
            if (idx !== indexToRemove) {
                newDt.items.add(file);
            }
        });
        uploadDataTransfer = newDt;
        fileInput.files = uploadDataTransfer.files;
        renderPreviews();
    }

    function renderPreviews() {
        filePreviewGrid.innerHTML = '';
        const files = Array.from(uploadDataTransfer.files);
        if (files.length === 0) return;

        files.forEach((file, index) => {
            const card = document.createElement('div');
            card.style.cssText = 'position: relative; width: 95px; height: 95px; border-radius: 0.75rem; overflow: hidden; border: 1px solid rgba(255,255,255,0.2); background: #0f172a; box-shadow: 0 4px 10px rgba(0,0,0,0.3);';

            const img = document.createElement('img');
            img.style.cssText = 'width: 100%; height: 100%; object-fit: cover; display: block;';

            // Badge indicator (Principal o número)
            const badge = document.createElement('span');
            badge.style.cssText = index === 0
                ? 'position: absolute; bottom: 0.25rem; left: 0.25rem; background: #f97316; color: #ffffff; font-size: 0.65rem; font-weight: 700; padding: 0.1rem 0.35rem; border-radius: 0.25rem; pointer-events: none;'
                : 'position: absolute; bottom: 0.25rem; left: 0.25rem; background: rgba(0,0,0,0.75); color: #cbd5e1; font-size: 0.65rem; padding: 0.1rem 0.35rem; border-radius: 0.25rem; pointer-events: none;';
            badge.textContent = index === 0 ? 'Principal' : '#' + (index + 1);

            // Botón 'X' para eliminar la foto
            const btnDelete = document.createElement('button');
            btnDelete.type = 'button';
            btnDelete.title = 'Quitar esta foto';
            btnDelete.setAttribute('aria-label', 'Eliminar foto');
            btnDelete.style.cssText = 'position: absolute; top: 0.3rem; right: 0.3rem; width: 22px; height: 22px; background: rgba(239, 68, 68, 0.95); color: #ffffff; border: 1px solid rgba(255,255,255,0.4); border-radius: 50%; font-size: 14px; font-weight: 800; line-height: 1; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.15s ease; box-shadow: 0 2px 6px rgba(0,0,0,0.5); z-index: 10; padding: 0;';
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
                removeFile(index);
            };

            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);

            card.appendChild(img);
            card.appendChild(badge);
            card.appendChild(btnDelete);
            filePreviewGrid.appendChild(card);
        });
    }

    // Drag & Drop
    const dropzone = document.getElementById('dropzoneCreate');
    if (dropzone && fileInput) {
        ['dragenter', 'dragover'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.style.borderColor = '#f97316';
                dropzone.style.background = 'rgba(249, 115, 22, 0.15)';
            }, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropzone.addEventListener(eventName, (e) => {
                e.preventDefault();
                e.stopPropagation();
                dropzone.style.borderColor = 'rgba(249, 115, 22, 0.4)';
                dropzone.style.background = 'rgba(15, 23, 42, 0.6)';
            }, false);
        });

        dropzone.addEventListener('drop', (e) => {
            const dt = e.dataTransfer;
            if (dt && dt.files && dt.files.length > 0) {
                handleFileSelection(dt.files);
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

    function toggleSizeOptions(enabled) {
        const section = document.getElementById('sizesConfigSection');
        if (section) section.style.display = enabled ? 'block' : 'none';
        if (enabled) renderSizeBadges();
    }

    function handleSizeTypeChange(type) {
        const customGroup = document.getElementById('customSizesGroup');
        if (customGroup) customGroup.style.display = (type === 'custom') ? 'block' : 'none';
        renderSizeBadges();
    }

    function renderSizeBadges() {
        const container = document.getElementById('sizesPreviewBadges');
        if (!container) return;
        const type = document.getElementById('sizeTypeSelect')?.value || 'polo';
        let sizes = [];

        if (type === 'polo') {
            sizes = ['S', 'M', 'L', 'XL', 'XXL'];
        } else if (type === 'zapatillas') {
            sizes = ['36', '37', '38', '39', '40', '41', '42', '43', '44', '45'];
        } else if (type === 'pantalon') {
            sizes = ['28', '30', '32', '34', '36', '38'];
        } else if (type === 'custom') {
            const val = document.getElementById('customSizesInput')?.value || '';
            sizes = val.split(',').map(s => s.trim()).filter(s => s.length > 0);
            if (sizes.length === 0) sizes = ['Ej. Talla 1', 'Talla 2'];
        }

        container.innerHTML = sizes.map(s => `
            <span style="background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.45); color: #fdba74; font-size: 0.8rem; font-weight: 700; padding: 0.2rem 0.6rem; border-radius: 0.45rem;">
                ${s}
            </span>
        `).join('');
    }
    renderSizeBadges();

    // Video preview handlers
    function previewVideoUrl(url) {
        const container = document.getElementById('videoPreviewContainer');
        const wrapper = document.getElementById('videoPlayerWrapper');
        if (!url || !url.trim()) {
            if (!document.getElementById('videoFileInput').files.length) {
                container.style.display = 'none';
            }
            return;
        }

        url = url.trim();
        let embed = '';

        const ytMatch = url.match(/(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))([\w-]{11})/);
        if (ytMatch) {
            embed = `<iframe src="https://www.youtube.com/embed/${ytMatch[1]}" style="width: 100%; height: 100%; border: none;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
        } else {
            const vimeoMatch = url.match(/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)/);
            if (vimeoMatch) {
                embed = `<iframe src="https://player.vimeo.com/video/${vimeoMatch[3]}" style="width: 100%; height: 100%; border: none;" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>`;
            } else if (url.match(/\.(mp4|webm|ogg|mov)(\?.*)?$/i)) {
                embed = `<video src="${url}" controls style="width: 100%; height: 100%; object-fit: contain;"></video>`;
            } else {
                embed = `<iframe src="${url}" style="width: 100%; height: 100%; border: none;"></iframe>`;
            }
        }

        wrapper.innerHTML = embed;
        container.style.display = 'block';
    }

    function previewVideoFile(input) {
        const container = document.getElementById('videoPreviewContainer');
        const wrapper = document.getElementById('videoPlayerWrapper');
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileUrl = URL.createObjectURL(file);
            wrapper.innerHTML = `<video src="${fileUrl}" controls style="width: 100%; height: 100%; object-fit: contain;"></video>`;
            container.style.display = 'block';
        }
    }

    function clearVideoPreview() {
        document.getElementById('videoUrlInput').value = '';
        document.getElementById('videoFileInput').value = '';
        document.getElementById('videoPlayerWrapper').innerHTML = '';
        document.getElementById('videoPreviewContainer').style.display = 'none';
    }

    // Auto-trigger video preview if old input exists
    @if(old('video_url'))
        previewVideoUrl(@json(old('video_url')));
    @endif
</script>
@endsection

