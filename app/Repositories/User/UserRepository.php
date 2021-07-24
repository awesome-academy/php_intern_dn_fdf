<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements IUserRepository
{
    public function getModel()
    {
        return User::class;
    }

    public function all()
    {
        $users = $this->model::withCount([
            'orders',
            'suggestProducts',
        ])->paginate(config('app.number_paginate'));

        return $users;
    }

    public function delete($id)
    {
        $user = $this->findOrFail($id);

        $user->suggestProducts()->delete();

        $user->ratings()->delete();

        $user->favoriteProducts()->delete();

        $user->orders()->delete();

        $user->delete();
    }

    public function updateAvatarCurrentUser($data)
    {
        $avatar = $data['avatar'];

        if (File::exists(public_path('storage/' .  $this->currentUser()->avatar_path))) {
            File::delete(public_path('storage/' . $this->currentUser()->avatar_path));
        }

        $avatar_path = config('app.avatar_path') . '/' . time() . '.' . $avatar->getClientOriginalExtension();
        $path = public_path('/storage/' . config('app.avatar_path'));

        $avatar->move($path, $avatar_path);

        $this->currentUser()->avatar_path = $avatar_path;
        $this->currentUser()->save();
    }

    public function updateInfomationCurrentUser($data)
    {
        $this->currentUser()->name = $data['name'];
        $this->currentUser()->phone = $data['phone'] ?? '';
        $this->currentUser()->city = $data['city'] ?? '';
        $this->currentUser()->address = $data['address'] ?? '';
        $this->currentUser()->save();
    }

    public function updatePasswordCurrentUser($data)
    {
        $this->currentUser()->password = Hash::make($data['password']);
        $this->currentUser()->save();
    }

    public function checkListFavoriteHasThisProduct($product_id)
    {
        if ($this->currentUser()->favoriteProducts->where('id', $product_id)->count() > 0) {
            return true;
        }

        return false;
    }

    public function addProductToListFavorite($product_id)
    {
        $this->currentUser()->favoriteProducts()->attach($product_id);
    }

    public function removeProductFromListFavorite($product_id)
    {
        $this->currentUser()->favoriteProducts()->detach($product_id);
    }

    public function getAllFavoriteOfCurrentUser()
    {
        $favorites = $this->currentUser()->favoriteProducts;

        foreach ($favorites as $favorite) {
            $favorite->image = $favorite->first_image;
        }

        return $favorites;
    }
}
