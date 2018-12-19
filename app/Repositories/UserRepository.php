<?php
/**
 * Created by PhpStorm.
 * User: Tommy
 * Date: 2018/12/9
 * Time: 下午11:43
 */

namespace App\Repositories;


use App\User;

class UserRepository {

	public function byId( $id ) {
		return User::find($id);
	}
}