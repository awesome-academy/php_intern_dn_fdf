<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'city',
        'address',
        'phone',
        'avatar_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
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

    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorite_products');
    }

    public function ratings()
    {
        return $this->belongsToMany(Product::class, 'ratings', 'user_id', 'product_id')
                    ->withPivot('num_rated', 'content')->withTimestamps()
                    ->orderBy('pivot_created_at', 'desc');
    }

    public function suggestProducts()
    {
        return $this->hasMany(Suggest::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function getAvatarAttribute()
    {
        return $this->avatar_path != '' ? $this->avatar_path : 'img/ava-default.png';
    }

    public function checkListFavoriteExistProduct($product)
    {
        foreach ($this->favoriteProducts as $favorite) {
            if ($favorite->id == $product->id) {
                return false;
            }
        }

        return true;
    }

    public function getCountFavorite()
    {
        return $this->favoriteProducts->count();
    }
    /**
     * Get the oauth providers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function oauthProviders()
    {
        return $this->hasMany(OAuthProvider::class);
    }
}
