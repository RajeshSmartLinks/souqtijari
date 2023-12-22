<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Models\Post;
use App\pushmessage;
use App\Toaster;
use Illuminate\Http\Request;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use phpDocumentor\Reflection\Types\Self_;

class NotificationController extends BaseApiController
{

    public function index()
    {
        $strLang = app()->getLocale();

        $title = 'title_' . $strLang;
        $message = 'description_' . $strLang;

        $lists = Post::pushMessages()->limit(5)->orderBy('id', 'desc')->get();
        if ($lists->count() > 0) {
            foreach ($lists as $list) {
                $items[] = [
                    "id" => $list->id,
                    "title" => $list->$title,
                    "message" => $list->$message,
                ];
            }
            return $this->sendResponse(self::HTTP_OK, ['data' => $items, 'message' => trans('app.success')]);
        } else {
            return $this->sendResponse(self::HTTP_ERR, ['message' => trans('app.failed')]);
        }

    }

    public function sendTopic()
    {
        sendNotificationFcm('/topics/updates', 'General Notification', "Hello! THis is the sample notification", 5);
        // $this->sendFcmNotification('title', 'title', 'skjdfasdf', 'hkskdf', '/topics/updates');
    }

    public function sendOrder($userId = 0)
    {
        $fcmToken = "FCM Token";

        if ($userId) {
            $userData = User::find($userId);
            $fcmToken = $userData->fcm_token;
        }

        sendNotificationFcm($fcmToken, '#987654 Your order is confirmed', "Dear Mohammed, Hurray! Your order has been confirmed", 17, "order");
    }
}
