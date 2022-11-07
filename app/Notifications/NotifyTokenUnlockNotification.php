<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NotifyTokenUnlockNotification extends Notification
{
    use Queueable;
    public $token;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return  ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
        // public function toMail($notifiable)
        // {
        //     return (new MailMessage)
        //                 ->line('The introduction to the notification.')
        //                 ->action('Notification Action', url('/'))
        //                 ->line('Thank you for using our application!');
        // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'name' => $this->token->name,
            'coin_id' => $this->token->coin_id,
            'next_unlock_date' => $this->token->next_unlock_date,
            'next_unlock_number_of_tokens' => $this->token->next_unlock_number_of_tokens,
            'symbol' => $this->token->symbol,
            'image' => $this->token->image,
            'type' => $this->token->notifytype,
            'current_price' => $this->token->current_price,
        ];
    }
}
