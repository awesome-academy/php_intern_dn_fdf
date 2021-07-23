<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Cart\ICartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cartRepository;

    public function __construct(ICartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
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
    public function store(Request $request, Product $product)
    {
        $cart = $this->cartRepository->addCart($product->id, $request->quantity);

        return response()->json([
            'product' => session()->get('cart')->items[$product->id],
            'totalPrice' => $cart->totalPrice,
            'totalQuantity' => $cart->totalQuantity,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $cart = $this->cartRepository->updateCart($product->id, $request->quantity);

        return response()->json([
            'product' => session()->get('cart')->items[$product->id],
            'totalPrice' => $cart->totalPrice,
            'totalQuantity' => $cart->totalQuantity,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $cart = $this->cartRepository->removeCart($product->id);

        return response()->json([
            'totalPrice' => $cart->totalPrice,
            'totalQuantity' => $cart->totalQuantity,
        ]);
    }
}
