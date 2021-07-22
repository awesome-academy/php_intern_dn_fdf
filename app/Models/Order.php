<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderDetails()
    {
        return $this->belongsToMany(Product::class, 'order_details', 'order_id', 'product_id')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }

    public function getTotalPriceAttribute()
    {
        $total = 0;
        foreach ($this->orderDetails as $product) {
            $total += $product->price * $product->pivot->quantity;
        }

        return $total;
    }
}
