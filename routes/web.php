<?php

use App\Http\Controllers\admin\AdOrderController;
use App\Http\Controllers\admin\ColorController;

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\admin\FlashSaleOneController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SaleController;
use App\Http\Controllers\admin\SizeController;
use App\Http\Controllers\admin\thongkeController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\auth\AuthenticationController;
use App\Http\Controllers\auth\FilterController;
use App\Http\Controllers\BrandController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\CheckoutController;
use App\Http\Controllers\client\DetailController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\client\SearchController;
use App\Http\Controllers\CommentController;



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


Route::get('/', [HomeController::class, 'getProductHome']);
// bên admin
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->as('admin.')
    ->group(function () {
        Route::get('/', [thongkeController::class, 'index']);
        Route::resource('banners', BannerController::class);
        // Route::get('/admin', [thongkeController::class, 'index']);
        Route::resource('products', ProductController::class);

        Route::resource('sizes', SizeController::class);
        Route::resource('colors', ColorController::class);

        Route::resource('brands', BrandController::class);
        Route::put('brands/{brand}/update-status', [BrandController::class, 'updateStatus'])->name('brands.updateStatus');

        Route::resource('categories', CategoryController::class);
        Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');


        Route::get('/orders', [AdOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/pending', [AdOrderController::class, 'pendingOrders'])->name('orders.pending');
        Route::get('/orders/confirmed', [AdOrderController::class, 'confirmedOrders'])->name('orders.confirmed');
        Route::get('/orders/shipping', [AdOrderController::class, 'shippingOrders'])->name('orders.shipping');
        Route::get('/orders/delivered', [AdOrderController::class, 'deliveredOrders'])->name('orders.delivered');
        Route::get('/orders/canceled', [AdOrderController::class, 'canceledOrders'])->name('orders.canceled');
        Route::get('/orders/{id}', [AdOrderController::class, 'show'])->name('orders.show');

        Route::post('/orders/{id}/status', [AdOrderController::class, 'updateStatus'])->name('orders.updateStatus');



        Route::get('/comments', [CommentController::class, 'index'])->name('comment.index');
        Route::get('/comments/{id}', [CommentController::class, 'show'])->name('comment.show');
        Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
        Route::resource('users',UserController::class);

        // dành cho quản lí flash sale bên phía admin
        Route::resource('/sales',SaleController::class);

        //dành cho flashsale
        Route::get('list-product-flash-sale', [FlashSaleOneController::class, 'listProductFlashSale'])->name('listProductFlashSale');
        Route::get('list-flash-sale', [FlashSaleOneController::class, 'listFlashSale'])->name('listFlashSale');
        Route::get('create-flash-sale', [FlashSaleOneController::class, 'createFlashSale'])->name('createFlashSale');
        Route::post('store-flash-sale', [FlashSaleOneController::class, 'storeFlashSale'])->name('storeFlashSale');
        Route::get('{flashSaleId}/add-products', [FlashSaleOneController::class, 'addProductsToFlashSale'])->name('add_products');
        Route::post('{flashSaleId}/save-products', [FlashSaleOneController::class, 'saveProductsToFlashSale'])->name('save_products');
        // load những sản phẩm liên quan flash-sale
        Route::get('flash-sale/{flashSaleId}/products', [FlashSaleOneController::class, 'splienquan'])->name('view_products');
        //Xoá sản phẩm liên quan flash-sale mình thích
        Route::delete('flash-sale/{flashSaleId}/product/{productId}', [FlashSaleOneController::class, 'deleteProduct'])->name('delete_product');
    });



// bên client
Route::get('/home', [HomeController::class, 'getProductHome'])->name('home');
Route::get('detail/{id}', [DetailController::class, 'show'])->name('detail.show');
Route::post('/product/{id}/comment', [DetailController::class, 'storeComment'])->name('storeComment');


Route::get('login', [AuthenticationController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthenticationController::class, 'login']);
Route::get('register', [AuthenticationController::class, 'showFormRegister'])->name('register');
Route::post('register', [AuthenticationController::class, 'register']);
Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::resource('profile',AuthenticationController::class);



Route::get('/danhmucsp', [FilterController::class, 'danhmucsp'])->name('danhmucsp');

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/cart', [CartController::class, 'index'])->name('cart.load');
Route::delete('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('checkout', [CheckoutController::class, 'viewCheckout'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'Order'])->name('checkout.order');
Route::get('thankyou', [CheckoutController::class, 'thankyou'])->name('thankyou');




Route::get('checkout',[CheckoutController::class,'viewCheckout'])->name('checkout');
Route::post('/checkout', [OrderController::class, 'Order'])->name('checkout.order');
Route::get('thankyou',[CheckoutController::class,'thankyou'])->name('thankyou');
Route::get('/orders', [OrderController::class,'loadOrderUser'])->name('orders.loadUser');



Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
Route::post('/orders/{orderId}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
Route::get('order/repurchase/{orderId}', [OrderController::class, 'repurchase'])->name('order.repurchase');

// tìm kiếm sản phẩm
Route::get('/search', [SearchController::class, 'search'])->name('products.search');
