<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Cart;
use App\Models\City;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Events\SendMailOrderUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserSubmitOrderNotification;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();

        $cities = City::select('name')->get();

        $cart = new Cart(session()->get('cart'));

        return view('checkout', compact('user', 'cities', 'cart'));
    }

    public function store(CheckoutRequest $request)
    {
        if (!Auth::guard('web')->check()) {
            return response()->json([
                'message' => trans('homepage.not_login'),
            ], 401);
        }

        $cart = new Cart(session()->get('cart'));

        if (!$cart->items) {
            return response()->json([
                'message' => trans('checkout.cart_is_empty'),
            ], 200);
        }

        DB::beginTransaction();

        try {
            $order = Auth::guard('web')->user()->orders()->create([
                'status' => config('app.status_order.pending'),
            ]);

            foreach (session()->get('cart')->items as $item) {
                $order->orderDetails()->attach($item->id, [
                    'quantity' => $item->quantity,
                ]);
            }

            // send mail
            event(new SendMailOrderUser($order));

            Auth::guard('web')->user()
            ->notify(new UserSubmitOrderNotification($order, trans('homepage.message_order_pending')));

            Notification::send(Admin::all(), new UserSubmitOrderNotification($order, ''));

            DB::commit();

            session()->forget('cart');

            return response()->json([
                'message' => trans('checkout.success'),
            ], 200);
        } catch (Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message_fail' => trans('checkout.fail'),
            ], 500);
        }
    }
}
