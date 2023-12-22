<?php
// DI CODE - Start
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Newly Added
use Illuminate\Database\Eloquent\SoftDeletes;


class Faq extends Model
{
    //use HasFactory;
	use HasFactory, SoftDeletes;
	
	protected $guarded = [];
}
// DI CODE - End