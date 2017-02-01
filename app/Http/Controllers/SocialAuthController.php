<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SocialAccountService;
use App\Http\Requests;
use Socialite;

class SocialAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('facebook')->scopes(['user_friends'])->redirect();
    }

    public function callback(SocialAccountService $service, Request $request)
    {
    	$providerUser = Socialite::driver('facebook')->user();
        $user = $service->createOrGetUser($providerUser);
        // dd($user);
        return redirect()->route('dashboard');
    }
}
