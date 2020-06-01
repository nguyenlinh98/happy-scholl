<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Advertises;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdvertisesController extends Controller
{
    private $advertises;

    public function __construct(Advertises $advertises)
    {
        $this->advertises = $advertises;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $listAdvertises = $this->advertises->all();
        return view('admin.advertises.index',compact('listAdvertises'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.advertises.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        DB::beginTransaction();
        try {
            // insert data đến bảng user table
            $fileName = $request->file('filename')->getClientOriginalName();

            $request->file('filename')->storeAs('image-advertises',$fileName);

            $advertisesCreate = $this->advertises->create([
                'filename' => $fileName,
                'startdate' => $request->startdate,
                'enddate' => $request->enddate,
                'school_id' => 0
            ]);
            DB::commit();
            return redirect()->route('advertises.index');
        } catch (\Exception $exception) {
            DB::rollBack();
        }
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
    public function edit($id)
    {
        $advertise =$this->advertises->findorfail($id);
        return view('admin.advertises.edit',compact('advertise'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $fileName = $request->file('filename')->getClientOriginalName();

            $request->file('filename')->storeAs('image-advertises',$fileName);
            $advertiseUpdate = $this->advertises->find($id);
            $advertiseUpdate->filename = $fileName;
            $advertiseUpdate->startdate = $request->startdate;
            $advertiseUpdate->enddate = $request->enddate;

            $advertiseUpdate->save();
            DB::commit();
            return redirect()->route('advertises.index');
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
        foreach ($id as $k){
            $advertise =$this->advertises->findorfail($k);
            $advertise->delete();
        }
        session()->flash('message', __('advertises.action.destroyed'));
        return redirect()->route('advertises.index');
    }
}
