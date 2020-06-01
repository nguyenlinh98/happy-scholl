<?php

namespace App\Jobs;

use App\Models\User;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use Log;

class NotifyViaFirebaseJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public $user;

    public $setting;

    public $message;

    public $title;

    private $version;

    private $shouldProcess = true;

    public function __construct(User $user, string $setting = '', string $title = '', $message = '')
    {
        echo "[NotifyViaFirebaseJob] __construct start\n";
        $this->user = $user;
        $this->version = '4.1.0';
        $this->setting = $setting;
        $this->title = $title;
        $this->message = $message;
        $this->setup();
        echo "[NotifyViaFirebaseJob] __construct end\n";
    }

    /**
     *  Preparing data and Jobs.
     */
    private function setup()
    {
        try {
            throw_if('' === $this->setting, InvalidArgumentException::class, 'No setting specified');

            throw_if(null === $this->user->settings, ModelNotFoundException::class, "Use {$this->user->id} does not have any setting");

            // Checking condition wrong. Urgent need a push setting ???
            // Show null == $this->user->settings
            // Todo: Has problem ???
            // Should be: throw_if(0 == $this->user->settings->{$this->setting}, InvalidArgumentException::class, "User {$this->user->id} has disabled notification");
            throw_if(0 === $this->user->settings->{$this->setting}, InvalidArgumentException::class, "User {$this->user->id} has disabled notification");

            throw_if(0 === $this->user->devices->count(), ModelNotFoundException::class, "User {$this->user->id} does not have any registered devices");

            $this->shouldProcess = true;
        } catch (Exception $e) {
            echo "setup error: ". $e->getMessage()."\n";
            logger()->warning($e->getMessage());
            // Todo: Has problem ???
            $this->shouldProcess = false;
        }
        // Todo: Only Exception flow run through this.
        //info("Should process: ".($this->shouldProcess == true ? 1 : 0));
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($this->shouldProcess) {
            //logger('Send notification to user '.$this->user->id);
            info('Send notification to user '.$this->user->id);
            $this->toFirebase();
        }
    }

    /**
     * Send notification to firebase.
     */
    public function toFirebase()
    {
        // get user device

        $toUserDevices = $this->user->devices->pluck('device_token')->flatten()->toArray();
        hsp_debug('user_devices', $toUserDevices);
        $isSuccess = $this->send($toUserDevices);
        // Todo: Mock to test only fire base
        //$isSuccess = $this->send(['fdfd', 'fdsafds']);

        if (!$isSuccess) {
            echo "[NotifyViaFirebaseJob] toFirebase Error\n";
            throw new Exception('Something wrong with firebase API');
        }
    }

    /**
     * Send the given notification.
     *
     * @param App\Notification $notification
     * @param mixed            $message
     */
    private function send(array $tokens)
    {
        Log::info('[NotifyViaFirebaseJob.send] Start...');

        $badge = $this->user->getUnreadCount();
        hsp_debug('Badge Count', $badge);
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder();
        $notificationBuilder->setTitle($this->title);
        $notificationBuilder->setBody($this->message);
        $notificationBuilder->setSound('default');
        $notificationBuilder->setBadge($badge);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $downstreamResponse = FCM::sendTo($tokens, $option, $notification);

        Log::info('[NotifyViaFirebaseJob.send] End...');

        return true;
    }
}
