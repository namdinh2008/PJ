<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsAdmin;

// Admin Controllers
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CarController;
use App\Http\Controllers\Admin\CarModelController;
use App\Http\Controllers\Admin\CarVariantController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CartItemController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AccessoryController;
use App\Http\Controllers\Admin\OrderLogController;


// Public Controllers
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\UserOrderController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\UserCarVariantController;
use App\Http\Controllers\User\AccessoryController as UserAccessoryController;


// --- Trang chủ ---
Route::get('/', [HomeController::class, 'index'])->name('home');

// --- Dashboard cho user ---
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Wishlist (User)
Route::prefix('wishlist')->name('wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/add', [WishlistController::class, 'add'])->name('add');
    Route::post('/remove', [WishlistController::class, 'remove'])->name('remove');
    Route::post('/clear', [WishlistController::class, 'clear'])->name('clear');
    Route::get('/check', [WishlistController::class, 'check'])->name('check');
    Route::get('/count', [WishlistController::class, 'getCount'])->name('count');
})->middleware('migrate.wishlist');

// Carvariant detail (User)
Route::get('/car-variants/{id}', [UserCarVariantController::class, 'show'])->name('car_variants.show');

// Accessory detail (User)
Route::get('/accessories/{id}', [UserAccessoryController::class, 'show'])->name('accessories.show');

// Test route for debugging
Route::get('/test-variant/{id}', function($id) {
    $variant = \App\Models\CarVariant::with('product')->find($id);
    if ($variant) {
        echo "Variant: " . $variant->name . "<br>";
        echo "Product: " . ($variant->product ? $variant->product->name : 'No product') . "<br>";
        echo "Product ID: " . ($variant->product ? $variant->product->id : 'No ID') . "<br>";
    } else {
        echo "Variant not found";
    }
});

// Test wishlist route
Route::get('/test-wishlist', function() {
    try {
        $wishlist = new \App\Models\Wishlist();
        echo "Wishlist model created successfully<br>";
        echo "Table name: " . $wishlist->getTable() . "<br>";
        
        $count = \App\Models\Wishlist::count();
        echo "Wishlist count: " . $count . "<br>";
        
        echo "Wishlist table exists and is working!";
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
});

// --- Profile cá nhân ---
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/order', [UserOrderController::class, 'store'])->name('order.store');

// Cart
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index'); // Xem giỏ hàng
    Route::get('/count', [CartController::class, 'getCount'])->name('count'); // Lấy số lượng cart
    Route::post('/add', [CartController::class, 'add'])->name('add'); // Thêm vào giỏ
    Route::post('/update/{cartItem}', [CartController::class, 'update'])->name('update'); // Cập nhật số lượng
    Route::delete('/remove/{cartItem}', [CartController::class, 'remove'])->name('remove'); // Xóa khỏi giỏ
    Route::post('/clear', [CartController::class, 'clear'])->name('clear'); // Xóa toàn bộ giỏ
});

// --- Cart routes ---
Route::get('/cart/checkout', [CartController::class, 'showCheckoutForm'])->name('cart.checkout.form');
Route::post('/cart/checkout', [CartController::class, 'processCheckout'])->name('cart.checkout');

// --- Admin routes ---
Route::middleware(['auth', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Car
    Route::prefix('cars')->name('cars.')->group(function () {
        Route::get('/', [CarController::class, 'index'])->name('index');
        Route::get('/create', [CarController::class, 'create'])->name('create');
        Route::post('/store', [CarController::class, 'store'])->name('store');
        Route::get('/edit/{car}', [CarController::class, 'edit'])->name('edit');
        Route::put('/update/{car}', [CarController::class, 'update'])->name('update');
        Route::delete('/delete/{car}', [CarController::class, 'destroy'])->name('destroy');
    });

    // Car Models
    Route::prefix('carmodels')->name('carmodels.')->group(function () {
        Route::get('/', [CarModelController::class, 'index'])->name('index');
        Route::get('/create', [CarModelController::class, 'create'])->name('create');
        Route::post('/store', [CarModelController::class, 'store'])->name('store');
        Route::get('/edit/{carmodel}', [CarModelController::class, 'edit'])->name('edit');
        Route::put('/update/{carmodel}', [CarModelController::class, 'update'])->name('update');
        Route::delete('/delete/{carmodel}', [CarModelController::class, 'destroy'])->name('destroy');
    });

    // Car Variants
    Route::prefix('carvariants')->name('carvariants.')->group(function () {
        Route::get('/', [CarVariantController::class, 'index'])->name('index');
        Route::get('/create', [CarVariantController::class, 'create'])->name('create');
        Route::post('/store', [CarVariantController::class, 'store'])->name('store');
        Route::get('/edit/{carvariant}', [CarVariantController::class, 'edit'])->name('edit');
        Route::put('/update/{carvariant}', [CarVariantController::class, 'update'])->name('update');
        Route::delete('/delete/{carvariant}', [CarVariantController::class, 'destroy'])->name('destroy');
    });

    // Accessories
    Route::prefix('admin/accessories')->name('admin.accessories.')->group(function () {
        Route::get('/', [AccessoryController::class, 'index'])->name('index');
        Route::get('/create', [AccessoryController::class, 'create'])->name('create');
        Route::post('/', [AccessoryController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AccessoryController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AccessoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [AccessoryController::class, 'destroy'])->name('destroy');
    });

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/store', [OrderController::class, 'store'])->name('store');
        Route::get('/edit/{order}', [OrderController::class, 'edit'])->name('edit');
        Route::put('/update/{order}', [OrderController::class, 'update'])->name('update');
        Route::delete('/delete/{order}', [OrderController::class, 'destroy'])->name('destroy');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/logs', [\App\Http\Controllers\Admin\OrderLogController::class, 'logs'])->name('logs');

        // Chuyển trạng thái đơn
        Route::post('/{order}/next-status', [OrderController::class, 'nextStatus'])->name('nextStatus');
        Route::post('/{order}/cancel', [OrderController::class, 'cancel'])->name('cancel');

        // Logs
        Route::get('/{order}/logs', [OrderLogController::class, 'index'])->name('logs');
    });
    // Products
    Route::prefix('products')->name('products.')->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('index');
        Route::get('/create', [ProductController::class, 'create'])->name('create');
        Route::post('/store', [ProductController::class, 'store'])->name('store');
        Route::get('/edit/{product}', [ProductController::class, 'edit'])->name('edit');
        Route::put('/update/{product}', [ProductController::class, 'update'])->name('update');
        Route::delete('/delete/{product}', [ProductController::class, 'destroy'])->name('destroy');
    });

    // Accessories
    Route::prefix('accessories')->name('accessories.')->group(function () {
        Route::get('/', [AccessoryController::class, 'index'])->name('index');
        Route::get('/create', [AccessoryController::class, 'create'])->name('create');
        Route::post('/store', [AccessoryController::class, 'store'])->name('store');
        Route::get('/edit/{accessory}', [AccessoryController::class, 'edit'])->name('edit');
        Route::put('/update/{accessory}', [AccessoryController::class, 'update'])->name('update');
        Route::delete('/delete/{accessory}', [AccessoryController::class, 'destroy'])->name('destroy');
    });

    // Cart Items
    Route::prefix('cartitems')->name('cartitems.')->group(function () {
        Route::get('/', [CartItemController::class, 'index'])->name('index');
        Route::delete('/delete/{cartitem}', [CartItemController::class, 'destroy'])->name('destroy');
    });

    // Blogs
    Route::prefix('blogs')->name('blogs.')->group(function () {
        Route::get('/', [BlogController::class, 'index'])->name('index');
        Route::get('/create', [BlogController::class, 'create'])->name('create');
        Route::post('/store', [BlogController::class, 'store'])->name('store');
        Route::get('/edit/{blog}', [BlogController::class, 'edit'])->name('edit');
        Route::put('/update/{blog}', [BlogController::class, 'update'])->name('update');
        Route::delete('/delete/{blog}', [BlogController::class, 'destroy'])->name('destroy');
    });

    // Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{user}', [UserController::class, 'destroy'])->name('destroy');
    });
});

// Trang chi tiết model xe
Route::get('/car-models/{id}', [\App\Http\Controllers\User\CarModelController::class, 'show'])->name('car_models.show');

// --- Auth routes ---
require __DIR__ . '/auth.php';