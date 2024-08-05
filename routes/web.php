<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AdminLoginController;

// DI CODE - Start
// Newly Added
use Illuminate\Support\Facades\App;
use App\Http\Controllers\AdController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\CustomResetPasswordController;

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

/*Route::get('/', function () {
    return view('welcome');
});*/



/*Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/localize/{lang}', [HomeController::class, 'changeLang'])->name('changelang');
Route::get('/lang/{lang}', [HomeController::class, 'changeLang'])->name('changelang');*/

/*Route::get('/greeting/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'ar'])) {
        abort(400);
    }

	app()->setLocale('ar');
    // App::setLocale($locale);
	echo app()->getLocale();

    return redirect()->route('home');
})->name('greeting');*/


Route::get('/', function () {
    // return redirect(app()->getLocale());
    return redirect(app()->getLocale() . '/home');
});

Route::get('/en', function () {
    return redirect('en/home');
});
Route::get('/ar', function () {
    return redirect('/ar/home');
});

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
// Custom Password Reset Routes
Route::get('/reset-password/{token}', [CustomResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [CustomResetPasswordController::class, 'reset'])->name('custom-password.update');



Route::group([
    'prefix' => '{locale}',
    'where' => ['locale' => '[a-zA-Z]{2}'],
    'middleware' => 'setlocale'], function () {

    /*Route::get('/', function () {
        return view('home');
    });*/

    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get('/password-reset-status', [CustomResetPasswordController::class, 'resetstatus'])->name('password.reset.status');

    // Listing - Search
    Route::get('/ad/category/list/{catname?}', [AdController::class, 'index'])->name('ad.category.list');
    Route::get('/ad/user/list/{user?}', [AdController::class, 'index'])->name('ad.user.list');
    Route::get('/ad/location/list/{location?}', [AdController::class, 'index'])->name('ad.location.list');
    //Route::post('/search', [AdController::class, 'index'])->name('ad.search');
    //Route::match(array('GET','POST'),'/search', [AdController::class, 'index'])->name('ad.search');
    //Route::any('/search', [AdController::class, 'index'])->name('ad.search');
    Route::post('/dosearch', [AdController::class, 'doSearch'])->name('ad.dosearch'); // Session based

    // Login
    Route::get('/userlogin', [UserController::class, 'userlogin'])->name('userlogin');
    Route::post('/userlogin', [UserController::class, 'login'])->name('user.login.submit');
    Route::post('/loginpoup', [UserController::class, 'loginpoup'])->name('user.login.popup');
    Route::post('/userregister', [UserController::class, 'register'])->name('user.register.submit');
    Route::get('/userforgot', [UserController::class, 'viewforgot'])->name('userforgot');
    Route::post('/userforgot', [UserController::class, 'forgot'])->name('user.forgot.submit');
    Route::get('/userforgototp', [UserController::class, 'viewforgototp'])->name('userforgototp');
    Route::post('/userforgototp', [UserController::class, 'forgototp'])->name('user.forgototp.submit');

    // User
    Route::group([
        'middleware' => 'userdashboard'], function () {
        Route::get('/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard');
        Route::post('/userupdate', [UserController::class, 'userupdate'])->name('user.update.submit');
        Route::get('/myads', [UserController::class, 'myads'])->name('user.ads');
        Route::get('/createad', [AdController::class, 'createad'])->name('createad');
        Route::get('/getsubcategory', [AdController::class, 'getsubcategory'])->name('getsubcategory');
        Route::get('/getcountryAreas', [AdController::class, 'getcountryAreas'])->name('getcountryAreas');
        Route::get('/getbrandname', [AdController::class, 'getbrandname'])->name('getbrandname');
        Route::post('/adcreate', [AdController::class, 'adcreate'])->name('adcreate');

        // Image uploading in Create Ad and Edit Ad
        Route::post('/upload-a-image', [AdController::class, 'uploadAdsImage'])->name('upload_ads_image');
        Route::get('/append-media-image', [AdController::class, 'appendMediaImage'])->name('append_media_image');
        Route::post('/feature-media-creating', [AdController::class, 'featureMediaCreatingAds'])->name('feature_media_creating_ads');
        Route::get('/deleteMediAd/{delId?}', [AdController::class, 'deleteMediAd'])->name('deleteMediAd');

        //Route::get('/ad/{id?}/edit',[AdController::class, 'showedit'])->name('showedit');
        Route::get('/showedit/{id?}', [AdController::class, 'showedit'])->name('showedit');
        Route::post('/doedit', [AdController::class, 'doedit'])->name('doedit');
        Route::get('/deletead', [AdController::class, 'deletead'])->name('deletead');
        Route::get('/adfavourite', [AdController::class, 'adfavourite'])->name('adfavourite');
        Route::get('/myfavourites', [UserController::class, 'myfavourites'])->name('user.favourites');
    });

    //Ad
    Route::get('/viewad/{id?}', [\App\Http\Controllers\AdController::class, 'viewad'])->name('viewad');
    // News
    Route::get('/news', [\App\Http\Controllers\NewsController::class, 'index'])->name('news');
    Route::get('/news/{slug?}', [\App\Http\Controllers\NewsController::class, 'getSingle'])->name('news.detail');
    // Content Pages
    Route::get('/about', [\App\Http\Controllers\NewsController::class, 'aboutUs'])->name('content.about');
    Route::get('/privacy-policy', [\App\Http\Controllers\NewsController::class, 'privacyPolicy'])->name('content.privacy');
    Route::get('/terms-and-conditions', [\App\Http\Controllers\NewsController::class, 'terms'])->name('content.terms');
    // Newsletter
    Route::post('/newsletter', [NewsletterController::class, 'index'])->name('newsletter.submit');
    // Contact Us
    Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('contact');
    Route::post('/contact-us', [HomeController::class, 'contactSubmit'])->name('contact.submit');
    // Categories
    Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
    // Faq
    Route::get('/faq', [\App\Http\Controllers\HomeController::class, 'faq'])->name('faq');

});


Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Home Page - Categories
//Route::get('/category/{catname}', [AdController::class, 'index'])->name('ad.category.list');

// DI CODE - End
//route for data migration
Route::get('/DumpUser', [\App\Http\Controllers\DataMigrationController::class, 'DumpUsers']);

Route::get('/UploadOldAds', [\App\Http\Controllers\DataMigrationController::class, 'uploadOldAds']);
Route::get('/UploadOldUsers', [\App\Http\Controllers\DataMigrationController::class, 'uploadOldUsers']);
Route::get('/dumpArears', [\App\Http\Controllers\DataMigrationController::class, 'dumpArears']);
Route::get('/dumpoldNew', [\App\Http\Controllers\DataMigrationController::class, 'dumpoldTabletOneTable']);
Route::get('/updateareas', [\App\Http\Controllers\DataMigrationController::class, 'updateareas']);