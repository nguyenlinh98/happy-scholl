<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\SystemStatus\SystemStatusRequest;
use App\Transformers\SystemStatusTransformer;
use App\Http\Controllers\BaseController;
use App\Models\SystemStatus;
use Log;
use App\Http\Resources\SystemStatusCollection;

/**
 * @group SystemStatus
 *
 * APIs for SystemStatus
 */
class SystemStatusController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @authenticated
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Log::info('[SystemStatusController.index] Start...');

        $resp =  new SystemStatusCollection(SystemStatus::all());

        Log::info('[SystemStatusController.index] End...');

        return $resp;
    }
}
