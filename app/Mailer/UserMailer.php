<?php
/**
 * Created by PhpStorm.
 * User: Tommy
 * Date: 2019/1/13
 * Time: 上午10:50
 */

namespace App\Mailer;


use App\User;
use Illuminate\Support\Facades\Auth;

class UserMailer extends Mailer {

	public function followNotifyEmail($email) {
		$data = ['url'=>'http://zhihu-app.test','name'=>Auth::guard('api')->user()->name];
		
		$this->sendTo( 'zhihu_app_user_follow', $email, $data);
		
	}

	public function passwordReset($email,$token) {
		$data = ['url' => route( 'password.reset',$token)];
		$this->sendTo( 'zhihu_app_password_rest', $email, $data);
	}

	public function welcome( User $user ) {
		$data = [
			'url' => route( 'email.verify',['token'=>$user->confirmation_token]),
			'name'=>$user->name,
		];
		$this->sendTo( 'zhihu_app_register', $user->email, $data);
	}
}