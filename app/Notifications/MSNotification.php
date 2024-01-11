<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsChannel;
use NotificationChannels\MicrosoftTeams\MicrosoftTeamsMessage;

class MSNotification extends Notification
{
    use Queueable;

    private $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message)
    {
        //
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [MicrosoftTeamsChannel::class];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */

    //For teams noti
    // public function toMicrosoftTeams($notifiable)
    // {
    //     return MicrosoftTeamsMessage::create()
    //         ->to(config('services.microsoft_teams.sales_url'))
    //         ->type('success')
    //         ->title('Subscription Created')
    //         ->content('Yey, you got a **new subscription**. Maybe you want to contact him if he needs any support?')
    //         ->button('Check User', 'https://foo.bar/users/123');
    // }
    public function toMicrosoftTeams($notifiable)
    {
        return MicrosoftTeamsMessage::create()
        ->to(config('services.microsoft_teams.webhook_url'))
        ->type('success')
        ->title('New message alert')
        ->content($this->message)
        ->button('Check Now', env('APP_URL').'/chats');

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
            //
        ];
    }
}
