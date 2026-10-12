@extends('layouts.app')

@section('title', 'Configuración de Moneda - Elvatrago')

@section('content')
@php
    $currentCurrency = session('currency', 'USD');
@endphp

<div style="max-width: 860px; margin: 2rem auto; padding: 0 1.5rem 4rem;">
    <!-- Enlace de regreso -->
    <a href="{{ route('shop.index') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #94a3b8; font-size: 0.875rem; text-decoration: none; margin-bottom: 1.5rem; transition: color 0.2s ease;">
        <i data-feather="arrow-left" style="width: 16px; height: 16px;"></i>
        <span>Volver a la tienda</span>
    </a>

    <!-- Tarjeta Principal de Configuración -->
    <div style="background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(16px); border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 1.25rem; padding: 2rem; box-shadow: 0 20px 40px -15px rgba(0,0,0,0.6);">
        <!-- Encabezado de la página -->
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem; flex-wrap: wrap; border-bottom: 1px solid rgba(255, 255, 255, 0.08); padding-bottom: 1.5rem; margin-bottom: 2rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="width: 52px; height: 52px; border-radius: 1rem; background: linear-gradient(135deg, rgba(99, 102, 241, 0.2), rgba(168, 85, 247, 0.2)); border: 1px solid rgba(99, 102, 241, 0.4); display: flex; align-items: center; justify-content: center;">
                    <i data-feather="settings" style="width: 26px; height: 26px; color: #818cf8;"></i>
                </div>
                <div>
                    <h1 style="font-size: 1.5rem; font-weight: 800; color: #ffffff; margin: 0 0 0.25rem 0;">Cambio de Moneda</h1>
                    <p style="font-size: 0.875rem; color: #94a3b8; margin: 0;">Selecciona la moneda con la que prefieres ver y comprar productos en la tienda.</p>
                </div>
            </div>
            
            <!-- Estado actual -->
            <div style="display: flex; align-items: center; gap: 0.5rem; background: rgba(30, 41, 59, 0.7); border: 1px solid rgba(255, 255, 255, 0.12); padding: 0.45rem 0.95rem; border-radius: 9999px;">
                <span style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; font-weight: 600;">Moneda Actual:</span>
                <span style="font-size: 0.85rem; font-weight: 800; color: {{ $currentCurrency === 'PEN' ? '#34d399' : '#818cf8' }};">
                    {{ $currentCurrency === 'PEN' ? 'Soles (PEN - S/.)' : 'Dólares (USD - $)' }}
                </span>
            </div>
        </div>

        <!-- Opciones de Moneda en Grilla -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <!-- Opción: Dólar Estadounidense (USD) -->
            <div style="border-radius: 1rem; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s ease; position: relative; {{ $currentCurrency === 'USD' ? 'background: rgba(99, 102, 241, 0.12); border: 2px solid #6366f1; box-shadow: 0 0 25px rgba(99, 102, 241, 0.25);' : 'background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.1);' }}">
                @if($currentCurrency === 'USD')
                    <div style="position: absolute; top: 1rem; right: 1rem; background: #6366f1; color: #ffffff; font-size: 0.7rem; font-weight: 800; padding: 0.2rem 0.6rem; border-radius: 9999px; display: flex; align-items: center; gap: 0.3rem;">
                        <i data-feather="check" style="width: 12px; height: 12px;"></i> Activa
                    </div>
                @endif

                <div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                        <div style="width: 44px; height: 44px; border-radius: 0.75rem; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 800; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);">
                            $
                        </div>
                        <div>
                            <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin: 0;">Dólar Americano</h2>
                            <span style="font-size: 0.75rem; font-weight: 700; color: #818cf8; text-transform: uppercase;">USD ($)</span>
                        </div>
                    </div>

                    <p style="font-size: 0.85rem; color: #cbd5e1; line-height: 1.45; margin-bottom: 1.25rem;">
                        Moneda base de la tienda. Todos los precios se muestran en dólares americanos con su tarifa original.
                    </p>

                    <div style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 0.75rem; padding: 0.75rem 1rem; margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: #94a3b8; margin-bottom: 0.25rem;">
                            <span>Tipo de cambio:</span>
                            <span style="color: #ffffff; font-weight: 600;">1.00 USD = $1.00</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: #94a3b8;">
                            <span>Ejemplo de precio:</span>
                            <span style="color: #38bdf8; font-weight: 700;">$50.00 USD</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('settings.currency.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="currency" value="USD">
                    <button type="submit" 
                            style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; font-weight: 700; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s ease; {{ $currentCurrency === 'USD' ? 'background: rgba(99, 102, 241, 0.25); border: 1px solid #6366f1; color: #ffffff;' : 'background: #6366f1; border: none; color: #ffffff; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.4);' }}">
                        @if($currentCurrency === 'USD')
                            <i data-feather="check-circle" style="width: 16px; height: 16px;"></i>
                            <span>Moneda Seleccionada</span>
                        @else
                            <i data-feather="arrow-right-circle" style="width: 16px; height: 16px;"></i>
                            <span>Elegir Dólares (USD)</span>
                        @endif
                    </button>
                </form>
            </div>

            <!-- Opción: Sol Peruano (PEN) -->
            <div style="border-radius: 1rem; padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; transition: all 0.25s ease; position: relative; {{ $currentCurrency === 'PEN' ? 'background: rgba(16, 185, 129, 0.12); border: 2px solid #10b981; box-shadow: 0 0 25px rgba(16, 185, 129, 0.25);' : 'background: rgba(30, 41, 59, 0.5); border: 1px solid rgba(255, 255, 255, 0.1);' }}">
                @if($currentCurrency === 'PEN')
                    <div style="position: absolute; top: 1rem; right: 1rem; background: #10b981; color: #ffffff; font-size: 0.7rem; font-weight: 800; padding: 0.2rem 0.6rem; border-radius: 9999px; display: flex; align-items: center; gap: 0.3rem;">
                        <i data-feather="check" style="width: 12px; height: 12px;"></i> Activa
                    </div>
                @endif

                <div>
                    <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 1rem;">
                        <div style="width: 44px; height: 44px; border-radius: 0.75rem; background: linear-gradient(135deg, #10b981, #059669); color: #ffffff; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; font-weight: 800; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);">
                            S/.
                        </div>
                        <div>
                            <h2 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin: 0;">Sol Peruano</h2>
                            <span style="font-size: 0.75rem; font-weight: 700; color: #34d399; text-transform: uppercase;">PEN (S/.)</span>
                        </div>
                    </div>

                    <p style="font-size: 0.85rem; color: #cbd5e1; line-height: 1.45; margin-bottom: 1.25rem;">
                        Moneda oficial del Perú. Los precios de los productos se convertirán al tipo de cambio referencial de S/. 3.75.
                    </p>

                    <div style="background: rgba(15, 23, 42, 0.6); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 0.75rem; padding: 0.75rem 1rem; margin-bottom: 1.5rem;">
                        <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: #94a3b8; margin-bottom: 0.25rem;">
                            <span>Tipo de cambio:</span>
                            <span style="color: #ffffff; font-weight: 600;">1.00 USD ≈ S/. 3.75 PEN</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; font-size: 0.75rem; color: #94a3b8;">
                            <span>Ejemplo de precio:</span>
                            <span style="color: #34d399; font-weight: 700;">S/. 187.50 PEN</span>
                        </div>
                    </div>
                </div>

                <form action="{{ route('settings.currency.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="currency" value="PEN">
                    <button type="submit" 
                            style="width: 100%; padding: 0.75rem 1rem; border-radius: 0.75rem; font-weight: 700; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 0.5rem; transition: all 0.2s ease; {{ $currentCurrency === 'PEN' ? 'background: rgba(16, 185, 129, 0.25); border: 1px solid #10b981; color: #ffffff;' : 'background: #10b981; border: none; color: #ffffff; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);' }}">
                        @if($currentCurrency === 'PEN')
                            <i data-feather="check-circle" style="width: 16px; height: 16px;"></i>
                            <span>Moneda Seleccionada</span>
                        @else
                            <i data-feather="arrow-right-circle" style="width: 16px; height: 16px;"></i>
                            <span>Elegir Soles (PEN)</span>
                        @endif
                    </button>
                </form>
            </div>
        </div>

        <!-- Botón para volver a la tienda -->
        <div style="border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <div style="display: flex; align-items: center; gap: 0.5rem; font-size: 0.8rem; color: #64748b;">
                <i data-feather="info" style="width: 14px; height: 14px; flex-shrink: 0;"></i>
                <span>La moneda elegida se guardará en tu sesión y se aplicará en todo el catálogo y carrito.</span>
            </div>

            <a href="{{ route('shop.index') }}" 
               style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: #ffffff; text-decoration: none; padding: 0.7rem 1.4rem; border-radius: 9999px; font-weight: 700; font-size: 0.875rem; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35); transition: all 0.2s ease;">
                <span>Ir al Catálogo de Productos</span>
                <i data-feather="arrow-right" style="width: 15px; height: 15px;"></i>
            </a>
        </div>
    </div>
</div>
@endsection
