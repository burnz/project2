<?php
namespace App\Notifications;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
class WithDrawConfirm extends Notification
{
    public $user;
    public $coinData;
    public $linkConfirm;
    public function __construct($user, $coinData, $linkConfirm)
    {
        $this->user = $user;
        $this->coinData = $coinData;
        $this->linkConfirm = $linkConfirm;
    }
    public function via($notifiable)
    {
        return ['mail'];
    }
    public function toMail()
    {
        return (new MailMessage)
            ->from('no-reply@mycarcoin.com', 'CAR')
            ->subject('Withdrawal '.($this->coinData['type'] == 'btc' ? 'BTC' : 'CAR').' confirmation')
            ->greeting('Hi '.$this->user->name. ',')
            ->line('A request to withdraw '.$this->coinData['amount'].' '.($this->coinData['type'] == 'btc' ? 'BTC' : 'CAR').' from your CAR account to address '.$this->coinData['address'].' was just made.')
            ->action('Confirmation link', $this->linkConfirm)
            ->line('This link will expire in 30 mins.')
            ->line('If you did not request a withdrawal. Please contact us immediately!');
    }
}