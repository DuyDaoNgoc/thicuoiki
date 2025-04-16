<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderTrackController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\AdvertisementController; // ✅ Thêm controller quảng cáo

// ====================
// FRONTEND ROUTES
// ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.redirect');

// ✅ Route lấy danh sách quảng cáo đang hoạt động (cho trang chủ)
Route::get('/quang-cao/dang-hoat-dong', [AdvertisementController::class, 'getActiveAdvertisements'])->name('advertisements.active');

// Products
Route::prefix('products')->group(function () {
    Route::get('/', [HomeController::class, 'allProducts'])->name('products');
    Route::get('/ao', [HomeController::class, 'categoryAo'])->name('products.ao');
    Route::get('/quan', [HomeController::class, 'categoryQuan'])->name('products.quan');
    Route::get('/filter/{category}', [HomeController::class, 'filterProducts'])->name('products.filter');
});

Route::get('/search', [HomeController::class, 'search'])->name('product.search');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('product.category');
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('product.show');
Route::get('/product/detail/{product}', [HomeController::class, 'detail'])->name('product.detail');

// Cart
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// Favorite
Route::post('/favorite/add', [FavoriteController::class, 'add'])->name('favorite.add');

// Checkout
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/buy-now', [CartController::class, 'buyNow'])->name('checkout.buyNow');
    Route::post('/buy', [CartController::class, 'buyNow'])->name('checkout.buy');
});

// Order tracking
Route::get('/orders', [OrderTrackController::class, 'index'])->name('orders.index');

// Profile (User)
Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ====================
// AUTH ROUTES
// ====================
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ====================
// EMAIL VERIFICATION
// ====================
Route::middleware('auth')->group(function () {
    Route::get('/email/verify', fn () => view('auth.verify-email'))->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/');
    })->middleware('signed')->name('verification.verify');

    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware('throttle:6,1')->name('verification.send');
});

// ====================
// ADMIN ROUTES
// ====================
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');

    // Quản lý sản phẩm theo loại
    Route::get('products/manage/ao', [ProductController::class, 'manageAo'])->name('products.manage.ao');
    Route::get('products/manage/quan', [ProductController::class, 'manageQuan'])->name('products.manage.quan');

    // CRUD
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('slides', SlideController::class);

    // ✅ Quản lý quảng cáo
    Route::resource('advertisements', AdvertisementController::class);

    // Orders
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Contacts
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('contacts/{id}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
});