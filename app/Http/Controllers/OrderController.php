<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\Order\IOrderRepository;

class OrderController extends Controller
{
    protected $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $orders = $this->orderRepository->getAllOrderOfCurrentUser();

        return view('orders.order', compact('orders'));
    }

    public function getByType($type)
    {
        $orders = $this->orderRepository->getOrderByType($type);

        return response()->json($orders, 200);
    }

    public function cancelOrder(Order $order)
    {
        $this->authorize('cancelOrder', $order);

        $order = $this->orderRepository->cancelOrderOfCurrentUser($order->id);

        return response()->json($order, 200);
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);

        return view('orders.show', compact('order'));
    }
}
