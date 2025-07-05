<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    Auth\AuthenticatedSessionController, ProductController,
    ProfileController, CartController, CheckoutController,
    OrderController, StripeWebhookController
};
use Chatify\Http\Controllers\MessagesController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductReportController;
use Illuminate\Http\Request;

// ==================== Stripe Webhook ====================
Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook'])
    ->name('stripe.webhook')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

// ==================== Redirects ====================
Route::get('/', fn () => redirect()->route('products.index'));

// ==================== Static Pages ====================
Route::view('/about', 'pages.about')->name('about');
Route::view('/terms', 'pages.terms')->name('terms');
Route::view('/privacy', 'pages.privacy')->name('privacy');
Route::view('/faq', 'pages.faq')->name('faq');

// ==================== Products ====================
Route::controller(ProductController::class)->group(function () {
    // Public
    Route::get('/products', 'index')->name('products.index');
    Route::get('/products/{product}', 'show')->name('products.show');

    // Authenticated + Verified
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::post('/products', 'store')->name('products.store');
        Route::get('/my-products', 'myProducts')->name('products.my-products');
        Route::get('/my-products/create', 'create')->name('products.create');
        Route::get('/products/{product}/edit', 'edit')->name('products.edit')->middleware('can:update,product');
        Route::match(['put', 'patch'], '/products/{product}', 'update')->name('products.update')->middleware('can:update,product');
        Route::delete('/products/{product}', 'destroy')->name('products.destroy')->middleware('can:delete,product');
        Route::post('/products/{product}/toggle-status', 'toggleStatus')->name('products.toggleStatus');
    });
});

// ==================== Cart ====================
Route::middleware(['auth', 'verified'])->controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/cart/add/{product}', 'add')->name('cart.add');
    Route::post('/cart/remove/{product}', 'remove')->name('cart.remove');
    Route::post('/cart/clear', 'clear')->name('cart.clear');
});

// ==================== Checkout ====================
Route::middleware(['auth', 'verified', 'throttle:checkout'])->controller(CheckoutController::class)->group(function () {
    Route::get('/checkout', 'index')->name('checkout.index');
    Route::post('/checkout', 'process')->name('checkout.process');
    Route::get('/checkout/success/{order}/{session_id}', 'paymentSuccess')->name('checkout.success');
    Route::get('/checkout/cancel', 'paymentCancel')->name('checkout.cancel');
    Route::post('/checkout/buy-now', 'buyNow')->name('checkout.buyNow');
});

// ==================== Profile ====================
Route::controller(ProfileController::class)->group(function () {
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/profile', 'index')->name('profile.index');
        Route::get('/profile/edit', 'edit')->name('profile.edit');
        Route::post('/profile/avatar', 'updateAvatar')->name('profile.avatar');
        Route::patch('/profile/update', 'update')->name('profile.update');
        Route::put('/password/update', 'updatePassword')->name('profile.password.update');
        //Route::put('/password/update', 'updatePassword')->name('password.update');
    });

    // Public profile
    Route::get('/profile/{user}', 'show')->name('profile.show');
});

// ==================== Orders ====================
Route::middleware(['auth', 'verified'])->controller(OrderController::class)->group(function () {
    Route::get('/orders', 'index')->name('orders.index');
    Route::get('/orders/{order}', 'show')->name('orders.show')->middleware('can:view,order');
});

// ==================== Review ====================
Route::post('/products/{product}/reviews', [ReviewController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('products.reviews.store');

// ==================== Dashboard ====================
Route::middleware(['auth', 'verified'])->get('/dashboard', fn () => view('dashboard'))->name('dashboard');

// ==================== Chat ====================
Route::prefix('chatify')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [MessagesController::class, 'index'])->name('chatify');
    Route::post('/openChat/{id}', [MessagesController::class, 'openChat'])->name('chatify.open');
    Route::get('/{id}', [MessagesController::class, 'show'])->name('chatify.show');
});

// ==================== Notification ====================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/mark-as-read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
});

// ==================== Product Report ====================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/products/{product}/report', [ProductReportController::class, 'create'])->name('report.product.form');
    Route::post('/report/product', [ProductReportController::class, 'store'])->name('report.product');
});

Route::get('/manual-verify', function (Request $request) {
    if ($request->user() && !$request->user()->hasVerifiedEmail()) {
        $request->user()->markEmailAsVerified();
    }
    return redirect('/products');
})->middleware('auth')->name('manual.verify');

// ==================== Logout ====================
Route::middleware('auth')->post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// ==================== Auth Routes ====================
require __DIR__.'/auth.php';
