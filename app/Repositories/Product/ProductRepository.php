<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\BaseRepository;

class ProductRepository extends BaseRepository implements IProductRepository
{
    public function getModel()
    {
        return Product::class;
    }

    public function all()
    {
        $products = $this->model::withCount([
            'ratings',
            'images',
        ])->paginate(config('app.number_paginate'));

        return $products;
    }

    public function create($data)
    {
        $product = $this->model::create([
            'cate_id' => $data['cate'],
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
        ]);

        return $product;
    }

    public function delete($id)
    {
        $product = $this->findOrFail($id);

        $product->images()->delete();

        $product->ratings()->delete();

        $product->favoriteProducts()->delete();

        $product->orderDetails()->delete();

        $product->delete();
    }
}
