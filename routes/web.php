<?php

use App\Http\Controllers\AffiliateRedirectController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClientOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ImportarCatalogoController;
use App\Http\Controllers\PedidoController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReturnRequestController;
use App\Http\Controllers\TiendaController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

// =========================================================================
// Rutas Públicas (Tienda y Catálogo)
// =========================================================================
Route::get('/', [TiendaController::class, 'index'])->name('shop.index');
Route::get('/product/{slug}', [TiendaController::class, 'show'])->name('shop.show');

// Solicitud pública de devolución para clientes
Route::get('/solicitar-devolucion', [ReturnRequestController::class, 'showPublicForm'])->name('returns.public.create');
Route::post('/solicitud-devolucion', [ReturnRequestController::class, 'storePublic'])->name('returns.public.store');

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
// Carrito y Checkout (Público para cualquier cliente o visitante)
// =========================================================================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout y Órdenes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success/{orderNumber}', [CheckoutController::class, 'success'])->name('checkout.success');

// =========================================================================
// Módulo de Pedidos e Historial del Cliente
// =========================================================================
Route::middleware('auth')->group(function () {
    Route::get('/mis-pedidos', [ClientOrderController::class, 'index'])->name('client.orders.index');
    Route::get('/mis-pedidos/{orderNumber}', [ClientOrderController::class, 'show'])->name('client.orders.show');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});


// =========================================================================
// Módulo de Gestión / Administración (Estilo Shopify)
// =========================================================================
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Módulo: Productos Manuales
    Route::resource('products', ProductoController::class);
    Route::delete('products/images/{image}', [ProductoController::class, 'deleteImage'])->name('products.images.destroy');

    // Módulo: Categorías
    Route::resource('categories', CategoriaController::class)->only(['index', 'store', 'destroy']);

    // Módulo: Pedidos
    Route::get('orders', [PedidoController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [PedidoController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [PedidoController::class, 'updateStatus'])->name('orders.update-status');

    // Módulo: Solicitudes de Devolución
    Route::get('returns', [ReturnRequestController::class, 'index'])->name('returns.index');
    Route::get('returns/{return}', [ReturnRequestController::class, 'show'])->name('returns.show');
    Route::patch('returns/{return}/status', [ReturnRequestController::class, 'updateStatus'])->name('returns.update-status');
    Route::delete('returns/{return}', [ReturnRequestController::class, 'destroy'])->name('returns.destroy');
});

