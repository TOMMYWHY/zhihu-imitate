<?php

namespace App\Http\Controllers\Auth;

use App\Mailer\UserMailer;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Naux\Mail\SendCloudTemplate;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
	        'avatar'=>'/images/avatars/default.jpeg',
	        'confirmation_token'=>str_random(48),
	        'api_token'=>str_random(60),
        ]);

        $this->sendVerifyEmailToUser($user);
        return $user;

    }

	private function sendVerifyEmailToUser( $user ) {
		/*$data = [
			'url' => route( 'email.verify',['token'=>$user->confirmation_token]),
			'name'=>$user->name,
		];
		$template = new SendCloudTemplate('zhihu_app_register', $data);

		Mail::raw($template, function ($message) use($user){
			$message->from('tommy_admin@zhihu.com', 'Tommy-zhihu');
			$message->to($user->email);
		});*/
		(new UserMailer())->welcome( $user);
	}
}
