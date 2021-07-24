<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Suggest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Repositories\Suggest\ISuggestRepository;

class SuggestController extends Controller
{
    protected $suggestRepository;

    public function __construct(ISuggestRepository $suggestRepository)
    {
        $this->suggestRepository = $suggestRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suggests = $this->suggestRepository->all();

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
            $this->suggestRepository->approveSuggest($request->all(), $suggest->id);

            DB::commit();

            return response()->json([
                'message' => trans('suggest.approve_success')
            ], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }

    public function defuse(Suggest $suggest)
    {
        $this->suggestRepository->refuseSuggest($suggest->id);

        return redirect()->back()->with('message', trans('suggest.refuse_success'));
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
