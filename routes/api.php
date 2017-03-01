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

        $checkExisting = User::whereEmail($request['email'])->first();
        if(count($checkExisting) > 0) {
            return ['state' => 'exists'];
        }

        $user->email = $request['email'];
        $user->fname = $request['fname'];
        $user->lname = $request['lname'];
        $user->full_name = $request['fname'] . ' ' .$request['lname'];
        $user->dof = $request['dof'];
        $user->gender = $request['gender'];
        $user->confirmation_code = str_random(30);
        $user->confirmed = 0;
        $user->password = bcrypt($request['password']);
        $user->save();

        // Mail::send('emails.verify', ['code' => $request['confirmation_code']], function ($m) use ($user) {
        //     $m->from('admin@reddobox.com', 'Reddobox');

        //     $m->to($user->email, $user->name)->subject('Your Verification Code!');
        // });

        $to = $user->email;
        $subject = "Reddobox Verification Code";

        $message = '
            <!DOCTYPE html>
            <html>
            <head>
                <title>Your Verification Code</title>
            </head>
            <body>
            <center>
                <h1><a href="/api/user/confirm/' . $user->confirmation_code . '">Click here</a> to Confirm your email.</h1>
            </center>
            </body>
            </html>
        ';

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: Reddo box <reddo@reddobox.com.com>' . "\r\n";
        $headers .= 'Cc: myboss@reddobox.com' . "\r\n". "Reply-To: succ-reddobox@gmail.com" . "\r\n" .
        "X-Mailer: PHP/" . phpversion() . "Return-Path: mypl-reddobox@gmail.com\r\n";

        if (mail($to,$subject,$message,$headers)){
            return ['state' => true];
        }
        
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
        $user = User::whereEmail($request['email'])->first();
        if($user->confirmed == 1) {
            if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
                return ['state' => true];
            }
            return ['state' => false];
        }else{
            return ['state' => 'notConfirmed', 'message' => 'You have to verify your e-mail first before you can login!'];
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
