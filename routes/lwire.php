<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Product\AddProduct;
use App\Http\Livewire\Product\AllProducts;

Route::group(['middleware' => 'auth'], function () {

    // Products
    Route::get('/products', AllProducts::class)->name('products');
    Route::get('/add-product', AddProduct::class);
    Route::get('/product/{id}/edit', AddProduct::class);
});