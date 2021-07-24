<?php

namespace App\Repositories\Order;

use Carbon\Carbon;
use App\Models\Admin;
use App\Models\Order;
use App\Traits\PusherTrait;
use App\Events\SendMailOrderUser;
use App\Repositories\BaseRepository;
use App\Jobs\SendMailWhenUserCheckoutJob;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserSubmitOrderNotification;

class OrderRepository extends BaseRepository implements IOrderRepository
{
    use PusherTrait;

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

        $job = (new SendMailWhenUserCheckoutJob($order))
        ->delay(Carbon::now()->addSeconds(3));
        dispatch($job);

        event(new SendMailOrderUser($order));
        $order->totalPrice = $order->total_price;

        $this->currentUser()
            ->notify(new UserSubmitOrderNotification($order, trans('homepage.message_order_cancel')));

        $pusher = $this->connectPusher();

        $pusher->trigger('SendMailOrderUser', 'send-message-order-' . $order->user->id, [
            'order' => $order,
            'message' => trans('homepage.message_order_cancel'),
        ]);

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

        $job = (new SendMailWhenUserCheckoutJob($order))
        ->delay(Carbon::now()->addSeconds(3));
        dispatch($job);

        $order->user = $order->user;

        event(new SendMailOrderUser($order));

        $this->currentUser()
            ->notify(new UserSubmitOrderNotification($order, trans('homepage.message_order_pending')));

        Notification::send(Admin::all(), new UserSubmitOrderNotification($order, ''));

        $pusher = $this->connectPusher();

        $pusher->trigger('SendMailOrderUser', 'send-message-order-'. $order->user->id, [
            'order' => $order,
            'message' => trans('homepage.message_order_pending'),
        ]);

        $pusher->trigger('SendNotiForAdminWhenUserOrder', 'send-noti-user-order-admin', [
            'order' => $order,
            'message_to_admin' => trans('notification.message_admin'),
        ]);

        session()->forget('cart');

        return $order;
    }

    public function updateOrder($data, $id)
    {
        $order = $this->findOrFail($id);
        $order->status = $data['status'];
        $order->save();

        $pusher = $this->connectPusher();

        $job = (new SendMailWhenUserCheckoutJob($order))
        ->delay(Carbon::now()->addSeconds(3));
        dispatch($job);

        event(new SendMailOrderUser($order));
        if ($order->status == config('app.status_order.done')) {
            $order->user
                ->notify(new UserSubmitOrderNotification($order, trans('homepage.message_order_done')));

            $pusher->trigger('SendMailOrderUser', 'send-message-order-'. $order->user->id, [
                'order' => $order,
                'message' => trans('homepage.message_order_done'),
            ]);
        } elseif ($order->status == config('app.status_order.cancel')) {
            $order->user
                ->notify(new UserSubmitOrderNotification($order, trans('homepage.message_order_cancel')));

            $pusher->trigger('SendMailOrderUser', 'send-message-order-'. $order->user->id, [
                'order' => $order,
                'message' => trans('homepage.message_order_cancel'),
            ]);
        }
    }
}
