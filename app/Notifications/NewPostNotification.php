<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPostNotification extends Notification
{
    use Queueable;

    protected $data;
    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
         $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $unsubscribeUrl = url('/travel-blog/unsubscribe/' . urlencode($notifiable->email));
        return (new MailMessage)
                ->subject($this->data->title)
                ->line('Hello,')
                ->line('A new post has been published: "' . $this->data->title)
                ->action('Read the Post', url('/travel-blog/blog/' . $this->data->slug))
                ->line('Thank you for being part of our community!')
                ->line('If you no longer wish to receive these notifications, you can unsubscribe by clicking the link below:')
                 ->line($unsubscribeUrl);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'post_title' => $this->data->title,
            'post_slug' => $this->data->slug,
        ];
    }
}
