<?php

use App\Http\Controllers\Admin\AppearanceController as AdminAppearanceController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// -------------------------------------------------------------
// 1. PUBLIC FRONTEND & CATALOG ROUTES (PERTEMUAN 5 & 7)
// -------------------------------------------------------------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/cupang/{slug}', [CatalogController::class, 'show'])->name('catalog.show');

// -------------------------------------------------------------
// 2. SHOPPING CART ROUTES (PERTEMUAN 7)
// -------------------------------------------------------------
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// -------------------------------------------------------------
// 3. CHECKOUT & LIVE ANIMAL ORDERS (PERTEMUAN 8 - UTS)
// -------------------------------------------------------------
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/orders/{order_number}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders/{order_number}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('orders.confirm_payment');
Route::get('/my-orders', [OrderController::class, 'customerOrders'])->name('orders.index')->middleware('auth');

// -------------------------------------------------------------
// 4. CMS EDUKASI & WISHLIST (PERTEMUAN 9)
// -------------------------------------------------------------
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])->name('articles.show');
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
Route::post('/wishlist/toggle/{product}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');

// -------------------------------------------------------------
// 5. LIVE TRACKING & SPECIMEN REVIEWS (PERTEMUAN 10)
// -------------------------------------------------------------
Route::get('/tracking', [OrderController::class, 'track'])->name('tracking.index');
Route::post('/cupang/{product}/review', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

// -------------------------------------------------------------
// 6. AUTHENTICATION (MULTI-ROLE: ADMIN & CUSTOMER)
// -------------------------------------------------------------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// -------------------------------------------------------------
// 7. ADMIN PANEL (PERTEMUAN 6 & 11)
// -------------------------------------------------------------
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Overview Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Live Appearance Customizer (Pertemuan 6)
    Route::get('/appearance', [AdminAppearanceController::class, 'index'])->name('appearance.index');
    Route::post('/appearance', [AdminAppearanceController::class, 'update'])->name('appearance.update');
    Route::post('/appearance/reset', [AdminAppearanceController::class, 'reset'])->name('appearance.reset');

    // Categories Management (Pertemuan 6)
    Route::resource('categories', AdminCategoryController::class);

    // Products Management (Pertemuan 6)
    Route::resource('products', AdminProductController::class);
    Route::post('products/{product}/duplicate', [AdminProductController::class, 'duplicate'])->name('products.duplicate');

    // Orders Management & Live Animal Tracking (Pertemuan 10 & 11)
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update_status');

    // Articles CMS & Educational Content (Pertemuan 9)
    Route::resource('articles', AdminArticleController::class);

    // Sales Reports & Analytics (Pertemuan 11)
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-csv', [AdminReportController::class, 'exportCsv'])->name('reports.export_csv');
    Route::get('/reports/print', [AdminReportController::class, 'print'])->name('reports.print');
});
