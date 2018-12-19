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



Route::middleware('api')->post('/questions/follower', function (Request $request) {
	$followed =\App\Follow::where('question_id',$request->get( 'question'))->where('user_id',$request->get( 'user'))->count();
//	dd( $followed);
//	dd( $request->all());
//	return 1;
	return response()->json(['follow'=>true]);

	if($followed >0){
		return response()->json(['followed'=>true]);


	}
	return response()->json(['followed'=>false]);

});

Route::middleware('api')->post('/questions/follow', function (Request $request) {
	$followed =\App\Follow::where('question_id',$request->get( 'question'))->where('user_id',$request->get( 'user'))->first();
	if($followed !==null){
		$followed->delete();
		return response()->json(['followed'=>false]);

	}
	\App\Follow::create([
		'question_id'=>$request->get( 'question'),
		'user_id'=>$request->get( 'user')
	]);
	return response()->json(['followed'=>true]);

});

//Route::middleware('auth:api')->get('/user/followers/{id}','FollowerController@index');
//Route::middleware('auth:api')->post('/user/follow','FollowerController@follow');