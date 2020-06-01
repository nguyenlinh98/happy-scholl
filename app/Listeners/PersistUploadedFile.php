<?php

namespace App\Listeners;

use App\Events\FileInfoSavedToDatabase;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Storage;

class PersistUploadedFile
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * Todo: Implement queue interface for large size files.
     *
     * @param  FileInfoSavedToDatabase  $event
     * @return void
     */
    public function handle(FileInfoSavedToDatabase $event)
    {
        $model = $event->model;

        foreach ($event->uploadedFiles as $file) {
            $mime = $file->getMimeType();

            [$mainMime, $subMime] = explode('/', $mime);

            Storage::disk('local')->putFile(
                'public/uploads/'.$model->getTable().'/'.$model->id.'/'.$mainMime.'s',
                $file
            );
        }

        if (null !== $event->oldModelData) {
            // Clean old files.
        }
    }
}
