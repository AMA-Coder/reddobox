<?php

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Friend;
use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::group(['prefix' => 'user'], function () {
	Route::post('/create', function (Request $request, User $user) {
        $user->email = $request->get('email');
        $user->fname = $request->get('fname');
        $user->lname = $request->get('lname');
        $user->full_name = $request->get('fname') . ' ' .$request->get('lname');
        $user->dof = $request->get('dof');
        $user->gender = $request->get('gender');
        $user->confirmation_code = str_random(30);
        $user->confirmed = 1;
        $user->password = bcrypt($request->get('password'));
        $user->save();

        // Mail::send('emails.verify', ['code' => $request['confirmation_code']], function ($m) use ($user) {
        //     $m->from('admin@reddobox.com', 'Reddobox');

        //     $m->to($user->email, $user->name)->subject('Your Verification Code!');
        // });

    	return ['state' => true];
	});
    Route::get('confirm/{code}', function($code) {
        //
        $user = User::whereConfirmationCode($code)->first();
        $user->confirmed = 1;
        $user->confirmation_code = 0;
        $user->save();
        $confirmed = true;
        return redirect()->route('welcome', compact('confirmed'));
    });
	Route::post('/login', function (Request $request, User $user) {
        $user = User::whereEmail($request->get('email'))->first();
        if($user->confirmed == 1) {
            if (Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')])) {
                return ['state' => true, 'confirmed' => true];
            }
            return ['state' => false, 'confirmed' => true];
        }else{
            return ['confirmed' => false];
        }
	});

    Route::post('edit', function(Request $request) {
        $user = User::find($request['id']);
        $user->fname = $request['user']['fname'];
        $user->lname = $request['user']['lname'];
        $user->dof = $request['user']['dof'];
        $user->email = $request['user']['email'];
        $user->gender = $request['user']['gender'];
        $user->save();
        return ['check' => true];
    });

    Route::get('test', function() {
        $d=mktime(0, 0, 0, 8, 12, 2014);
        // echo new Carbon('Sun Jan 01 2017 00:00:00 GMT+0200 (EET)');
        return Auth::user();
    });
});