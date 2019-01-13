<?php
/**
 * Created by PhpStorm.
 * User: Tommy
 * Date: 2018/12/3
 * Time: 下午10:12
 */

namespace App\Repositories;


use App\Answer;

class AnswerRepository {

	public function create(array $attributes) {
		return Answer::create($attributes);

	}

	public function byId( $id ) {
			return Answer::find($id);
	}



}