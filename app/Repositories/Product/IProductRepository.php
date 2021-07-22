<?php

namespace App\Repositories\Product;

interface IProductRepository
{
    public function searchProductByName($word);

    public function createRating($data, $id);

    public function getSpecifyRating($id, $num_rate);
}
