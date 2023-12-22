<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\UserController;
// DI CODE - Start
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\NewsletterController;

Auth::routes();

// DI CODE - End
Route::group([
    'name' => 'admin.',
    'prefix' => 'admin',
    'middleware' => ['auth:admin'],
], function () {
    // Admin Dashboard Route
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::resource('operator', \App\Http\Controllers\Admin\OperatorController::class);//Operator
    Route::resource('role', \App\Http\Controllers\Admin\RoleController::class);//Roles
    Route::resource('permission', \App\Http\Controllers\Admin\PermissionController::class);//Permissions

    Route::resource('category', \App\Http\Controllers\Admin\CategoryController::class);//Category
    Route::resource('area', \App\Http\Controllers\Admin\AreaController::class);//Area
    Route::resource('brand', \App\Http\Controllers\Admin\BrandController::class);//Brand
    Route::resource('model', \App\Http\Controllers\Admin\ModelController::class);//Model
	// DI CODE - Start
	// Ad
    Route::resource('ad', \App\Http\Controllers\Admin\AdController::class);
	Route::get('/adlist', [AdController::class, 'adlist'])->name('adlist');
	Route::get('/adblock', [AdController::class, 'adblock'])->name('adblock');
	Route::get('/adblocklist', [AdController::class, 'adblocklist'])->name('adblocklist');
	Route::get('/adfeatured', [AdController::class, 'adfeatured'])->name('adfeatured');
	Route::get('/adpriority', [AdController::class, 'adpriority'])->name('adpriority');
    Route::get('deleteMedia/{delId}', [\App\Http\Controllers\Admin\AdController::class, 'deleteMedia'])->name('deleteMedia');
	Route::post('/adimport', [AdController::class, 'adimport'])->name('adimport');
	Route::post('/adimagesimport', [AdController::class, 'adimagesimport'])->name('adimagesimport');
	Route::post('/createadimagesthumb', [AdController::class, 'createadimagesthumb'])->name('createadimagesthumb');

	// Catgeory - Delete - Slide Image
    Route::get('deleteCatSlide/{delId}', [\App\Http\Controllers\Admin\CategoryController::class, 'deleteCatSlide'])->name('deleteCatSlide');

	Route::get('/getbrand','App\Http\Controllers\Admin\CategoryController@getbrand')->name('getbrand');// Brand
	Route::resource('faq', \App\Http\Controllers\Admin\FaqController::class);// Faq
	Route::resource('notification', \App\Http\Controllers\Admin\NotificationController::class);// Notification
    Route::resource('post', \App\Http\Controllers\Admin\PostController::class);//Post
    Route::resource('content', \App\Http\Controllers\Admin\ContentController::class);//Content
	// DI CODE - End

    // User
    Route::resource('user', UserController::class);
	// DI CODE - Start
	Route::get('/userblock', [UserController::class, 'userblock'])->name('userblock');
	Route::get('/userblocklist', [UserController::class, 'userblocklist'])->name('userblocklist');

	// Newsletter
	Route::get('/newsletter', [NewsletterController::class, 'index'])->name('newsletter');
	Route::delete('/newsletter.destroy', [NewsletterController::class, 'destroy'])->name('newsletter.destroy');
	Route::get('/newsletterunsubcribe', [NewsletterController::class, 'newsletterunsubcribe'])->name('newsletterunsubcribe');
	// DI CODE - End

    // Contacts
    Route::get('/contactinfo', [SettingsController::class, 'contactinfo'])->name('contactinfo');
    Route::put('/contactinfoupdate', [SettingsController::class, 'contactinfoUpdate'])->name('contactinfo.update');
    Route::get('/feedback', [SettingsController::class, 'feedback'])->name('feedback');
    Route::delete('/feedback/{feedback}', [SettingsController::class, 'feedbackDelete'])->name('feedback.destroy');

    // Settings
    Route::get('/settings', [SettingsController::class, 'settings'])->name('admin.settings.show');
    Route::post('/settings', [SettingsController::class, 'settingsUpdate'])->name('admin.settings.update');
    Route::get('/settings/profile/', [SettingsController::class, 'showprofile'])->name('admin.profile.show');
    Route::post('/settings/profile/', [SettingsController::class, 'updateprofile'])->name('admin.profile.update');

    // Import from Old Db functionalities
    Route::get('/importolduser', [UserController::class, 'importOldUser'])->name('import.olduser');
    Route::group([
        'prefix' => 'import'
    ], function () {
        Route::get('/importolduser', [\App\Http\Controllers\Admin\ImportController::class, 'importOldUser'])->name('azhar.import.olduser');
        Route::get('/importoldads', [\App\Http\Controllers\Admin\ImportController::class, 'importOldAds'])->name('azhar.import.oldads');
    });

});

/* Admin Login Things */
// Logout Route
Route::post('admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Login Routes
Route::get('admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('admin/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
