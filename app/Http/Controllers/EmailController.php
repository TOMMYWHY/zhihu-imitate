<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailController extends Controller
{
    //
	public function verify( $token ) {
		$user = User::where('confirmation_token',$token)->first();
		if (is_null($user)){
			//session tip
			flash('email verify fail~!','danger');
			return redirect('/');
		}
		$user->is_active = 1;
		$user->confirmation_token = str_random(48);
		$user->save();
		Auth::login($user);
		flash('email verify success~!','success');

		return redirect('/home');
	}
}
