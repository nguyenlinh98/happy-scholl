<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserDevice\CreateUserDeviceRequest;
use App\Models\UserDevice;
use App\Http\Controllers\BaseController;
use App\Transformers\UserDeviceTransformer;
use Log;
use Auth;

class UserDeviceController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserDeviceRequest $request)
    {
        Log::info('[UserDeviceController.store] Start...');
        $item = UserDevice::firstOrNew(array('user_id' => Auth::user()->id, 'device_token' => $request->device_token));
        //$item = UserDevice::firstOrNew(array('user_id' => $request->user_id, 'device_token' => $request->device_token));
        $item->save();
        //$resp = $this->item($item, new UserDeviceTransformer());

        Log::info('[UserDeviceController.store] End...');
        return response()->json([
            'status' => 'OK'
        ]);
    }
}
