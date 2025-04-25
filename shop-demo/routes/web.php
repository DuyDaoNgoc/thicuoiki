<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

// Controllers
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
use App\Http\Controllers\AdvertisementController;

// ==============================
// 🌐 FRONTEND ROUTES
// ==============================

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home.redirect');

// Quảng cáo
Route::get('/quang-cao/dang-hoat-dong', [AdvertisementController::class, 'getActiveAdvertisements'])->name('advertisements.active');

// Sản phẩm
Route::prefix('products')->group(function () {
    Route::get('/', [HomeController::class, 'allProducts'])->name('products');
    Route::get('/ao', [HomeController::class, 'categoryAo'])->name('products.ao');
    Route::get('/quan', [HomeController::class, 'categoryQuan'])->name('products.quan');
    Route::get('/filter/{category}', [HomeController::class, 'filterProducts'])->name('products.filter');
    Route::get('/search', [HomeController::class, 'search'])->name('products.search');
    Route::get('/view/{slug}', [HomeController::class, 'show'])->name('product.slug.show');
});

// Tìm kiếm toàn bộ shop
Route::get('/shop/search', [HomeController::class, 'search'])->name('shop.search');

// Chi tiết sản phẩm (các kiểu)
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.id.show');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product/detail/{product}', [HomeController::class, 'detail'])->name('product.detail');
Route::get('/product/show/{id}', [ProductController::class, 'show'])->name('product.show'); // thêm nếu cần

// ==============================
// 🛒 GIỎ HÀNG
// ==============================
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
});

// ==============================
// 💖 YÊU THÍCH
// ==============================
Route::post('/favorite/add', [FavoriteController::class, 'add'])->name('favorite.add');
// ==============================
/// ==============================
// 💳 THANH TOÁN
// ==============================
Route::prefix('checkout')->group(function () {
    // Trang thanh toán (GET)
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index'); // ✅ sửa tên route

    // Xử lý thanh toán sau khi submit (POST)
    Route::post('/', [CheckoutController::class, 'process'])->name('checkout.process');

    // Mua ngay không cần thêm vào giỏ (POST)
    Route::post('/buy-now', [CartController::class, 'buyNow'])->name('checkout.buyNow');

    // Tùy chọn khác cho "buy" (POST)
    Route::post('/buy', [CartController::class, 'buyNow'])->name('checkout.buy');
});


    
// ==============================
// 📦 ĐƠN HÀNG NGƯỜI DÙNG
// ==============================
Route::get('/orders', [OrderTrackController::class, 'index'])->name('orders.index');

// ==============================
// 👤 HỒ SƠ NGƯỜI DÙNG
// ==============================
Route::middleware('auth')->prefix('profile')->group(function () {
    Route::get('/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    Route::delete('/destroy', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ==============================
// 🔐 AUTH ROUTES
// ==============================

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ==============================
// 📧 EMAIL VERIFICATION
// ==============================

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

// ==============================
// 🛠️ ADMIN ROUTES
// ==============================

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::view('/', 'admin.dashboard')->name('dashboard');

    // Quản lý sản phẩm
    Route::get('products/manage/ao', [ProductController::class, 'manageAo'])->name('products.manage.ao');
    Route::get('products/manage/quan', [ProductController::class, 'manageQuan'])->name('products.manage.quan');

    // Tìm kiếm sản phẩm trong admin
    Route::get('products/search', [ProductController::class, 'search'])->name('products.search');

    // CRUD
    Route::resource('products', ProductController::class);
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('slides', SlideController::class);
    Route::resource('advertisements', AdvertisementController::class);
    // Cập nhật quyền
    Route::post('users/{id}/make-admin', [UserController::class, 'makeAdmin'])->name('users.makeAdmin');

    // Đơn hàng
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');

    // Liên hệ
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::post('contacts/{id}/reply', [ContactController::class, 'reply'])->name('contacts.reply');
});