<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\AboutController;
use App\Http\Controllers\frontend\IndexController;
use App\Http\Controllers\frontend\EnquiryController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ResourceController;
use App\Http\Controllers\admin\WeightController;
use App\Http\Controllers\admin\GoogleAdsenseController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\frontend\ServiceEnquiryController;
use App\Http\Controllers\admin\PincodeController;
use App\Http\Controllers\admin\PrivacyPolicyController;
use App\Http\Controllers\frontend\PincodeCheckController;
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
Route::get('/', [App\Http\Controllers\frontend\IndexController::class, 'index']);
Route::get('/ads.txt', function () {
    $path = base_path('ads.txt');

    if (file_exists($path)) {
        return Response::file($path, [
            'Content-Type' => 'text/plain',
        ]);
    }

    abort(404);
});
Route::controller(IndexController::class)->group(function(){
    Route::get('/','index');
     Route::get('profile/{id}','profile')->middleware('auth.user')->name('profile');
    Route::get('conpostprofile/{id}','conpostprofile')->name('conpostprofile');
    Route::get('sabpostprofile/{id}','sabpostprofile')->name('sabpostprofile');
    Route::get('buspostprofile/{id}','buspostprofile')->name('buspostprofile');
    Route::post('profile_update/{id}','profile_update')->name('profile_update');
    Route::post('/filter-waste','filter')->name('filter.waste');
     Route::get('about','about')->name('about');
     Route::get('privacypolicy','privacypolicy')->name('privacypolicy');
       Route::get('ourteam','ourteam')->name('ourteam');
       Route::get('contact','contact')->name('contact');
        Route::post('contact_store','contact_store')->name('contact_store');
    Route::get('listings','listings')->name('listings');
     Route::get('faq','faq')->name('faq');
    Route::get('howitsworks','howitsworks')->name('howitsworks');
    Route::get('service','service')->name('service');
    Route::get('buy/listings','buy_listings')->name('buy_listings');
    Route::get('con_listing_details/{id}','con_listing_details')->name('con_listing_details');
    Route::get('sabs_listing_details/{id}','sabs_listing_details')->name('sabs_listing_details');
    Route::get('bus_listing_details/{id}','bus_listing_details')->name('bus_listing_details');
    Route::get('business_login', 'business_login')->name('business_login');
    Route::post('business_store','business_store')->name('business.store');
    Route::get('business_details','business_details')->name('business_details');
    Route::post('business_post_save','business_post_save')->name('business_post_save');
    Route::get('business_listing_details/{id}','business_listing_details')->name('business_listing_details');
    Route::get('business_own_listing_details/{id}','business_own_listing_details')->name('business_own_listing_details');
    Route::get('business_posts','business_posts')->name('business_posts');
     Route::get('business_own_posts','business_own_posts')->name('business_own_posts');
    Route::get('sab_login', 'sab_login')->name('sab_login');
    Route::post('sab_store','sab_store')->name('sab.store');
    Route::get('sab_posts','sab_posts')->name('sab_posts');
     Route::get('sab_own_posts','sab_own_posts')->name('sab_own_posts');
    Route::get('sab_details','sab_details')->name('sab_details');
    Route::post('sab_post_save','sab_post_save')->name('sab_post_save');
    Route::get('sab_listing_details/{id}','sab_listing_details')->name('sab_listing_details');
     Route::get('sab_own_listing_details/{id}','sab_own_listing_details')->name('sab_own_listing_details');
    Route::post('/sab_send_enquiry', 'sabsendEnquiryEmail')->name('sab_send_enquiry');
    Route::post('/loginsab_send_enquiry', 'loginsabsendEnquiryEmail')->name('loginsab_send_enquiry');
    Route::get('consumer_login', 'consumer_login')->name('consumer_login');
    //Route::post('send_otp','sendOtp')->name('send_otp');

    Route::post('resendOtp','resendOtp')->name('resend_Otp');

    Route::get('register_otp/{id}', 'register_otp')->name('register_otp');
     Route::get('activate_otp/{id}', 'activate_otp')->name('activate_otp');

    Route::get('loginverify_otp/{id}', 'loginverify_otp')->name('loginverify_otp');

    Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
     Route::post('/activate-verify-otp', 'activateverifyOtp')->name('activateverify.otp');

    Route::post('consumer_store','consumer_store')->name('consumer.store');
    Route::get('consumer_posts','consumer_posts')->name('consumer_posts');
     Route::get('consumer_own_posts','consumer_own_posts')->name('consumer_own_posts');
    Route::get('consumer_details','consumer_details')->name('consumer_details');
    Route::post('consumer_post_save','consumer_post_save')->name('consumer_post_save');
    Route::get('consumer_listing_details/{id}','consumer_listing_details')->name('consumer_listing_details');
     Route::get('consumer_own_listing_details/{id}','consumer_own_listing_details')->name('consumer_own_listing_details');

     Route::post('/consumer-posts/deactivate' ,'con_deactivate')->name('consumer-posts.deactivate');
     Route::post('/consumer-posts/reactivate' ,'con_reactivate')->name('consumer-posts.reactivate');
      Route::post('/sab-posts/deactivate' ,'sab_deactivate')->name('sab-posts.deactivate');
      Route::post('/sab-posts/reactivate' ,'sab_reactivate')->name('sab-posts.reactivate');
       Route::post('/business-posts/deactivate' ,'bus_deactivate')->name('bus-posts.deactivate');
       Route::post('/business-posts/reactivate' ,'bus_reactivate')->name('bus-posts.reactivate');

     Route::get('con_all_posts','con_all_posts')->name('con_all_posts');
      Route::post('con_all_posts_filter','con_all_posts_filter')->name('con_all_posts_filter');
       Route::get('/con_all_posts_sort', 'con_all_posts_sort')->name('con_all_posts_sort');
        Route::get('get_con_post_details','get_con_post_details')->name('get_con_post_details');
      Route::get('sab_all_posts','sab_all_posts')->name('sab_all_posts');
       Route::post('sab_all_posts_filter','sab_all_posts_filter')->name('sab_all_posts_filter');
        Route::get('get_post_details','get_post_details')->name('get_post_details');
         Route::get('sab_all_buy_posts','sab_all_buy_posts')->name('sab_all_buy_posts');
           Route::post('sab_all_buy_posts_filter','sab_all_buy_posts_filter')->name('sab_all_buy_posts_filter');
       Route::get('bus_all_posts','bus_all_posts')->name('bus_all_posts');
        Route::post('bus_all_posts_filter','bus_all_posts_filter')->name('bus_all_posts_filter');
         Route::get('bus_all_buy_posts','bus_all_buy_posts')->name('bus_all_buy_posts');
        Route::post('bus_all_buy_posts_filter','bus_all_buy_posts_filter')->name('bus_all_buy_posts_filter');
        Route::get('get_business_post_details','get_business_post_details')->name('get_business_post_details');
         Route::get('get_consumer_post_details','get_consumer_post_details')->name('get_consumer_post_details');

       Route::get('/sab_all_posts_sort', 'sab_all_posts_sort')->name('sab_all_posts_sort');
        Route::get('/business_all_posts_sort', 'bus_all_posts_sort')->name('bus_all_posts_sort');
          Route::get('/terms_conditions', 'terms_conditions')->name('terms_conditions');

Route::post('/check-contact', 'checkContact')->name('check.contact');
    Route::get('user_register', 'user_register')->name('user_register');
    Route::get('user_type', 'user_type')->name('user_type');
    Route::get('business_add', 'business_add')->name('business_add');
    Route::get('sab_add', 'sab_add')->name('sab_add');
    Route::get('consumer_add', 'consumer_add')->name('consumer_add');
    Route::post('business_save','business_save')->name('business.save');
    Route::post('sab_save','sab_save')->name('sab.save');
    Route::post('consumer_save','consumer_save')->name('consumer.save');
    Route::get('/user_logout', 'signOut')->name('user_logout');
     Route::get('user_deactivate', 'user_deactivate')->name('user.user_deactivate');
      Route::get('user_activate/{id}', 'user_activate')->name('user.user_activate');


      Route::get('gadsense','gadsense')->name('gadsense');
});

Route::controller(EnquiryController::class)->group(function(){

    Route::post('enquiry/consumer_save','consumer_save')->name('enquiry.consumer_save');
    Route::post('enquiry/sab_save','sab_save')->name('enquiry.sab_save');
    Route::post('enquiry/business_save','business_save')->name('enquiry.business_save');
    Route::post('review/sab_save','sabreviewsave')->name('review.sab_save');
    Route::post('review/consumer_save','consumerreviewsave')->name('review.consumer_save');
    Route::post('review/business_save','businessreviewsave')->name('review.business_save');

     Route::get('Consumerconnectreportlist','Consumerconnectreportlist')->name('user.Consumerconnectreportlist');
      Route::post('shortConsumerconnectReportList','shortConsumerconnectReportList')->name('user.shortConsumerconnectReportList');

      Route::get('sabconnectreportlist','sabconnectreportlist')->name('user.sabconnectreportlist');
      Route::post('shortsabconnectReportList','shortsabconnectReportList')->name('user.shortsabconnectReportList');

      Route::get('Businessconnectreportlist','Businessconnectreportlist')->name('user.Businessconnectreportlist');
       Route::post('shortBusinessconnectReportList','shortBusinessconnectReportList')->name('user.shortBusinessconnectReportList');


});
Route::controller(ServiceEnquiryController::class)->group(function(){
    Route::post('service_enquiry/save', 'service_enquiry_save')->name('service_enquiry.save');

});
Route::controller(PincodeCheckController::class)->group(function(){
    Route::post('/check-pincode', 'checkPincode')->name('check-pincode');
      Route::get('/service-not-available', 'servicenotavailable')->name('service-not-available');
       Route::post('/check-pincode-save', 'checkPincodeSave')->name('check-pincode-save');
  });
Auth::routes();

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index']);
// //Language Translation

// Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
// Route::post('/formsubmit', [App\Http\Controllers\HomeController::class, 'FormSubmit'])->name('FormSubmit');

Route::get('/admin_login', [App\Http\Controllers\admin\AuthController::class, 'admin_login'])->name('admin_login');
Route::post('/admin_store', [App\Http\Controllers\admin\AuthController::class, 'admin_store'])->name('admin_store');
Route::get('/admin_dashboard', [App\Http\Controllers\admin\AuthController::class, 'admin_dashboard'])->name('admin_dashboard');
Route::get('/admin_logout', [App\Http\Controllers\admin\AuthController::class, 'signOut'])->name('admin.admin_logout');
Route::get('/admin_profile/{id}', [App\Http\Controllers\admin\AuthController::class, 'admin_profile'])->name('admin.admin_profile');
Route::post('/admin_profile_update/{id}', [App\Http\Controllers\admin\AuthController::class, 'admin_profile_update'])->name('admin_profile_update');
Route::get('/changepassword/{id}', [App\Http\Controllers\admin\AuthController::class, 'changepassword'])->name('changepassword');
Route::post('/changepassword_store', [App\Http\Controllers\admin\AuthController::class, 'changepassword_store'])->name('changepassword_store');

Route::controller(AdminController::class)->group(function(){
    Route::get('user/businesslist','businesslist')->name('user.businesslist');
    Route::get('/changeStatus', 'changeStatus')->name('user.changeStatus');
    Route::get('user/sablist','sablist')->name('user.sablist');
    Route::get('user/sabposts','sabposts')->name('user.sabposts');
    Route::get('user/sabpostsview/{id}','sabpostsview')->name('user.sabpostsview');
    Route::get('user/consumerlist','consumerlist')->name('user.consumerlist');
    Route::get('user/consumerposts','consumerposts')->name('user.consumerposts');
    Route::get('user/consumerpostsview/{id}','consumerpostsview')->name('user.consumerpostsview');
    Route::get('user/businessview/{id}','businessview')->name('user.businessview');
    Route::get('user/sabview/{id}','sabview')->name('user.sabview');
    Route::get('user/consumerview/{id}','consumerview')->name('user.consumerview');
    Route::get('user/businessposts','businessposts')->name('user.businessposts');
    Route::get('user/businesspostsview/{id}','businesspostsview')->name('user.businesspostsview');
    Route::get('user/sabreviews','sabreviews')->name('user.sabreviews');
    Route::get('user/consumerreviews','consumerreviews')->name('user.consumerreviews');
    Route::get('user/usercontact','usercontact')->name('user.usercontact');
     Route::get('user/delete/{id}','deleteuser')->name('user.deleteuser');
     Route::get('user/edit/{id}','edituser')->name('user.edituser');
     Route::post('user/update/{id}','updateuser')->name('user.updateuser');

     Route::get('user/consumerpostreportlist','consumerpostreportlist')->name('user.consumerpostreportlist');
     Route::post('shortconsumerReportList','shortconsumerReportList')->name('user.shortconsumerReportList');

     Route::get('user/sabpostreportlist','sabpostreportlist')->name('user.sabpostreportlist');
      Route::post('shortsabReportList','shortsabReportList')->name('user.shortsabReportList');

     Route::get('user/businesspostreportlist','businesspostreportlist')->name('user.businesspostreportlist');
      Route::post('shortbusinessReportList','shortbusinessReportList')->name('user.shortbusinessReportList');

      Route::get('user/activityreportlist','activityreportlist')->name('user.activityreportlist');
      Route::post('shortactivityreportlist','shortactivityreportlist')->name('user.shortactivityreportlist');

});

Route::controller(ContactController::class)->group(function(){
    Route::get('contact/list','list')->name('contact.list');
    Route::get('contact/add', 'add')->name('contact.add');
    Route::post('contact/save','save')->name('contact.save');
    Route::get('contact/edit/{id}', 'edit')->name('contact.edit');
    Route::post('contact/update/{id}','update')->name('contact.update');
    Route::get('contact/delete/{id}','delete')->name('contact.delete');
});

Route::controller(FaqController::class)->group(function(){
    Route::get('faq/list','list')->name('faq.list');
    Route::get('faq/add', 'add')->name('faq.add');
    Route::post('faq/save','save')->name('faq.save');
    Route::get('faq/edit/{id}','edit')->name('faq.edit');
    Route::post('faq/update/{id}','update')->name('faq.update');
    Route::get('faq/delete/{id}','delete')->name('faq.delete');
});

Route::controller(AboutController::class)->group(function(){
    Route::get('about/list','list')->name('about.list');
    Route::get('about/add', 'add')->name('about.add');
    Route::post('about/save','save')->name('about.save');
    Route::get('about/edit/{id}','edit')->name('about.edit');
    Route::post('about/update/{id}','update')->name('about.update');
    Route::get('about/delete/{id}','delete')->name('about.delete');
});

Route::controller(ServiceController::class)->group(function(){
    Route::get('service/list','list')->name('service.list');
    Route::get('service/add', 'add')->name('service.add');
    Route::post('service/save','save')->name('service.save');
    Route::get('service/edit/{id}','edit')->name('service.edit');
    Route::post('service/update/{id}','update')->name('service.update');
    Route::get('service/delete/{id}','delete')->name('service.delete');

    Route::get('service_enquiry/list','service_enquiry')->name('service_enquiry.list');
});

Route::controller(CategoryController::class)->group(function(){
    Route::get('category/list','list')->name('category.list');
    Route::get('category/add', 'add')->name('category.add');
    Route::post('category/save','save')->name('category.save');
    Route::get('category/edit/{id}','edit')->name('category.edit');
    Route::post('category/update/{id}','update')->name('category.update');
    Route::get('category/delete/{id}','delete')->name('category.delete');
});

Route::controller(ResourceController::class)->group(function(){
    Route::get('resource/list','list')->name('resource.list');
    Route::get('resource/add', 'add')->name('resource.add');
    Route::post('resource/save','save')->name('resource.save');
    Route::get('resource/edit/{id}','edit')->name('resource.edit');
    Route::post('resource/update/{id}','update')->name('resource.update');
    Route::get('resource/delete/{id}','delete')->name('resource.delete');
});
Route::controller(PincodeController::class)->group(function(){
    Route::get('pincode/list','list')->name('pincode.list');
    Route::get('pincode/add', 'add')->name('pincode.add');
    Route::post('pincode/save','save')->name('pincode.save');
    Route::get('pincode/edit/{id}','edit')->name('pincode.edit');
    Route::post('pincode/update/{id}','update')->name('pincode.update');
    Route::get('pincode/delete/{id}','delete')->name('pincode.delete');

    Route::get('unavailablepincode/list','unavaillist')->name('pincode.unavaillist');
});
Route::controller(PrivacyPolicyController::class)->group(function(){
    Route::get('privacypolicy/add', 'add')->name('privacypolicy.add');
    Route::post('privacypolicy/save','save')->name('privacypolicy.save');
    Route::get('privacypolicy/edit/{id}','edit')->name('privacypolicy.edit');
    Route::post('privacypolicy/update/{id}','update')->name('privacypolicy.update');
});
Route::controller(WeightController::class)->group(function(){
    Route::get('weight/list','list')->name('weight.list');
    Route::get('weight/add', 'add')->name('weight.add');
    Route::post('weight/save','save')->name('weight.save');
    Route::get('weight/edit/{id}','edit')->name('weight.edit');
    Route::post('weight/update/{id}','update')->name('weight.update');
    Route::get('weight/delete/{id}','delete')->name('weight.delete');
});
Route::controller(GoogleAdsenseController::class)->group(function(){
    Route::get('googleadsense/list','list')->name('googleadsense.list');
    Route::get('googleadsense/add', 'add')->name('googleadsense.add');
    Route::post('googleadsense/save','save')->name('googleadsense.save');
    Route::get('googleadsense/edit/{id}','edit')->name('googleadsense.edit');
    Route::post('googleadsense/update/{id}','update')->name('googleadsense.update');
    Route::get('googleadsense/delete/{id}','delete')->name('googleadsense.delete');
    Route::get('/changeGadsenseStatus','gadsense_status_update')->name('changeGadsenseStatus');
});

Route::get('/health', function () {
    return response()->json(['status' => 'OK'], 200);
});
