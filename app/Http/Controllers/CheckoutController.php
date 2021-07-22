<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\Cart;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CheckoutRequest;
use App\Repositories\Cart\ICartRepository;
use App\Repositories\User\IUserRepository;
use App\Repositories\Order\IOrderRepository;

class CheckoutController extends Controller
{
    protected $cartRepository;
    protected $userRepository;
    protected $orderRepository;

    public function __construct(
        ICartRepository $cartRepository,
        IUserRepository $userRepository,
        IOrderRepository $orderRepository
    ) {
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $user = $this->userRepository->currentUser();

        $cities = City::select('name')->get();

        $cart = $this->cartRepository->getCurrentCart();

        return view('checkout', compact('user', 'cities', 'cart'));
    }

    public function store(CheckoutRequest $request)
    {
        if (!Auth::guard('web')->check()) {
            return response()->json([
                'message' => trans('homepage.not_login'),
            ], 401);
        }

        if ($this->cartRepository->checkCartIsEmpty()) {
            return response()->json([
                'message' => trans('checkout.cart_is_empty'),
            ], 200);
        }

        DB::beginTransaction();

        try {
            $cart = $this->cartRepository->getCurrentCart();

            $this->orderRepository->handleCheckout($cart);

            DB::commit();

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
