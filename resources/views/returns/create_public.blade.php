@extends('layouts.app')

@section('title', 'Solicitud de Devolución - GlobalClick')

@section('content')
<div class="main-container" style="padding-top: 3rem; padding-bottom: 5rem;">
    <div style="max-width: 680px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 2.5rem;">
            <div style="width: 60px; height: 60px; border-radius: 50%; background: rgba(249, 115, 22, 0.15); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; color: #fb923c; border: 1px solid rgba(249, 115, 22, 0.3);">
                <i data-feather="rotate-ccw" style="width: 28px; height: 28px;"></i>
            </div>
            <h1 style="font-size: 2.25rem; font-weight: 800; color: #ffffff; letter-spacing: -0.02em;">Solicitud de Devolución</h1>
            <p style="color: #94a3b8; font-size: 1rem; margin-top: 0.5rem; line-height: 1.5;">
                ¿Tuviste algún problema con tu pedido? Completa este formulario y nuestro equipo procesará tu solicitud de devolución o reemplazo a la brevedad.
            </p>
        </div>

        <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.5rem; padding: 2.5rem; box-shadow: 0 20px 40px -15px rgba(0,0,0,0.5);">
            
            @if ($errors->any())
                <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; padding: 1rem; border-radius: 0.75rem; margin-bottom: 1.5rem; font-size: 0.9rem;">
                    <strong style="display: block; margin-bottom: 0.35rem;">Por favor corrige los siguientes errores:</strong>
                    <ul style="margin: 0; padding-left: 1.25rem;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('returns.public.store') }}" method="POST">
                @csrf

                <!-- Número de Orden -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.5rem;">
                        Número de Orden <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="order_number" value="{{ old('order_number', request('order')) }}" required placeholder="Ej: ORD-UCZJPDLO"
                           style="width: 100%; padding: 0.85rem 1rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem;">
                    <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.35rem;">
                        Puedes encontrar tu código de orden en el comprobante o correo de confirmación de compra.
                    </div>
                </div>


                <!-- Nombre Completo -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.5rem;">
                        Tu Nombre Completo <span style="color: #ef4444;">*</span>
                    </label>
                    <input type="text" name="customer_name" value="{{ old('customer_name', Auth::check() ? Auth::user()->name : '') }}" required placeholder="Juan Pérez"
                           style="width: 100%; padding: 0.85rem 1rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem;">
                </div>

                <!-- Email & Teléfono -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.5rem;">
                            Correo Electrónico <span style="color: #ef4444;">*</span>
                        </label>
                        <input type="email" name="customer_email" value="{{ old('customer_email', Auth::check() ? Auth::user()->email : '') }}" required placeholder="tucorreo@ejemplo.com"
                               style="width: 100%; padding: 0.85rem 1rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem;">
                    </div>

                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.5rem;">
                            Teléfono / WhatsApp (Opcional)
                        </label>
                        <input type="text" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="+51 987 654 321"
                               style="width: 100%; padding: 0.85rem 1rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem;">
                    </div>
                </div>

                <!-- Motivo de Devolución -->
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.5rem;">
                        Motivo de la Devolución <span style="color: #ef4444;">*</span>
                    </label>
                    <select name="reason" required style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem;">
                        <option value="">-- Selecciona el motivo principal --</option>
                        <option value="Producto defectuoso o dañado" {{ old('reason') == 'Producto defectuoso o dañado' ? 'selected' : '' }}>Producto defectuoso o dañado</option>
                        <option value="Producto diferente al solicitado" {{ old('reason') == 'Producto diferente al solicitado' ? 'selected' : '' }}>Producto diferente al solicitado</option>
                        <option value="Talla o medida equivocada" {{ old('reason') == 'Talla o medida equivocada' ? 'selected' : '' }}>Talla o medida equivocada</option>
                        <option value="No cumple con mis expectativas" {{ old('reason') == 'No cumple con mis expectativas' ? 'selected' : '' }}>No cumple con mis expectativas</option>
                        <option value="Llegó con retraso excesivo" {{ old('reason') == 'Llegó con retraso excesivo' ? 'selected' : '' }}>Llegó con retraso excesivo</option>
                        <option value="Otro motivo" {{ old('reason') == 'Otro motivo' ? 'selected' : '' }}>Otro motivo</option>
                    </select>
                </div>

                <!-- Detalles / Explicación -->
                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 700; color: #cbd5e1; margin-bottom: 0.5rem;">
                        Explica brevemente lo sucedido <span style="color: #ef4444;">*</span>
                    </label>
                    <textarea name="details" rows="4" required placeholder="Describe los detalles del producto, el defecto o la razón por la cual solicitas la devolución..."
                              style="width: 100%; padding: 0.85rem 1rem; background: rgba(15, 23, 42, 0.8); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; line-height: 1.5; resize: vertical;">{{ old('details') }}</textarea>
                </div>

                <button type="submit" style="width: 100%; padding: 1rem; background: var(--accent-gradient); border: none; border-radius: 0.75rem; color: #ffffff; font-weight: 700; font-size: 1.05rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; box-shadow: 0 10px 20px -5px rgba(249, 115, 22, 0.5);">
                    <i data-feather="send" style="width: 18px; height: 18px;"></i>
                    Enviar Solicitud de Devolución
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
