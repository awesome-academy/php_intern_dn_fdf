<?php

namespace App\Http\Controllers;

use App\Http\Requests\SuggestRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuggestController extends Controller
{
    public function index()
    {
        $user = Auth::guard('web')->user();
        $categories = Category::isParent()->get();

        return view('suggest', compact('user', 'categories'));
    }

    public function store(SuggestRequest $request)
    {
        $request->user()->suggestProducts()->create([
            'cate_id' => $request->cate,
            'name' => $request->product,
            'status' => config('app.status_suggest.pending'),
        ]);

        return response()->json([
            'message' => trans('homepage.suggest_succes'),
        ], 200);
    }
}
