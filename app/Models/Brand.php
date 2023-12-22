<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'brand' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/brand/';


    public function ads()
    {
        return $this->hasMany(Ad::class);
    }
	// DI CODE - Start
	/*public function parent()
    {
        return $this->belongsTo(Brand::Class, 'category_id');
    }*/
	// DI CODE - End
}
