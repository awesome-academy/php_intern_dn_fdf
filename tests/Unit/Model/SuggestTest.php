<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use App\Models\Suggest;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SuggestTest extends TestCase
{
    public function testSuggestsConfig()
    {
        $coloumnCheck = [
            'user_id',
            'cate_id',
            'name',
            'status',
        ];

        $this->assertEquals($coloumnCheck, (new Suggest)->getFillable());
    }

    public function testBelongsToUser()
    {
        $suggest = new Suggest();

        $relation = $suggest->user();

        $this->assertInstanceOf(BelongsTo::class, $relation);

        $this->assertEquals('id', $relation->getOwnerKeyName());

        $this->assertEquals('user_id', $relation->getForeignKeyName());
    }

    public function testBelongsToCategory()
    {
        $suggest = new Suggest();

        $relation = $suggest->category();

        $this->assertInstanceOf(BelongsTo::class, $relation);

        $this->assertEquals('id', $relation->getOwnerKeyName());

        $this->assertEquals('cate_id', $relation->getForeignKeyName());
    }
}
