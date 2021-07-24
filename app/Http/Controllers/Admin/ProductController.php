<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Repositories\Category\ICategoryRepository;
use App\Repositories\Product\IProductRepository;

class ProductController extends Controller
{
    protected $productRepository;

    protected $categoryRepository;

    public function __construct(
        IProductRepository $productRepository,
        ICategoryRepository $categoryRepository
    ) {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->productRepository->all();

        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryRepository->getAllChildCategory();

        return view('admin.products.add', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        try {
            $this->productRepository->create($request->all());

            return redirect()->route('admin.products.index')->with('message', trans('products.message_create_success'));
        } catch (Throwable $e) {
            return redirect()->route('admin.products.index')->with('error', trans('products.message_create_fail'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = $this->categoryRepository->getAllChildCategory();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            $this->productRepository->update($product->id, $request->all());

            return redirect()->route('admin.products.index')->with('message', trans('products.message_update_success'));
        } catch (Throwable $e) {
            return redirect()->route('admin.products.index')->with('error', trans('products.message_update_fail'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();

        try {
            $this->productRepository->delete($product->id);

            DB::commit();

            return response()->json([
                'message' => trans('products.message_delete_success'),
            ], 200);
        } catch (Throwable $e) {
            DB::rollBack();
        }
    }
}
