<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class UserTest extends TestCase
{
    public function testUsersConfig()
    {
        $coloumnCheck = [
            'name',
            'email',
            'password',
            'city',
            'address',
            'phone',
            'avatar_path',
        ];

        $this->assertEquals($coloumnCheck, (new User)->getFillable());
    }

    public function testBelongsToManyFavoriteProductsWithProduct()
    {
        $user = new User();

        $relation = $user->favoriteProducts();

        $this->assertInstanceOf(BelongsToMany::class, $relation);

        $this->assertEquals('favorite_products.user_id', $relation->getQualifiedForeignPivotKeyName());

        $this->assertEquals('favorite_products.product_id', $relation->getQualifiedRelatedPivotKeyName());
    }

    public function testBelongsToManyProductWithRating()
    {
        $user = new User();

        $relation = $user->ratings();

        $this->assertInstanceOf(BelongsToMany::class, $relation);

        $this->assertEquals('ratings.user_id', $relation->getQualifiedForeignPivotKeyName());

        $this->assertEquals('ratings.product_id', $relation->getQualifiedRelatedPivotKeyName());
    }

    public function testHasManyOrder()
    {
        $user = new User();

        $relation = $user->orders();

        $this->assertInstanceOf(HasMany::class, $relation);

        $this->assertEquals('user_id', $relation->getForeignKeyName());

        $this->assertEquals('users.id', $relation->getQualifiedParentKeyName());
    }

    public function testHasManySuggest()
    {
        $user = new User();

        $relation = $user->suggestProducts();

        $this->assertInstanceOf(HasMany::class, $relation);

        $this->assertEquals('user_id', $relation->getForeignKeyName());

        $this->assertEquals('users.id', $relation->getQualifiedParentKeyName());
    }
}
