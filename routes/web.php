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
use App\Http\Controllers\client\FavoriteController;
use App\Http\Controllers\client\HomeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\client\SearchController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VoucherController;
use App\Models\Order;

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

Route::get('/', [HomeController::class, 'getProductHome'])->name('home');

// bên admin
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->as('admin.')
    ->group(function () {
        Route::get('/statistics', [thongkeController::class, 'index'])->name('statistics.index');
        Route::post('/statistics/revenue', [thongkeController::class, 'revenue'])->name('statistics.revenue');
        Route::post('/statistics/top-users', [thongkeController::class, 'topUsers'])->name('statistics.topUsers');
        Route::post('/statistics/top-products', [thongkeController::class, 'topProducts'])->name('statistics.topProducts');
        Route::post('/statistics/orders-summary', [thongkeController::class, 'ordersSummary'])->name('statistics.ordersSummary');
        Route::resource('banners', BannerController::class);
        // Route::get('/admin', [thongkeController::class, 'index']);
        Route::resource('products', ProductController::class);
        // trạng thái ngừng bán
        Route::patch('/product/{id}/update-status', [ProductController::class, 'updateStatus'])->name('product.updateStatus');
        // danh sách sản phẩm ngừnh kinh doanh
        Route::get('list-product-end', [ProductController::class, 'listEndProduct'])->name('listEndProduct');
        Route::resource('sizes', SizeController::class);
        Route::resource('colors', ColorController::class);

        Route::resource('brands', BrandController::class);
        Route::put('brands/{brand}/update-status', [BrandController::class, 'updateStatus'])->name('brands.updateStatus');

        Route::resource('categories', CategoryController::class);
        Route::post('/categories/create', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');



        Route::get('/orders', [AdOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{id}', [AdOrderController::class, 'show'])->name('orders.show');

        Route::get('/order/update-status/{order}', [AdOrderController::class, 'update'])->name('order.update');



        Route::get('/comments', [CommentController::class, 'index'])->name('comment.index');
        Route::get('/comments/{id}', [CommentController::class, 'show'])->name('comment.show');
        Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');
        Route::resource('users', UserController::class);

        // dành cho quản lí flash sale bên phía admin
        Route::resource('/sales', SaleController::class);



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

        Route::resource('vouchers', VoucherController::class);

        // thêm biến thể admin
        Route::get('admin/products/{product}/variants/create', [ProductController::class, 'createVariant'])
            ->name('products.variants.create');
        Route::post('admin/products/{product}/variants', [ProductController::class, 'storeVariant'])
            ->name('products.variants.store');
        Route::delete('/variants/{id}', [ProductController::class, 'deleteVariant'])->name('variants.destroy');
        Route::get('/admin/products', [ProductController::class, 'search'])->name('search.product');

    });


    Route::middleware('auth')
    ->group(function(){
        Route::get('favorites',[FavoriteController::class,'index'])->name('favorites.index');
        Route::post('product/{id}/favorite',[FavoriteController::class,'addFavorite'])->name('favorites.add');
        Route::delete('product/{id}/favorites',[FavoriteController::class,'deleteFavorite'])->name('favorites.delete');

        Route::get('list-flash-sale-home',[HomeController::class,'getFlashSaleHome'])->name('getFlashSaleHome');
        Route::get('/change-password',[AuthenticationController::class,'showFormChangePassWord'])->name('showFormChangePassWord');
        Route::post('/change-password',[AuthenticationController::class,'changePassWord'])->name('changePassWord');
    });
// bên client
Route::get('/load-flash-sale',[HomeController::class,'getFlashSale'])->name('getFlashSale');
Route::get('/home', [HomeController::class, 'getProductHome'])->name('home');
Route::get('detail/{id}', [DetailController::class, 'show'])->name('detail.show');
Route::post('/product/{id}/comment', [DetailController::class, 'storeComment'])->name('storeComment');


Route::get('login', [AuthenticationController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthenticationController::class, 'login']);
Route::get('register', [AuthenticationController::class, 'showFormRegister'])->name('register');
Route::post('register', [AuthenticationController::class, 'register']);
Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
Route::resource('profile', AuthenticationController::class)->middleware('auth');



//Quên mật khẩu
Route::get('forgot-password', [AuthenticationController::class, 'showForgotPassword'])->name('showForgotPassword');
Route::post('forgot-password', [AuthenticationController::class, 'forgotPassword'])->name('forgotPassword');
Route::post('reset-password', [AuthenticationController::class, 'resetPassword'])->name('resetPassword');
Route::get('reset-password/{email}', [AuthenticationController::class, 'showResetPassword'])->name('showResetPassword');


Route::get('/danhmucsp', [FilterController::class, 'danhmucsp'])->name('danhmucsp');

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/cart', [CartController::class, 'index'])->name('cart.load')->middleware('auth');
Route::delete('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove')->middleware('auth');
Route::get('checkout', [CheckoutController::class, 'viewCheckout'])->name('checkout')->middleware('auth');
Route::post('/checkout', [OrderController::class, 'Order'])->name('checkout.order')->middleware('auth');
Route::get('thankyou', [CheckoutController::class, 'thankyou'])->name('thankyou')->middleware('auth');



Route::get('/orders', [OrderController::class, 'index'])->name('orders.index')->middleware('auth');
Route::post('/orders/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus')->middleware('auth');

Route::get('checkout', [CheckoutController::class, 'viewCheckout'])->name('checkout')->middleware('auth');
Route::post('/checkout', [OrderController::class, 'Order'])->name('checkout.order')->middleware('auth');

Route::get('thankyou', [CheckoutController::class, 'thankyou'])->name('thankyou')->middleware('auth');
Route::get('/orders', [OrderController::class, 'loadOrderUser'])->name('orders.loadUser')->middleware('auth');



// Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show')->middleware('auth');
Route::post('/orders/{orderId}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel')->middleware('auth');
Route::get('order/repurchase/{orderId}', [OrderController::class, 'repurchase'])->name('order.repurchase')->middleware('auth');

// tìm kiếm sản phẩm
Route::get('/search', [SearchController::class, 'search'])->name('products.search');
Route::post('/vnpay_payment', [OrderController::class, 'createOrder'])->name('vnpay')->middleware('auth');
Route::get('/vnpay/callback', [PaymentController::class, 'vnpay_callback'])->name('vnpay.callback')->middleware('auth');

Route::post('/apply-voucher', [OrderController::class, 'applyVoucher'])->name('applyVoucher')->middleware('auth');

// xử lí mua lại trong order
Route::post('/reorder/{orderId}', [OrderController::class, 'reorder'])->name('orders.reorder')->middleware('auth');
// xử lí mua sản phẩm đã chọn
// Route::post('purchase', [CheckoutController::class, 'purchase'])->name('cart.purchase');
Route::post('/cart/proceed-to-checkout', [CartController::class, 'proceedToCheckout'])->name('cart.proceedToCheckout')->middleware('auth');

// Route để hiển thị trang bình luận
Route::get('/comment/{productId}', [CommentController::class, 'showCommentForm'])->name('comment.form')->middleware('auth');
// Route để lưu bình luận
// Route::get('/orders/{orderId}', [OrderController::class, 'show'])->name('order.show')->middleware('auth');

Route::get('/comment/{productId}', [CommentController::class, 'showCommentForm'])->name('comment.form')->middleware('auth');

Route::post('/comment/{productId}', [CommentController::class, 'store'])->name('comment.store')->middleware('auth');
// Route::get('/orders/{orderId}', [OrderController::class, 'show'])->name('orders.show')->middleware('auth');

Route::get('product/detail/{id}', [DetailController::class, 'show'])->name('product.detail')->middleware('auth');

Route::get('/orders/search', [OrderController::class, 'search'])->name('orders.search');

// Route để hiển thị trang bình luận
Route::get('/comment/{orderId}/{productVariantId}', [CommentController::class, 'showCommentForm'])->name('comment.form');

// Route để lưu bình luận
Route::post('/comment/{orderId}/{productVariantId}', [CommentController::class, 'store'])->name('comment.store');


Route::get('/product/{productId}/comment', [ProductController::class, 'showCommentForm'])->name('product.showCommentForm');

Route::get('admin/comment/{order_id}/{product_id}/{product_variant_id}', [CommentController::class, 'show'])->name('admin.comment.show');