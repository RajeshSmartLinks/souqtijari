<?php
// DI CODE - Start
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

	protected $guarded = [];
    protected $dates = ['post_date'];

    public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'post' . DIRECTORY_SEPARATOR;
    public static $imageMediumPath = 'uploads' . DIRECTORY_SEPARATOR . 'post' . DIRECTORY_SEPARATOR. 'medium' . DIRECTORY_SEPARATOR;
    public static $imageThumbPath = 'uploads' . DIRECTORY_SEPARATOR . 'post' . DIRECTORY_SEPARATOR. 'thumb' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/post/';
    public static $imageMediumUrl = 'uploads/post/medium/';
    public static $imageThumbUrl = 'uploads/post/thumb/';


	public static $noImageUrl = 'images/placeholder/noimage_homeblog.png';

    public function scopePushMessages($query)
    {
        $query->whereType('notification');
    }
}
// DI CODE - End
