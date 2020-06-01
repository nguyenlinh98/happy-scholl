<?php

namespace App\Http\Controllers\Admin;

use App\Models\SchoolSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SchoolSettingController extends Controller
{
    protected $schoolSetting;

    public function __construct(SchoolSetting $schoolSetting)
    {
        $this->schoolSetting = $schoolSetting;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SchoolSetting $schoolSetting)
    {
        $schoolSetting = SchoolSetting::where('school_id', auth()->user()->school_id)->first();
        $params = hsp_getConfig('sidebar_menu.name');
        return view('admin.school-setting.index', ['schoolSetting' => $schoolSetting],['params' => $params]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(SchoolSetting $schoolSetting)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, SchoolSetting $schoolSetting)
    {
        DB::beginTransaction();
        try {
            $params = $schoolSetting->getTableColumns();
            $schoolSettingUpdate = $this->schoolSetting->find($id);
            foreach ($request->except('_token') as $key => $part) {
                if (in_array($key, $params)) {
                    if ($schoolSettingUpdate->$key == 1){
                        $schoolSettingUpdate->$key = 0;
                    } else{
                        $schoolSettingUpdate->$key = 1;
                    }
                }
            }
            $schoolSettingUpdate->save();
            DB::commit();
            return redirect()->route('admin.school_setting.index');
        } catch (\Exception $exception) {
            DB::rollBack();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
