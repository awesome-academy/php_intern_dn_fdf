<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Repositories\User\IUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $favorites = $this->userRepository->getAllFavoriteOfCurrentUser();

        return response()->json($favorites, 200);
    }

    public function storeFavorite(Request $request, Product $product)
    {
        if ($this->userRepository->checkListFavoriteHasThisProduct($product->id)) {
            return response()->json([
                'message_exist' => trans('homepage.exist_product'),
            ], 200);
        } else {
            $this->userRepository->addProductToListFavorite($product->id);

            return response()->json([
                'message_success' => trans('homepage.add_favorite_success'),
            ]);
        }
    }

    public function destroy(Request $request, Product $product)
    {
        if ($this->userRepository->checkListFavoriteHasThisProduct($product->id)) {
            $this->userRepository->removeProductFromListFavorite($product->id);

            return response()->json([
                'message_success' => trans('homepage.remove_favorite_success'),
            ]);
        } else {
            return response()->json([
                'message-fail' => trans('homepage.remove_favorite_fail'),
            ]);
        }
    }
}
