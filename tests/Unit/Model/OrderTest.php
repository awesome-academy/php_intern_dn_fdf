<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use App\Models\Order;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderTest extends TestCase
{
    public function testOrdersConfig()
    {
        $coloumnCheck = [
            'user_id',
            'status',
        ];

        $this->assertEquals($coloumnCheck, (new Order)->getFillable());
    }

    public function testBelongsToUser()
    {
        $order = new Order();

        $relation = $order->user();

        $this->assertInstanceOf(BelongsTo::class, $relation);

        $this->assertEquals('id', $relation->getOwnerKeyName());

        $this->assertEquals('user_id', $relation->getForeignKeyName());
    }

    public function testBelongsToManyOrderDetailsWithProduct()
    {
        $order = new Order();

        $relation = $order->orderDetails();

        $this->assertInstanceOf(BelongsToMany::class, $relation);

        $this->assertEquals('order_details.order_id', $relation->getQualifiedForeignPivotKeyName());

        $this->assertEquals('order_details.product_id', $relation->getQualifiedRelatedPivotKeyName());
    }
}
