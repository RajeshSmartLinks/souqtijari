<?php
// DI CODE - Start
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'ads_ad_id',
        'user_id',
        'status',
    ];
}
// DI CODE - End