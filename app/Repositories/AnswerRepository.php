<?php
/**
 * Created by PhpStorm.
 * User: Tommy
 * Date: 2018/12/3
 * Time: 下午10:12
 */

namespace App\Repositories;


use App\Answers;

class AnswerRepository {

	public function create(array $attributes) {
		return Answers::create($attributes);

	}



}