<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;

class CartTest extends TestCase
{
    public function testAddProductToCart()
    {
        $cart = new Cart();

        $product = new Product();
        $product->cate_id = 1;
        $product->name = 'abc';
        $product->price = 123;
        $product->description = 'abc';

        $quantity = rand(1, 5);

        $cart->add($product, $quantity);

        $this->assertEquals($quantity, $cart->items[$product->id]->quantity);

        $this->assertEquals($product->name, $cart->items[$product->id]->name);
    }

    public function testUpdateProductToCart()
    {
        $cart = new Cart();

        $product = new Product();
        $product->cate_id = 1;
        $product->name = 'abc';
        $product->price = 123;
        $product->description = 'abc';

        $quantity_add = rand(1, 5);

        $cart->add($product, $quantity_add);

        $quantity_update = rand(1, 5);
        $cart->updateCart($product->id, $quantity_update);

        $this->assertEquals($cart->totalQuantity, $cart->items[$product->id]->quantity);
    }

    public function testRemoveCart()
    {
        $cart = new Cart();

        $product = new Product();
        $product->cate_id = 1;
        $product->name = 'abc';
        $product->price = 123;
        $product->description = 'abc';

        $quantity_add = rand(1, 5);

        $cart->add($product, $quantity_add);

        $this->assertEquals($quantity_add, $cart->items[$product->id]->quantity);

        $this->assertEquals($product->name, $cart->items[$product->id]->name);

        $cart->remove($product->id);

        $isDelete = isset($cart->items[$product->id]) ? false : true;

        $this->assertTrue($isDelete);
    }
}
