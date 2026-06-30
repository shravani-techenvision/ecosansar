<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\FaqController;
use App\Http\Controllers\admin\ContactController;
use App\Http\Controllers\admin\AboutController;
use App\Http\Controllers\frontend\IndexController;
use App\Http\Controllers\frontend\ReusableController;
use App\Http\Controllers\frontend\MapController;
use App\Http\Controllers\frontend\EnquiryController;
use App\Http\Controllers\frontend\BlogDetailController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\ResourceController;
use App\Http\Controllers\admin\ReusableResourceController;
use App\Http\Controllers\admin\WeightController;
use App\Http\Controllers\admin\GoogleAdsenseController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\BlogController;
use App\Http\Controllers\admin\DownloadPosterController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\PrivacyPolicyController;
use App\Http\Controllers\admin\PincodeController;
use App\Http\Controllers\admin\SubscriptionModuleController;
use App\Http\Controllers\admin\PlanValidity;
use App\Http\Controllers\frontend\ServiceEnquiryController;
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
Route::get('/health', function () {
    return response('OK', 200);
});
Route::get('/usercounts', [MapController::class, 'getUserCounts'])->name('usercount');
Route::get('/geocode-address', [MapController::class, 'geocodeAddress'])->name('geocodeAddress');

Route::controller(IndexController::class)->group(function(){
    Route::get('/','index');
     Route::get('recyclable-choose-one','recyclable_choose_one')->name('recyclable-choose_one');
     Route::get('reusable-choose-one','reusable_choose_one')->name('reusable-choose_one');
     Route::get('profile/{id}','profile')->middleware('auth.user')->name('profile');
    Route::post('profile_update/{id}','profile_update')->name('profile_update');
      Route::post('consumer_save','consumer_save')->name('consumer.save');
     Route::get('about','about')->name('about');
      Route::get('privacypolicy','privacypolicy')->name('privacypolicy');
     Route::get('blog','blog')->name('blog');
     Route::get('blog-detail/{slug}','blog_detail')->name('blog.detail');
     Route::get('/blog/category/{slug}', 'categoryBlogs')->name('blog.category');
    Route::get('/blog/tag/{slug}', 'tagBlogs')->name('blog.tag');
    Route::get('/download-posters','downloadPoster')->name('download.posters');
    Route::post('download-poster/store-enquiry','storePosterEnquiry')->name('download.poster.enquiry');
    Route::get('/download-poster-file/{id}', 'downloadPosterFile')->name('download.poster.file');
    Route::post('/collection-drive/store', 'storeCollectionDrive')->name('collection.drive.store');
    
       Route::get('contact','contact')->name('contact');
         Route::get('faq','faq')->name('faq');
    Route::get('howitsworks','howitsworks')->name('howitsworks');
     Route::get('workwithus','workwithus')->name('workwithus');
     Route::get('service','service')->name('service');
      Route::get('repairmap','repairmap')->name('repairmap');
        Route::get('findcollectionagent','findcollectionagent')->name('findcollectionagent');
        Route::post('/search-pincode', 'searchPincode');
        Route::post('contact_store','contact_store')->name('contact_store');
          Route::get('/terms_conditions', 'terms_conditions')->name('terms_conditions');
        Route::post('repair_contact_store','repair_contact_store')->name('repair_contact_store');
    Route::get('listings','listings')->name('listings');

    Route::get('consumer_login', 'consumer_login')->name('consumer_login');
    //Route::post('send_otp','sendOtp')->name('send_otp');

    Route::post('resendOtp','resendOtp')->name('resend_Otp');

    Route::get('register_otp/{id}', 'register_otp')->name('register_otp');
     Route::get('activate_otp/{id}', 'activate_otp')->name('activate_otp');

    Route::get('loginverify_otp/{id}', 'loginverify_otp')->name('loginverify_otp');

    Route::post('/verify-otp', 'verifyOtp')->name('verify.otp');
     Route::post('/activate-verify-otp', 'activateverifyOtp')->name('activateverify.otp');
Route::get('/whatsapp/share', 'shareOnWhatsApp')->name('whatsapp.share');
    Route::post('consumer_store','consumer_store')->name('consumer.store');

    Route::get('recyclable_add_post','recyclable_add_post')->name('recyclable_add_post');
    Route::post('recyclable_post_save','recyclable_post_save')->name('recyclable_post_save');

    Route::get('recyclable_listing_details/{id}','recyclable_listing_details')->name('recyclable_listing_details');
     Route::get('recyclable_post_filter','recyclable_post_filter')->name('recyclable_post_filter');
     Route::get('/recyclable-post-sort', 'recyclable_post_sort')->name('recyclable_post_sort');
     Route::get('recyclablepostprofile/{id}','recyclablepostprofile')->name('recyclablepostprofile');
      Route::get('/api/pincodes', 'getPincodes');
       Route::post('/recyclable-posts/deactivate' ,'recyclable_deactivate')->name('recyclable-posts.deactivate');
       Route::post('/recyclable-posts/reactivate' ,'recyclable_reactivate')->name('recyclable-posts.reactivate');
       Route::post('/mark-as-fulfilled', 'markAsFulfilled');
        Route::get('get_recyclable_post_details','get_recyclable_post_details')->name('get_recyclable_post_details');
        Route::get('get_post_details','get_post_details')->name('get_post_details');

Route::post('/check-contact', 'checkContact')->name('check.contact');
    Route::get('user_register', 'user_register')->name('user_register');



    Route::get('/user_logout', 'signOut')->name('user_logout');
     Route::get('user_deactivate', 'user_deactivate')->name('user.user_deactivate');
      Route::get('user_activate/{id}', 'user_activate')->name('user.user_activate');
     Route::get('notify_me','notify_me')->name('notify_me');
     Route::post('notify_me_store','notify_me_store')->name('notify_me_store');
     Route::get('notify_me_edit/{id}','notify_me_edit')->name('notify_me_edit');
    Route::post('notify_me_update/{id}', 'notify_me_update')->name('notify_me_update');
    Route::get('/notification_logs', 'notification_logs')->name('notification_logs');
    Route::post('/update-notification-status/{id}', 'updateNotificationStatus')->name('updateNotificationStatus');
});
Route::controller(ReusableController::class)->group(function(){
     Route::get('reusable_listings','listings')->name('reusable_listings');
    Route::get('reusable_add_post','reusable_add_post')->name('reusable_add_post');
    Route::post('reusable_post_save','reusable_post_save')->name('reusable_post_save');
     Route::get('reusable_post_filter','reusable_post_filter')->name('reusable_post_filter');
     Route::get('/reusable-post-sort', 'reusable_post_sort')->name('reusable_post_sort');
     Route::get('reusable_listing_details/{id}','reusable_listing_details')->name('reusable_listing_details');
     Route::post('/reusable-item-enquiry', 'storeEnquiry')->name('reusable.item.enquiry.store');

     Route::post('reusable_enquiry_save','reusable_enquiry_save')->name('reusable_enquiry_save');
      Route::get('get_reusable_post_details','get_reusable_post_details')->name('get_reusable_post_details');
      Route::post('review/reusablereviewsave','reusablereviewsave')->name('review.reusablereviewsave');
       Route::post('/send-reusable-review-request/{id}',  'sendReusableReviewRequest')->name('sendReusableReviewRequest');
        Route::get('reusablepostprofile/{id}','reusablepostprofile')->name('reusablepostprofile');
        Route::post('/change-reusable-review-request/{id}',  'changeReusableReviewRequest')->name('changeReusableReviewRequest');
    Route::get('/edit-reusable-review/{id}/{rid}', 'editReusableReview')->name('edit.ReusableReview');
    Route::post('/reusable-update-review/{id}', 'reusableupdateReview')->name('update.reusablereview');
});
Route::controller(EnquiryController::class)->group(function(){

    Route::post('recyclable_enquiry_save','recyclable_enquiry_save')->name('recyclable_enquiry_save');
     Route::post('review/recyclablereviewsave','recyclablereviewsave')->name('review.recyclablereviewsave');
      Route::post('/send-review-request/{id}',  'sendReviewRequest')->name('sendReviewRequest');
    Route::post('/update-review/{id}', 'updateReview')->name('update.review');
    Route::post('/change-recyclable-review-request/{id}',  'changeReviewRequest')->name('changeReviewRequest');
    Route::get('/edit-recyclable-review/{id}/{rid}', 'editReview')->name('edit.conreview');
    Route::post('review/recyclablereviewsave','recyclablereviewsave')->name('review.recyclablereviewsave');
    Route::get('recyclableconnectreportlist','Consumerconnectreportlist')->name('user.recyclableconnectreportlist');
     Route::post('shortConsumerconnectReportList','shortConsumerconnectReportList')->name('user.shortConsumerconnectReportList');
    Route::get('reusableconnectreportlist','sabconnectreportlist')->name('user.reusableconnectreportlist');
     Route::post('shortsabconnectReportList','shortsabconnectReportList')->name('user.shortsabconnectReportList');
    // Route::get('Businessconnectreportlist','Businessconnectreportlist')->name('user.Businessconnectreportlist');

});
Route::controller(BlogDetailController::class)->group(function(){


    Route::post('comment/save', 'save')->name('comment.save');
    Route::post('/comment/reply', 'saveReply')->name('comment.savereply');

    Route::get('user_blog_add', 'user_blog_add')->name('user_blog_add');
    Route::post('user_blog/save', 'user_blog_save')->name('user_blog.save');
});

Route::controller(ServiceEnquiryController::class)->group(function(){
    Route::post('service_enquiry/save', 'service_enquiry_save')->name('service_enquiry.save');

});
Route::controller(PincodeCheckController::class)->group(function(){
  Route::post('/check-pincode', 'checkPincode')->name('check-pincode');
    Route::get('/service-not-available', 'servicenotavailable')->name('service-not-available');
     Route::post('/check-pincode-save', 'checkPincodeSave')->name('check-pincode-save');
     Route::get('/nearby-pincodes/{pincode}', 'nearby');
});

Auth::routes();

// Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index']);
// //Language Translation

// Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);
// Route::post('/formsubmit', [App\Http\Controllers\HomeController::class, 'FormSubmit'])->name('FormSubmit');

Route::get('/admin_login', [App\Http\Controllers\admin\AuthController::class, 'admin_login'])->name('admin_login');
Route::post('/admin_store', [App\Http\Controllers\admin\AuthController::class, 'admin_store'])->name('admin_store');
Route::get('/admin_logout', [App\Http\Controllers\admin\AuthController::class, 'signOut'])->name('admin.admin_logout');
Route::middleware(['auth', 'user-access'])->group(function () {
Route::get('/admin_dashboard', [App\Http\Controllers\admin\AuthController::class, 'admin_dashboard'])->name('admin_dashboard');
Route::get('/admin_profile/{id}', [App\Http\Controllers\admin\AuthController::class, 'admin_profile'])->name('admin.admin_profile');
Route::post('/admin_profile_update/{id}', [App\Http\Controllers\admin\AuthController::class, 'admin_profile_update'])->name('admin_profile_update');
Route::get('/changepassword/{id}', [App\Http\Controllers\admin\AuthController::class, 'changepassword'])->name('changepassword');
Route::post('/changepassword_store', [App\Http\Controllers\admin\AuthController::class, 'changepassword_store'])->name('changepassword_store');

Route::controller(AdminController::class)->group(function(){
    Route::post('user/post-access', 'changePostAccess')->name('user.collection.agent.post.access');  //Collection agent post access toggle
    Route::get('user/recyclableposts','recyclableposts')->name('user.recyclableposts');
     Route::get('user/recyclableposts/delete/{id}','recyclablepostsdelete')->name('recyclableposts.delete');
    Route::get('user/reusableposts','reusableposts')->name('user.reusableposts');
     Route::get('user/reusableposts/delete/{id}','reusablepostsdelete')->name('reusableposts.delete');
    Route::get('user/recyclablepostsview/{id}','recyclablepostsview')->name('user.recyclablepostsview');
    Route::get('user/reusablepostsview/{id}','reusablepostsview')->name('user.reusablepostsview');
    Route::get('user/recyclablereviews','recyclablereviews')->name('user.recyclablereviews');
    Route::get('user/reusablerreviews','reusablerreviews')->name('user.reusablerreviews');
    Route::get('user/edit/{id}','edituser')->name('user.edituser');
    Route::get('volunteer/list','volunteerlist')->name('volunteer.list');
    Route::get('volunteer/add', 'volunteeradd')->name('volunteer.add');
    Route::post('volunteer/save','volunteersave')->name('volunteer.save');
    Route::get('volunteer/edit/{id}', 'volunteeredit')->name('volunteer.edit');
    Route::post('volunteer/update/{id}','volunteerupdate')->name('volunteer.update');
    Route::get('volunteer/delete/{id}','volunteerdelete')->name('volunteer.delete');
     Route::get('/volunteerchangeStatus', 'volunteerchangeStatus')->name('user.volunteerchangeStatus');

    Route::get('user/businesslist','businesslist')->name('user.businesslist');
    Route::get('/changeStatus', 'changeStatus')->name('user.changeStatus');
     Route::post('user/businessassignplan','businessassignplan')->name('user.businessassignplan');
    Route::get('user/sablist','sablist')->name('user.sablist');
    
    Route::get('user/consumerlist','consumerlist')->name('user.consumerlist');
    Route::get('user/businessview/{id}','businessview')->name('user.businessview');
    Route::get('user/sabview/{id}','sabview')->name('user.sabview');
    Route::get('user/consumerview/{id}','consumerview')->name('user.consumerview');
    Route::get('user/recyclablepostreportlist','recyclablepostreportlist')->name('user.recyclablepostreportlist');
    Route::get('user/reusablepostreportlist','reusablepostreportlist')->name('user.reusablepostreportlist');
    Route::post('shortrecyclableReportList','shortrecyclableReportList')->name('user.shortrecyclableReportList');
     Route::post('shortreusableReportList','shortreusableReportList')->name('user.shortreusableReportList');

    Route::get('user/usercontact','usercontact')->name('user.usercontact');
     Route::get('user/delete/{id}','deleteuser')->name('user.deleteuser');

     Route::post('user/update/{id}','updateuser')->name('user.updateuser');

     Route::get('user/consumerpostreportlist','consumerpostreportlist')->name('user.consumerpostreportlist');
     Route::post('shortconsumerReportList','shortconsumerReportList')->name('user.shortconsumerReportList');
      Route::get('user/activityreportlist','activityreportlist')->name('user.activityreportlist');
      Route::post('shortactivityreportlist','shortactivityreportlist')->name('user.shortactivityreportlist');
       Route::get('user/requestfulfilledlist','requestfulfilledlist')->name('user.requestfulfilledlist');


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

Route::controller(PrivacyPolicyController::class)->group(function(){
    Route::get('privacypolicy/add', 'add')->name('privacypolicy.add');
    Route::post('privacypolicy/save','save')->name('privacypolicy.save');
    Route::get('privacypolicy/edit/{id}','edit')->name('privacypolicy.edit');
    Route::post('privacypolicy/update/{id}','update')->name('privacypolicy.update');
});
Route::controller(SettingController::class)->group(function(){
    Route::get('breadcrumimage/add', 'add')->name('breadcrumimage.add');
    Route::post('breadcrumimage/save','save')->name('breadcrumimage.save');
    Route::get('breadcrumimage/edit/{id}','edit')->name('breadcrumimage.edit');
    Route::post('breadcrumimage/update/{id}','update')->name('breadcrumimage.update');
});

Route::controller(WeightController::class)->group(function(){
    Route::get('weight/list','list')->name('weight.list');
    Route::get('weight/add', 'add')->name('weight.add');
    Route::post('weight/save','save')->name('weight.save');
    Route::get('weight/edit/{id}','edit')->name('weight.edit');
    Route::post('weight/update/{id}','update')->name('weight.update');
    Route::get('weight/delete/{id}','delete')->name('weight.delete');
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
Route::controller(ReusableResourceController::class)->group(function(){
    Route::get('reusable_resource/list','list')->name('reusable_resource.list');
    Route::get('reusable_resource/add', 'add')->name('reusable_resource.add');
    Route::post('reusable_resource/save','save')->name('reusable_resource.save');
    Route::get('reusable_resource/edit/{id}','edit')->name('reusable_resource.edit');
    Route::post('reusable_resource/update/{id}','update')->name('reusable_resource.update');
    Route::get('reusable_resource/delete/{id}','delete')->name('reusable_resource.delete');
    Route::get('/reusable-item-enquiry-list','reusableEnquiryList')->name('reusable_item_enquiry.list');
    Route::get('/reusable-resource-enquiry/delete/{id}','enquiryDestroy')->name('reusable_resource_enquiry.delete');
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
Route::controller(GoogleAdsenseController::class)->group(function(){
    Route::get('googleadsense/list','list')->name('googleadsense.list');
    Route::get('googleadsense/add', 'add')->name('googleadsense.add');
    Route::post('googleadsense/save','save')->name('googleadsense.save');
    Route::get('googleadsense/edit/{id}','edit')->name('googleadsense.edit');
    Route::post('googleadsense/update/{id}','update')->name('googleadsense.update');
    Route::get('googleadsense/delete/{id}','delete')->name('googleadsense.delete');
    Route::get('/changeGadsenseStatus','gadsense_status_update')->name('changeGadsenseStatus');
});
Route::controller(BlogController::class)->group(function(){
        Route::get('blog_category_list','blog_category_list')->name('blog.blog_category_list');
        Route::get('blog_category_add','blog_category_add')->name('blog.blog_category_add');
        Route::post('blog_category_save','blog_category_save')->name('blog.blog_category_save');
        Route::get('blog_category_edit/{id}','blog_category_edit')->name('blog.blog_category_edit');
        Route::post('blog_category_update/{id}','blog_category_update')->name('blog.blog_category_update');
        Route::get('blog_category_delete/{id}','blog_category_delete')->name('blog.blog_category_delete');

        Route::get('blog_tag_list','blog_tag_list')->name('blog.blog_tag_list');
        Route::get('blog_tag_add','blog_tag_add')->name('blog.blog_tag_add');
        Route::post('blog_tag_save','blog_tag_save')->name('blog.blog_tag_save');
        Route::get('blog_tag_edit/{id}','blog_tag_edit')->name('blog.blog_tag_edit');
        Route::post('blog_tag_update/{id}','blog_tag_update')->name('blog.blog_tag_update');
        Route::get('blog_tag_delete/{id}','blog_tag_delete')->name('blog.blog_tag_delete');

        Route::get('admin_blog_list','blog_list')->name('admin_blog_list');
        Route::get('admin_blog_add','blog_add')->name('admin_blog_add');
        Route::post('admin_blog_save','blog_save')->name('admin_blog_save');
        Route::get('admin_blog_edit/{id}','blog_edit')->name('admin_blog_edit');
        Route::post('admin_blog_update/{id}','blog_update')->name('admin_blog_update');
        Route::get('admin_blog_delete/{id}','blog_delete')->name('admin_blog_delete');
        Route::get('admin_blog_view/{id}','blog_view')->name('admin_blog_view');
        Route::get('/admin_changeBlogStatus','changeBlogStatus')->name('admin_changeBlogStatus');

        Route::get('comment_list','comment_list')->name('blog.comment_list');
        Route::get('/changeCommentStatus','comment_status_update')->name('changeCommentStatus');
        Route::get('comment_reply_list','comment_reply_list')->name('blog.comment_reply_list');
        Route::get('/changeCommentReplyStatus','commentreply_status_update')->name('changeCommentReplyStatus');

         Route::post('/upload-image','upload')->name('upload.image');
});

Route::controller(DownloadPosterController::class)->group(function(){
    Route::get('download-posters-list', 'index')->name('download_posters.index');
    Route::get('download-posters/add', 'create')->name('download_posters.create');
    Route::post('download-posters/store','store')->name('download_posters.store');
    Route::get('download-posters/edit/{id}','edit')->name('download_posters.edit');
    Route::post('download-posters/update/{id}','update')->name('download_posters.update');
    Route::get('download-posters/delete/{id}','destroy')->name('download_posters.delete');
    Route::post('download-posters/status','changeStatus')->name('download_posters.status');
});
});
Route::middleware(['auth', 'superadmin:superadmin'])->group(function () {
    Route::controller(AdminController::class)->group(function(){
Route::get('adminuser/list','adminuserlist')->name('adminuser.list');
Route::get('adminuser/add','adminuseradd')->name('adminuser.add');
 });
 Route::get('/changeAdminStatus',[App\Http\Controllers\admin\AuthController::class, 'changeAdminStatus'])->name('changeAdminStatus');


Route::controller(SubscriptionModuleController::class)->group(function(){
    Route::get('subscription/list','list')->name('subscription.list');
    Route::get('subscription/add', 'add')->name('subscription.add');
    Route::post('subscription/save','save')->name('subscription.save');
    Route::get('subscription/edit/{id}','edit')->name('subscription.edit');
    Route::post('subscription/update/{id}','update')->name('subscription.update');
    Route::get('subscription/view/{id}','view')->name('subscription.view');
    Route::get('/changeSubscriptionStatus','changeSubscriptionStatus')->name('changeSubscriptionStatus');
});
Route::controller(PlanValidity::class)->group(function(){
    Route::get('planvalidity/list','list')->name('planvalidity.list');
    Route::get('planvalidity/add', 'add')->name('planvalidity.add');

});
});

Route::middleware(['auth:volunteer'])->group(function () {
    Route::get('/volunteer_dashboard', [App\Http\Controllers\admin\AuthController::class, 'volunteer_dashboard'])->name('volunteer_dashboard');

    Route::controller(BlogController::class)->group(function(){
        Route::get('volunteer_blog_category_list','blog_category_list')->name('blog.volunteer_blog_category_list');
        Route::get('volunteer_blog_category_add','blog_category_add')->name('blog.volunteer_blog_category_add');
        Route::post('volunteer_blog_category_save','blog_category_save')->name('blog.volunteer_blog_category_save');
        Route::get('blog_category_edit/{id}','blog_category_edit')->name('blog.blog_category_edit');
        Route::post('blog_category_update/{id}','blog_category_update')->name('blog.blog_category_update');
        Route::get('blog_category_delete/{id}','blog_category_delete')->name('blog.blog_category_delete');

        Route::get('volunteer_blog_tag_list','blog_tag_list')->name('volunteer_blog_tag_list');
        Route::get('volunteer_blog_tag_add','blog_tag_add')->name('volunteer_blog_tag_add');
        Route::post('volunteer_blog_tag_save','blog_tag_save')->name('volunteer_blog_tag_save');
        Route::get('volunteer_blog_tag_edit/{id}','blog_tag_edit')->name('volunteer_blog_tag_edit');
        Route::post('volunteer_blog_tag_update/{id}','blog_tag_update')->name('volunteer_blog_tag_update');
        Route::get('volunteer_blog_tag_delete/{id}','blog_tag_delete')->name('volunteer_blog_tag_delete');

        Route::get('blog_list','blog_list')->name('blog.blog_list');
        Route::get('blog_add','blog_add')->name('blog.blog_add');
        Route::post('blog_save','blog_save')->name('blog.blog_save');
        Route::get('blog_edit/{id}','blog_edit')->name('blog.blog_edit');
        Route::post('blog_update/{id}','blog_update')->name('blog.blog_update');
        Route::get('blog_delete/{id}','blog_delete')->name('blog.blog_delete');
        Route::get('blog_view/{id}','blog_view')->name('blog.blog_view');
        Route::get('/changeBlogStatus','changeBlogStatus')->name('changeBlogStatus');

        Route::get('volunteer_comment_list','comment_list')->name('volunteer_comment_list');
        Route::get('/volunteer_changeCommentStatus','comment_status_update')->name('volunteer_changeCommentStatus');
        Route::get('volunteer_comment_reply_list','comment_reply_list')->name('volunteer_comment_reply_list');
        Route::get('/volunteer_changeCommentReplyStatus','commentreply_status_update')->name('volunteer_changeCommentReplyStatus');
});
});


