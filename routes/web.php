<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [AuthController::class, 'showRegister']);

Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth')->group(function () {

    Route::get('/product', [ProductController::class, 'index']);

    Route::get('/product_search', [ProductController::class, 'searchByName']);

    Route::get('/product_filter_category/{id}', [ProductController::class, 'fileterProductByCategory']);

    Route::get('//product_orderBy_price/asc', [ProductController::class, 'ProductOrderByAsc']);

    Route::get('/product_orderBy_price/desc', [ProductController::class, 'ProductOrderByDesc']);

    Route::get('/product_price_range', [ProductController::class, 'ProductPriceRange']);

    Route::get('/product/{id}', [ProductController::class, 'showProduct']);

    Route::get('/logout', [AuthController::class, 'logout']);

    Route::get('/product_preview', [ProductController::class, 'preview']);

    Route::get('/cart',[CartController::class,'index']);

    Route::get('/cart_addToCart/{id}',[CartController::class,'addToCart']);

    Route::get('/cart_update/{id}/{action}',[CartController::class,'cartUpdate']);

    Route::get('/cart_remove/{id}',[CartController::class,'remove']);

});

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'dashboard']);

    Route::get('/category', [CategoryController::class, 'index']);

    Route::get('/category_create', [CategoryController::class, 'showCreateCategory']);

    Route::post('/category_create', [CategoryController::class, 'createCategory']);

    Route::get('/category_edit/{id}', [CategoryController::class, 'showEditCategory']);

    Route::post('/category_edit/{id}', [CategoryController::class, 'updateCategory']);

    Route::get('/category_delete/{id}', [CategoryController::class, 'destroy']);

    Route::get('/product_create', [ProductController::class, 'showCreateProduct']);

    Route::post('/product_create', [ProductController::class, 'createProduct']);

    Route::get('/product_edit/{id}', [ProductController::class, 'showeditProduct']);

    Route::post('/product_edit/{id}', [ProductController::class, 'updateProduct']);

    Route::get('/product_delete/{id}', [ProductController::class, 'destroy']);

    Route::get('/product/image/delete/{id}', [ProductController::class, 'deleteImage']);

    Route::post('/product/bulk-action', [ProductController::class, 'bulkAction']);

    Route::post('/product/bulk-action/delete',[ProductController::class,'bulkDelete']);

    Route::get('/product_duplicate/{id}', [ProductController::class, 'duplicateCreate']);

    Route::get('/product_trash', [ProductController::class, 'showTrash']);

    Route::get('/product_restore/{id}', [ProductController::class, 'productRestore']);

    Route::get('/product_forceDelete/{id}', [ProductController::class, 'productForceDelete']);

    Route::get('/product_export', [ProductController::class, 'export'])->name('product.export');

    Route::get('/product_orderBy_status/{status}', [ProductController::class, 'orderByStatus']);
});