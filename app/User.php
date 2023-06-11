<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'mail', 'password', 'images',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'following_id', 'followed_id');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'following_id');
    }

    public function getImagesAttribute($value)
    {
        return $value ? '/images/' . $value : '/images/avatar.jpeg';
    }

    public function isFollowing($followed_id)
    {
        return DB::table('follows')->where([
            ['following_id', '=', $this->id],
            ['followed_id', '=', $followed_id],
        ])->exists();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
