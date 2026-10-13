@extends('layouts.app')

@section('title', 'Carrito de Compras - GlobalClick')

@section('content')
<div style="max-width: 1100px; margin: 3rem auto 4rem; padding: 0 1.5rem;">
    <h1 style="font-size: 2rem; font-weight: 800; color: #ffffff; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <i data-feather="shopping-cart" style="color: #f97316;"></i> Carrito de Compras Directas
    </h1>

    @if(count($cart) > 0)
        <div style="display: grid; grid-template-columns: 1fr 340px; gap: 2rem; align-items: start;">
            <!-- Cart Table Items -->
            <div style="background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="background: rgba(15, 23, 42, 0.8); border-bottom: 1px solid rgba(255, 255, 255, 0.08); font-size: 0.8rem; text-transform: uppercase; color: #94a3b8;">
                            <th style="padding: 1rem 1.25rem;">Producto</th>
                            <th style="padding: 1rem 1.25rem;">Precio Unit.</th>
                            <th style="padding: 1rem 1.25rem;">Cantidad</th>
                            <th style="padding: 1rem 1.25rem;">Subtotal</th>
                            <th style="padding: 1rem 1.25rem; text-align: center;">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $id => $item)
                            <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                                <td style="padding: 1.25rem;">
                                    <div style="display: flex; align-items: center; gap: 1rem;">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 0.5rem; border: 1px solid rgba(255,255,255,0.1);">
                                        <div>
                                            <a href="{{ route('shop.show', $item['slug']) }}" style="font-weight: 700; color: #ffffff; font-size: 0.95rem;">
                                                {{ $item['title'] }}
                                            </a>
                                            <div style="font-size: 0.75rem; color: #34d399; margin-top: 0.2rem;">Stock disponible: {{ $item['stock'] }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1.25rem; font-weight: 700; color: #cbd5e1;">
                                    @money($item['price'])
                                </td>
                                <td style="padding: 1.25rem;">
                                    <form action="{{ route('cart.update', $id) }}" method="POST" style="display: flex; align-items: center; gap: 0.5rem;">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="{{ $item['stock'] }}" style="width: 65px; padding: 0.4rem; background: #0f172a; border: 1px solid rgba(255,255,255,0.15); border-radius: 0.5rem; color: #ffffff; font-weight: 700; text-align: center;">
                                        <button type="submit" style="background: rgba(249, 115, 22, 0.2); border: 1px solid rgba(249, 115, 22, 0.4); color: #fdba74; padding: 0.4rem 0.6rem; border-radius: 0.5rem; cursor: pointer;">
                                            <i data-feather="refresh-cw" style="width: 14px; height: 14px;"></i>
                                        </button>
                                    </form>
                                </td>
                                <td style="padding: 1.25rem; font-weight: 800; color: #ffffff;">
                                    @money($item['price'] * $item['quantity'])
                                </td>
                                <td style="padding: 1.25rem; text-align: center;">
                                    <form action="{{ route('cart.remove', $id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background: rgba(239, 68, 68, 0.15); border: 1px solid rgba(239, 68, 68, 0.3); color: #fca5a5; padding: 0.4rem 0.65rem; border-radius: 0.5rem; cursor: pointer;">
                                            <i data-feather="trash-2" style="width: 16px; height: 16px;"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="padding: 1rem 1.25rem; display: flex; justify-content: space-between; align-items: center; background: rgba(15, 23, 42, 0.4);">
                    <form action="{{ route('cart.clear') }}" method="POST">
                        @csrf
                        <button type="submit" style="background: transparent; border: none; color: #94a3b8; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; gap: 0.35rem;">
                            <i data-feather="trash" style="width: 14px; height: 14px;"></i> Vaciar Carrito
                        </button>
                    </form>
                    <a href="{{ route('shop.index') }}" style="font-size: 0.85rem; color: #f97316; font-weight: 600;">&larr; Continuar comprando</a>
                </div>
            </div>

            <!-- Order Summary Card -->
            <div style="background: rgba(30, 41, 59, 0.6); border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 1.25rem; padding: 1.5rem;">
                <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin-bottom: 1.25rem; padding-bottom: 0.75rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08);">
                    Resumen del Pedido
                </h3>

                <div style="display: flex; justify-content: space-between; color: #cbd5e1; font-size: 0.95rem; margin-bottom: 0.85rem;">
                    <span>Subtotal</span>
                    <span>@money($subtotal)</span>
                </div>

                <div style="display: flex; justify-content: space-between; color: #cbd5e1; font-size: 0.95rem; margin-bottom: 1.25rem;">
                    <span>Envío Estimado</span>
                    <span style="color: #34d399; font-weight: 600;">GRATIS</span>
                </div>

                <div style="display: flex; justify-content: space-between; color: #ffffff; font-size: 1.25rem; font-weight: 800; padding-top: 1rem; border-top: 1px solid rgba(255, 255, 255, 0.08); margin-bottom: 1.5rem;">
                    <span>Total</span>
                    <span>@money($subtotal)</span>
                </div>

                <a href="{{ route('checkout.index') }}" style="display: flex; align-items: center; justify-content: center; gap: 0.5rem; width: 100%; padding: 0.9rem; background: var(--accent-gradient); border-radius: 0.75rem; color: #ffffff; font-weight: 800; font-size: 1rem; box-shadow: 0 4px 14px rgba(249, 115, 22, 0.4);">
                    Proceder al Checkout &rarr;
                </a>
            </div>
        </div>
    @else
        <div style="text-align: center; padding: 4rem 1.5rem; background: rgba(30, 41, 59, 0.4); border-radius: 1.5rem; max-width: 500px; margin: 2rem auto;">
            <i data-feather="shopping-cart" style="width: 48px; height: 48px; color: #64748b; margin-bottom: 1rem;"></i>
            <h3 style="font-size: 1.25rem; color: #ffffff; margin-bottom: 0.5rem;">Tu carrito está vacío</h3>
            <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 1.5rem;">Añade algunos productos de venta directa para continuar.</p>
            <a href="{{ route('shop.index') }}" class="pill-item active" style="display: inline-block;">Explorar Productos</a>
        </div>
    @endif
</div>
@endsection
