<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Repositories\QuestionRepository;
use Illuminate\Http\Request;
use Auth;

/**
 * Class QuestionController
 * @package App\Http\Controllers
 */
class QuestionController extends Controller
{

	/**
	 * @var QuestionRepository
	 */
	protected $questionRepository;
	/**
	 * QuestionController constructor.
	 */
	public function __construct(QuestionRepository $question_repository) {
		$this->middleware('auth')->except( ['index','show']);//除index show，其他方法使用中间件。
		$this->questionRepository = $question_repository;
	}

	/**
	 *
	 */
	public function index() {
		$questions =$this->questionRepository->getQuestionsFeed();
		return view('questions.index',compact( 'questions'));
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create() {
		return view('questions.create');
	}

	/**
	 * @param StoreQuestionRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(StoreQuestionRequest $request) {

		//判断传递的topics 数组
		$topics = $this->questionRepository->normalizeTopic( $request->get( 'topics'));
//		dd( $topics);

		$data = [
			"title" => $request->get( 'title'),
			"body" => $request->get( 'body'),
			'user_id'=>Auth::id(),
		];

		$question = $this->questionRepository->create( $data);
		$res =  $question->topics()->attach($topics);
//		dd( $res);
		return redirect()->route( 'questions.show',[$question->id]);

	}

	/**
	 * @param $id
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function show( $id ) {

		$question = $this->questionRepository->byIdWithTopicsAndAnswers( $id);

		return view('questions.show',compact( 'question'));
	}

	/**
	 * @param $id
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit( $id ) {

		$question = $this->questionRepository->byId( $id);
//		dd( $question);
		if(Auth::user()->owns($question)){
			return view('questions.edit',compact( 'question'));

		}
		return back();
	}


	/**
	 * @param StoreQuestionRequest $request
	 * @param $id
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(StoreQuestionRequest $request, $id) {
		$question = $this->questionRepository->byId( $id);
		$topics = $this->questionRepository->normalizeTopic( $request->get( 'topics'));
		$question->update([
			'title'=>$request->get( 'title'),
			'body'=>$request->get( 'body'),
		]);
		$question->topics()->sync($topics);
//		dd( 'qqq');
		return redirect()->route( 'questions.show',[$question->id]);
	}

	public function destroy( $id ) {
//		dd(11);
		$questions = $this->questionRepository->byId( $id);
		if(Auth::user()->owns($questions)){
			$questions->delete();
			return redirect('/');
		}
		abort( 403, 'Forbidden');
	}

}
