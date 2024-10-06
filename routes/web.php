<?php
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\admin\thongkeController;
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

Route::get('/admin',[thongkeController::class,'index']);


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
});
Route::resource('banners', BannerController::class);

