<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\NotificationUserRequest;
use App\Transformers\NotificationUserTransformer;
use App\NotificationUser;
use Log;

/**
 * @group NotificationUser
 *
 * APIs for NotificationUser
 */
class NotificationUserController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @authenticated
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info('[NotificationUserController.index] Start...');

        $resp =  $this->response->collection(NotificationUser::forCurrentUser()->withNotificationSetting()->get(), new NotificationUserTransformer());

        Log::info('[NotificationUserController.index] End...');

        return $resp;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @authenticated
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationUserRequest $request)
    {
        Log::info('[NotificationUserController.store] Start...');

        $item = NotificationUser::create($request->all());
        $resp = $this->item($item, new NotificationUserTransformer());

        Log::info('[NotificationUserController.store] End...');
        return $resp;
    }

    /**
     * Display the specified resource.
     *
     * @authenticated
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('[NotificationUserController.show] Start...');

        $resp = $this->item(NotificationUser::withNotificationSetting()->find($id), new NotificationUserTransformer());

        Log::info('[NotificationUserController.show] End...');

        return $resp;
    }

    /**
     * Update the specified resource in storage.
     *
     * @authenticated
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NotificationUserRequest $request, $id)
    {
        Log::info('[NotificationUserController.update] Start...');

        $item = NotificationUser::find($id);
        $item->update($request->all());
        $resp = $this->item($item, new NotificationUserTransformer());

        Log::info('[NotificationUserController.update] End...');
        return $resp;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @authenticated
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::info('[NotificationUserController.destroy] Start...');

        NotificationUser::destroy($id);

        Log::info('[NotificationUserController.destroy] End...');

        return response()->json(null, 204);
    }
}
