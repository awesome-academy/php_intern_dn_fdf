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

    public function searchProductByName($word)
    {
        return $this->model->searchByName($word)->get();
    }

    public function createRating($data, $id)
    {
        $this->currentUser()->ratings()->attach($id, [
            'num_rated' => $data['rating'],
            'content' => $data['content'],
        ]);

        $product = $this->findOrFail($id);

        $rating = $product->ratings()->get()->first();

        return $rating;
    }

    public function getSpecifyRating($id, $num_rate)
    {
        $product = $this->findOrFail($id);

        return $product->getSpecifyRating($num_rate);
    }

    public function getAllByCategory($id_cate)
    {
        $products = $this->model->ofCategory($id_cate)->get();

        foreach ($products as $product) {
            $product->image = $product->first_image;
            $product->avg_rating = $product->avg_rating;
        }

        return $products;
    }
}
