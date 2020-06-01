<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class QaController extends Controller
{
    public function ask()
    {
        Log::info('[QaController.index] Start...' );
        return view('front.qas.ask');
    }

    public function complete()
    {
        Log::info('[QaController.complete] Start...' );
        return view('front.qas.complete');
    }

    public function reAsk()
    {
        Log::info('[QaController.reAsk] Start...' );
        return view('front.qas.re_ask');
    }
}
