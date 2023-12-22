<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Image;
use League\Flysystem\File;

class SettingsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param \App\Admin $admin
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $title = "Settings";

        $settings = Setting::find(1);
        $loggedUser = auth()->user();
        $avatar = !empty($loggedUser->avatar) ? asset(User::$imageUrl . $loggedUser->avatar) : '';

        return view('admin.settings.settings', compact('title', 'loggedUser', 'avatar', 'settings'));
    }

    public function settingsUpdate(Request $request)
    {
        $settings = Setting::find(1);

        $settings->sitename_en = $request->sitename_en;
        $settings->sitename_ar = $request->sitename_ar;
        $settings->app_ios_url = $request->app_ios_url;
        $settings->app_android_url = $request->app_android_url;

        $settings->host = $request->host;
        $settings->port = $request->port;
        $settings->email = $request->email;
        $settings->from_name = $request->from_name;
        $settings->smtp_password = $request->smtp_password;
        $settings->smtp_encryption = $request->smtp_encryption;

        $settings->save();
        return redirect()->route('admin.settings.show')->with('success', 'Updated Successfully');
    }

    public function showprofile()
    {
        $title = "Edit Profile";
        $loggedUser = auth()->user();
        $avatar = !empty($loggedUser->avatar) ? asset(User::$imageUrl . $loggedUser->avatar) : '';

        return view('admin.settings.profile-edit', compact('title', 'loggedUser', 'avatar'));
    }

    public function updateprofile(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email',
        ]);

        $admin = auth()->user();

        $originalImage = $request->file('profile_image');

        if ($originalImage != NULL) {
            $newFileName = time() . $originalImage->getClientOriginalName();
            $thumbnailPath = User::$imageThumbPath;
            $originalPath = User::$imagePath;

            // Delete the previous image
            $this->deleteImageBuddy(User::$imagePath, $admin->avatar);
            $this->deleteImageBuddy(User::$imageThumbPath, $admin->avatar);

            // Image Upload Process
            $thumbnailImage = Image::make($originalImage);

            $thumbnailImage->save($originalPath . $newFileName);
            $thumbnailImage->resize(150, 150);
            $thumbnailImage->save($thumbnailPath . $newFileName);

            $admin->avatar = $newFileName;
        }

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->whatsapp = $request->whatsapp;
        $admin->instagram = $request->instagram;

        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        return redirect(route('admin.profile.show'))->with('success', 'Updated Successfully');

    }

    public function contactInfo()
    {
        $titles = ['title' => "Update Contact Information", 'sub_title' => "Edit Contact Info"];
        $contactInfo = Setting::first();
        return view('admin.contact.edit', compact('titles', 'contactInfo'));
    }

    public function contactInfoUpdate(Request $request)
    {
        $setting = Setting::find(1);

        $data = [
            "contact_email" => $request->contact_email,
            "contact_phone" => $request->contact_phone,
            "contact_mobile" => $request->contact_mobile,
            "facebook_url" => $request->facebook_url,
            "instagram_url" => $request->instagram_url,
			// DI CODE - Start
            "twitter_url" => $request->twitter_url,
			// DI CODE - End
            "contact_whatsapp" => $request->contact_whatsapp,
            "contact_address" => $request->contact_address,
        ];
        $setting->update($data);
        return redirect()->route('contactinfo')->with('success', "Updated Successfully");
    }

    public function feedback()
    {
        $titles = ['title' => "Feedbacks", 'sub_title' => "Feedback Enquiries"];

        $lists = Feedback::all();
        $deleteRouteName = "feedback.destroy";

        return view('admin.contact.feedback', compact('titles', 'lists', 'deleteRouteName'));
    }

    public function feedbackDelete(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('feedback')->with('success', 'Deleted Successfully');
    }


}
