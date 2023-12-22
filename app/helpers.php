<?php

//use App\User;
use Illuminate\Support\Str;

// DI CODE - Start
// Newly Added
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

// DI CODE - End

function unique_slug($title = '', $model = 'Ad', $id = '')
{
    $slug = Str::slug($title);
    //get unique slug...
    $nSlug = $slug;
    $i = 0;

    $model = str_replace(' ', '', "\App\Models\ " . $model);
    $slugcount = $model::whereSlug($nSlug);
    if (!empty($id)) {
        $slugcount = $slugcount->where('id', '!=', $id);
    }
    $slugcount = $slugcount->count();

    while (($model::whereSlug($nSlug)->count()) > 0) {
        $i++;
        $nSlug = $slug . '-' . $i;
    }
    if ($i > 0) {
        $newSlug = substr($nSlug, 0, strlen($slug)) . '-' . $i;
    } else {
        $newSlug = $slug;
    }
    return $newSlug;
}

function flySlug($title)
{
    return $slug = Str::slug($title);
}

function currency($amount, $strLang = "en", $decimal = '0')
{
    $amount = empty($amount) ? "0" : $amount;
    $formatted = number_format($amount, $decimal, '.', '');

    $aligned = $formatted . ' ' . getenv('KD_AR');
    if ($strLang == 'en') {
        $aligned = $formatted . ' ' . getenv('KD_EN');
    }
    return $aligned;
}

function showAvatar($imageName)
{
    // DI CODE - Start
    $imageUrl = asset('images/placeholder/noimage_user.jpg');
    // DI CODE - End
    if ($imageName) {
        $imageUrl = asset(\App\Models\User::$imageUrl . $imageName);
    }
    return $imageUrl;
}

// DI CODE - Start
function showAboutUs()
{
    $details = Post::whereSlug('about-us')->first();

    $lang = app()->getLocale();
    $description = 'description_' . $lang;
    return strip_tags(substr($details->$description, 0, 200)) . '...';
}

function menucatads()
{
    $categories = Category::select('categories.id', 'categories.name_en', 'categories.name_ar', 'categories.slug', 'categories.image', DB::raw('COUNT(' . DB::getTablePrefix() . 'ads.ad_category_id) as catcount'))
        ->rightJoin('ads', 'categories.id', '=', 'ads.ad_category_id')
        ->where('categories.category_id', '0')
        ->where('ads.status', '=', '1')
        ->whereNull('ads.deleted_at')
        ->groupBy('categories.id')
        ->orderByDesc('catcount')
        ->take(5)
        ->get();
    return $categories;
}

function userdetails()
{
    // User Details - Sidebar
    $user = auth()->user();
    $userdetails = User::find($user->id);
    if (!empty($userdetails->first_name) && !empty($userdetails->last_name)) {
        $fullname = $userdetails->first_name . ' ' . $userdetails->last_name;
    } else {
        $fullname = $userdetails->name;
    }
    $data = [
        'user_full_name' => $fullname,
        'user_avatar' => !empty($userdetails->avatar) ? asset(User::$imageThumbUrl . $userdetails->avatar) : asset(User::$noImageUrl),
    ];
    return $data;
}

// DI CODE - End
