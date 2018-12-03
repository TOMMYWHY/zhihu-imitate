<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'QuestionController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');//middleware('auth')
Route::get('email/verify/{token}','EmailController@verify' )->name('email.verify');//注册之后，用户邮箱中验证地址路由


Route::resource('/questions', 'QuestionController',['name'=>[
	'create'=>'question.create',
	'show'=>'question.show',
	'edit'=>'question.edit',
	'update'=>'question.update',
	'destroy'=>'question.delete'

]]);


