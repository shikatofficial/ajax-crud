<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return redirect()->route("products.index");
// });

Route::get('/', function () {
    return view("welcome");
});

Route::resource('products', ProductController::class);
// Route::post('/products/{id}', [ProductController::class, 'update'])->name('products.update');
