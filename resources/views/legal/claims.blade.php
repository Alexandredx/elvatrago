@extends('layouts.app')

@section('title', 'Libro de Reclamaciones Virtual - GlobalClick')

@section('content')
<div class="main-container" style="max-width: 900px; margin: 0 auto; padding: 3rem 1.5rem 5rem;">
    <!-- Breadcrumb & Back -->
    <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <a href="{{ route('legal.index') }}" style="display: inline-flex; align-items: center; gap: 0.4rem; color: #94a3b8; font-size: 0.9rem; text-decoration: none; transition: color 0.2s;" onmouseover="this.style.color='#f97316'" onmouseout="this.style.color='#94a3b8'">
            <i data-feather="chevron-left" style="width: 16px; height: 16px;"></i>
            <span>Volver al Centro Legal</span>
        </a>
        <span style="font-size: 0.8rem; color: #64748b;">Conforme a la Ley N° 29571 / D.S. 101-2022-PCM</span>
    </div>

    <!-- Official Header Box -->
    <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(249, 115, 22, 0.3); border-radius: 1.5rem; padding: 2rem 2.5rem; margin-bottom: 2.5rem; box-shadow: 0 10px 30px rgba(0,0,0,0.3);">
        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding-bottom: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <div style="display: inline-flex; align-items: center; gap: 0.5rem; background: rgba(249, 115, 22, 0.15); border: 1px solid rgba(249, 115, 22, 0.3); color: #fdba74; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700; margin-bottom: 0.5rem;">
                    <i data-feather="book-open" style="width: 14px; height: 14px;"></i>
                    <span>Libro de Reclamaciones Oficial</span>
                </div>
                <h1 style="font-size: 2.15rem; font-weight: 800; color: #ffffff; letter-spacing: -0.02em;">
                    Libro de Reclamaciones Virtual
                </h1>
                <p style="color: #94a3b8; font-size: 0.95rem; margin: 0.25rem 0 0;">
                    Hoja de Reclamación conforme al Código de Protección y Defensa del Consumidor
                </p>
            </div>
            <!-- Provider Info Badge -->
            <div style="background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255,255,255,0.1); border-radius: 0.85rem; padding: 1rem 1.25rem; font-size: 0.85rem; color: #cbd5e1; min-width: 250px;">
                <div style="font-size: 0.75rem; color: #f97316; font-weight: 800; text-transform: uppercase; margin-bottom: 0.25rem;">Establecimiento Comercial:</div>
                <div style="font-weight: 700; color: #ffffff;">GlobalClick</div>
                <div style="color: #94a3b8;">Tienda Virtual de Comercio Electrónico</div>
                <div style="color: #94a3b8;">Lima, Perú</div>
                <div style="color: #94a3b8; font-size: 0.75rem; margin-top: 0.25rem;">Fecha: {{ date('d/m/Y') }}</div>
            </div>
        </div>

        <!-- Info alert: Diferencia entre Reclamo y Queja -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; background: rgba(15, 23, 42, 0.5); padding: 1.25rem; border-radius: 0.85rem; border: 1px solid rgba(255,255,255,0.06);">
            <div>
                <strong style="color: #f97316; font-size: 0.9rem; display: flex; align-items: center; gap: 0.35rem;">
                    <i data-feather="alert-circle" style="width: 14px; height: 14px;"></i> Reclamo:
                </strong>
                <p style="font-size: 0.825rem; color: #94a3b8; margin: 0.25rem 0 0; line-height: 1.5;">
                    Disconformidad relacionada directamente a los productos o servicios adquiridos en la tienda.
                </p>
            </div>
            <div>
                <strong style="color: #60a5fa; font-size: 0.9rem; display: flex; align-items: center; gap: 0.35rem;">
                    <i data-feather="message-circle" style="width: 14px; height: 14px;"></i> Queja:
                </strong>
                <p style="font-size: 0.825rem; color: #94a3b8; margin: 0.25rem 0 0; line-height: 1.5;">
                    Malestar o descontento respecto a la atención al cliente, demoras de respuesta o trato recibido.
                </p>
            </div>
        </div>
    </div>

    <!-- Error Validation Display -->
    @if ($errors->any())
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; padding: 1.25rem; border-radius: 1rem; margin-bottom: 2rem;">
            <strong style="display: block; margin-bottom: 0.5rem; font-size: 0.95rem;">Por favor, corrige los siguientes campos:</strong>
            <ul style="margin: 0; padding-left: 1.25rem; font-size: 0.9rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario Oficial -->
    <form action="{{ route('legal.claims.store') }}" method="POST" style="background: rgba(30, 41, 59, 0.4); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 20px 40px rgba(0,0,0,0.4);">
        @csrf

        <!-- 1. Tipo de Reclamación -->
        <div style="margin-bottom: 2.25rem; padding-bottom: 1.75rem; border-bottom: 1px solid rgba(255,255,255,0.08);">
            <label style="display: block; font-size: 1.05rem; font-weight: 700; color: #ffffff; margin-bottom: 0.75rem;">
                1. Tipo de Registro <span style="color: #ef4444;">*</span>
            </label>
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <label style="display: flex; align-items: center; gap: 0.75rem; background: rgba(15, 23, 42, 0.7); border: 1px solid {{ old('type', 'reclamo') === 'reclamo' ? '#f97316' : 'rgba(255,255,255,0.1)' }}; padding: 1rem 1.25rem; border-radius: 0.75rem; cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="type" value="reclamo" {{ old('type', 'reclamo') === 'reclamo' ? 'checked' : '' }} style="accent-color: #f97316;">
                    <div>
                        <div style="font-weight: 700; color: #ffffff; font-size: 0.95rem;">Reclamo</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">Por producto o servicio</div>
                    </div>
                </label>
                <label style="display: flex; align-items: center; gap: 0.75rem; background: rgba(15, 23, 42, 0.7); border: 1px solid {{ old('type') === 'queja' ? '#60a5fa' : 'rgba(255,255,255,0.1)' }}; padding: 1rem 1.25rem; border-radius: 0.75rem; cursor: pointer; transition: all 0.2s;">
                    <input type="radio" name="type" value="queja" {{ old('type') === 'queja' ? 'checked' : '' }} style="accent-color: #60a5fa;">
                    <div>
                        <div style="font-weight: 700; color: #ffffff; font-size: 0.95rem;">Queja</div>
                        <div style="font-size: 0.75rem; color: #94a3b8;">Por atención al cliente</div>
                    </div>
                </label>
            </div>
        </div>

        <!-- 2. Identificación del Consumidor Reclamante -->
        <div style="margin-bottom: 2.25rem; padding-bottom: 1.75rem; border-bottom: 1px solid rgba(255,255,255,0.08);">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">2.</span> Identificación del Consumidor Reclamante
            </h3>

            <!-- Nombre Completo -->
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                    Nombres y Apellidos Completos / Razón Social <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="customer_name" required value="{{ old('customer_name', Auth::check() ? Auth::user()->name : '') }}" placeholder="Ej. Juan Carlos Pérez Morales" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none;">
            </div>

            <!-- Tipo y Número de Documento -->
            <div style="display: grid; grid-template-columns: 180px 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                        Tipo Documento <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="document_type" required style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none; cursor: pointer;">
                        <option value="DNI" {{ old('document_type') === 'DNI' ? 'selected' : '' }}>DNI</option>
                        <option value="CE" {{ old('document_type') === 'CE' ? 'selected' : '' }}>Carné Extranjería</option>
                        <option value="Pasaporte" {{ old('document_type') === 'Pasaporte' ? 'selected' : '' }}>Pasaporte</option>
                        <option value="RUC" {{ old('document_type') === 'RUC' ? 'selected' : '' }}>RUC</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                        Número de Documento <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="document_number" required value="{{ old('document_number') }}" placeholder="Ej. 72345678" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none;">
                </div>
            </div>

            <!-- Email y Teléfono -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                        Correo Electrónico (Para respuesta legal) <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="email" name="customer_email" required value="{{ old('customer_email', Auth::check() ? Auth::user()->email : '') }}" placeholder="correo@ejemplo.com" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                        Teléfono / Celular <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="tel" name="customer_phone" required value="{{ old('customer_phone') }}" placeholder="Ej. 987654321" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none;">
                </div>
            </div>

            <!-- Domicilio -->
            <div style="margin-bottom: 1.25rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                    Domicilio (Dirección, Distrito, Ciudad) <span style="color: #ef4444;">*</span>
                </label>
                <input type="text" name="customer_address" required value="{{ old('customer_address') }}" placeholder="Ej. Av. Javier Prado Este 1234, Dpto 502, San Isidro, Lima" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none;">
            </div>

            <!-- Checkbox Menor de edad -->
            <div style="margin-top: 1rem; padding: 1rem; background: rgba(15, 23, 42, 0.4); border-radius: 0.75rem; border: 1px solid rgba(255,255,255,0.05);">
                <label style="display: flex; align-items: center; gap: 0.65rem; font-size: 0.85rem; color: #cbd5e1; cursor: pointer;">
                    <input type="checkbox" id="is_minor_check" name="is_minor" value="1" {{ old('is_minor') ? 'checked' : '' }} onchange="toggleParentField(this.checked)" style="accent-color: #f97316; width: 16px; height: 16px;">
                    <span>El consumidor es menor de edad</span>
                </label>
                <div id="parent_field_wrapper" style="display: {{ old('is_minor') ? 'block' : 'none' }}; margin-top: 0.85rem;">
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #94a3b8; margin-bottom: 0.35rem;">
                        Nombre del Padre, Madre o Apoderado:
                    </label>
                    <input type="text" name="parent_name" value="{{ old('parent_name') }}" placeholder="Nombre completo del apoderado legal" style="width: 100%; padding: 0.75rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.5rem; color: #ffffff; font-size: 0.9rem; outline: none;">
                </div>
            </div>
        </div>

        <!-- 3. Identificación del Bien Contratado -->
        <div style="margin-bottom: 2.25rem; padding-bottom: 1.75rem; border-bottom: 1px solid rgba(255,255,255,0.08);">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">3.</span> Identificación del Bien Contratado
            </h3>

            <div style="display: grid; grid-template-columns: 180px 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                        Tipo de Bien <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="contracted_good" required style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none; cursor: pointer;">
                        <option value="producto" {{ old('contracted_good') === 'producto' ? 'selected' : '' }}>Producto</option>
                        <option value="servicio" {{ old('contracted_good') === 'servicio' ? 'selected' : '' }}>Servicio</option>
                    </select>
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                        N° de Orden / Pedido (Opcional)
                    </label>
                    <input type="text" name="order_number" value="{{ old('order_number', request('order')) }}" placeholder="Ej. ORD-A1B2C3D4" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                        Monto Reclamado (Opcional)
                    </label>
                    <input type="number" step="0.01" name="amount_claimed" value="{{ old('amount_claimed') }}" placeholder="Ej. 159.00" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none;">
                </div>
            </div>

            <div>
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                    Descripción del Producto o Servicio
                </label>
                <input type="text" name="good_description" value="{{ old('good_description') }}" placeholder="Ej. Smartwatch AMOLED Deportivo Negro / Audífonos Inalámbricos Pro" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none;">
            </div>
        </div>

        <!-- 4. Detalle de la Reclamación y Pedido del Consumidor -->
        <div style="margin-bottom: 2.25rem;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                <span style="color: #f97316;">4.</span> Detalle de la Reclamación y Pedido Concreto
            </h3>

            <!-- Detalle -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                    Detalle del Reclamo o Queja <span style="color: #ef4444;">*</span>
                </label>
                <textarea name="details" required rows="5" placeholder="Describe claramente lo sucedido: fechas, circunstancias, inconvenientes detectados con el producto o la atención recibida..." style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; line-height: 1.6; outline: none; resize: vertical;">{{ old('details') }}</textarea>
            </div>

            <!-- Pedido del Consumidor -->
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">
                    Pedido Concreto del Consumidor (¿Qué solución solicita?) <span style="color: #ef4444;">*</span>
                </label>
                <textarea name="consumer_request" required rows="3" placeholder="Ej. Solicito el cambio de la unidad por una nueva operativa o el reembolso íntegro de lo pagado..." style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; line-height: 1.6; outline: none; resize: vertical;">{{ old('consumer_request') }}</textarea>
            </div>

            <!-- Declaración Jurada y Plazo Legal -->
            <div style="background: rgba(15, 23, 42, 0.7); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 0.85rem; padding: 1.25rem; margin-bottom: 1.5rem;">
                <label style="display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.85rem; color: #cbd5e1; cursor: pointer; line-height: 1.5;">
                    <input type="checkbox" name="accept_policy" value="1" required {{ old('accept_policy') ? 'checked' : '' }} style="accent-color: #f97316; width: 18px; height: 18px; margin-top: 0.15rem; flex-shrink: 0;">
                    <span>
                        Declaro bajo juramento que los datos consignados en esta Hoja de Reclamación son verídicos, y autorizo a GlobalClick a utilizar mi correo y teléfono para notificarme formalmente el resultado dentro del <strong>plazo legal máximo de quince (15) días hábiles</strong> improrrogables, conforme al D.S. N° 101-2022-PCM.
                    </span>
                </label>
            </div>
        </div>

        <!-- Botón de Envío -->
        <button type="submit" style="width: 100%; padding: 1.15rem; background: var(--accent-gradient); border: none; border-radius: 0.85rem; color: #ffffff; font-weight: 800; font-size: 1.1rem; cursor: pointer; box-shadow: 0 4px 18px rgba(249, 115, 22, 0.4); display: flex; align-items: center; justify-content: center; gap: 0.65rem; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='translateY(0)'">
            <i data-feather="send" style="width: 20px; height: 20px;"></i>
            <span>Enviar y Registrar Hoja de Reclamación</span>
        </button>
    </form>
</div>

<script>
function toggleParentField(show) {
    const wrapper = document.getElementById('parent_field_wrapper');
    if (wrapper) wrapper.style.display = show ? 'block' : 'none';
}
</script>
@endsection
