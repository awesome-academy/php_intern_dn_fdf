<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::isChild()->with('products')->get();

        $product_trend = Product::isTrend()->limit(config('app.number_limit_product'))->get();

        $product_best_selling = Product::bestSelling()->limit(config('app.number_limit_product'))->get();

        return view('home', compact('categories', 'product_trend', 'product_best_selling'));
    }
}
