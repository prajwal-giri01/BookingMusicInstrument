<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\instrumentsController;
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
});

// ✅ User Dashboard (Only Authenticated Users)
Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::put('/cart/update/{id}', [CartController::class, 'updateCart'])->name('cart.update');
    Route::delete('/cart/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    Route::put('/cart/update-date/{id}', [CartController::class, 'updateDate'])->name('cart.updateDate');


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

    //Drink
    Route::get('instruments', [instrumentsController::class, 'index'])->name('instruments.index');
    Route::get('instruments/create', [instrumentsController::class, 'create'])->name('instruments.create');
    Route::post('instruments', [instrumentsController::class, 'store'])->name('instruments.store');
    Route::get('instruments/{id}/edit', [instrumentsController::class, 'edit'])->name('instruments.edit');
    Route::put('instruments/{id}', [instrumentsController::class, 'update'])->name('instruments.update');
    Route::delete('instruments/{id}', [instrumentsController::class, 'destroy'])->name('instruments.destroy');
});

