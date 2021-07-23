<?php

namespace App\Http\Controllers\Admin;

use Throwable;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ImageProductRequest;
use App\Repositories\ProductImage\IProductImageRepository;

class ImageProductController extends Controller
{
    protected $productImageRepository;

    public function __construct(IProductImageRepository $productImageRepository)
    {
        $this->productImageRepository = $productImageRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageProductRequest $request, Product $product)
    {
        try {
            $this->productImageRepository->storeImageOfProduct($request->all(), $product->id);

            return redirect()->route('admin.products.edit', $product->id)
                ->with('message', trans('products.message_add_image_success'));
        } catch (Throwable $th) {
            dd($th);
            return redirect()->route('admin.products.edit', $product->id)
                ->with('error', trans('products.message_add_image_fail'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function show(ProductImage $productImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductImage $productImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        try {
            $this->productImageRepository->delete($id);

            return response()->json([
                'message' => trans('products.message_delete_image_success'),
            ], 200);
        } catch (Throwable $th) {
            return response()->json([
                'message' => trans('products.message_delete_image_fail'),
            ], 500);
        }
    }
}
