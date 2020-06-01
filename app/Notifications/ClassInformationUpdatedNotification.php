<?php

namespace App\Notifications;

use App\Channels\FirebaseTopicChannel;
use App\Models\SchoolClass;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ClassInformationUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $class;

    public function __construct(SchoolClass $class)
    {
        $this->class = $class;
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
        return [FirebaseTopicChannel::class, 'database'];
    }

    public function toFirebaseTopic($notifiable)
    {
        return $this->toArray($notifiable);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'body' => "Class name {$this->class->name} updated.",
            'title' => 'Class updated',
        ];
    }
}
