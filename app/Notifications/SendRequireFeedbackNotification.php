<?php

namespace App\Notifications;

use App\Channels\FirebaseChannel;
use App\Models\RequireFeedback;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;
use InvalidArgumentException;

class SendRequireFeedbackNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $requireFeedback;
    public $version = 'v1.0.0';
    public $notificationSetting;

    public function __construct(RequireFeedback $requireFeedback)
    {
        info(self::class.'::_construct:start', [$this->version]);
        $this->requireFeedback = $requireFeedback;
        $this->notificationSetting = config('require_feedback.push_setting');
        info(self::class.'::_construct:end');
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
        info(self::class.'::via:start');

        try {
            throw_if(null === $notifiable->settings, ModelNotFoundException::class, get_class($notifiable)."::{$notifiable->id} does not have any setting");

            throw_if(0 === $notifiable->settings->{$this->notificationSetting}, InvalidArgumentException::class, get_class($notifiable)."::{$notifiable->id} has disabled notification");

            throw_if(0 === $notifiable->devices->count(), ModelNotFoundException::class, get_class($notifiable)."::{$notifiable->id} does not have any registered devices");
        } catch (Exception $e) {
            logger()->warning($e->getMessage());
            logger(self::class.'::via:catchEnd');

            return [];
        }
        info(self::class.'::via:end');

        return ['database', FirebaseChannel::class];
    }

    /**
     * Get the database representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'subject' => $this->requireFeedback->subject,
            'require_feedback_id' => $this->requireFeedback->id,
        ];
    }

    public function toFirebase($notifiable)
    {
        return [
            'title' => $this->requireFeedback->subject,
            'body' => Str::limit($this->requireFeedback->body, config('require_feedback.body_limit')),
            'sound' => config('require_feedback.notification_sound', 'default'),
        ];
    }
}
