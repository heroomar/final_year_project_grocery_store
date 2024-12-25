<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PlanRequestController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\PlanCouponController;
use App\Http\Controllers\PaystackPaymentController;
use App\Http\Controllers\RazorpayPaymentController;
use App\Http\Controllers\MercadoPaymentController;
use App\Http\Controllers\SkrillPaymentController;
use App\Http\Controllers\PaymentWallPaymentController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Controllers\FlutterwaveController;
use App\Http\Controllers\PaytmPaymentController;
use App\Http\Controllers\MolliePaymentController;
use App\Http\Controllers\CoingateController;
use App\Http\Controllers\SspayController;
use App\Http\Controllers\ToyyibpayController;
use App\Http\Controllers\PaytabsController;
use App\Http\Controllers\IyziPayController;
use App\Http\Controllers\BankTransferController;
use App\Http\Controllers\PayFastController;
use App\Http\Controllers\BenefitPaymentController;
use App\Http\Controllers\CashfreeController;
use App\Http\Controllers\AamarpayController;
use App\Http\Controllers\PaytrController;
use App\Http\Controllers\YookassaController;
use App\Http\Controllers\XenditPaymentController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\ShippingZoneController;
use App\Http\Controllers\ShippingMethodController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\PixelFieldsController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\TaxOptionController;
use App\Http\Controllers\TaxMethodController;
use App\Http\Controllers\FlashSaleController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\MainCategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DeliveryBoyController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductAttributeOptionController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ThemeSettingController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProductQuestionController;
use App\Http\Controllers\AccountProfileController;
use App\Http\Controllers\AddonController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AITemplateController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Customer\Auth\CustomerLoginController;
use App\Http\Controllers\ThemeAnalyticController;
use App\Http\Controllers\OrderNoteController;
use App\Http\Controllers\WoocomCategoryController;
use App\Http\Controllers\WoocomSubCategoryController;
use App\Http\Controllers\WoocomProductController;
use App\Http\Controllers\WoocomCustomerController;
use App\Http\Controllers\WoocomCouponController;
use App\Http\Controllers\ShopifyProductController;
use App\Http\Controllers\ShopifyCategoryController;
use App\Http\Controllers\ShopifyCustomerController;
use App\Http\Controllers\ShopifyCouponController;
use App\Http\Controllers\ShopifySubCategoryController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\OrderRefundController;
use App\Http\Controllers\ContactController;
use App\Http\Middleware\ActiveTheme;
use App\Http\Controllers\TagController;
use App\Http\Controllers\NepalstePaymnetController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\KhaltiPaymnetController;
use App\Http\Controllers\PayHerePaymnetController;
use App\Http\Controllers\ProductBrandController;
use App\Http\Controllers\AuthorizeNetPaymnetController;
use App\Http\Controllers\TapPaymnetController;
use App\Http\Controllers\PhonePePaymentController;
use App\Http\Controllers\PaddlePaymentController;
use App\Http\Controllers\PaiementProPaymentController;
use App\Http\Controllers\FedPayPaymentController;
use App\Http\Controllers\ProductLabelController;
use App\Http\Controllers\CinetPayController;
use App\Http\Controllers\SenangPayController;
use App\Http\Controllers\CyberSourceController;
use App\Http\Controllers\OzowController;
use App\Http\Controllers\EasebuzzController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\MyFatoorahController;
use App\Http\Controllers\NMIPayController;
use App\Http\Controllers\PayUPaymentController;
use App\Http\Controllers\OfertemagController;
use App\Http\Controllers\PaynowController;
use App\Http\Controllers\SofortController;
use App\Http\Controllers\ESewaPaymentController;
use App\Http\Controllers\DPOPayController;
use App\Http\Controllers\BraintreeController;
use App\Http\Controllers\PowertranzPaymentController;
use App\Http\Controllers\SSLCommerzPaymentController;
use App\Http\Controllers\StoreExpenseController;
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
require __DIR__ . '/auth.php';

Route::any('/', [HomeController::class, 'Landing'])->name('start');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
Route::get('/addcart/{id}', [HomeController::class, 'addcart'])->name('addcart');
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/deletecart', [HomeController::class, 'deletecart'])->name('deletecart');
Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [HomeController::class, 'storecheckout']);
Route::get('/success', [HomeController::class, 'success']);
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');


Route::get('/get-cats', [MainCategoryController::class, 'getcats'])->name('getcats');

Route::middleware(['auth','web'])->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('store-expenses', StoreExpenseController::class);
    
    Route::get('user-enable-login/{id}', [UserController::class, 'userLoginManage'])->name('users.enable.login');
    Route::resource('setting', SettingController::class);
    Route::post('business-settings', [SettingController::class, 'BusinessSettings'])->name('business.settings');
    Route::post('/setting-form', [SettingController::class, 'settingForm'])->name('setting.form');

    Route::resource('main-category', MainCategoryController::class);
    Route::resource('sub-category', SubCategoryController::class);
    Route::resource('product', ProductController::class);
//     Route::post('get-slug', [ProductController::class, 'get_slug'])->name('get.slug');
    Route::post('get-product-subcategory', [ProductController::class, 'get_subcategory'])->name('get.product.subcategory');


    Route::delete('products/{id}/delete', [ProductController::class, 'file_delete'])->name('products.file.detele');

    Route::resource('coupon', CouponController::class);

    Route::get('order-reports', [ReportController::class, 'OrderReport'])->name('reports.order_report');
    Route::get('order-reports-chart', [ReportController::class, 'order_reports_chart'])->name('reports.order.chart');

    Route::resource('customer', CustomerController::class);

    Route::resource('order', controller: OrderController::class);
    Route::get('order-view/{id}', [OrderController::class, 'order_view'])->name('order.view');
    Route::resource('pos', PosController::class);
    Route::get('product-categories', [MainCategoryController::class, 'getProductCategories'])->name('product.categories');
    Route::get('search-products', [ProductController::class, 'searchProducts'])->name('search.products');
    Route::post('/cartdiscount', [PosController::class, 'cartDiscount'])->name('cartdiscount');
    Route::get('addToCart/{id}/{session}/{variation_id?}', [ProductController::class, 'addToCart'])->name('pos.add.to.cart');
    Route::patch('update-cart', [ProductController::class, 'updateCart']);
    Route::delete('remove-from-cart', [ProductController::class, 'removeFromCart'])->name('remove-from-cart');
    Route::get('printview/pos', [PosController::class, 'printView'])->name('pos.printview');
    Route::get('pos/data/store', [PosController::class, 'store'])->name('pos.data.store');
    Route::post('empty-cart', [ProductController::class, 'emptyCart'])->name('empty-cart');

  Route::get('orders/order_view/{id}', [OrderController::class, 'show'])->name('order.order_view');
 Route::post('order-status-change/{id}', [OrderController::class, 'order_status_change'])->name('order.status.change');
  Route::post('order-payment-status', [OrderController::class, 'order_payment_status'])->name('order.payment.status');
 Route::post('update-order-status/{id}', [OrderController::class, 'updateStatus'])->name('order.order_status_update')->middleware('themelanguage');

  Route::post('order-return-request', [OrderController::class, 'order_return_request'])->name('order.return.request')->middleware('themelanguage');

    Route::get('/storeSlug', [HomeController::class, 'landing_page'])->name('landing_page');


});