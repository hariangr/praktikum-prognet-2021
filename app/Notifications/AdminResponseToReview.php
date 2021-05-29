<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminResponseToReview extends Notification
{
    use Queueable;
    public string $content;
    public string $response_content;
    public int $review_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($_content, $_review_id, $_response_content)
    {
        $this->content = $_content;
        $this->review_id = $_review_id;
        $this->response_content = $_response_content;
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
                    ->line('Seorang admin merespon ulasanmu!')
                    // ->action('Notification Action', url('/'))
                    ->line($this->response_content);
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
            "review_id" => $this->review_id,
            "content" => $this->content,
            "response" => $this->response_content,
        ];
    }
}
