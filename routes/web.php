<?php

use App\Http\Controllers\admin\AdOrderController;
use App\Http\Controllers\admin\ColorController;

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\admin\FlashSaleAllController;
use App\Http\Controllers\admin\FlashSaleController;
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
        // Route::resource('/flash-sales',FlashSaleController::class);
        // Route::resource('/flash-salesAll',FlashSaleAllController::class);
        // // kết thúc flash sale
        // Route::get('/flash-sale/select', [FlashSaleController::class, 'createSelectFlashSale'])->name('flash-sale.select');
        // Route::post('/flash-sale/select', [FlashSaleController::class, 'storeSelectFlashSale'])->name('storeSelectFlashSale'); // Dùng POST khi chọn sản phẩm
        // Route::get('/flash-sale/create', [FlashSaleController::class, 'createFlashSale'])->name('flash-sale.create');
        // Route::post('/flash-sale/store', [FlashSaleController::class, 'storeFlashSale'])->name('flash-sale.store');
        Route::get('/select-products', [FlashSaleController::class, 'selectProducts'])->name('select_products');
        Route::post('/save-selected-products', [FlashSaleController::class, 'saveSelectedProduct'])->name('save_selected_products');
        Route::get('/prepare', [FlashSaleController::class, 'prepareFlashSale'])->name('prepare');
        Route::post('/apply', [FlashSaleController::class, 'applyFlashSale'])->name('apply');
        Route::get('all-flash-sale', [FlashSaleController::class, 'index'])->name('all_flash_sale');
        Route::delete('/{id}', [FlashSaleController::class, 'delete'])->name('delete');
    });



// bên client
Route::get('/home', [HomeController::class, 'getProductHome'])->name('home');
Route::get('detail/{id}', [DetailController::class, 'show'])->name('detail.show');


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
