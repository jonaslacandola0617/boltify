<?php

use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\EnsurePaymentSuccess;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function (Request $request) {
    $categories = Category::query()->orderBy('name')->get();
    $search = trim((string) $request->input('search'));
    $filter = array_values(array_filter((array) $request->input('categories', [])));
    $minPrice = $request->filled('min_price') ? max(0, (float) $request->input('min_price')) : null;
    $maxPrice = $request->filled('max_price') ? max(0, (float) $request->input('max_price')) : null;
    $sort = (string) $request->input('sort', 'newest');

    $query = Product::query()->with('category')
        ->when($search, fn ($query) => $query->where('name', 'like', "%{$search}%"))
        ->when($filter, fn ($query) => $query->whereIn('categoryId', $filter))
        ->when($minPrice !== null, fn ($query) => $query->where('price', '>=', $minPrice))
        ->when($maxPrice !== null, fn ($query) => $query->where('price', '<=', $maxPrice));

    match ($sort) {
        'price_low' => $query->orderBy('price'),
        'price_high' => $query->orderByDesc('price'),
        'name' => $query->orderBy('name'),
        default => $query->latest(),
    };

    $products = $query->paginate(12)->withQueryString();

    return view('feed', compact('products','categories','filter','minPrice','maxPrice','sort','search'));
})->name('feed');

Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/success', [CheckoutController::class, 'success'])->middleware(EnsurePaymentSuccess::class)->name('success');

    Route::resource('order', OrderController::class)->only(['index', 'show', 'update']);
    Route::post('/order/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');

    Route::controller(CartController::class)->group(function () {
        Route::post('/cart', 'store')->name('cart.store');
        Route::get('/cart/{cart}', 'show')->name('cart.show');
        Route::put('/cart/{cart}', 'update')->name('cart.update');
    });
});

Route::middleware(['auth', 'verified', 'admin'])->prefix('admin')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.overview'))->name('admin');
    Route::get('/overview', [AdminController::class, 'overview'])->name('admin.overview');

    Route::controller(ProductController::class)->group(function () {
        Route::get('/product', 'index')->name('admin.product.index');
        Route::post('/product', 'store')->name('admin.product.store');
        Route::get('/product/{product}/edit', 'edit')->name('admin.product.edit');
        Route::put('/product/{product}', 'update')->name('admin.product.update');
        Route::delete('/product/{product}', 'destroy')->name('admin.product.delete');
    });

    Route::get('/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('admin.orders.show');
    Route::post('/orders/{order}/refund', [AdminOrderController::class, 'refund'])->name('admin.orders.refund');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users.index');
    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('admin.categories.store');
    Route::delete('/categories/{category}', [AdminCategoryController::class, 'destroy'])->name('admin.categories.delete');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
