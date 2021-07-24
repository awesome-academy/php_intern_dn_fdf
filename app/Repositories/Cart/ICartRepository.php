<?php

namespace App\Repositories\Cart;

interface ICartRepository
{
    public function getCurrentCart();

    public function addCart($id, $quantity);

    public function updateCart($id, $quantity);

    public function removeCart($id);

    public function checkCartIsEmpty();
}
