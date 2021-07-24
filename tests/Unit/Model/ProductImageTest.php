<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImageTest extends TestCase
{
    public function testProductImagesConfig()
    {
        $coloumnCheck = [
            'product_id',
            'image_path',
        ];

        $this->assertEquals($coloumnCheck, (new ProductImage)->getFillable());
    }

    public function testBelongsToProduct()
    {
        $productImage = new ProductImage();

        $relation = $productImage->product();

        $this->assertInstanceOf(BelongsTo::class, $relation);

        $this->assertEquals('id', $relation->getOwnerKeyName());

        $this->assertEquals('product_id', $relation->getForeignKeyName());
    }
}
