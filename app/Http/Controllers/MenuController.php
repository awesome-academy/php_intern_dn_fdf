<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Repositories\Category\ICategoryRepository;
use App\Repositories\Product\IProductRepository;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $categoryRepository;

    protected $productRepository;

    public function __construct(
        ICategoryRepository $categoryRepository,
        IProductRepository $productRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->getAllParentCategory();

        return view('menu', compact('categories'));
    }

    public function getProductById($id)
    {
        $products = $this->productRepository->getAllByCategory($id);

        return response()->json($products, 200);
    }
}
