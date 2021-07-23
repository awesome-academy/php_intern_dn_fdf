<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProductTest extends TestCase
{
    public function testProductsConfig()
    {
        $coloumnCheck = [
            'cate_id',
            'name',
            'price',
            'description',
        ];

        $this->assertEquals($coloumnCheck, (new Product)->getFillable());
    }

    public function testBelongsToCategory()
    {
        $product = new Product();

        $relation = $product->category();

        $this->assertInstanceOf(BelongsTo::class, $relation);

        $this->assertEquals('id', $relation->getOwnerKeyName());

        $this->assertEquals('cate_id', $relation->getForeignKeyName());
    }

    public function testHasManyImages()
    {
        $product = new Product();

        $relation = $product->images();

        $this->assertInstanceOf(HasMany::class, $relation);

        $this->assertEquals('product_id', $relation->getForeignKeyName());

        $this->assertEquals('products.id', $relation->getQualifiedParentKeyName());
    }

    public function testBelongsToManyUserWithRating()
    {
        $product = new Product();

        $relation = $product->ratings();

        $this->assertInstanceOf(BelongsToMany::class, $relation);

        $this->assertEquals('ratings.product_id', $relation->getQualifiedForeignPivotKeyName());

        $this->assertEquals('ratings.user_id', $relation->getQualifiedRelatedPivotKeyName());
    }

    public function testBelongsToManyOrderDetailsWithOrder()
    {
        $product = new Product();

        $relation = $product->orderDetails();

        $this->assertInstanceOf(BelongsToMany::class, $relation);

        $this->assertEquals('order_details.product_id', $relation->getQualifiedForeignPivotKeyName());

        $this->assertEquals('order_details.order_id', $relation->getQualifiedRelatedPivotKeyName());
    }

    public function testBelongsToManyFavoriteProductsWithUser()
    {
        $product = new Product();

        $relation = $product->favoriteProducts();

        $this->assertInstanceOf(BelongsToMany::class, $relation);

        $this->assertEquals('favorite_products.product_id', $relation->getQualifiedForeignPivotKeyName());

        $this->assertEquals('favorite_products.user_id', $relation->getQualifiedRelatedPivotKeyName());
    }
}
