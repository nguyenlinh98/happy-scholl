<?php

namespace App\Jobs\CalendarEvent;

use App\Models\Event;
use App\Notifications\SendEventReminderNotification;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;

class SendEventReminderJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $event;

    public $users;

    public $notificationSetting = 'push_calendar';
    public $version = '1.3.0';

    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->users = $event->calendar->users()->with(['settings', 'devices'])->get();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        echo "[SendEventReminderJob] handle start \n";
        hsp_debug(['version' => $this->version]);
        if ($this->event->reminder_sent) {
            logger()->warning("Event::{$this->event->id} is already sent, aborting");
            echo "[SendEventReminderJob] Event::{$this->event->id} is already sent, aborting\n";
            return false;
        }

        if ('hsp' === $this->event->calendar->type) {
            logger()->warning("Calling send reminder job to Event::{$this->event->id} of calendar type 'hsp', please check");
            echo "[SendEventReminderJob] Calling send reminder job to Event::{$this->event->id} of calendar type 'hsp', please check\n";
            return false;
        }

        hsp_debug([
            'calendar_id' => $this->event->calendar_id,
            'total_users_affected' => $this->users->count(),
        ]);

        echo "[SendEventReminderJob] processUsers start \n";
        $this->processUsers();
        echo "[SendEventReminderJob] update to sent start \n";
        $this->setEventReminderAsSent();
        echo "[SendEventReminderJob] handle end \n";
    }

    public function processUsers()
    {
        foreach ($this->users as $user) {
            try {
                throw_if(null === $user->settings, ModelNotFoundException::class, get_class($user)."::{$user->id} does not have any setting");

                throw_if(0 === $user->settings->{$this->notificationSetting}, InvalidArgumentException::class, get_class($user)."::{$user->id} has disabled event reminder");

                throw_if(0 === $user->devices->count(), ModelNotFoundException::class, get_class($user)."::{$user->id} does not have any registered devices");
            } catch (Exception $e) {
                echo "[SendEventReminderJob] processUsers error".$e->getMessage()."\n";
                logger()->warning($e->getMessage());
                continue;
            }
            info('Notify a SendEventReminderNotification for user id::'.$user->id);
            echo 'Notify a SendEventReminderNotification for user id::'.$user->id."\n";
            $user->notify(new SendEventReminderNotification($this->event));
        }
    }

    public function setEventReminderAsSent()
    {
        hsp_debug("Mark Event::{$this->event->id} as reminded");
        $this->event->markAsReminded();
    }
}
