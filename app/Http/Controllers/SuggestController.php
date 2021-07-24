<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\SuggestRequest;
use App\Repositories\Suggest\ISuggestRepository;

class SuggestController extends Controller
{
    protected $suggestRepository;

    public function __construct(ISuggestRepository $suggestRepository)
    {
        $this->suggestRepository = $suggestRepository;
    }

    public function index()
    {
        $user = Auth::guard('web')->user();
        $categories = Category::isParent()->get();

        return view('suggest', compact('user', 'categories'));
    }

    public function store(SuggestRequest $request)
    {
        $this->suggestRepository->addSuggest($request->all());

        return response()->json([
            'message' => trans('homepage.suggest_succes'),
        ], 200);
    }
}
