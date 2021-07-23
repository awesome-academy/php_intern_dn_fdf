<?php

namespace App\Repositories\Order;

use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository implements IOrderRepository
{
    public function getModel()
    {
        return Order::class;
    }

    public function all()
    {
        $orders = $this->model::with([
            'user',
        ])->withCount('orderDetails')->orderBy('status', 'desc')
        ->paginate(config('app.number_paginate'));

        return $orders;
    }

    public function getAllOrderOfCurrentUser()
    {
        return $this->currentUser()->orders;
    }

    public function getOrderByType($type)
    {
        if ($type === config('app.total')) {
            $orders = $this->getAllOrderOfCurrentUser();
        } else {
            $orders = $this->currentUser()->orders()->where('status', $type)->get();
        }

        foreach ($orders as $order) {
            $order->totalPrice = $order->total_price;
        }

        return $orders;
    }

    public function cancelOrderOfCurrentUser($id)
    {
        $order = $this->findOrFail($id);

        $order->status = config('app.status_order.cancel');
        $order->save();

        return $order;
    }

    public function handleCheckout($cart)
    {
        $order = $this->currentUser()->orders()->create([
            'status' => config('app.status_order.pending'),
        ]);

        foreach ($cart->items as $item) {
            $order->orderDetails()->attach($item->id, [
                'quantity' => $item->quantity,
            ]);
        }
        // send mail

        session()->forget('cart');
    }
}
