<?php

namespace App\Notifications\trip;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

use App\Models\User;
use App\Models\Trip;


class newPrivateTrip extends Notification
{
    use Queueable;

    private $sender;
    private $recipient;
    private $privateTrip;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $senderUser,User $recipientUser,Trip $trip)
    {
        $this->sender = $senderUser;
        $this->recipient = $recipientUser;
        $this->privateTrip = $trip;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if($notifiable->mail_notifications == 1)
        {
            return ['database','mail'];
        }
        else
        {
            return ['database'];
        }

    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'id_user'               =>  $this->recipient->id,
            'id_user_origin'        =>  $this->sender->id,
            'id_trip'               =>  $this->privateTrip->id,
        ];
    }
}
