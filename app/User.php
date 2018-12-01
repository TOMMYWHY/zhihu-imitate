<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	public function sendPasswordResetNotification( $token ) {
		$data = ['url' => route( 'password.reset',$token)];
		$template = new SendCloudTemplate('zhihu_app_password_rest', $data);

		Mail::raw($template, function ($message) {
			$message->from('tommy_admin@zhihu.com', 'Tommy-zhihu');
			$message->to($this->email);
		});
    }

	public function owns( Model $model) {
		return $this->id = $model->user_id;
    }
}
