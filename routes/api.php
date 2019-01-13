<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/topics', function (Request $request) {
	$topics = \App\Topic::select(['id','name'])->where('name','like','%'.$request->query('q').'%')->get();
	return $topics;
});



Route::middleware('auth:api')->post('/questions/follower', function (Request $request) {
	$user = Auth::guard('api')->user();
	$followed =$user->followed($request->get('question'));
	if($followed){
		return response()->json(['followed'=>true]);
	}
	return response()->json(['followed'=>false]);
});

Route::middleware('api')->post('/questions/follow', function (Request $request) {
	$user = Auth::guard('api')->user();
	$question =  \App\Question::find($request->get('question'));

	$followed = $user->followThis($question->id);

//	$followed =$user->follows()->where('question_id',$question->id)->firs();
//	where('user_id',$user->id)->first();
	if(count($followed['detached']) >0){
		$question->decrement('followers_count');
		return response()->json(['followed'=>false]);
	}
//	$user->followThis($question->id);

	$question->increment('followers_count');
	return response()->json(['followed'=>true]);

});

Route::middleware('auth:api')->get('/user/followers/{id}','FollowerController@index');
Route::middleware('auth:api')->post('/user/follow','FollowerController@follow');

//vote
Route::middleware('auth:api')->post('/answer/{id}/votes/users','VotesController@users');

Route::middleware('auth:api')->post('/answer/vote','VotesController@vote');