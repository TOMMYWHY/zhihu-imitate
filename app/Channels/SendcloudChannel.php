<?php
/**
 * Created by PhpStorm.
 * User: Tommy
 * Date: 2019/1/10
 * Time: 下午4:43
 */

namespace App\Channels;


use Illuminate\Notifications\Notification;

class SendcloudChannel {

	public function send( $notifiable, Notification $notification ) {
		$message = $notification->toSendcloud($notifiable);
	}
}