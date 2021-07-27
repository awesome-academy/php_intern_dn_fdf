<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements ICategoryRepository
{
    public function getModel()
    {
        return Category::class;
    }

    public function all()
    {
        $categories = $this->model::withCount('products')
            ->paginate(config('app.number_paginate'));

        return $categories;
    }

    public function getAllParentCategory()
    {
        $categories = $this->model::isParent()->get();

        return $categories;
    }

    public function getAllChildCategory()
    {
        $categories = $this->model::isChild()->get();

        return $categories;
    }

    public function create($data)
    {
        $value_parent = $data['type'] == '0' ? null : $data['parent'];

        $category = $this->model::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'parent_id' => $value_parent,
            'type' => $data['type'],
        ]);

        return $category;
    }

    public function delete($id)
    {
        $category = $this->findOrFail($id);

        $category->suggestProducts()->delete();

        $products = $category->products()->with([
            'ratings',
            'images',
            'orderDetails',
            'favoriteProducts',
        ])->get();

        foreach ($products as $product) {
            $product->ratings()->detach();
            $product->images()->delete();
            $product->orderDetails()->detach();
            $product->favoriteProducts()->detach();
        }

        $category->products()->delete();

        $category->delete();
    }
}
