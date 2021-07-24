<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ProfileInfoRequest;
use App\Http\Requests\ProfilePassRequest;
use App\Repositories\User\IUserRepository;

class ProfileController extends Controller
{
    protected $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $cities = City::select('name')->get();

        $user = $this->userRepository->currentUser();

        return view('profile', compact('user', 'cities'));
    }

    public function updateAvatar(Request $request)
    {
        $this->userRepository->updateAvatarCurrentUser($request->all());

        return redirect()->route('profile.index');
    }

    public function updateInfomation(ProfileInfoRequest $request)
    {
        $this->userRepository->updateInfomationCurrentUser($request->all());

        return redirect()->back();
    }

    public function updatePassword(ProfilePassRequest $request)
    {
        if (!Hash::check($request->oldpassword, Auth::guard('web')->user()->password)) {
            return response()->json([
                'error' => trans('users.pass_not_match'),
            ], 422);
        }

        $this->userRepository->updatePasswordCurrentUser($request->all());

        return response()->json([
            'message' => trans('users.change_pass_success'),
        ]);
    }
}
