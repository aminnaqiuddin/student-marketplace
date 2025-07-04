<?php

use Illuminate\Support\Facades\Route;

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\CRUD.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => array_merge(
        (array) config('backpack.base.web_middleware', 'web'),
        (array) config('backpack.base.middleware_key', 'admin')
    ),
    'namespace' => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('user', 'UserCrudController');
    Route::crud('product', 'ProductCrudController');
    Route::crud('order', 'OrderCrudController');
    Route::crud('category', 'CategoryCrudController');
    Route::crud('product-image', 'ProductImageCrudController');
    Route::crud('product-report', 'ProductReportCrudController');
    Route::crud('review', 'ReviewCrudController');
    Route::crud('cart-item', 'CartItemCrudController');
    Route::crud('order-item', 'OrderItemCrudController');
    Route::crud('ch-favorite', 'ChFavoriteCrudController');
    Route::crud('ch-message', 'ChMessageCrudController');
}); // this should be the absolute last line of this file

/**
 * DO NOT ADD ANYTHING HERE.
 */
