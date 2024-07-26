<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\EnquiryChatsController;
use App\Http\Controllers\SaleChatsController;
use App\Http\Controllers\ProductChatsController;
use App\Http\Controllers\EnquiryChatroomController;
use App\Http\Controllers\SaleChatRoomController;
use App\Http\Controllers\ProductChatroomController;
use App\Http\Controllers\ChatroomController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\MobileVerification;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\TermsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

// Route::get('/register/demo',function(){
//     return Inertia::render('RegisterDemo');
// })->name('register.demo');

Route::get('/logo', [AuthController::class, 'getLogo'])->name('logo')->middleware('guest');

Route::get('/register', [AuthController::class, 'register'])->name('register')->middleware('guest');

Route::get('/terms-of-service', [TermsController::class, 'terms'])->name('terms')->middleware('guest');

Route::get('/privacy-policy', [TermsController::class, 'privacy'])->name('privacy')->middleware('guest');

Route::get('/states/{country}', [LocationController::class, 'states'])->name('states');
Route::get('/cities/{state}', [LocationController::class, 'cities'])->name('cities');

Route::get('/redirectUser', [RedirectController::class, 'home'])->name('redirect');

Route::get('/de-active', [HomeController::class, 'deActive'])->name('deactive');
//  user and admin route 
Route::middleware(['middleware' => 'user', 'auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {

    Route::post('/send-otp', [MobileVerification::class, 'sendOtp'])->name('send.otp')->withoutMiddleware('mobile_verification');
    Route::get('/verify/mobile', [MobileVerification::class, 'verifyOtpForm'])->name('mobile.verifyform')->withoutMiddleware('mobile_verification');
    Route::post('/verify/mobile', [MobileVerification::class, 'verifyOtp'])->name('mobile.verify')->withoutMiddleware('mobile_verification');

    Route::get('/enquiry', [EnquiryController::class, 'index'])->name('enquiry.index');
    Route::get('/enquiry/create', [EnquiryController::class, 'create'])->name('enquiry.create');
    Route::post('/enquiry/store', [EnquiryController::class, 'store'])->name('enquiry.store');
    Route::get('/enquiry/{enquiry}', [EnquiryController::class, 'show'])->name('enquiry.show')->withOutMiddleware('user');
    Route::get('/enquiry/{enquiry}/edit', [EnquiryController::class, 'edit'])->name('enquiry.edit');
    Route::post('/enquiry/{enquiry}/update', [EnquiryController::class, 'update'])->name('enquiry.update');
    Route::post('/enquiry/{enquiry}/update', [EnquiryController::class, 'update'])->name('enquiry.update');
    Route::delete('/enquiry/{enquiry}', [EnquiryController::class, 'destroy'])->name('enquiry.destroy');

    Route::get('/sales', [SalesController::class, 'index'])->name('sales.index');
    Route::get('/sales/create', [SalesController::class, 'create'])->name('sales.create');
    Route::post('/sales/store', [SalesController::class, 'store'])->name('sale.store');
    Route::get('/sales/{sale}', [SalesController::class, 'show'])->name('sales.show')->withOutMiddleware('user');
    Route::get('/sales/{sale}/edit', [SalesController::class, 'edit'])->name('sale.edit');
    Route::post('/sales/{sale}/update', [SalesController::class, 'update'])->name('sale.update');
    Route::delete('/sales/{sale}', [SalesController::class, 'destroy'])->name('sale.destroy');

    Route::get('/products', [ProductController::class, 'index'])->name('product.index');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show')->withOutMiddleware('user');
    Route::get('/product/{product}/edit', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/{product}/update', [ProductController::class, 'update'])->name('product.update');
    Route::post('/product/{product}/share', [ProductController::class, 'share'])->name('product.share');
    Route::delete('/product/{product}', [ProductController::class, 'destroy'])->name('product.destroy');

    Route::group(['prefix' => 'chat'], function () {
        Route::get('enquiry-chats', [EnquiryChatsController::class, 'index'])->name('enquiry.chats.index');
        Route::get('enquiry-chats/redirect/{sale}', [EnquiryChatsController::class, 'redirectToChat'])->name('enquiry.chats.redirect');
        Route::get('enquiry-chats/{chat}', [EnquiryChatsController::class, 'show'])->name('enquiry.chats.show');
        Route::post('enquiry-chats/create-new', [EnquiryChatsController::class, 'createNew'])->name('enquiry.chatroom.createnew');
        Route::post('enquiry-chats/{chat}/star', [EnquiryChatsController::class, 'star'])->name('enquiry.chats.star');
        Route::delete('enquiry-chats/{id}', [EnquiryChatsController::class, 'deleteChat'])->name('enquiry.chats.delete');
    
        Route::get('enquiry-chatroom/{chatroom}', [EnquiryChatroomController::class, 'show'])->name('enquiry.chatroom.show');
        Route::get('enquiry-chatroom/temp/{sale}', [EnquiryChatroomController::class, 'tempshow'])->name('enquiry.chatroom.tempshow');
        Route::get('enquiry-chatroom/settings/{chatroom}', [EnquiryChatroomController::class, 'settings'])->name('enquiry.chatroom.settings');
        Route::post('enquiry-chatroom/{id}/message', [EnquiryChatroomController::class, 'newMessage'])->name('enquiry.chatroom.newMessage');
        Route::post('enquiry-chatroom/{id}/adduser', [EnquiryChatroomController::class, 'addUser'])->name('enquiry.chatroom.addUser');
    
        Route::get('sale-chats', [SaleChatsController::class, 'index'])->name('sale.chats.index');
        Route::get('sale-chats/redirect/{enquiry}', [SaleChatsController::class, 'redirectToChat'])->name('sale.chats.redirect');
        Route::get('sale-chats/{chat}', [SaleChatsController::class, 'show'])->name('sale.chats.show');
        Route::post('sale-chats/create-new', [SaleChatsController::class, 'createNew'])->name('sale.chatroom.createnew');
        Route::post('sale-chats/{chat}/star', [SaleChatsController::class, 'star'])->name('sale.chats.star');
        Route::delete('sale-chats/{id}', [SaleChatsController::class, 'deleteChat'])->name('sale.chats.delete');
    })->name('chat');
   

    Route::get('product-chats/redirect/{product}', [ProductChatsController::class, 'redirectToChat'])->name('product.chats.redirect');
    Route::post('product-chats/create-new', [ProductChatsController::class, 'createNew'])->name('product.chatroom.createnew');

    Route::get('product-chatroom/temp/{product}', [ProductChatroomController::class, 'tempshow'])->name('product.chatroom.tempshow');

    Route::get('sale-chatroom/{chatroom}', [SaleChatroomController::class, 'show'])->name('sale.chatroom.show');
    Route::get('sale-chatroom/temp/{enquiry}', [SaleChatroomController::class, 'tempshow'])->name('sale.chatroom.tempshow');
    Route::get('sale-chatroom/settings/{chatroom}', [SaleChatroomController::class, 'settings'])->name('sale.chatroom.settings');
    Route::post('sale-chatroom/{id}/message', [SaleChatroomController::class, 'newMessage'])->name('sale.chatroom.newMessage');
    Route::post('sale-chatroom/{id}/adduser', [SaleChatroomController::class, 'addUser'])->name('sale.chatroom.addUser');

    Route::post('chatroom/send-messages', [ChatroomController::class, 'sendMessages'])->name('chatroom.sendMessages');
    Route::post('chatroom/share-message', [ChatroomController::class, 'shareMessage'])->name('chatroom.shareMessage');
    Route::post('chatroom/{id}/message', [ChatroomController::class, 'newMessage'])->name('chatroom.newMessage');
    Route::post('chatroom/{id}/fileupload', [ChatroomController::class, 'fileUpload'])->name('chatroom.fileUpload');
    Route::post('chatroom/{id}/adduser', [ChatroomController::class, 'addUser'])->name('chatroom.addUser');
    Route::post('chatroom/{chatroom}/delete-messages', [ChatroomController::class, 'deleteMessages'])->name('chatroom.deleteMessages');
    Route::post('chatroom/{chatroom}/leave-chat', [ChatroomController::class, 'exitGroup'])->name('chatroom.exitGroup');
    Route::post('chatroom/delete-chats', [ChatroomController::class, 'deleteChats'])->name('chatroom.deleteChats');
    Route::post('chatroom/{message}/delete-message', [ChatroomController::class, 'deleteMessage'])->name('chatroom.deleteMessage');

    Route::get('/company/manage', [CompanyController::class, 'manage'])->name('company.manage');
    Route::get('/company/{id}', [CompanyController::class, 'show'])->name('company.show')->withOutMiddleware('user');
    Route::get('/company/employees', [CompanyController::class, 'getEmployees'])->name('company.employees');
    Route::get('/company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit')->middleware('admin');
    Route::patch('/company/{company}/update', [CompanyController::class, 'update'])->name('company.update')->middleware('admin');
    Route::post('/company/{company}/updatelogo', [CompanyController::class, 'updateLogo'])->name('company.updatelogo')->middleware('admin');


    Route::group(['middleware' => 'admin'], function () {
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users/store', [UserController::class, 'store'])->name('user.store');
        Route::get('/users/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('user.updaterole');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::patch('/users/{user}', [UserController::class, 'update'])->name('user.update');
    });

    Route::get('/manage-storage', [StorageController::class, 'index'])->name('storage.index');


    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.display')->withOutMiddleware('user');
    Route::get('/user/profile', [ProfileController::class, 'edit'])->name('profile.show')->withoutMiddleware('mobile_verification');

    Route::get('/subscription/create', [SubscriptionController::class, 'create'])->name('subscription.create');
    Route::get('/subscription/store', [SubscriptionController::class, 'store'])->name('subscription.store');
    Route::post('/subscription/wallet-pay', [SubscriptionController::class, 'walletpay'])->name('subscription.walletpay');

    Route::get('/coupon/{coupon}/validate', [CouponController::class, 'validateCoupon'])->name('coupon.validate');

    Route::get('/contacts', [HomeController::class, 'contacts'])->name('contacts');

    Route::get('/notifications', [HomeController::class, 'notifications'])->name('notifications');

    Route::get('/wallet', [HomeController::class, 'wallet'])->name('wallet');

    Route::get('/payout', [HomeController::class, 'payout'])->name('payout');
    Route::post('/payout/store', [HomeController::class, 'storePayout'])->name('payout.store');

    Route::get('/refer', [HomeController::class, 'refer'])->name('refer');
    Route::get('/refer/show', [HomeController::class, 'referShow'])->name('refer.show');

    Route::get('/help', [HomeController::class, 'help'])->name('help');

    Route::get('/buy', [HomeController::class, 'buy'])->name('buy');
    Route::post('/buy/store', [HomeController::class, 'storeBuy'])->name('buy.store');
    Route::get('/buy/show', [HomeController::class, 'buyShow'])->name('buy.show');

    Route::get('/links', [HomeController::class, 'links'])->name('links');

    Route::get('/settings', [HomeController::class, 'settings'])->name('settings');

    Route::get('/help', [HomeController::class, 'help'])->name('help');

    Route::post('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/verify', [PaymentController::class, 'verify'])->name('payment.verify');
});


// super admin route 
Route::name('admin.')->prefix('admin')->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::group(['middleware' => 'accounts_admin'], function () {
        Route::get('/', [Admin\UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [Admin\UserController::class, 'create'])->name('user.create');
        Route::get('/user/pending', [Admin\UserController::class, 'pending'])->name('user.pending');
        Route::get('/user/{id}/edit', [Admin\UserController::class, 'edit'])->name('user.edit');
        Route::patch('/user/{user}/update', [Admin\UserController::class, 'update'])->name('user.update');
    });

    Route::group(['middleware' => 'accounts_admin'], function () {
        Route::get('/country', [Admin\CountryController::class, 'index'])->name('country.index');
        Route::get('/country/create', [Admin\CountryController::class, 'create'])->name('country.create');
        Route::post('/country/store', [Admin\CountryController::class, 'store'])->name('country.store');
        Route::delete('/country/delete/{country_id}/{state_id}/{city_id}', [Admin\CountryController::class, 'delete'])->name('country.delete');
    });

    Route::group(['middleware' => 'super_admin'], function () {
        Route::get('/admins', [Admin\AdminController::class, 'index'])->name('admin.index');
        Route::get('/admin/create', [Admin\AdminController::class, 'create'])->name('admin.create');
        Route::post('/admin/store', [Admin\AdminController::class, 'store'])->name('admin.store');
        Route::get('/admin/{admin}/edit', [Admin\AdminController::class, 'edit'])->name('admin.edit');
        Route::patch('/admin/{admin}/update', [Admin\AdminController::class, 'update'])->name('admin.update');
        Route::post('/admin/{admin}/updatestatus', [Admin\AdminController::class, 'updateStatus'])->name('admin.updateStatus');

        // Logo Update
        Route::get('/logo/create', [Admin\AdminController::class, 'createLogo'])->name('logo.create');
        Route::post('/logo/store', [Admin\AdminController::class, 'storeLogo'])->name('logo.store');

    });

    Route::group(['middleware' => 'accounts_admin'], function () {
        Route::get('/companies', [Admin\CompanyController::class, 'index'])->name('company.index');
        Route::get('/company/{id}/edit', [Admin\CompanyController::class, 'edit'])->name('company.edit');
    });

    Route::group(['middleware' => 'sales_admin'], function () {
        Route::get('/coupon', [Admin\CouponController::class, 'index'])->name('coupon.index');
        Route::get('/coupon/create', [Admin\CouponController::class, 'create'])->name('coupon.create');
        Route::post('/coupon/store', [Admin\CouponController::class, 'store'])->name('coupon.store');
        Route::get('/coupon/{coupon}/edit', [Admin\CouponController::class, 'edit'])->name('coupon.edit');
        Route::patch('/coupon/{coupon}/update', [Admin\CouponController::class, 'update'])->name('coupon.update');
        Route::patch('/coupon/{coupon}/updateStatus', [Admin\CouponController::class, 'updateStatus'])->name('coupon.updateStatus');

        Route::get('/susbscription', [Admin\SubsciptionController::class, 'index'])->name('subscription.index');
        Route::get('/susbscription/create', [Admin\SubsciptionController::class, 'create'])->name('subscription.create');
        Route::post('/susbscription/store', [Admin\SubsciptionController::class, 'store'])->name('subscription.store');
        Route::get('/susbscription/{subscription}/edit', [Admin\SubsciptionController::class, 'edit'])->name('subscription.edit');
        Route::patch('/susbscription/{subscription}/update', [Admin\SubsciptionController::class, 'update'])->name('subscription.update');
        Route::patch('/susbscription/{subscription}/updateStatus', [Admin\SubsciptionController::class, 'updateStatus'])->name('subscription.updateStatus');

        Route::get('/subscription-payments', [Admin\HomeController::class, 'subscriptionPayments'])->name('subscription.payments');
        Route::get('/uploadpack-payments', [Admin\HomeController::class, 'uploadPackPayments'])->name('uploadpack.payments');

        Route::get('/payouts', [Admin\PayoutController::class, 'index'])->name('payout.index');
        Route::post('/payouts/{payout}/update', [Admin\PayoutController::class, 'update'])->name('payout.update');

        Route::get('/upload-pack', [Admin\BuyUploadPackController::class, 'index'])->name('uploadpack.index');

        Route::patch('/upload-pack/update', [Admin\BuyUploadPackController::class, 'update'])->name('uploadpack.update');
    });


    Route::group(['middleware' => 'data_admin'], function () {
        Route::get('/upload-pack/showlist', [Admin\BuyUploadPackController::class, 'showlist'])->name('uploadpack.showlist');


        Route::get('/sales', [Admin\SalesController::class, 'index'])->name('sale.index');
        Route::get('/sales/create', [Admin\SalesController::class, 'create'])->name('sale.create');
        Route::get('/sales/{id}/edit', [Admin\SalesController::class, 'edit'])->name('sale.edit');
        Route::post('/sales/{sale}/updatestatus', [Admin\SalesController::class, 'updateStatus'])->name('sale.updateStatus');
        Route::delete('/sales/{sale}', [Admin\SalesController::class, 'destroy'])->name('sale.delete');

        Route::get('/enquiries', [Admin\EnquiryController::class, 'index'])->name('enquiry.index');
        Route::post('/enquiries/{enquiry}/updatestatus', [Admin\EnquiryController::class, 'updateStatus'])->name('enquiry.updateStatus');
        Route::delete('/enquiries/{enquiry}', [Admin\EnquiryController::class, 'destroy'])->name('enquiry.delete');

        Route::get('/products', [Admin\ProductController::class, 'index'])->name('product.index');
        Route::post('/products/{product}/updatestatus', [Admin\ProductController::class, 'updateStatus'])->name('product.updateStatus');
        Route::get('/products/{user}/{pack}/create', [Admin\ProductController::class, 'create'])->name('product.create');
        Route::delete('/products/{product}', [Admin\ProductController::class, 'destroy'])->name('product.delete');
    });
});
