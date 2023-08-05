<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/category', [App\Http\Controllers\CategoryController::class, 'storeCategory'])->name('store_category');
Route::get('/get-category', [App\Http\Controllers\CategoryController::class, 'getCategoryUsingAjax']);
Route::get('/view-category', [App\Http\Controllers\CategoryController::class, 'viewCategory'])->name('view_category');
Route::get('/sub-category-datatables', [App\Http\Controllers\CategoryController::class, 'subCategory'])->name('subCategory');
Route::get('/delete-category/{id}', [App\Http\Controllers\CategoryController::class, 'deleteCategory'])->name('category-delete');


Route::post('/sub-category', [App\Http\Controllers\SubCategoryController::class, 'SubCategoryStore'])->name('store_sub_category');
Route::get('/view-sub-category', [App\Http\Controllers\SubCategoryController::class, 'viewSubCategory'])->name('view_sub_category');
Route::get('/delete-sub-category/{id}', [App\Http\Controllers\SubCategoryController::class, 'deleteSubCategory'])->name('sub_category_delete');

Route::post('/products', [App\Http\Controllers\productsController::class, 'productsStore'])->name('store_products');
Route::get('/get-sub-category', [App\Http\Controllers\productsController::class, 'getsubCategoryUsingAjax']);
Route::get('/view-products', [App\Http\Controllers\productsController::class, 'viewProducts'])->name('view_products');
