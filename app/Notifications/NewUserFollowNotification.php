<?php

namespace App\Notifications;

use App\Channels\SendcloudChannel;
use App\Mailer\UserMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Auth;
use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;


class NewUserFollowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database',SendcloudChannel::class];
    }

	public function toSendcloud($notifiable) {
		/*$data = ['url'=>'http://zhihu-app.test','name'=>Auth::guard('api')->user()->name];
		$template = new SendCloudTemplate( 'zhihu_app_user_follow', $data);
		Mail::raw( $template, function ($message) use($notifiable){
			$message->from('tommy_admin@zhihu.com', 'Tommy-zhihu');
			$message->to($notifiable->email);
		});*/

		(new UserMailer())->followNotifyEmail( $notifiable->email);

    }

	public function toDatabase( $notifiable ) {
		return [
			'name'=> Auth::guard('api')->user()->name,
		];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
   /* public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }*/

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
