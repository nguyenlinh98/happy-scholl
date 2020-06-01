<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Recycle\CreateRecyclePlaceRequest;
use App\Models\RecyclePlace;

class RecyclePlaceController extends Controller
{

    public function store(CreateRecyclePlaceRequest $request)
    {
        $recyclePlace = RecyclePlace::where('school_id', auth()->user()->school_id)->first();
        if(empty($recyclePlace)) {
            $recyclePlace = new recyclePlace();
        }
        
        $recyclePlace->createNew($request);

        session()->flash('include', 'admin.recycle.modal.recycle-place-created');

        return redirect()->back();
    }
}
