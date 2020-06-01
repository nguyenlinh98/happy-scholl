<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;

class BaseController extends Controller
{

    public function __construct(Guard $auth)
    {
        $this->currentUser = $auth->user();
    }

    /**
     * Return success shortcut
     *
     * @param mixed $message
     *
     * @return Dingo\Api\Routing\Helpers::$response
     *
     */

    protected function success($message = null)
    {
        if ($message === null) {
            return $this->response->array(["success" => true], 200);
        }
        return $this->response->array(['success' => true, 'message' => $message], 200);
    }
}
