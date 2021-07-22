<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Suggest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;

class SuggestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suggests = Suggest::with([
            'user',
            'category',
        ])->paginate(config('app.number_paginate'));

        return view('admin.suggests.index', compact('suggests'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Suggest $suggest)
    {
        $suggest->category = $suggest->category;

        return response()->json($suggest, 200);
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
    public function update(Request $request, Suggest $suggest)
    {
        //
    }

    public function approve(ProductRequest $request, Suggest $suggest)
    {
        DB::beginTransaction();

        try {
            $suggest->status = 'Approve';
            $suggest->save();

            Product::create([
                'cate_id' => $request->cate,
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
            ]);

            DB::commit();

            return response()->json([
                'message' => trans('suggest.approve-success')
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function defuse(Suggest $suggest)
    {
        $suggest->status = 'Refuse';
        $suggest->save();

        return redirect()->back()->with('message', trans('suggest.refuse-success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
