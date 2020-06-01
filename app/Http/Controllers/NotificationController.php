<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\NotificationRequest;
use App\Notification;
use App\Transformers\NotificationTransformer;
use Illuminate\Http\Request;
use Log;

/**
 * @group Notification
 *
 * APIs for Notification
 */
class NotificationController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @authenticated
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info('[NotificationController.index] Start...');

        $resp = $this->response->collection(Notification::forMe()->withApp()->get(), new NotificationTransformer());

        Log::info('[NotificationController.index] End...');

        return $resp;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @authenticated
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationRequest $request)
    {
        Log::info('[NotificationController.store] Start...');

        $item = Notification::create($request->all());
        $resp = $this->item($item, new NotificationTransformer());

        Log::info('[NotificationController.store] End...');

        return $resp;
    }

    /**
     * Display the specified resource.
     *
     * @authenticated
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('[NotificationController.show] Start...');

        $resp = $this->item(Notification::find($id), new NotificationTransformer());

        Log::info('[NotificationController.show] End...');

        return $resp;
    }

    /**
     * Update the specified resource in storage.
     *
     * @authenticated
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(NotificationRequest $request, $id)
    {
        Log::info('[NotificationController.update] Start...');

        $item = Notification::find($id);
        $item->update($request->all());
        $resp = $this->item($item, new NotificationTransformer());

        Log::info('[NotificationController.update] End...');

        return $resp;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @authenticated
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::info('[NotificationController.destroy] Start...');

        Notification::destroy($id);

        Log::info('[NotificationController.destroy] End...');

        return response()->json(null, 204);
    }
}
