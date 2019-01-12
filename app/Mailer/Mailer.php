<?php
/**
 * Created by PhpStorm.
 * User: Tommy
 * Date: 2019/1/13
 * Time: 上午10:43
 */

namespace App\Mailer;


use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer {

	protected function sendTo($template,$email, array $data) {

		$content = new SendCloudTemplate( $template, $data);

		Mail::raw( $content, function ($message) use($email){
			$message->from('tommy_admin@zhihu.com', 'Tommy-zhihu');
			$message->to($email);
		});
	}
}