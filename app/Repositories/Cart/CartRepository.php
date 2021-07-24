<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\BaseRepository;

class CartRepository extends BaseRepository implements ICartRepository
{
    public function getModel()
    {
        return Cart::class;
    }

    public function getCurrentCart()
    {
        if (session()->has('cart')) {
            $cart = new $this->model(session()->get('cart'));
        } else {
            $cart = new $this->model;
        }

        return $cart;
    }

    public function addCart($id, $quantity)
    {
        $product = Product::findOrFail($id);

        $cart = $this->getCurrentCart();

        $cart->add($product, $quantity);

        session()->put('cart', $cart);

        return $cart;
    }

    public function updateCart($id, $quantity)
    {
        $cart = $this->getCurrentCart();

        $cart->updateCart($id, $quantity);

        session()->put('cart', $cart);

        return $cart;
    }

    public function removeCart($id)
    {
        $cart = $this->getCurrentCart();

        $cart->remove($id);

        session()->put('cart', $cart);

        return $cart;
    }

    public function checkCartIsEmpty()
    {
        if (!$this->getCurrentCart()->items) {
            return true;
        }

        return false;
    }
}
