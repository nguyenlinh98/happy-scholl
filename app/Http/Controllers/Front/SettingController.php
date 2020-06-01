<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    const GUARD = 'parents';

    protected $userSetting;

    public function __construct(UserSetting $userSetting)
    {
        $this->userSetting = $userSetting;
    }

    public function index()
    {
        Log::info('[SchoolController.index] Start...');
        $user = $this->getParent();

        $setting = $user->setting->first();
        Log::info('[SchoolController.index] End...');

        return view('front.setting.index', compact('setting'));
    }

    public function success(Request $request)
    {
        Log::info('[SchoolController.success] Start...');
        $data = $request->all();

        $data['push_letter'] = isset($data['push_letter']) ? $data['push_letter'] : 0;
        $data['push_notice'] = isset($data['push_notice']) ? $data['push_notice'] : 0;
        $data['push_require_feedback'] = isset($data['push_require_feedback']) ? $data['push_require_feedback'] : 0;
        $data['push_organization'] = isset($data['push_organization']) ? $data['push_organization'] : 0;
        $data['push_recycle'] = isset($data['push_recycle']) ? $data['push_recycle'] : 0;
        $data['push_course'] = isset($data['push_course']) ? $data['push_course'] : 0;
        $data['push_event'] = isset($data['push_event']) ? $data['push_event'] : 0;
        $data['push_happy_school_plus'] = isset($data['push_happy_school_plus']) ? $data['push_happy_school_plus'] : 0;
        $data['disp_happy_school_plus'] = isset($data['disp_happy_school_plus']) ? $data['disp_happy_school_plus'] : 0;
        $data['push_calendar'] = isset($data['push_calendar']) ? $data['push_calendar'] : 0;

        $user = $this->getParent();

        $data['user_id'] = $user->id;

        $setting = $this->userSetting->getDataByUserId($data['user_id']);
        if (!$setting) {
            $setting = $this->userSetting;
        }

        $setting->fill($data)->save();

        Log::info('[SchoolController.success] End...');
        return view('front.setting.success');
    }

    private function getParent()
    {
        Log::info('[SchoolController.getParent] Start...');
        return Auth::guard(self::GUARD)->user();
    }
}
