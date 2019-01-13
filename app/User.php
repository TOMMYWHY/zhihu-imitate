<?php

namespace App;

use App\Mailer\UserMailer;
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
        'name', 'email', 'password','avatar','confirmation_token','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	/**
	 * @param string $token
	 */
	public function sendPasswordResetNotification( $token ) {
		/*$data = ['url' => route( 'password.reset',$token)];
		$template = new SendCloudTemplate('zhihu_app_password_rest', $data);

		Mail::raw($template, function ($message) {
			$message->from('tommy_admin@zhihu.com', 'Tommy-zhihu');
			$message->to($this->email);
		});*/

		(new UserMailer())->passwordReset( $this->email, $token);




    }

	/**
	 * @param Model $model
	 *
	 * @return mixed
	 */
	public function owns( Model $model) {
		return $this->id = $model->user_id;
    }

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function answers() {
		return $this->hasMany(Answer::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function follows(  ) {
//		return Follow::create([
//			'question_id'=> $question,
//			'user_id'=> $this->id,
//		]);
		 return $this->belongsToMany( Question::class,'user_question')->withTimestamps();
	}

	/**
	 * @param $question
	 *
	 * @return array
	 */
	public function followThis( $question ) {
		return $this->follows()->toggle( $question);
	}

	/**
	 * @param $question
	 *
	 * @return int
	 */
	public function followed( $question ) {
		return $this->follows()->where( 'question_id',$question)->count();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function followers() {
		return $this->belongsToMany( self::class,'followers','follower_id','followed_id')->withTimestamps();
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function followersUser() {
		return $this->belongsToMany( self::class,'followers','followed_id','follower_id')->withTimestamps();
	}

	/**
	 * @param $user
	 *
	 * @return array
	 */
	public function followThisUser($user) {
		return $this->followers()->toggle( $user);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function votes() {
		return $this->belongsToMany( Answer::class,'votes')->withTimestamps();
	}

	public function voteFor( $answer ) {
		return $this->votes()->toggle( $answer);
	}

	public function hasVotedFor($answer  ) {
		return !! $this->votes()->where( 'answer_id', $answer)->count();
	}
}
