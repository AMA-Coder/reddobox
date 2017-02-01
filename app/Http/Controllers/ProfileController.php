<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Request as FriendRequest;
use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index($id)
    {
    	$user = User::find($id);
    	return view('profile', compact('user'));
    }

    public function request($id)
    {
    	User::find($id)->befriend(Auth::user());
    	return ['check' => true];
    }
}
