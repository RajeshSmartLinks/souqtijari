<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\AdController;
use App\Http\Controllers\Api\V1\UserController;

Route::group(['prefix' => 'v1'], function () {
    Route::get('home/{device_token?}', [HomeController::class, 'index']);
    Route::get('categories', [HomeController::class, 'categories']);
    Route::get('brands', [HomeController::class, 'brands']);
    Route::get('content/{keyword}', [HomeController::class, 'getContentPage']);
    Route::get('areas/{state_id?}', [HomeController::class, 'areas']);
    Route::get('faq', [HomeController::class, 'faq']);

    Route::post('register', [UserController::class, 'register']); // Register
    Route::post('login', [UserController::class, 'login']); // Login Step 2

    Route::post('passCodeCheck', [UserController::class, 'passCodeCheck']); // Step 1
    Route::post('pinlogin', [UserController::class, 'pinLogin']); // Step 2
    Route::post('verify', [UserController::class, 'mobileVerifyCheck']); // Mobile OTP Verification
    Route::post('otp/resend', [UserController::class, 'resendOtp']); // Resend OTP Verification
    Route::post('forgotpassword', [UserController::class, 'resendOtp']); // Forgot Password
    Route::post('resetpasscode', [UserController::class, 'resetPasscode']); // Reset Passcode

    Route::get('smstest', [UserController::class, 'sendSmsTest']);

    Route::group(['prefix' => 'ads'], function () {
        Route::post('/', [AdController::class, 'index']);
        Route::post('/detail', [AdController::class, 'detail']);
        Route::post('/edit', [AdController::class, 'edit'])->middleware('auth:api');// Edit Ad
        Route::post('/create', [AdController::class, 'createAd'])->middleware('auth:api'); // Post Ad
        Route::post('/update', [AdController::class, 'update'])->middleware('auth:api'); // Update Ad
        Route::post('/makefav', [AdController::class, 'makeFavourite'])->middleware('auth:api'); // Favourite the Ad

        // Media section
        Route::post('uploadimage', [AdController::class, 'uploadAdsImage'])->middleware('auth:api'); // Upload the ad images
        Route::post('makefeature', [AdController::class, 'makeFeatureMedia'])->middleware('auth:api'); // Make the Media feature
        Route::post('media', [AdController::class, 'grabMediaImages'])->middleware('auth:api'); // Grabs Media Images
        Route::get('media/{id}/delete', [AdController::class, 'deleteMediAd'])->middleware('auth:api'); // Delete Media Image
    });

    Route::group(['prefix' => 'user', 'middleware' => ['auth:api']], function () {
        Route::get('detail', [UserController::class, 'details']);
        Route::post('updateprofile', [UserController::class, 'update']);
        Route::post('ads', [UserController::class, 'myAds']);
        Route::get('favourites', [UserController::class, 'favorites']);
        Route::post('favourites/add', 'Api\V1\UserController@addFavorite');
        Route::get('orders', 'Api\V1\UserController@myOrders');
        Route::get('order/{id}', 'Api\V1\UserController@orderDetail');

    });

    Route::group(['prefix' => 'notification'], function () {
        Route::get('/', [\App\Http\Controllers\Api\V1\NotificationController::class, 'index']);
        Route::get('test/topic', 'Api\V1\NotificationController@sendTopic');
        Route::get('test/order/{id?}', 'Api\V1\NotificationController@sendOrder');
    });
});

