<?php

namespace App\Repositories\Order;

interface IOrderRepository
{
    public function getAllOrderOfCurrentUser();

    public function getOrderByType($type);

    public function cancelOrderOfCurrentUser($id);

    public function handleCheckout($cart);

    public function updateOrder($data, $id);
}
