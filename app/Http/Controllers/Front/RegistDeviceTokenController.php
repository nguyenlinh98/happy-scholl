<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Models\UserDevice;
use App\Http\Controllers\BaseController;
use App\Transformers\UserDeviceTransformer;
use Log;
use Auth;

class RegistDeviceTokenController extends BaseController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('[UserDeviceController.store] Start...');
        $deviceToken = $request->header('device-token');
        $deviceTokencookie = $request->cookie('device-token');
        Log::info('[UserDeviceController.store] cookie...' .$deviceTokencookie);
        if(!empty($deviceToken)) {
            $item = UserDevice::firstOrNew(array('user_id' => \Auth::guard('parents')->user()->id, 'device_token' => $deviceToken));
            //$item = UserDevice::firstOrNew(array('user_id' => $request->user_id, 'device_token' => $request->device_token));
            $item->save();
            //$resp = $this->item($item, new UserDeviceTransformer());
        }
        else if(!empty($deviceTokencookie)) {
            $item = UserDevice::firstOrNew(array('user_id' => \Auth::guard('parents')->user()->id, 'device_token' => $deviceTokencookie));
            //$item = UserDevice::firstOrNew(array('user_id' => $request->user_id, 'device_token' => $request->device_token));
            $item->save();
            //$resp = $this->item($item, new UserDeviceTransformer());
        } else {
            Log::info('[UserDeviceController.store] device_token: ' .$deviceToken);
        }

        Log::info('[UserDeviceController.store] End...');
        return redirect()->route('front.school.choose');
    }
}
