<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public $myTitle;
    public $myName;
    public $myDescription;

    // SMS Things
    public $smsClientUrl = "https://www.kwtsms.com/API/";
    public $smsApiUsername = "smartlinks";
    public $smsApiPassword = "Kuwait@786";
    public $smsApiSenderName = "SOUQ TIJARI";

    public function __construct()
    {
        $this->myTitle = 'title_' . app()->getLocale();
        $this->myName = 'name_' . app()->getLocale();
        $this->myDescription = 'description_' . app()->getLocale();
    }

    public function getMyName()
    {
        return $this->myName = 'name_' . app()->getLocale();
    }

    public function deleteImageBuddy($imagePath, $imageName)
    {
        $originalPath = $imagePath;

        // Delete the previous image
        $imageCheck = $originalPath . $imageName;

        if (\File::exists($imageCheck)) {
            \File::delete($imageCheck);
        }
        return true;
    }

    public function genOtp()
    {
        return mt_rand(123456, 999999);
    }

    public function sendSms($smsContent, $numbers, $type = 'otp')
    {
        $res = [];
        $value = 0;

        $sendSmsUrl = $this->smsClientUrl . 'send/';

        if (!empty($numbers) && !empty($smsContent)) {

            $postValue = [
                'username' => $this->smsApiUsername,
                'password' => $this->smsApiPassword,
                'sender' => $this->smsApiSenderName,
                'mobile' => $numbers,
                'lang' => 1,
                'message' => $smsContent,
            ];

            $response = Http::get($sendSmsUrl, $postValue);
            $status = $response->status();

            if ($status == 200) {
                $value = 1;
            }
        }

        $res['status'] = $status;
        $res['value'] = $value;

        return $res;
    }

}
