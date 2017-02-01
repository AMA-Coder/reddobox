<?php

namespace App;

use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\Facades\Auth;

class SocialAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        // $account = SocialAccount::whereProvider('facebook')
        //     ->whereProviderUserId($providerUser->getId())
        //     ->first();

        // if ($account) {
        //     return $account->user;
        // } else {

        //     $account = new SocialAccount([
        //         'provider_user_id' => $providerUser->getId(),
        //         'provider' => 'facebook',
        //         'avatar' => $providerUser->getAvatar(),
        //         'email' => $providerUser->getEmail()
        //     ]);
            $user = Auth::user();
            $user->provider_user_id = $providerUser->getId();
            $user->update();

            return $user;

        // }

    }
}
