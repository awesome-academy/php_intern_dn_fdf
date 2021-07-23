<?php

namespace App\Repositories\Suggest;

use App\Models\Product;
use App\Models\Suggest;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class SuggestRepository extends BaseRepository implements ISuggestRepository
{
    public function getModel()
    {
        return Suggest::class;
    }

    public function all()
    {
        $suggests = $this->model::with([
            'user',
            'category',
        ])->paginate(config('app.number_paginate'));

        return $suggests;
    }

    public function approveSuggest($data, $id)
    {
        $suggest = $this->findOrFail($id);
        $suggest->status = config('app.status_suggest.approve');
        $suggest->save();

        Product::create([
            'cate_id' => $data['cate'],
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'],
        ]);
    }

    public function refuseSuggest($id)
    {
        $suggest = $this->findOrFail($id);
        $suggest->status = config('app.status_suggest.refuse');
        $suggest->save();
    }

    public function addSuggest($data)
    {
        $this->currentUser()->suggestProducts()->create([
            'cate_id' => $data['cate'],
            'name' => $data['product'],
            'status' => config('app.status_suggest.pending'),
        ]);
    }
}
