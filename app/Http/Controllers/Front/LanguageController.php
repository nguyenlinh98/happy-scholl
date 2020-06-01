<?php
/**
 * User: JohnAVu
 * Date: 2019-12-27
 * Time: 13:41
 */

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function index($lang)
    {
        Log::info('[LanguageController.index] Start...');
        Session::put('lang', $lang);
        Log::info('[LanguageController.index] End...');
        return redirect()->back();
    }
}
