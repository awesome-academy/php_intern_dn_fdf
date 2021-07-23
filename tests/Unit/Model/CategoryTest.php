<?php

namespace Tests\Unit\Model;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryTest extends TestCase
{
    public function testCategoriesConfig()
    {
        $coloumnCheck = [
            'name',
            'description',
            'type',
            'parent_id',
        ];

        $this->assertEquals($coloumnCheck, (new Category)->getFillable());
    }

    public function testHasManyChildCategories()
    {
        $category = new Category();

        $relation = $category->childCategories();

        $this->assertInstanceOf(HasMany::class, $relation);

        $this->assertEquals('parent_id', $relation->getForeignKeyName());

        $this->assertEquals('categories.id', $relation->getQualifiedParentKeyName());
    }

    public function testHasManySuggest()
    {
        $category = new Category();

        $relation = $category->suggestProducts();

        $this->assertInstanceOf(HasMany::class, $relation);

        $this->assertEquals('cate_id', $relation->getForeignKeyName());

        $this->assertEquals('categories.id', $relation->getQualifiedParentKeyName());
    }

    public function testHasManyProduct()
    {
        $category = new Category();

        $relation = $category->products();

        $this->assertInstanceOf(HasMany::class, $relation);

        $this->assertEquals('cate_id', $relation->getForeignKeyName());

        $this->assertEquals('categories.id', $relation->getQualifiedParentKeyName());
    }

    public function testCategoryBelongsToParentCategoryRelationship()
    {
        $category = new Category();

        $relation = $category->parentCategory();

        $this->assertInstanceOf(BelongsTo::class, $relation);

        $this->assertEquals('id', $relation->getOwnerKeyName());

        $this->assertEquals('parent_id', $relation->getForeignKeyName());
    }
}
