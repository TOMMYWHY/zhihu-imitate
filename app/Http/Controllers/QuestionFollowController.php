<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class QuestionFollowController extends Controller
{
    //
	public function follow( $question ) {
		Auth::user()->followThis($question);
		return back();
	}


}
