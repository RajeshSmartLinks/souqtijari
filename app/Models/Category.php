<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

	// DI CODE - Start	
    public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'category' . DIRECTORY_SEPARATOR;
    public static $imageMediumPath = 'uploads' . DIRECTORY_SEPARATOR . 'category' . DIRECTORY_SEPARATOR . 'medium' . DIRECTORY_SEPARATOR;
    public static $imageThumbPath = 'uploads' . DIRECTORY_SEPARATOR . 'category' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/category/';
    public static $imageMediumUrl = 'uploads/category/medium/';
    public static $imageThumbUrl = 'uploads/category/thumb/';
	
	public static $noImageUrl = 'images/placeholder/noimage_homeblog.png';
	// DI CODE - End

    public function scopeActive($query)
    {
        return $query->whereStatus('1');
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
}
