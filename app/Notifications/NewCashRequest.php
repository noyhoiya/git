<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\CashRequest;

class NewCashRequest extends Notification
{
    use Queueable;

    protected $cashRequest;

    public function __construct(CashRequest $cashRequest)
    {
        $this->cashRequest = $cashRequest;
    }

    public function via($notifiable)
    {
        return ['mail']; // only email, no database
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Cash Request')
                    ->greeting('Hello '.$notifiable->full_name)
                    ->line($this->cashRequest->requesterUser->full_name.' requested '
                        .number_format($this->cashRequest->amount, 2).' from '
                        .$this->cashRequest->requesterVault->name)
                    ->action('View Request', url('/cash-requests')) // optional link
                    ->line('Thank you for using our system!');
    }
}