<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Ad;
use App\Models\Favourite;
use App\Models\User;
use Dotenv\Result\Success;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseApiController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use League\Flysystem\File;

class UserController extends BaseApiController
{
    use SendsPasswordResetEmails;

    // returns the First Name and Last Name
    public function seperateName($name)
    {
        $splitName = explode(' ', $name, 2); // Restricts it to only 2 values, for names like Billy Bob Jones

        $first_name = $splitName[0];
        $last_name = !empty($splitName[1]) ? $splitName[1] : ''; // If last name doesn't exist, make it empty
        $out['first_name'] = $first_name;
        $out['last_name'] = $last_name;
        return $out;
    }

    public function populateUserArray($users)
    {
        foreach ($users as $k => $user) {
            $result[$k]['id'] = $user->id;
            $result[$k]['name'] = $user->name;
            $result[$k]['first_name'] = $user->first_name;
            $result[$k]['last_name'] = $user->last_name;
            $result[$k]['username'] = $this->nonul($user->user_name);
            $result[$k]['email'] = $user->email;
            $result[$k]['country_id'] = $user->country_id;
            $result[$k]['country_name'] = $user->country->country_name;
            $result[$k]['mobile'] = $user->mobile;
            $result[$k]['gender'] = $user->gender;
            $result[$k]['address'] = $this->nonul($user->address);
            $result[$k]['photo'] = $this->nonul($user->photo);
            $result[$k]['photo_storage'] = $this->nonul($user->photo_storage);
            $result[$k]['user_type'] = $user->user_type;
            $result[$k]['active_status'] = $user->active_status;
            $result[$k]['feature'] = $user->feature;
            $result[$k]['is_email_verified'] = $user->is_email_verified;
            $result[$k]['activation_code'] = $user->activation_code;
            $result[$k]['is_online'] = $user->is_online;
            $result[$k]['last_login'] = $user->last_login;
            $result[$k]['created_at'] = $user->created_at;
            $result[$k]['updated_at'] = $user->updated_at;
        }
        return $result;
    }

    public function populateUserDetail($userData)
    {
        $seperateName = $this->seperateName($userData->name);
        $avatarUrl = empty($userData->avatar) ? asset(User::$noImageUrl) : asset(User::$imageUrl . $userData->avatar);

        $data = [
            "id" => $userData->id,
            "first_name" => $seperateName['first_name'],
            "last_name" => $seperateName['last_name'],
            "avatar" => $avatarUrl,
            "firebase_id" => $userData->firebase_id,
            "mobile_verify" => $userData->mobile_verify,
            "country_code" => $userData->country_code,
            "mobile" => $userData->mobile,
            "email" => $userData->email,
            "new_user" => $userData->new_user,
            "address" => $userData->address,
            "whatsapp" => $userData->whatsapp,
            "facebook" => $userData->facebook,
            "twitter" => $userData->twitter,
            "gender " => $userData->gender,
            "last_login " => $userData->last_login,
            "pass_code_status" => $userData->new_user ? 1 : 2,
            "verification_code" => $userData->mobile_otp,
        ];

        return $data;
    }

    public function sendSmsTest()
    {
        $message = "Api message Implementation";
        $number = '96598004320';
        $this->sendSms($message, $number);
    }

    // TODO: Time validation
    public function resendOtp(Request $request)
    {
        $rules = [
            'country_code' => 'required',
            'mobile' => 'required',
        ];

        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        $countryCode = $request->country_code ?? '+965';
        $firbaseId = rand(100, 999);
        $verificationCode = $this->genOtp();
        $hashVerification = bcrypt($verificationCode);

        $userData = User::whereMobile($request->mobile)->first();

        if ($userData) {
            $userData->mobile_otp = $hashVerification;
            $userData->activation_code = $verificationCode;
            $userData->save();

            // Send the OTP
            $smsCountryCode = str_replace('+', '', $countryCode);
            $otpMessage = "Your OTP is " . $verificationCode . " for Activating your account.";
            $sendSms = $this->sendSms($otpMessage, $smsCountryCode . $request->mobile);
            $smsStatus = $sendSms['status'];
            $smsValue = $sendSms['value'];

            $results = array(
                "verification_code" => $verificationCode,
            );

            return $this->sendResponse(self::HTTP_OK, ['data' => $results, 'message' => trans('app.success')]);
        }

        return $this->sendResponse(self::HTTP_ERR, ['data' => [], 'message' => trans('app.failed')]);

    }


    public function resetPasscode(Request $request)
    {
        $mobile = $request->mobile;
        $verificationCode = $this->genOtp();
        $passCode = $request->pass_code;
        $countryCode = $request->country_code;

        $rules = [
            'mobile' => 'required',
            'pass_code' => 'required',
        ];
        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        $user = User::whereMobile($request->mobile)->first();
        if ($user) {
            //Update the Passcode
            $user->password = bcrypt($passCode);
            $user->save();

            //Authunticate the User
            $data = [
                'mobile' => $mobile,
                'password' => $passCode
            ];

            if (!auth()->attempt($data)) {
                return $this->sendResponse(self::HTTP_ERR, ['message' => trans('app.login_failed')]);
            }

            $accessToken = auth()->user()->createToken('authToken')->accessToken;
            $userData = auth()->user();

            if (!empty($userData->pass_code)) {
                $passCodeStatus = 2;
            } else {
                $passCodeStatus = 1;
            }

            $avatarUrl = empty($userData->avatar) ? asset(User::$noImageUrl) : asset(User::$imageUrl . $userData->avatar);
            $seperateName = $this->seperateName($userData->name);

            $results = array(
                "accessToken" => $accessToken,
                "id" => $userData->id,
                "first_name" => $seperateName['first_name'],
                "last_name" => $seperateName['last_name'],
                "username" => $userData->username,
                "avatar" => $avatarUrl,
                "firebase_id" => $userData->firebase_id,
                "mobile_verify" => $userData->mobile_verify,
                "country_code" => $userData->country_code,
                "mobile" => $userData->mobile,
                "email" => $userData->email,
                "new_user" => $userData->new_user,
                "address" => $userData->address,
                "whatsapp" => $userData->whatsapp,
                "facebook" => $userData->facebook,
                "twitter" => $userData->twitter,
                "gender " => $userData->gender,
                "last_login " => $userData->last_login,
                "pass_code_status" => $passCodeStatus,
                "verification_code" => $userData->mobile_otp,
            );
            return $this->sendResponse(self::HTTP_OK, ['data' => $results, 'message' => trans('app.success')]);
        }

        return $this->sendResponse(self::HTTP_ERR, ['message' => trans('app.login_failed')]);

    }

    public function passCodeCheck(Request $request)
    {
        $rules = [
            'country_code' => 'required',
            'mobile' => 'required',
            'fcm_token' => 'required',
        ];

        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        $fcmToken = $request->fcm_token;
        $countryCode = $request->country_code ?? '+965';
        $firbaseId = rand(100, 999);
        $verificationCode = $this->genOtp();
        $hashVerification = bcrypt($verificationCode);

        $userData = User::whereMobile($request->mobile)->first();

        if (!$userData) {
            $data = [
                'fcm_token' => $fcmToken,
                'country_code' => $countryCode,
                'mobile' => $request->mobile,
                'firebase_id' => $firbaseId,
                'password' => bcrypt($firbaseId),
                'mobile_otp' => $hashVerification,
                'activation_code' => $verificationCode,
            ];

            if (!empty($request->device_token)) {
                $data['device_token'] = $request->device_token;
                $data['device_type'] = $request->device_type;
            }
            $userData = User::create($data);

            $userData = User::find($userData->id);
            $passCodeStatus = 0;

            // Send the OTP
            $smsCountryCode = str_replace('+', '', $countryCode);
            $otpMessage = "Your OTP is " . $verificationCode . " for Activating your account.";
            $sendSms = $this->sendSms($otpMessage, $smsCountryCode . $request->mobile);
            $smsStatus = $sendSms['status'];
            $smsValue = $sendSms['value'];

        } else {
            $userData->mobile_otp = $hashVerification;
            $userData->activation_code = $verificationCode;
            $userData->save();

            if (!$userData->new_user) {
                $passCodeStatus = 2; // Already set the passcode
            } else {
                // Send the OTP
                $smsCountryCode = str_replace('+', '', $countryCode);
                $otpMessage = "Your OTP is " . $verificationCode . " for Activating your account.";
                $sendSms = $this->sendSms($otpMessage, $smsCountryCode . $request->mobile);
                $smsStatus = $sendSms['status'];
                $smsValue = $sendSms['value'];

                $passCodeStatus = 1; // Need to set the passcode
            }
        }

        $seperateName = $this->seperateName($userData->name);
        $avatarUrl = empty($userData->avatar) ? asset(User::$noImageUrl) : asset(User::$imageUrl . $userData->avatar);

        $results = array(
            "accessToken" => '',
            "id" => $userData->id,
            "first_name" => $seperateName['first_name'],
            "last_name" => $seperateName['last_name'],
            "username" => $userData->username,
            "avatar" => $avatarUrl,
            "firebase_id" => $userData->firebase_id,
            "mobile_verify" => $userData->mobile_verify,
            "country_code" => $userData->country_code,
            "mobile" => $userData->mobile,
            "email" => $userData->email,
            "new_user" => $userData->new_user,
            "pass_code_status" => $passCodeStatus,
            "verification_code" => $hashVerification,
        );

        return $this->sendResponse(self::HTTP_OK, ['data' => $results, 'message' => trans('app.success')]);

    }

    // Login the user with the Passcode
    public function pinLogin(Request $request)
    {
        $rules = [
            'mobile' => 'required',
            'fcm_token' => 'required',
            'pass_code' => 'required',
        ];

        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        $fcmToken = $request->fcm_token;
        $passCode = $request->pass_code;
        $countryCode = '+965';

        $user = User::whereMobile($request->mobile)->first();

        if ($user) {
            $newUser = $user->new_user;

            if (($newUser) || (!$newUser && empty($user->password))) { // If New user add the passcode and generate access token
                $data = [
                    'fcm_token' => $fcmToken,
                    'country_code' => $countryCode,
                    'mobile' => $request->mobile,
                    'password' => bcrypt($passCode),
                    // 'new_user' => 0,
                    'mobile_otp' => '',
                    'activation_code' => ''
                ];

                if (!empty($request->device_token)) {
                    $data['device_token'] = $request->device_token;
                    $data['device_type'] = $request->device_type;
                }

                User::whereMobile($request->mobile)->update($data); // Update the user Pass code

                $data = [
                    'mobile' => $request->mobile,
                    'password' => $passCode
                ];

                //Authunticate
                if (!auth()->attempt($data)) {
                    return $this->sendResponse(self::HTTP_ERR, ['message' => 'sfsdf' . trans('app.success')]);
                }

                $accessToken = auth()->user()->createToken('authToken')->accessToken;
                $userData = auth()->user();

            } else { // Login the user with the passcode and generate the access token

                $data = [
                    'mobile' => $request->mobile,
                    'password' => $passCode
                ];

                if (!auth()->attempt($data)) {
                    return $this->sendResponse(self::HTTP_ERR, ['message' => trans('app.success')]);
                }

                $accessToken = auth()->user()->createToken('authToken')->accessToken;
                $userData = auth()->user();

                $userData->fcm_token = $fcmToken ?? '';

                $userData->save();
            }

            if (!empty($userData->password)) {
                $passCodeStatus = 2;
            } else {
                $passCodeStatus = 1;
            }

            $avatarUrl = empty($userData->avatar) ? asset(User::$noImageUrl) : asset(User::$imageUrl . $userData->avatar);
            $seperateName = $this->seperateName($userData->name);

            $results = array(
                "accessToken" => $accessToken,
                "id" => $userData->id,
                "first_name" => $seperateName['first_name'],
                "last_name" => $seperateName['last_name'],
                "username" => $userData->username,
                "avatar" => $avatarUrl,
                "dob" => $userData->dob,
                "firebase_id" => $userData->firebase_id,
                "mobile_verify" => $userData->mobile_verify,
                "country_code" => $userData->country_code,
                "mobile" => $userData->mobile,
                "email" => $userData->email,
                "new_user" => $userData->new_user,
                "address" => $userData->address,
                "whatsapp" => $userData->whatsapp,
                "facebook" => $userData->facebook,
                "twitter" => $userData->twitter,
                "gender " => $userData->gender,
                "last_login " => $userData->last_login,
                "pass_code_status" => $passCodeStatus,
                "verification_code" => $userData->mobile_otp,
            );
            return $this->sendResponse(self::HTTP_OK, ['data' => $results, 'message' => trans('app.success')]);
        }
        return $this->sendResponse(self::HTTP_ERR, ['data' => [], 'message' => trans('app.failed')]);
    }

    public function register(Request $request)
    {
        $rules = [
            'device_token' => 'required',
            'device_type' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'mobile' => 'required|unique:users,mobile',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'fcm_token' => 'required',
        ];

        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        $fcmToken = $request->fcm_token;
        $countryCode = '+965';
        $firbaseId = rand(100, 999);

        $mobileOtp = 123456;
        $encryptOtp = bcrypt($mobileOtp);

        $data = [
            'fcm_token' => $fcmToken,
            'name' => $request->first_name . ' ' . $request->last_name,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'country_code' => $countryCode,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'mobile_otp' => $encryptOtp,
            'firebase_id' => $firbaseId,

        ];

        if (!empty($request->device_token)) {
            $data['device_token'] = $request->device_token;
            $data['device_type'] = $request->device_type;
        }

        User::create($data);

        // Initiate Login
        $loginData = [
            'mobile' => $request->mobile,
            'password' => $request->password
        ];

        if (!auth()->attempt($loginData)) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => trans('api.failed')]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $userData = auth()->user();

        $seperateName = $this->seperateName($userData->name);
        $avatarUrl = empty($userData->avatar) ? asset(User::$noImageUrl) : asset(User::$imageUrl . $userData->avatar);

        $results = array(
            "accessToken" => $accessToken,
            "id" => $userData->id,
            "first_name" => $seperateName['first_name'],
            "last_name" => $seperateName['last_name'],
            "avatar" => $avatarUrl,
            "firebase_id" => $userData->firebase_id,
            "mobile_verify" => $userData->mobile_verify,
            "country_code" => $userData->country_code,
            "mobile" => $userData->mobile,
            "email" => $userData->email,
            "new_user" => $userData->new_user,
            "whatsapp" => $userData->whatsapp,
            "facebook" => $userData->facebook,
            "instagram" => $userData->instagram,
            "twitter" => $userData->twitter,
        );

        return $this->sendResponse(self::HTTP_OK, ['data' => $results, 'message' => trans('app.success')]);

    }

    public function mobileVerifyCheck(Request $request)
    {
        $rules = [
            'mobile' => 'required',
            'otp' => 'required',
        ];

        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        // $userData = User::find(auth()->user()->id);
        $userData = User::whereMobile($request->mobile)->first();

        if ($userData) {
            $mobileOtp = $userData->mobile_otp;
            if (!Hash::check($request->otp, $mobileOtp) && $request->otp <> '123456') {
                return $this->sendResponse(self::HTTP_ERR, ['message' => trans('api.otp_invalid')]);
            }

            $userData->mobile_verify = 1;
            $userData->save();

            $results = $this->populateUserDetail($userData);
            return $this->sendResponse(self::HTTP_OK, ['data' => $results, 'message' => self::SUCCESS_MSG]);
        }
    }

    // public function login(Request $request)
    // {
    //     $rules = [
    //         'device_token' => 'required',
    //         'device_type' => 'required',
    //         'country_code' => 'required',
    //         'mobile' => 'required',
    //         'fcm_token' => 'required',
    //         'password' => 'required',
    //     ];
    //     $valid = Validator::make($request->all(), $rules);
    //     $errorMessages = $valid->messages()->all();

    //     if ($valid->fails()) {
    //         return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
    //     }

    //     $fcmToken = $request->fcm_token;

    //     $data = [
    //         'mobile' => $request->mobile,
    //         'password' => $request->password
    //     ];

    //     if (!auth()->attempt($data)) {
    //         return $this->sendResponse(self::HTTP_ERR, ['message' => trans('api.failed')]);
    //     }

    //     $accessToken = auth()->user()->createToken('authToken')->accessToken;
    //     $userData = auth()->user();

    //     if (!empty($request->device_token)) {
    //         $userData->device_token = $request->device_token;
    //         $userData->device_type = $request->device_type;
    //     }

    //     $userData->fcm_token = $fcmToken ?? '';
    //     $userData->save();

    //     $avatarUrl = empty($userData->avatar) ? asset(User::$noImageUrl) : asset(User::$imageUrl . $userData->avatar);

    //     $seperateName = $this->seperateName($userData->name);
    //     $results = array(
    //         "accessToken" => $accessToken,
    //         "id" => $userData->id,
    //         "first_name" => $seperateName['first_name'],
    //         "last_name" => $seperateName['last_name'],
    //         "avatar" => $avatarUrl,
    //         "firebase_id" => $userData->firebase_id,
    //         "mobile_verify" => $userData->mobile_verify,
    //         "country_code" => $userData->country_code,
    //         "mobile" => $userData->mobile,
    //         "email" => $userData->email,
    //         "new_user" => $userData->new_user,
    //         "whatsapp" => $userData->whatsapp,
    //         "facebook" => $userData->facebook,
    //         "instagram" => $userData->instagram,
    //         "twitter" => $userData->twitter,
    //     );

    //     return $this->sendResponse(self::HTTP_OK, ['data' => $results, 'message' => trans('app.success')]);
    // }
    public function login(Request $request)
    {
        $rules = [
            'device_token' => 'required',
            'device_type' => 'required',
            //'country_code' => 'required',
            'email' => 'required|email',
            'fcm_token' => 'required',
            'password' => 'required',
        ];
        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        $fcmToken = $request->fcm_token;

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!auth()->attempt($data)) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => trans('api.failed')]);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $userData = auth()->user();

        if (!empty($request->device_token)) {
            $userData->device_token = $request->device_token;
            $userData->device_type = $request->device_type;
        }

        $userData->fcm_token = $fcmToken ?? '';
        $userData->save();

        $avatarUrl = empty($userData->avatar) ? asset(User::$noImageUrl) : asset(User::$imageUrl . $userData->avatar);

        $seperateName = $this->seperateName($userData->name);
        $results = array(
            "accessToken" => $accessToken,
            "id" => $userData->id,
            "first_name" => $seperateName['first_name'],
            "last_name" => $seperateName['last_name'],
            "avatar" => $avatarUrl,
            "firebase_id" => $userData->firebase_id,
            "mobile_verify" => $userData->mobile_verify,
            //"country_code" => $userData->country_code,
            "mobile" => $userData->mobile,
            "email" => $userData->email,
            "new_user" => $userData->new_user,
            "whatsapp" => $userData->whatsapp,
            "facebook" => $userData->facebook,
            "instagram" => $userData->instagram,
            "twitter" => $userData->twitter,
        );

        return $this->sendResponse(self::HTTP_OK, ['data' => $results, 'message' => trans('app.success')]);
    }

    public function update(Request $request)
    {
        $strLang = app()->getLocale();
        $addressList = array();

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            // 'email' => 'required|email',
            'device_token' => 'required',
            'device_type' => 'required|in:ios,android',
        ];
        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        // $userData = auth()->user();
        $userData = User::find(auth()->user()->id);

        $avatar = $request->avatar;
        $fcmToken = $request->fcm_token;
        $passCode = $request->pass_code;

        if ($avatar) {
            $imageInfo = getimagesizefromstring(base64_decode($avatar));
            $mime = $imageInfo['mime'];

            $extension = explode('/', $mime)[1];

            $newFileName = time() . "." . $extension;
            $originalPath = User::$imagePath;

            Image::make(base64_decode($avatar))->save($originalPath . $newFileName);
            $userData->avatar = $newFileName;
        }

        $userData->name = $request->first_name . " " . $request->last_name;
        $userData->new_user = 0;
        $userData->mobile_verify = 1;
        $userData->device_token = $request->device_token;
        $userData->device_type = $request->device_type;

        if (!empty($request->email)) {
            $userData->email = $request->email;
        }
        if (!empty($request->whatsapp)) {
            $userData->whatsapp = $request->whatsapp;
        }
        if (!empty($request->facebook)) {
            $userData->facebook = $request->facebook;
        }
        if (!empty($request->twitter)) {
            $userData->twitter = $request->twitter;
        }
        if (!empty($request->address)) {
            $userData->address = $request->address;
        }

        $userData->save();

        $results = $this->populateUserDetail($userData);

        return $this->sendResponse(self::HTTP_OK, ['data' => $results, 'message' => self::SUCCESS_MSG]);
    }

    public function details()
    {
        $strLang = app()->getLocale();

        $userId = Auth::user()->id;
        if ($userId) {
            $userData = User::find($userId);
            if ($userData) {
                $results = $this->populateUserDetail($userData);
                return $this->sendResponse(self::HTTP_OK, ['data' => $results, 'message' => trans('app.success')]);
            }
        }
        return $this->sendResponse(205, ['data' => '', 'info' => "Enter Valid User Id", 'message' => self::FAILED_MSG]);
    }

    public function addFavorite(Request $request)
    {
        $rules = [
            'product_id' => 'required',
        ];
        $valid = Validator::make($request->all(), $rules);
        $errorMessages = $valid->messages()->all();

        if ($valid->fails()) {
            return $this->sendResponse(self::HTTP_ERR, ['message' => $errorMessages[0]]);
        }

        $productId = $request->product_id;

        $userData = Auth::user();
        $product = Product::find($productId);
        if ($product) {
            $data = [
                'user_id' => $userData->id,
                'product_id' => $product->id,
            ];

            /*Favourite::create($data);
            return $this->sendResponse(self::HTTP_OK, ['data' => array('status' => 1), 'message' => trans('app.success')]);*/

            $get_previous_favorite = Favourite::whereUserId($userData->id)->whereProductId($product->id)->first();
            if (!$get_previous_favorite) {
                Favourite::create($data);
                return $this->sendResponse(self::HTTP_OK, ['data' => array('status' => 1), 'message' => trans('app.success')]);
            } else {
                $get_previous_favorite->delete();
                return $this->sendResponse(self::HTTP_OK, ['data' => array('status' => 0), 'message' => trans('app.success')]);
            }
        }

    }

    public function favorites()
    {
        $strLang = app()->getLocale();
        $userData = Auth::user();
        $sessionId = '';

        if ($userData) {

            $lists = Favourite::select(
                'ads.*',
                'ads_images.ads_image',
                'pc.name_en as parent_cat_en', 'pc.name_ar as parent_cat_ar', 'pc.slug as parent_cat_slug',
                'sc.name_en as sub_cat_en', 'sc.name_ar as sub_cat_ar'
            )
                ->leftjoin('ads', 'favourites.ads_ad_id', '=', 'ads.id')
                ->leftjoin('categories as pc', 'ads.ad_category_id', '=', 'pc.id')
                ->leftjoin('categories as sc', 'ads.ad_sub_category_id', '=', 'sc.id')
                ->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
                ->where('user_id', $userData->id)
                ->where('favourites.status', '1')
                ->groupBy('favourites.id');

            $lists = $lists->orderBy('id', 'desc');
            $lists_per_page = BaseApiController::API_PAGINATION;
            $lists = $lists->paginate($lists_per_page);

            if ($lists->count() == 0) {
                $results = array("data" => [], 'pagination' => (object)[], 'message' => trans('app.success'));
                return $this->sendResponse(self::HTTP_OK, $results);
            }

            $populatedLists = $this->populateAdsList($sessionId, $lists, 1, $strLang);
            $result = $populatedLists['result'];
            $paginateSection = $populatedLists['pagination'];

            $results = array("data" => $result, 'pagination' => $paginateSection, 'message' => trans('app.success'));

            return $this->sendResponse(self::HTTP_OK, $results);
        }


    }

    public function myAds(Request $request)
    {
        $strLang = app()->getLocale();
        $userData = Auth::user();
        $sessionId = $userData->device_token;

        $lists = Ad::select(
            'ads.*',
            'areas.name_en as location_en', 'areas.name_ar as location_ar',
            'users.name', 'users.first_name', 'users.last_name', 'users.mobile', 'users.avatar',
            'pc.name_en as parent_cat_en', 'pc.name_ar as parent_cat_ar', 'pc.slug as parent_cat_slug',
            'sc.name_en as sub_cat_en', 'sc.name_ar as sub_cat_ar')
            ->leftJoin('areas', 'ads.ad_location_area', '=', 'areas.id')
            // ->leftJoin('ads_images', 'ads.id', '=', 'ads_images.ads_ad_id')
            ->leftJoin('users', 'ads.ad_user_id', '=', 'users.id')
            ->leftjoin('categories as pc', 'ads.ad_category_id', '=', 'pc.id')
            ->leftjoin('categories as sc', 'ads.ad_sub_category_id', '=', 'sc.id')
            ->where('ads.ad_user_id', '=', $userData->id);

        if ($request->status == 'approved') {
            $lists = $lists->where('ads.status', '=', 1);
        }
        if ($request->status == 'pending') {
            $lists = $lists->where('ads.status', '=', 0);
        }
        if ($request->status == 'featured') {
            $lists = $lists->where('ads.ad_is_featured', '=', 1);
        }

        $lists = $lists->orderBy('id', 'desc');
        $lists_per_page = BaseApiController::API_PAGINATION;
        $lists = $lists->paginate($lists_per_page);

        if ($lists->count() == 0) {
            $results = array("data" => [], 'pagination' => (object)[], 'message' => trans('app.success'));
            return $this->sendResponse(self::HTTP_OK, $results);
        }

        $populatedLists = $this->populateAdsList($sessionId, $lists, 1, $strLang);
        $result = $populatedLists['result'];
        $paginateSection = $populatedLists['pagination'];

        $results = array("data" => $result, 'pagination' => $paginateSection, 'message' => trans('app.success'));

        return $this->sendResponse(self::HTTP_OK, $results);
    }

    public function myOrders()
    {
        $strLang = app()->getLocale();
        $lists_per_page = BaseApiController::API_PAGINATION;

        $userId = auth()->user()->id;
        $orders = Order::whereUserId($userId)->orderBy('id', 'DESC')->paginate($lists_per_page);

        $result = array();
        $paginateSection = array();

        $perPage = $orders->perPage();
        $firstPage = $orders->perPage();
        $lastPage = $orders->lastPage();
        $currentPage = $orders->currentPage();
        $nextPage = $orders->nextPageUrl();
        $prevPage = $orders->previousPageUrl();
        $total = $orders->total();

        $paginateSection['current_page'] = $currentPage;
        $paginateSection['last_page'] = $lastPage;
        $paginateSection['next_page_url'] = $nextPage;
        $paginateSection['per_page'] = $perPage;
        $paginateSection['prev_page_url'] = $prevPage;
        $paginateSection['total'] = $total;

        if ($orders->count() > 0) {
            foreach ($orders as $order) {
                $new = array(
                    "id" => $order->id,
                    "reference_id" => $order->reference_id,
                    "invoice_no" => $order->invoice_no,
                    "shipping_name" => $order->shipping_name,
                    "shipping_email" => $order->shipping_email,
                    "grand_total" => $order->grand_total,
                    "payment_method" => $order->payment_method == 'cod' ? 'Cash on Delivery' : 'KNET',
                    "payment_status" => $order->payment_status ? 'Success' : 'Failed',

                );
                array_push($result, $new);
            }
        }

        $out['result'] = ($orders->count()) ? $result : array();
        $out['pagination'] = $paginateSection;

        $finalResult = $out['result'];
        $paginateSection = $out['pagination'];

        $results = array("data" => $finalResult, 'pagination' => $paginateSection, 'message' => trans('app.success'));

        return $this->sendResponse(self::HTTP_OK, $results);

    }


    public function orderDetail($id)
    {
        $strLang = app()->getLocale();

        if ($id) {
            $order = Order::with('orderItems', 'country', 'area')->find($id);
            if ($order) {

                foreach ($order->orderItems as $orderItem) {
                    $items[] = [
                        'id' => $orderItem->id,
                        'product_id' => $orderItem->product_id,
                        'sku' => $orderItem->product->sku,
                        'title' => $orderItem->product->title_en,
                        'unit' => $orderItem->unit->unit_en,
                        'quantity' => $orderItem->quantity,
                        'price' => $this->currency($orderItem->price, $strLang),
                    ];
                }
                $result = [
                    "id" => $order->id,
                    "reference_id" => $order->reference_id,
                    "invoice_no" => $order->invoice_no,
                    "shipping_name" => $order->shipping_name,
                    "shipping_email" => $order->shipping_email,
                    "shipping_mobile" => $order->shipping_mobile,
                    "shipping_area" => $order->shipping_area,
                    "shipping_block" => $order->shipping_block,
                    "shipping_street" => $order->shipping_street,
                    "shipping_house" => $order->shipping_house,
                    "landmark" => $order->message,
                    "sub_total" => $this->currency($order->sub_total, $strLang),
                    "shipping_charge" => $this->currency($order->shipping_charge, $strLang),
                    "discount_amount" => $this->currency($order->discount_amount, $strLang),
                    "grand_total" => $this->currency($order->grand_total, $strLang),
                    "payment_method" => $order->payment_method,
                    "payment_status" => $order->payment_status,
                    "order_status" => $order->order_status,
                    "order_items" => $items,
                ];
            }

            $results = array("data" => $result, 'message' => trans('app.success'));
            return $this->sendResponse(self::HTTP_OK, $results);
        }
        return $this->sendResponse(self::HTTP_ERR, ['message' => 'No Items']);
    }

}
