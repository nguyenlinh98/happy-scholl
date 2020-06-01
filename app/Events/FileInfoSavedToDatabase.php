<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Database\Eloquent\Model;

class FileInfoSavedToDatabase
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Provide info about path used to store files.
     *
     * @var $model
     */
    public $model;

    /**
     * Resources is being saved.
     */
    public $uploadedFiles;

    /**
     * Old files is in need of cleaning.
     */
    public $oldModelData;

    /**
     * Create a new event instance.
     *
     * @param Illuminate\Database\Eloquent\Model $model
     * @param array of Illuminate\Http\File | Illuminate\Http\UploadedFile $file
     * @param mixed $oldModelData
     *
     * @return void
     */
    public function __construct(Model $model, array $files, $oldModelData = null)
    {
        $this->model = $model;

        $this->uploadedFiles = $files;

        $this->oldModelData = $oldModelData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
