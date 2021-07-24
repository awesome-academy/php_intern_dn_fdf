<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function scopeGetAllPending($query)
    {
        $query->where('status', config('app.status_order.pending'));
    }

    public function scopeGetAllToday($query)
    {
        $query->whereDate('created_at', Carbon::today());
    }

    public function scopeGetAllByStatusToday($query, $status)
    {
        $query->whereDate('created_at', Carbon::today())->where('status', $status);
    }
}
