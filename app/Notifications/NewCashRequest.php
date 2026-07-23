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

    /**
     * Specify delivery channels.
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // now saves to DB as well
    }

    /**
     * Email content
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('New Cash Request')
                    ->greeting('Hello '.$notifiable->full_name)
                    ->line($this->cashRequest->requesterUser->full_name.' requested '
                        .number_format($this->cashRequest->amount, 2).' from '
                        .$this->cashRequest->requesterVault->vault_name)
                    ->action('View Request', url('/cash-requests'))
                    ->line('Thank you for using our system!');
    }

    /**
     * Database content for notifications table
     */
    public function toDatabase($notifiable)
    {
        return [
            'request_id' => $this->cashRequest->id,
            'amount' => $this->cashRequest->amount,
            'vault_name' => $this->cashRequest->requesterVault->vault_name ?? null,
            'requester_name' => $this->cashRequest->requesterUser->full_name,
            'created_at' => $this->cashRequest->created_at,
        ];
    }
}
