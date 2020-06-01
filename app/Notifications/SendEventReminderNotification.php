<?php

namespace App\Notifications;

use App\Channels\FirebaseChannel;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class SendEventReminderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return [FirebaseChannel::class];
    }

    public function toFirebase()
    {
        return [
            'title' => 'リマインド',
            'body' => $this->event->title,
        ];
    }
}
