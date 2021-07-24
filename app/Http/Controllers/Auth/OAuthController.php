<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\OAuthProvider;
use App\Exceptions\OauthException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class OAuthController extends Controller
{
    use AuthenticatesUsers;

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        $user = $this->findOrCreateUser($provider, $user);

        Auth::guard('web')->login($user);

        return redirect()->route('home');
    }

    /**
     * @param  string $provider
     * @param  \Laravel\Socialite\Contracts\User $sUser
     * @return \App\User|false
     */
    protected function findOrCreateUser($provider, $user)
    {
        $oauthProvider = OAuthProvider::where('provider', $provider)
            ->where('provider_user_id', $user->getId())
            ->first();

        if ($oauthProvider) {
            return $oauthProvider->user;
        }

        if (User::where('email', $user->getEmail())->exists()) {
            throw new OauthException;
        }

        return $this->createUser($provider, $user);
    }

    /**
     * @param  string $provider
     * @param  \Laravel\Socialite\Contracts\User $sUser
     * @return \App\User
     */
    protected function createUser($provider, $sUser)
    {
        $name = $sUser->getName() ?? $sUser->getNickname();

        $user = User::create([
            'name' => $name,
            'email' => $sUser->getEmail(),
            'email_verified_at' => now(),
            'city' => '',
            'address' => '',
            'phone' => '',
            'avatar_path' => '',
        ]);

        $user->oauthProviders()->create([
            'provider' => $provider,
            'provider_user_id' => $sUser->getId(),
        ]);

        return $user;
    }
}
