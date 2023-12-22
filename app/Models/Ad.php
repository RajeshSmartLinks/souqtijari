<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// DI CODE - Start
use Illuminate\Database\Eloquent\SoftDeletes;
// DI CODE - End

class Ad extends Model
{
	// DI CODE - Start
    //use HasFactory;
	use HasFactory, SoftDeletes;
	
	protected $guarded = [];
	/*protected $fillable = [
        'ad_category_id',
		'ad_title',
		'slug',
		'ad_description',
		'ad_user_id',
		'ad_seller_name',
		'ad_seller_email',
		'ad_seller_phone',
    ];*/

	public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'ad' . DIRECTORY_SEPARATOR;
    public static $imageMediumPath = 'uploads' . DIRECTORY_SEPARATOR . 'ad' . DIRECTORY_SEPARATOR . 'medium' . DIRECTORY_SEPARATOR;
    public static $imageThumbPath = 'uploads' . DIRECTORY_SEPARATOR . 'ad' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/ad/';
    public static $imageMediumUrl = 'uploads/ad/medium/';
    public static $imageThumbUrl = 'uploads/ad/thumb/';
    //public static $noImageUrl = 'images/placeholder/product-no-image.jpg';
	
	public static $noImageUrl = 'images/placeholder/noimage_ad.jpg';

	// For calling from any Controller as Ad::active()
    public function scopeActive($query)
    {
        return $query->whereStatus('1');
    }
	/*// If used Foreign Key Concept in ads table --- For calling from any Controller as "Ad::active()->with('categories', 'brands')->orderBy('id', 'desc')->limit(10)->get();"*/
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
	public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
	
	

    public function scopeActiveParent($query)
    {
        return $query->whereStatus('1')->whereCategoryId(0);
    }

    public function scopeActiveBanner($query)
    {
        return $query->whereStatus('1')
            ->where('banner_image', '!=', '');
    }

    public function parent()
    {
        return $this->belongsTo(Category::Class, 'category_id');
    }

    public function child()
    {
        return $this->hasMany(Category::Class, 'category_id');
    }
	// DI CODE - End
}
