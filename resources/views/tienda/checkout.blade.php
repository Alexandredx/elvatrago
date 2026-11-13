@extends('layouts.app')

@section('title', 'Finalizar Compra - GlobalClick')

@section('content')
<div class="checkout-page-container">
    <!-- Header -->
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('cart.index') }}" style="color: #94a3b8; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; margin-bottom: 0.75rem;">
            <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i> Volver al Carrito
        </a>
        <h1 class="checkout-title">
            <i data-feather="check-circle" style="color: #f97316;"></i> Finalizar Pedido
        </h1>
        <p style="color: #94a3b8; font-size: 0.95rem; margin-top: 0.25rem;">Completa tus datos de envío y contacto para registrar y confirmar tu pedido.</p>
    </div>

    <!-- Error Alerts -->
    @if($errors->any())
        <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.4); color: #fca5a5; padding: 1rem 1.25rem; border-radius: 1rem; font-size: 0.9rem; margin-bottom: 2rem;">
            <div style="font-weight: 700; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                <i data-feather="alert-triangle" style="width: 16px; height: 16px;"></i> Por favor revisa los siguientes campos:
            </div>
            <ul style="margin: 0; padding-left: 1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="checkout-layout">
        <!-- Form Container -->
        <div>
            <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                @csrf

                <!-- SECCIÓN 1: DETALLES DE ENVÍO -->
                <div class="checkout-card">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                        <span style="width: 28px; height: 28px; border-radius: 50%; background: #f97316; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 800; flex-shrink: 0;">1</span>
                        <h2 style="font-size: 1.2rem; font-weight: 700; color: #ffffff; margin: 0;">
                            Detalles de Envío y Contacto
                        </h2>
                    </div>

                    <div style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Nombre Completo del Receptor *</label>
                        <input type="text" name="customer_name" required placeholder="Ej. Juan Pérez García" value="{{ old('customer_name', $user->name ?? '') }}" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none; transition: border-color 0.2s;">
                    </div>

                    <div class="checkout-two-cols" style="margin-bottom: 1.25rem;">
                        <div>
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Correo Electrónico *</label>
                            <input type="email" name="customer_email" required placeholder="juan@ejemplo.com" value="{{ old('customer_email', $user->email ?? '') }}" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none; transition: border-color 0.2s;">
                        </div>
                        <div>
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Teléfono / Celular de Contacto *</label>
                            <input type="tel" name="customer_phone" required placeholder="987654321" value="{{ old('customer_phone') }}" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none; transition: border-color 0.2s;">
                        </div>
                    </div>

                    <div style="margin-bottom: 0.5rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Dirección Exacta de Envío (Calle, Número, Depto, Distrito, Ciudad) *</label>
                        <textarea name="shipping_address" rows="3" required placeholder="Ej: Av. Las Flores 450, Dpto 302, Miraflores, Lima" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none; transition: border-color 0.2s;">{{ old('shipping_address') }}</textarea>
                    </div>
                </div>

                <!-- Aceptación Legal de Términos y Mayoría de Edad -->
                <div style="margin-bottom: 1.5rem; background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 0.85rem; padding: 1.15rem;">
                    <label style="display: flex; align-items: flex-start; gap: 0.75rem; font-size: 0.85rem; color: #cbd5e1; cursor: pointer; line-height: 1.5;">
                        <input type="checkbox" name="terms" value="1" required {{ old('terms') ? 'checked' : '' }} style="accent-color: #10b981; width: 18px; height: 18px; margin-top: 0.15rem; flex-shrink: 0; cursor: pointer;">
                        <span>
                            Declaro ser <strong>mayor de dieciocho (18) años</strong>, haber leído y aceptar expresamente los 
                            <a href="{{ route('legal.terms') }}" target="_blank" style="color: #fb923c; font-weight: 700; text-decoration: underline;">Términos y Condiciones</a>, la 
                            <a href="{{ route('legal.privacy') }}" target="_blank" style="color: #34d399; font-weight: 700; text-decoration: underline;">Política de Privacidad</a> y la 
                            <a href="{{ route('legal.returns') }}" target="_blank" style="color: #60a5fa; font-weight: 700; text-decoration: underline;">Política de Devoluciones</a> de GlobalClick.
                        </span>
                    </label>
                    @error('terms')
                        <div style="color: #fca5a5; font-size: 0.8rem; margin-top: 0.5rem; display: flex; align-items: center; gap: 0.35rem;">
                            <i data-feather="alert-circle" style="width: 14px; height: 14px;"></i>
                            <span>{{ $message }}</span>
                        </div>
                    @enderror
                </div>

                <!-- Botón de Confirmación -->
                <button type="submit" id="btnSubmitOrder" style="width: 100%; padding: 1.15rem; background: var(--direct-gradient); border: none; border-radius: 0.85rem; color: #ffffff; font-weight: 800; font-size: 1.15rem; cursor: pointer; box-shadow: 0 4px 18px rgba(16, 185, 129, 0.4); display: flex; align-items: center; justify-content: center; gap: 0.65rem; transition: transform 0.2s, box-shadow 0.2s;">
                    <i data-feather="check-circle" style="width: 22px; height: 22px;"></i>
                    <span id="btnSubmitText">Confirmar Pedido (@money($subtotal))</span>
                </button>
            </form>
        </div>

        <!-- Columna Lateral: Resumen del Pedido -->
        <div class="checkout-summary-card">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); display: flex; align-items: center; justify-content: space-between;">
                <span>Resumen de Compra</span>
                <span style="font-size: 0.8rem; background: rgba(249, 115, 22, 0.2); color: #fdba74; padding: 0.2rem 0.55rem; border-radius: 9999px;">{{ count($cart) }} items</span>
            </h3>

            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem; max-height: 280px; overflow-y: auto; padding-right: 0.25rem;">
                @foreach($cart as $item)
                    <div style="display: flex; align-items: center; gap: 0.85rem;">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1);">
                        <div style="flex: 1; overflow: hidden;">
                            <div style="font-size: 0.85rem; font-weight: 700; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item['title'] }}</div>
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-top: 0.15rem;">
                                <span style="font-size: 0.75rem; color: #94a3b8;">{{ $item['quantity'] }} unidad(es)</span>
                                @if(!empty($item['size']))
                                    <span style="background: rgba(249, 115, 22, 0.2); color: #fdba74; font-size: 0.7rem; font-weight: 700; padding: 0.05rem 0.35rem; border-radius: 0.25rem;">Talla: {{ $item['size'] }}</span>
                                @endif
                            </div>
                        </div>
                        <div style="font-weight: 800; font-size: 0.9rem; color: #ffffff;">
                            @money($item['price'] * $item['quantity'])
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="border-top: 1px solid rgba(255,255,255,0.08); padding-top: 1rem; margin-bottom: 1.25rem;">
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: #94a3b8; margin-bottom: 0.5rem;">
                    <span>Subtotal:</span>
                    <span style="color: #cbd5e1; font-weight: 600;">@money($subtotal)</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.9rem; color: #94a3b8; margin-bottom: 0.75rem;">
                    <span>Envío:</span>
                    <span style="color: #34d399; font-weight: 700;">GRATIS</span>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 1.25rem; font-weight: 800; color: #ffffff; padding-top: 0.75rem; border-top: 1px dashed rgba(255,255,255,0.1);">
                    <span>Total del Pedido:</span>
                    <span style="color: #34d399;">@money($subtotal)</span>
                </div>
            </div>

            <div style="background: rgba(15, 23, 42, 0.6); border-radius: 0.75rem; padding: 1rem; border: 1px solid rgba(255,255,255,0.05); font-size: 0.8rem; color: #94a3b8; display: flex; flex-direction: column; gap: 0.5rem;">
                <div style="display: flex; align-items: center; gap: 0.5rem; color: #cbd5e1;">
                    <i data-feather="check" style="width: 14px; height: 14px; color: #10b981;"></i> Compra protegida
                </div>
                <div style="display: flex; align-items: center; gap: 0.5rem; color: #cbd5e1;">
                    <i data-feather="truck" style="width: 14px; height: 14px; color: #f97316;"></i> Seguimiento en tiempo real
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
