<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

	// DI CODE - Start
	public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'area' . DIRECTORY_SEPARATOR;
    public static $imageMediumPath = 'uploads' . DIRECTORY_SEPARATOR . 'area' . DIRECTORY_SEPARATOR . 'medium' . DIRECTORY_SEPARATOR;
    public static $imageThumbPath = 'uploads' . DIRECTORY_SEPARATOR . 'area' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/area/';
    public static $imageMediumUrl = 'uploads/area/medium/';
    public static $imageThumbUrl = 'uploads/area/thumb/';
	
	public static $noImageUrl = 'images/placeholder/noimage_area.jpg';
	// DI CODE - End

    public function scopeActive($query)
    {
        return $query->whereStatus('1');
    }

    public function scopeActiveParent($query)
    {
        return $query->whereStatus('1')->whereAreaId(0);
    }

    public function parent()
    {
        return $this->belongsTo(Area::Class, 'area_id');
    }
	// DI CODE - Start
	public function child()
    {
        return $this->hasMany(Area::Class, 'area_id');
    }
	// DI CODE - End

}
