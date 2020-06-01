<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use LaravelFCM\Message\Topics;

class FirebaseTopicChannel
{
    private $defaultMessage = [];

    public function __construct()
    {
        $this->defaultMessage = [
            'title' => config('firebase.message.title'),
            'body' => '',
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
        $message = $notification->toFirebaseTopic($notifiable);
        // Merge message with default settings
        $firebaseMessage = array_merge($this->defaultMessage, $message);

        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder();
        $notificationBuilder->setTitle($firebaseMessage['title']);
        $notificationBuilder->setBody($firebaseMessage['body']);
        $notificationBuilder->setSound($firebaseMessage['sound']);
        $firebaseNotification = $notificationBuilder->build();

        $topic = new Topics();
        $topic->topic($notifiable->topic);
        $topicResponse = FCM::sendToTopic($topic, null, $firebaseNotification, null);

        return $topicResponse->isSuccess();
    }
}
