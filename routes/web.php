<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\SellerController as AdminSellerController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\SellerRegisterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Seller\DashboardController as SellerDashboardController;
use App\Http\Controllers\Seller\OrderController as SellerOrderController;
use App\Http\Controllers\Seller\ProductController as SellerProductController;
use App\Http\Controllers\Seller\SalesController as SellerSalesController;
use Illuminate\Support\Facades\Route;

// Entrada: login obrigatório
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'create'])->name('login');
    Route::post('/', [LoginController::class, 'store']);
    Route::get('/login', fn () => redirect()->route('login'));
    Route::get('/recuperar-senha', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/recuperar-senha', [ForgotPasswordController::class, 'store'])->name('password.email');
    Route::get('/redefinir-senha/{token}', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/redefinir-senha', [ResetPasswordController::class, 'store'])->name('password.update');
    Route::get('/registar-vendedor', [SellerRegisterController::class, 'create'])->name('seller.register');
    Route::post('/registar-vendedor', [SellerRegisterController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth')->name('logout');

// Área autenticada — apenas Admin e Vendedor
Route::middleware(['auth', 'staff'])->group(function () {

    // Loja (apenas Administrador)
    Route::middleware('role:admin')->group(function () {
        Route::get('/loja', [HomeController::class, 'index'])->name('home');
        Route::get('/pesquisa', [SearchController::class, 'index'])->name('search');
        Route::get('/categorias/{slug}', [CategoryController::class, 'show'])->name('categories.show');
        Route::get('/produtos/{slug}', [ProductController::class, 'show'])->name('products.show');
        Route::get('/carrinho', [CartController::class, 'index'])->name('cart.index');
        Route::post('/carrinho', [CartController::class, 'store'])->name('cart.store');
        Route::patch('/carrinho/{cartItem}', [CartController::class, 'update'])->name('cart.update');
        Route::delete('/carrinho/{cartItem}', [CartController::class, 'destroy'])->name('cart.destroy');
        Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
        Route::get('/pedidos', [OrderController::class, 'index'])->name('orders.index');
        Route::get('/pedidos/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::post('/pedidos/{order}/cancelar', [OrderController::class, 'cancel'])->name('orders.cancel');
    });

    // Perfil (ambos)
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/perfil/senha', [ProfileController::class, 'password'])->name('profile.password');

    // Admin — gestão total
    Route::prefix('admin')->name('admin.')->middleware('role:admin')->group(function () {
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('users', AdminUserController::class)->except(['show']);
        Route::get('sellers', [AdminSellerController::class, 'index'])->name('sellers.index');
        Route::get('sellers/{seller}', [AdminSellerController::class, 'show'])->name('sellers.show');
        Route::patch('sellers/{seller}/approve', [AdminSellerController::class, 'approve'])->name('sellers.approve');
        Route::patch('sellers/{seller}/reject', [AdminSellerController::class, 'reject'])->name('sellers.reject');
        Route::patch('sellers/{seller}/suspend', [AdminSellerController::class, 'suspend'])->name('sellers.suspend');
        Route::patch('sellers/{seller}/reactivate', [AdminSellerController::class, 'reactivate'])->name('sellers.reactivate');
        Route::resource('categories', AdminCategoryController::class)->except(['show']);
        Route::resource('products', AdminProductController::class)->except(['show']);
        Route::patch('products/{product}/approve', [AdminProductController::class, 'approve'])->name('products.approve');
        Route::patch('products/{product}/reject', [AdminProductController::class, 'reject'])->name('products.reject');
        Route::patch('products/{product}/featured', [AdminProductController::class, 'toggleFeatured'])->name('products.featured');
        Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    });

    // Vendedor — acesso limitado
    Route::prefix('vendedor')->name('seller.')->middleware('role:seller')->group(function () {
        Route::get('/', [SellerDashboardController::class, 'index'])->name('dashboard');
        Route::resource('products', SellerProductController::class)->except(['show']);
        Route::get('orders', [SellerOrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [SellerOrderController::class, 'show'])->name('orders.show');
        Route::get('vendas', [SellerSalesController::class, 'index'])->name('sales.index');
    });
});
