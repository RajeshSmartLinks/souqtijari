<?php
// DI CODE - Start
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
	
	protected $fillable = [
        'sessionid',
        'ipaddress',
        'date',
    ];
}
// DI CODE - End