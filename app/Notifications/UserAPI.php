<?php
namespace App\Notifications;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
class UserAPI extends Notification
{
    use Queueable;
    public $user;
    public $link_active;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
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
            ->line('Your random password:' . $this->password)
            ->line('Please change password as soon as possilbe!');
    }
}