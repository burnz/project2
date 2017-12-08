<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
class UserRegistered extends Notification
{
    use Queueable;
    public $user;
    public $link_active;

    public function __construct($user, $link_active)
    {
        $this->user = $user;
        $this->link_active = $link_active;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('no-reply@mycarcoin.com', 'CAR')
            ->subject('Welcome to the CAR Coin')
            // ->cc($dataSendMail['mail_to'], $this->user->name)
            ->greeting('Dear '.$this->user->name. ',')
            ->line('Thank you for registering on the CARCoin.')
            ->line('Below you will find your activation link:')
            ->action('Active Account', $this->link_active)
            ->line('This link will expire in 1 days.');
    }
}