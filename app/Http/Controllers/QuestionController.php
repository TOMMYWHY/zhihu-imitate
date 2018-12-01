<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Question;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
use Auth;
class QuestionController extends Controller
{
    //
	public function index() {

	}

	public function create() {
		return view('questions.create');
	}

	public function store(StoreQuestionRequest $request) {
//        return $request->all();
		/*
		 *
		$rules=[
			'title'=>'required|min:6|max:196',
			'body'=>'required|min:26',
		];
		$msg =[
			'title.required' => 'title could not be empty~!',
			'body.required' => 'body could not be empty~!'

		];
		$this->validate( $request, $rules,$msg);

		*/
		$data = [
			"title" => $request->get( 'title'),
			"body" => $request->get( 'body'),
			'user_id'=>Auth::id(),
		];
		$question = Question::create($data);
		return redirect()->route( 'questions.show',[$question->id]);
	}

	public function show( $id ) {
		$question = Question::findOrFail($id);
		return view('questions.show',compact( 'question'));
	}

}
