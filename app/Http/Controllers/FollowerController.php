<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Auth;

class FollowerController extends Controller
{
    protected $user;

	/**
	 * FollowerController constructor.
	 *
	 * @param $user
	 */
	public function __construct(UserRepository  $user ) {
		$this->user = $user;
		/*$this->middleware(function ($request, $next) {
			view()->share('user', Auth::guard('api'));

			return $next($request);
		});*/
	}
	public function index($id) {
		$user= $this->user->byId(  $id );
		$followers = $user->followers()->pluck('follower_id')->toArray();
		dd( Auth::guard('api'));
		if (in_array( Auth::guard('api')->user()->id, $followers)){
			return response()->json(['followed'=>true]);
		};
		return response()->json(['followed'=>false]);

	}

	public function follow() {

	}
}

