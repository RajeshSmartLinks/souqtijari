<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Permissions\HasPermissionsTrait;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasPermissionsTrait, HasApiTokens;

    const ADMIN_TYPE = 'admin';
    const DEFAULT_TYPE = 'default';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'email',
        'password',
        'mobile',
        'mobile_otp',
        'username',
        'country_code',
        'gender',
        'is_migrated',
        'admin_type',
        'status',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'mobile_otp',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static $imagePath = 'uploads' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR;
    public static $imageThumbPath = 'uploads' . DIRECTORY_SEPARATOR . 'user' . DIRECTORY_SEPARATOR . 'thumb' . DIRECTORY_SEPARATOR;
    public static $imageUrl = 'uploads/user/';
    public static $imageThumbUrl = 'uploads/user/thumb/';
	// DI CODE - Start
	public static $noImageUrl = 'images/placeholder/noimage_user.jpg';
	// DI CODE - End

    public function scopeNonSmartOnly($query)
    {
        return $query->where('id', '!=', '1');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

    // Return the user single role
    public function hisRole()
    {
        $role = $this->roles()->first();
        return $role;
    }

    public function hasRole($role_slug)
    {
        foreach ($this->roles as $role) {
            if ($role->slug == $role_slug) {
                return true;
            }
        }
        return false;
    }

    public function assignRole($role)
    {
        $this->roles()->attach($role);
    }

    public function isAdmin()
    {
        return $this->type === self::ADMIN_TYPE;
    }
}
