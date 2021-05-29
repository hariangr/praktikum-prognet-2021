<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentUploaded extends Notification
{
    use Queueable;
    public int $transaction_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($_transaction_id)
    {
        $this->transaction_id = $_transaction_id;
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
                    ->line('Seseorang baru saja mengunggah bukti pembayaran')
                    ->action('Buka transaksi', url(route('transaction.show', $this->transaction_id)));
                    // ->line('Thank you for using our application!');
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
            "transaction_id" => $this->transaction_id,
        ];
    }
}
