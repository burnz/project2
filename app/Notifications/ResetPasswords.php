<?php
namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Auth\Notifications\ResetPassword;
class ResetPasswords extends ResetPassword{
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->from('no-reply@mycarcoin.com', 'CAR')
            ->subject('Reset Password')
            //->greeting('Dear '.$this->name. ',')
            //->greeting('Dear Your')
            ->line('A request to reset the password on your account was just made.')
            ->line('To set a new password on this account, please click the following link:')
            ->action('Reset Password', url( route('password.reset', [$this->token, 'email'=>$notifiable->email], false)))
            ->line('This link will expire in 3 days.')
            ->line('If you did not request a password reset, no further action is required. Please contact us immediately if you did not submit this request.');
    }
}