<?php

namespace App\Repositories\ProductImage;

interface IProductImageRepository
{
    public function storeImageOfProduct(array $data, $id);
}
