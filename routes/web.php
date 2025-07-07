<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\instrumentsController;
use App\Http\Controllers\KhaltiPaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\SliderImageController;

// ✅ Public Pages (Accessible to Everyone)
Route::controller(PageController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/detail/{instruments}', 'instrumentDetail')->name('detail');
    Route::get('/instruments/{instruments}', 'instruments')->name('instruments');
    Route::get('/search', 'search')->name('search');
});
Route::post('/khalti/purchase', [KhaltiPaymentController::class, 'purchase'])->name('khalti.purchase');
Route::get('/verify-payment', [KhaltiPaymentController::class, 'verifyPayment']);
// ✅ User Dashboard (Only Authenticated Users)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/custom-packages', [PackageController::class, 'packages'])->name('custom-packages.index');
    Route::get('/custom-packages/create', [PackageController::class, 'create'])->name('custom-packages.create');
    Route::post('/custom-packages', [PackageController::class, 'store'])->name('custom-packages.store');
    Route::get('/custom-packages/{id}/edit', [PackageController::class, 'edit'])->name('custom-packages.edit');
    Route::put('/custom-packages/{id}', [PackageController::class, 'update'])->name('custom-packages.update');
    Route::delete('/custom-packages/{id}', [PackageController::class, 'destroy'])->name('custom-packages.destroy');
    Route::post('/custom-packages/{id}/add-instruments', [PackageController::class, 'addInstruments'])->name('custom-packages.add-instruments');
    Route::delete('/custom-packages/{packageId}/remove-instrument/{itemId}', [PackageController::class, 'removeInstrument'])->name('custom-packages.remove-instrument');

    Route::post('/custom-packages/{id}/rent', [PackageController::class, 'rentNow'])->name('custom-packages.rent');
    Route::get('/checkout/package', [OrderController::class, 'checkoutCustom'])->name('checkout.direct');

    Route::post('/order/{order}/payment', [PaymentController::class, 'process'])->name('order.payment.process');


    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/updateDate/{id}', [CartController::class, 'updateDate'])->name('cart.updateDate');
    Route::post('/order/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');


    // Order/Checkout routes
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/complete', [OrderController::class, 'store'])->name('checkout.store');
    Route::get('/order/confirmation/{order}', [OrderController::class, 'confirmation'])->name('order.confirmation');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/order/{order}', [OrderController::class, 'show'])->name('order.show');


    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ✅ User Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });
});

// ✅ Authentication Routes (Register, Login, Logout)
require __DIR__.'/auth.php';

// ✅ Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->name('admin.logout');
});

// ✅ Admin Routes (Only Accessible to Admins)
Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    // Admin Dashboard Route
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Admin Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [AdminProfileController::class, 'edit'])->name('edit');  // This is `admin.profile.edit`
        Route::put('/', [AdminProfileController::class, 'update'])->name('update');
    });
});

Route::prefix('admin')->name('admin.')->group(function () {
    //slider
    Route::get('sliders', [SliderImageController::class, 'index'])->name('sliders.index');
    Route::get('sliders/create', [SliderImageController::class, 'create'])->name('sliders.create');
    Route::post('sliders', [SliderImageController::class, 'store'])->name('sliders.store');
    Route::get('sliders/{id}/edit', [SliderImageController::class, 'edit'])->name('sliders.edit');
    Route::put('sliders/{id}', [SliderImageController::class, 'update'])->name('sliders.update');
    Route::delete('sliders/{id}', [SliderImageController::class, 'destroy'])->name('sliders.destroy');

    //category
    Route::get('category', [CategoryController::class, 'index'])->name('category.index');
    Route::get('category/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('category', [CategoryController::class, 'store'])->name('category.store');
    Route::get('category/{id}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('category/{id}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('category/{id}', [CategoryController::class, 'destroy'])->name('category.destroy');

    //instrument
    Route::get('instruments', [instrumentsController::class, 'index'])->name('instruments.index');
    Route::get('instruments/create', [instrumentsController::class, 'create'])->name('instruments.create');
    Route::post('instruments', [instrumentsController::class, 'store'])->name('instruments.store');
    Route::get('instruments/{id}/edit', [instrumentsController::class, 'edit'])->name('instruments.edit');
    Route::put('instruments/{id}', [instrumentsController::class, 'update'])->name('instruments.update');
    Route::delete('instruments/{id}', [instrumentsController::class, 'destroy'])->name('instruments.destroy');

    //bookings
    Route::get('bookings', [BookingController::class, 'index'])->name('booking.index');
    Route::get('bookings/{id}', [BookingController::class, 'show'])->name('booking.show');
    Route::get('bookings/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
    Route::put('bookings/{id}', [BookingController::class, 'update'])->name('booking.update');
    Route::delete('bookings/{id}', [BookingController::class, 'destroy'])->name('booking.destroy');
});

