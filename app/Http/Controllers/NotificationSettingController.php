<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\NotificationSettingRequest;
use App\Transformers\NotificationSettingTransformer;
use App\NotificationSetting;
use Log;

/**
 * @group NotificationSetting
 *
 * APIs for NotificationSetting
 */
class NotificationSettingController extends BaseController
{

    /**
     * Display a listing of the resource.
     * 
     * @authenticated
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info('[NotificationSettingController.index] Start...');

        $resp =  $this->response->collection(NotificationSetting::all(), new NotificationSettingTransformer());

        Log::info('[NotificationSettingController.index] End...');

        return $resp;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @authenticated
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(NotificationSettingRequest $request)
    {
        Log::info('[NotificationSettingController.store] Start...');

        $item = NotificationSetting::create($request->all());
        $resp = $this->item($item, new NotificationSettingTransformer());

        Log::info('[NotificationSettingController.store] End...');
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
        Log::info('[NotificationSettingController.show] Start...');

        $resp = $this->item(NotificationSetting::find($id), new NotificationSettingTransformer());

        Log::info('[NotificationSettingController.show] End...');

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
    public function update(NotificationSettingRequest $request, $id)
    {
        Log::info('[NotificationSettingController.update] Start...');

        $item = NotificationSetting::find($id);
        $item->update($request->all());
        $resp = $this->item($item, new NotificationSettingTransformer());

        Log::info('[NotificationSettingController.update] End...');
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
        Log::info('[NotificationSettingController.destroy] Start...');

        NotificationSetting::destroy($id);

        Log::info('[NotificationSettingController.destroy] End...');

        return response()->json(null, 204);
    }
}
