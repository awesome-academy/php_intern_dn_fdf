<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\Product\IProductRepository;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    protected $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function searchProductByName($word)
    {
        $products = $this->productRepository->searchProductByName($word);

        return response()->json($products, 200);
    }
}
