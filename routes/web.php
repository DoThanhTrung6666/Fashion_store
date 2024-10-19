<?php


use App\Http\Controllers\admin\ColorController;

use App\Http\Controllers\Admin\BannerController;

use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\thongkeController;
use App\Http\Controllers\auth\AuthenticationController;
use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\DetailController;
use App\Http\Controllers\client\HomeController;

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

// bên admin
Route::prefix('admin')
->as('admin.')
->group(function(){
    Route::get('/', [thongkeController::class, 'index']);
    Route::resource('banners', BannerController::class);
    // Route::get('/admin', [thongkeController::class, 'index']);
    Route::resource('products', ProductController::class);

    Route::resource('sizes', SizeController::class);
    Route::resource('colors', ColorController::class);

    Route::resource('brands', BrandController::class);
    Route::resource('categories', CategoryController::class);
    Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
})->middleware(['auth','admin']);


// bên client
Route::get('/home',[HomeController::class,'getProductHome'])->name('home');
Route::get('detail/{id}',[DetailController::class,'show'])->name('detail.show');


Route::get('login',[AuthenticationController::class,'showFormLogin'])->name('login');
Route::post('login',[AuthenticationController::class,'login']);
Route::get('register',[AuthenticationController::class,'showFormRegister'])->name('register');
Route::post('register',[AuthenticationController::class,'register']);
Route::post('logout',[AuthenticationController::class,'logout'])->name('logout');


Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');


