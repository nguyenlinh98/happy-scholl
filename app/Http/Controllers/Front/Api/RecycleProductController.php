<?php

namespace App\Http\Controllers\Front\Api;

use App\Models\RecycleProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RecycleProductController extends Controller
{
   protected $recycleProduct;

    public function __construct(RecycleProduct $recycleProduct)
    {
        $this->recycleProduct = $recycleProduct;
    }
    public function loadData(Request $request)
    {
        Log::info('[RecycleProductController.loadData] Start...');
        $set_output = '';
        $school_id = $request['id'];
        $page = $request['page'];
        $userId = $request['user_id'];
        $recycleProduct = $this->recycleProduct->getSellingProduct($school_id, $userId, $page);
        $html  = '';
        if (!$recycleProduct->isEmpty()) {
           $html = view('front.mypage.list_recycles',compact('recycleProduct'))->render();
        }
        Log::info('[RecycleProductController.loadData] End...');

        return  [
            'html'=>$html,
            'hasPage'=>$recycleProduct->lastPage()>$page
        ];
    }

    public function guard()
    {
        $parents = Auth::guard('parents')->user();
    }
}
