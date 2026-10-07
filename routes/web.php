<?php

use App\Http\Controllers\AffiliateRedirectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportarCatalogoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\TiendaController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// =========================================================================
// Rutas Públicas (Tienda y Catálogo)
// =========================================================================
Route::get('/', [TiendaController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [TiendaController::class, 'show'])->name('shop.show');
Route::get('/affiliate/redirect/{product}', [AffiliateRedirectController::class, 'redirect'])->name('affiliate.redirect');

// Selector de Moneda (USD / PEN)
Route::get('/currency/{code}', function ($code) {
    if (in_array(strtoupper($code), ['USD', 'PEN'])) {
        session(['currency' => strtoupper($code)]);
    }
    return back();
})->name('currency.switch');

// =========================================================================
// Módulo de Autenticación
// =========================================================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// =========================================================================
// Módulo de Clientes Autenticados (Carrito y Checkout)
// =========================================================================
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Carrito de compras
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Checkout y Órdenes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// =========================================================================
// Módulo de Gestión / Administración (Igual a la estructura de sistema_asesoria)
// =========================================================================
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Módulo: Importar Catálogo (AliExpress & Temu)
    Route::get('import', [ImportarCatalogoController::class, 'index'])->name('import.index');
    Route::post('import', [ImportarCatalogoController::class, 'store'])->name('import.store');

    // Módulo: Productos
    Route::resource('products', ProductoController::class);
    Route::delete('products/images/{image}', [ProductoController::class, 'deleteImage'])->name('products.images.destroy');

    // Módulo: Categorías
    Route::resource('categories', CategoriaController::class)->only(['index', 'store', 'destroy']);

    // Módulo: Pedidos
    Route::get('orders', [PedidoController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [PedidoController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [PedidoController::class, 'updateStatus'])->name('orders.update-status');
});
