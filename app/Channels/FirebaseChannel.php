<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class FirebaseChannel
{
    private $defaultMessage = [];
    private $shouldProcess = true;

    public function __construct()
    {
        $this->defaultMessage = [
            'title' => config('firebase.message.title'),
            'message' => '',
            'sound' => config('firebase.message.sound'),
        ];
    }

    /**
     * Send the given notification.
     *
     * @param mixed $notifiable
     */
    public function send($notifiable, Notification $notification)
    {
        info(self::class.'::send:start');
        $message = $notification->toFirebase($notifiable);
        // Merge message with default settings
        $firebaseMessage = array_merge($this->defaultMessage, $message);

        // get notifiable device token
        $tokens = $notifiable->devices->pluck('device_token')->flatten()->toArray();

        if (count($tokens)) {
            $optionBuilder = new OptionsBuilder();
            $optionBuilder->setTimeToLive(60 * 20);

            $notificationBuilder = new PayloadNotificationBuilder();

            $notificationBuilder->setTitle($firebaseMessage['title']);
            $notificationBuilder->setBody($firebaseMessage['body']);
            $notificationBuilder->setSound($firebaseMessage['sound']);

            $option = $optionBuilder->build();
            $firebaseNotification = $notificationBuilder->build();
            $downstreamResponse = FCM::sendTo($tokens, $option, $firebaseNotification);
            info(self::class.'::send:end');

            return $downstreamResponse->numberSuccess() === count($tokens);
        }
        info(self::class.'::send:emptyTokenEnd');

        return false;
        // Send notification to the $notifiable instance...
    }
}
