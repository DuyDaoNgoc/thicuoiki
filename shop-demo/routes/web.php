<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderTrackController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\ContactController;

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisteredUserController;

// ====================
// FRONTEND ROUTES
// ====================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

Route::get('/products', [HomeController::class, 'allProducts'])->name('products');
Route::get('/products/ao', [HomeController::class, 'categoryAo'])->name('products.ao');
Route::get('/products/quan', [HomeController::class, 'categoryQuan'])->name('products.quan');
Route::get('/search', [HomeController::class, 'search'])->name('product.search');
Route::get('/category/{slug}', [HomeController::class, 'category'])->name('product.category');
Route::get('/product/{slug}', [HomeController::class, 'show'])->name('product.show');
Route::get('/product/detail/{product}', [HomeController::class, 'detail'])->name('product.detail');
Route::get('/products/filter/{category}', [HomeController::class, 'filterProducts'])->name('products.filter');

// ====================
// CART
// ====================
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// ====================
// FAVORITE
// ====================
Route::post('/favorite/add', [FavoriteController::class, 'add'])->name('favorite.add');

// ====================
// CHECKOUT
// ====================
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/buy-now', [CartController::class, 'buyNow'])->name('checkout.buy');
});

// ====================
// ORDER TRACKING
// ====================
Route::get('/orders', [OrderTrackController::class, 'index'])->name('orders.index');

// ====================
// PROFILE (User)
// ====================
Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
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
// EMAIL VERIFICATION ROUTES
// ====================
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/'); // Hoặc redirect('/dashboard')
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// ====================
// ADMIN ROUTES (BACKEND)
// ====================
Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => view('admin.dashboard'))->name('dashboard');

    // Quản lý sản phẩm theo loại
    Route::get('products/manage/ao', [ProductController::class, 'manageAo'])->name('products.manage.ao');
    Route::get('products/manage/quan', [ProductController::class, 'manageQuan'])->name('products.manage.quan');

    // CRUD sản phẩm
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('products', [ProductController::class, 'store'])->name('products.store');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    // CRUD quản lý khác
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('slides', SlideController::class);

    // Đơn hàng
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Liên hệ
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('contacts/{id}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
});