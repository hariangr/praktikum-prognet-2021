<?php

namespace App\Notifications;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserStatusTransactionChanged extends Notification
{
    use Queueable;
    public int $transaction_id;
    public string $old_status;
    public string $new_status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($_transaction_id, $_old_status, $_new_status)
    {
        $this->transaction_id = $_transaction_id;
        $this->old_status = $_old_status;
        $this->new_status = $_new_status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
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
            ->line('Status transaksimu berubah')
            ->action('Buka transaksi', url(route('transaction.show', $this->transaction_id)))
            ->line('Dari ' . $this->old_status . ' menjadi ' . $this->new_status);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $trans = Transaction::find($this->transaction_id);

        return [
            "transaction_id" => $this->transaction_id,
            "transaction" => $trans,
            "old_status" => $this->old_status,
            "new_status" => $this->new_status
        ];
    }
}
