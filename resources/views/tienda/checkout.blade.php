@extends('layouts.app')

@section('title', 'Finalizar Compra - Elvatrago')

@section('content')
<div style="max-width: 1100px; margin: 3rem auto 4rem; padding: 0 1.5rem;">
    <h1 style="font-size: 2rem; font-weight: 800; color: #ffffff; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <i data-feather="credit-card" style="color: #6366f1;"></i> Checkout & Detalles de Envío
    </h1>

    <div style="display: grid; grid-template-columns: 1fr 360px; gap: 2.5rem; align-items: start;">
        <!-- Form Fields -->
        <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 2rem;">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #ffffff; margin-bottom: 1.5rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                Información del Cliente
            </h2>

            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 1.25rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Nombre Completo *</label>
                    <input type="text" name="customer_name" required placeholder="Ej. Juan Pérez" value="{{ old('customer_name') }}" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-bottom: 1.25rem;">
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Correo Electrónico *</label>
                        <input type="email" name="customer_email" required placeholder="juan@ejemplo.com" value="{{ old('customer_email') }}" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem;">
                    </div>
                    <div>
                        <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Teléfono de Contacto *</label>
                        <input type="text" name="customer_phone" required placeholder="+51 987654321" value="{{ old('customer_phone') }}" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem;">
                    </div>
                </div>

                <div style="margin-bottom: 2rem;">
                    <label style="display: block; font-size: 0.85rem; font-weight: 600; color: #cbd5e1; margin-bottom: 0.5rem;">Dirección Exacta de Envío *</label>
                    <textarea name="shipping_address" rows="3" required placeholder="Av. Principal 123, Dpto / Casa, Ciudad, País" style="width: 100%; padding: 0.8rem 1rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.75rem; color: #ffffff; font-size: 0.95rem;">{{ old('shipping_address') }}</textarea>
                </div>

                <button type="submit" style="width: 100%; padding: 1rem; background: var(--direct-gradient); border: none; border-radius: 0.75rem; color: #ffffff; font-weight: 800; font-size: 1.1rem; cursor: pointer; box-shadow: 0 4px 14px rgba(16, 185, 129, 0.4); display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                    <i data-feather="check-circle"></i> Confirmar y Realizar Pedido ({{ format_price($subtotal) }})
                </button>
            </form>
        </div>

        <!-- Order Summary Side Panel -->
        <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
            <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                Tu Carrito ({{ count($cart) }})
            </h3>

            <div style="display: flex; flex-direction: column; gap: 1rem; margin-bottom: 1.5rem;">
                @foreach($cart as $item)
                    <div style="display: flex; align-items: center; gap: 0.85rem;">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1);">
                        <div style="flex: 1; overflow: hidden;">
                            <div style="font-size: 0.85rem; font-weight: 700; color: #ffffff; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $item['title'] }}</div>
                            <div style="font-size: 0.75rem; color: #94a3b8;">Cantidad: {{ $item['quantity'] }} x {{ format_price($item['price']) }}</div>
                        </div>
                        <div style="font-weight: 800; font-size: 0.9rem; color: #ffffff;">
                            @money($item['price'] * $item['quantity'])
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.08); display: flex; justify-content: space-between; font-size: 1.2rem; font-weight: 800; color: #ffffff;">
                <span>Total a Pagar:</span>
                <span style="color: #34d399;">@money($subtotal)</span>
            </div>
        </div>
    </div>
</div>
@endsection
