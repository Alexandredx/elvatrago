@extends('layouts.app')

@section('title', 'Finalizar Compra - GlobalClick')

@section('content')
<div style="max-width: 1100px; margin: 3rem auto 4rem; padding: 0 1.5rem;">
    <!-- Header -->
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('cart.index') }}" style="color: #94a3b8; font-size: 0.85rem; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; margin-bottom: 0.75rem;">
            <i data-feather="arrow-left" style="width: 14px; height: 14px;"></i> Volver al Carrito
        </a>
        <h1 style="font-size: 2rem; font-weight: 800; color: #ffffff; display: flex; align-items: center; gap: 0.75rem;">
            <i data-feather="check-circle" style="color: #f97316;"></i> Finalizar Pedido y Pago
        </h1>
        <p style="color: #94a3b8; font-size: 0.95rem; margin-top: 0.25rem;">Completa tus datos de envío y selecciona tu medio de pago preferido para confirmar tu compra.</p>
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

    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 2.5rem; align-items: start;">
        <!-- Form Container -->
        <div>
            <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                @csrf
                
                <!-- SECCIÓN 1: DETALLES DE ENVÍO -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem; margin-bottom: 2rem;">
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                        <span style="width: 28px; height: 28px; border-radius: 50%; background: #f97316; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 800;">1</span>
                        <h2 style="font-size: 1.2rem; font-weight: 700; color: #ffffff; margin: 0;">
                            Detalles de Envío y Contacto
                        </h2>
                    </div>

                    <div style="margin-bottom: 1.25rem;">
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Nombre Completo del Receptor *</label>
                        <input type="text" name="customer_name" required placeholder="Ej. Juan Pérez García" value="{{ old('customer_name', $user->name ?? '') }}" style="width: 100%; padding: 0.85rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none; transition: border-color 0.2s;">
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
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

                <!-- SECCIÓN 2: MEDIOS DE PAGO -->
                <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem; margin-bottom: 2rem;">
                    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); flex-wrap: wrap; gap: 0.5rem;">
                        <div style="display: flex; align-items: center; gap: 0.75rem;">
                            <span style="width: 28px; height: 28px; border-radius: 50%; background: #10b981; color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 800;">2</span>
                            <h2 style="font-size: 1.2rem; font-weight: 700; color: #ffffff; margin: 0;">
                                Pasarela de Pago Segura (API Culqi)
                            </h2>
                        </div>
                        <div style="display: flex; align-items: center; gap: 0.45rem; background: rgba(16, 185, 129, 0.12); border: 1px solid rgba(16, 185, 129, 0.35); padding: 0.3rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; color: #34d399; font-weight: 700;">
                            <i data-feather="shield" style="width: 14px; height: 14px;"></i>
                            <span>Tokenización PCI-DSS Nivel 1</span>
                        </div>
                    </div>

                    <!-- Selector de método: Tarjeta o Yape -->
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">
                        <!-- Opción Tarjeta -->
                        <label id="label-tarjeta" style="border: 2px solid {{ old('payment_method', 'tarjeta') === 'tarjeta' ? '#f97316' : 'rgba(255,255,255,0.1)' }}; background: {{ old('payment_method', 'tarjeta') === 'tarjeta' ? 'rgba(249, 115, 22, 0.12)' : 'rgba(15, 23, 42, 0.6)' }}; padding: 1.25rem; border-radius: 1rem; cursor: pointer; transition: all 0.25s ease; display: flex; flex-direction: column; gap: 0.75rem; position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 0.65rem;">
                                    <input type="radio" name="payment_method" value="tarjeta" {{ old('payment_method', 'tarjeta') === 'tarjeta' ? 'checked' : '' }} style="accent-color: #f97316; width: 18px; height: 18px;">
                                    <span style="font-weight: 700; color: #ffffff; font-size: 1rem;">Tarjeta</span>
                                </div>
                                <i data-feather="credit-card" style="width: 22px; height: 22px; color: #f97316;"></i>
                            </div>
                            <div style="font-size: 0.8rem; color: #94a3b8;">
                                Crédito o Débito (Visa, Mastercard, AMEX)
                            </div>
                            <div style="display: flex; gap: 0.35rem; margin-top: auto;">
                                <span style="background: rgba(255,255,255,0.08); padding: 0.15rem 0.45rem; border-radius: 0.25rem; font-size: 0.65rem; font-weight: 700; color: #cbd5e1;">VISA</span>
                                <span style="background: rgba(255,255,255,0.08); padding: 0.15rem 0.45rem; border-radius: 0.25rem; font-size: 0.65rem; font-weight: 700; color: #cbd5e1;">MC</span>
                                <span style="background: rgba(255,255,255,0.08); padding: 0.15rem 0.45rem; border-radius: 0.25rem; font-size: 0.65rem; font-weight: 700; color: #cbd5e1;">AMEX</span>
                            </div>
                        </label>

                        <!-- Opción Yape -->
                        <label id="label-yape" style="border: 2px solid {{ old('payment_method') === 'yape' ? '#742284' : 'rgba(255,255,255,0.1)' }}; background: {{ old('payment_method') === 'yape' ? 'rgba(116, 34, 132, 0.2)' : 'rgba(15, 23, 42, 0.6)' }}; padding: 1.25rem; border-radius: 1rem; cursor: pointer; transition: all 0.25s ease; display: flex; flex-direction: column; gap: 0.75rem; position: relative;">
                            <div style="display: flex; align-items: center; justify-content: space-between;">
                                <div style="display: flex; align-items: center; gap: 0.65rem;">
                                    <input type="radio" name="payment_method" value="yape" {{ old('payment_method') === 'yape' ? 'checked' : '' }} style="accent-color: #742284; width: 18px; height: 18px;">
                                    <span style="font-weight: 700; color: #ffffff; font-size: 1rem;">Yape</span>
                                </div>
                                <span style="background: #742284; color: #00d2c4; font-weight: 900; font-size: 0.85rem; padding: 0.2rem 0.6rem; border-radius: 0.5rem; letter-spacing: 0.5px;">yape</span>
                            </div>
                            <div style="font-size: 0.8rem; color: #94a3b8;">
                                Pago instantáneo desde tu app de Yape (BCP)
                            </div>
                            <div style="display: flex; gap: 0.35rem; margin-top: auto;">
                                <span style="background: rgba(116, 34, 132, 0.4); padding: 0.15rem 0.45rem; border-radius: 0.25rem; font-size: 0.65rem; font-weight: 700; color: #00d2c4;">0% COMISIÓN</span>
                                <span style="background: rgba(255,255,255,0.08); padding: 0.15rem 0.45rem; border-radius: 0.25rem; font-size: 0.65rem; font-weight: 700; color: #cbd5e1;">QR / NÚMERO</span>
                            </div>
                        </label>
                    </div>

                    <!-- CAMPOS: TARJETA DE CRÉDITO / DÉBITO -->
                    <div id="section-card-fields" style="display: {{ old('payment_method', 'tarjeta') === 'tarjeta' ? 'block' : 'none' }}; background: rgba(15, 23, 42, 0.6); padding: 1.5rem; border-radius: 1rem; border: 1px solid rgba(255, 255, 255, 0.08);">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem;">
                            <span style="font-weight: 700; color: #f1f5f9; font-size: 0.95rem; display: flex; align-items: center; gap: 0.5rem;">
                                <i data-feather="shield" style="width: 16px; height: 16px; color: #10b981;"></i>
                                Datos de la Tarjeta
                            </span>
                            <span style="font-size: 0.75rem; color: #94a3b8; display: flex; align-items: center; gap: 0.3rem;">
                                <i data-feather="lock" style="width: 12px; height: 12px; color: #10b981;"></i> Cifrado SSL 256 bits
                            </span>
                        </div>

                        <div style="margin-bottom: 1.25rem;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Número de Tarjeta *</label>
                            <div style="position: relative;">
                                <i data-feather="credit-card" style="position: absolute; left: 1rem; top: 50%; transform: translateY(-50%); color: #64748b; width: 18px; height: 18px;"></i>
                                <input type="text" id="card_number" name="card_number" maxlength="19" placeholder="0000 0000 0000 0000" autocomplete="off" value="{{ old('card_number') }}" style="width: 100%; padding: 0.85rem 1rem 0.85rem 2.8rem; background: #0b1120; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 1rem; font-family: monospace; letter-spacing: 1px; outline: none;">
                            </div>
                        </div>

                        <div style="margin-bottom: 1.25rem;">
                            <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Nombre del Titular (como aparece en la tarjeta) *</label>
                            <input type="text" id="card_holder" name="card_holder" placeholder="JUAN PEREZ" autocomplete="off" value="{{ old('card_holder') }}" style="width: 100%; padding: 0.85rem 1rem; background: #0b1120; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; text-transform: uppercase; outline: none;">
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Vencimiento (MM/AA) *</label>
                                <input type="text" id="card_expiry" name="card_expiry" maxlength="5" placeholder="MM/AA" autocomplete="off" value="{{ old('card_expiry') }}" style="width: 100%; padding: 0.85rem 1rem; background: #0b1120; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; text-align: center; outline: none;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Código CVV *</label>
                                <input type="password" id="card_cvv" name="card_cvv" maxlength="4" placeholder="123" autocomplete="off" value="{{ old('card_cvv') }}" style="width: 100%; padding: 0.85rem 1rem; background: #0b1120; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; text-align: center; letter-spacing: 2px; outline: none;">
                            </div>
                        </div>
                    </div>

                    <!-- CAMPOS: PAGO CON YAPE -->
                    <div id="section-yape-fields" style="display: {{ old('payment_method') === 'yape' ? 'block' : 'none' }}; background: rgba(15, 23, 42, 0.6); padding: 1.5rem; border-radius: 1rem; border: 1px solid rgba(116, 34, 132, 0.4);">
                        <!-- Caja de Instrucciones Yape -->
                        <div style="background: linear-gradient(135deg, rgba(116, 34, 132, 0.35), rgba(15, 23, 42, 0.8)); border: 1px solid rgba(116, 34, 132, 0.5); border-radius: 0.85rem; padding: 1.25rem; margin-bottom: 1.5rem;">
                            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 0.75rem;">
                                <span style="font-weight: 800; color: #00d2c4; font-size: 1.1rem; display: flex; align-items: center; gap: 0.5rem;">
                                    <i data-feather="smartphone" style="width: 20px; height: 20px; color: #00d2c4;"></i>
                                    Paga con Yape
                                </span>
                                <span style="background: #742284; color: #ffffff; font-size: 0.75rem; font-weight: 800; padding: 0.2rem 0.5rem; border-radius: 0.5rem;">
                                    BCP
                                </span>
                            </div>
                            <p style="font-size: 0.85rem; color: #cbd5e1; margin-bottom: 1rem; line-height: 1.5;">
                                Abre tu aplicación Yape y transfiere el monto exacto al siguiente número oficial de la tienda:
                            </p>
                            
                            <div style="background: rgba(0, 0, 0, 0.4); border-radius: 0.75rem; padding: 1rem; display: flex; align-items: center; justify-content: space-between; border: 1px dashed rgba(0, 210, 196, 0.4);">
                                <div>
                                    <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase;">Número Oficial Yape:</div>
                                    <div style="font-size: 1.35rem; font-weight: 800; color: #ffffff; letter-spacing: 1px;">987 654 321</div>
                                    <div style="font-size: 0.8rem; color: #00d2c4; font-weight: 600;">GlobalClick Perú S.A.C.</div>
                                </div>
                                <div style="text-align: right;">
                                    <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase;">Monto a Yapear:</div>
                                    <div style="font-size: 1.35rem; font-weight: 800; color: #34d399;">@money($subtotal)</div>
                                </div>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Número Celular registrado en Yape *</label>
                                <input type="tel" id="yape_phone" name="yape_phone" maxlength="12" placeholder="Ej. 987654321" value="{{ old('yape_phone') }}" style="width: 100%; padding: 0.85rem 1rem; background: #0b1120; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; outline: none;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Código de Aprobación Yape (6 dígitos) *</label>
                                <input type="text" id="yape_code" name="yape_code" maxlength="10" placeholder="Ej. 582910" value="{{ old('yape_code') }}" style="width: 100%; padding: 0.85rem 1rem; background: #0b1120; border: 1px solid rgba(255,255,255,0.12); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem; letter-spacing: 2px; outline: none;">
                            </div>
                        </div>
                        <div style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.75rem; display: flex; align-items: center; gap: 0.4rem;">
                            <i data-feather="info" style="width: 14px; height: 14px; color: #00d2c4;"></i>
                            <span>Obtén tu código de 6 dígitos en tu app Yape: Menú &gt; <strong>Código de aprobación</strong>. Es seguro y de un solo uso.</span>
                        </div>
                    </div>
                </div>

                <!-- Botón de Confirmación -->
                <button type="submit" id="btnSubmitOrder" style="width: 100%; padding: 1.15rem; background: var(--direct-gradient); border: none; border-radius: 0.85rem; color: #ffffff; font-weight: 800; font-size: 1.15rem; cursor: pointer; box-shadow: 0 4px 18px rgba(16, 185, 129, 0.4); display: flex; align-items: center; justify-content: center; gap: 0.65rem; transition: transform 0.2s, box-shadow 0.2s;">
                    <i data-feather="check-circle" style="width: 22px; height: 22px;"></i>
                    <span id="btnSubmitText">Confirmar y Pagar Pedido (@money($subtotal))</span>
                </button>
            </form>
        </div>

        <!-- Columna Lateral: Resumen del Pedido -->
        <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.75rem; position: sticky; top: 2rem;">
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
                            <div style="font-size: 0.75rem; color: #94a3b8;">{{ $item['quantity'] }} unidad(es)</div>
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
                    <span>Total a Pagar:</span>
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const radioTarjeta = document.querySelector('input[name="payment_method"][value="tarjeta"]');
    const radioYape = document.querySelector('input[name="payment_method"][value="yape"]');
    const labelTarjeta = document.getElementById('label-tarjeta');
    const labelYape = document.getElementById('label-yape');
    const sectionCard = document.getElementById('section-card-fields');
    const sectionYape = document.getElementById('section-yape-fields');
    const btnSubmitText = document.getElementById('btnSubmitText');

    // Inputs
    const cardInputs = [
        document.getElementById('card_number'),
        document.getElementById('card_holder'),
        document.getElementById('card_expiry'),
        document.getElementById('card_cvv')
    ];

    const yapeInputs = [
        document.getElementById('yape_phone'),
        document.getElementById('yape_code')
    ];

    function updatePaymentMethod() {
        if (radioTarjeta.checked) {
            // Activar estilos tarjeta
            labelTarjeta.style.borderColor = '#f97316';
            labelTarjeta.style.background = 'rgba(249, 115, 22, 0.12)';
            labelYape.style.borderColor = 'rgba(255, 255, 255, 0.1)';
            labelYape.style.background = 'rgba(15, 23, 42, 0.6)';

            sectionCard.style.display = 'block';
            sectionYape.style.display = 'none';

            cardInputs.forEach(input => {
                if (input) input.required = true;
            });
            yapeInputs.forEach(input => {
                if (input) input.required = false;
            });

            btnSubmitText.textContent = 'Pagar con Tarjeta (@money($subtotal))';
        } else {
            // Activar estilos yape
            labelYape.style.borderColor = '#742284';
            labelYape.style.background = 'rgba(116, 34, 132, 0.2)';
            labelTarjeta.style.borderColor = 'rgba(255, 255, 255, 0.1)';
            labelTarjeta.style.background = 'rgba(15, 23, 42, 0.6)';

            sectionCard.style.display = 'none';
            sectionYape.style.display = 'block';

            cardInputs.forEach(input => {
                if (input) input.required = false;
            });
            yapeInputs.forEach(input => {
                if (input) input.required = true;
            });

            btnSubmitText.textContent = 'Confirmar Pago con Yape (@money($subtotal))';
        }

        if (typeof feather !== 'undefined') {
            feather.replace();
        }
    }

    if (radioTarjeta && radioYape) {
        radioTarjeta.addEventListener('change', updatePaymentMethod);
        radioYape.addEventListener('change', updatePaymentMethod);
        updatePaymentMethod();
    }

    // Formateador de tarjeta de crédito (espacio cada 4 números)
    const cardNumInput = document.getElementById('card_number');
    if (cardNumInput) {
        cardNumInput.addEventListener('input', function (e) {
            let val = e.target.value.replace(/\D/g, '').substring(0, 16);
            let formatted = val.match(/.{1,4}/g)?.join(' ') || val;
            e.target.value = formatted;
        });
    }

    // Formateador de fecha de vencimiento (MM/AA)
    const cardExpiryInput = document.getElementById('card_expiry');
    if (cardExpiryInput) {
        cardExpiryInput.addEventListener('input', function (e) {
            let val = e.target.value.replace(/\D/g, '').substring(0, 4);
            if (val.length >= 3) {
                e.target.value = val.substring(0, 2) + '/' + val.substring(2);
            } else {
                e.target.value = val;
            }
        });
    }

    // Solo números para CVV
    const cardCvvInput = document.getElementById('card_cvv');
    if (cardCvvInput) {
        cardCvvInput.addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 4);
        });
    }

    // Solo números para teléfono de Yape
    const yapePhoneInput = document.getElementById('yape_phone');
    if (yapePhoneInput) {
        yapePhoneInput.addEventListener('input', function (e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0, 9);
        });
    }
});
</script>
@endsection
