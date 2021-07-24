<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'cate_id',
        'name',
        'price',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'cate_id');
    }

    public function ratings()
    {
        return $this->belongsToMany(User::class, 'ratings', 'product_id', 'user_id')
                    ->withPivot('num_rated', 'content')->withTimestamps()
                    ->orderBy('pivot_created_at', 'desc');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orderDetails()
    {
        return $this->belongsToMany(Order::class, 'order_details', 'product_id', 'order_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany(User::class, 'favorite_products');
    }

    public function getAvgRatingAttribute()
    {
        $total_star = 0;

        if ($this->ratings->count() == 0) {
            return 0;
        } else {
            foreach ($this->ratings as $rating) {
                $total_star += $rating->pivot->num_rated;
            }

            return round($total_star / ($this->ratings->count()), 1);
        }
    }

    public function getFirstImageAttribute()
    {
        return $this->images->first()->image_path ?? 'img/default-image-product.png';
    }

    public function scopeOfCategory($query, $id)
    {
        return $query->where('cate_id', $id);
    }

    public function getNumbOfRating($num_star)
    {
        $count = 0;

        foreach ($this->ratings as $rating) {
            if ($rating->pivot->num_rated == $num_star) {
                $count++;
            }
        }

        return $count;
    }

    public function scopeSearchByName($query, $word)
    {
        return $query->where('name', 'like', '%' . $word . '%');
    }

    public function getSpecifyRating($num_rate)
    {
        $ratings = [];

        foreach ($this->ratings as $rating) {
            if ($rating->pivot->num_rated == $num_rate) {
                $ratings[] = $rating;
            }
        }

        return $ratings;
    }

    public function scopeIsTrend($query)
    {
        $query->withCount('ratings')->orderBy('ratings_count', 'desc');
    }

    public function scopeBestSelling($query)
    {
        $query->withCount('orderDetails')->orderBy('order_details_count', 'desc');
    }
}
