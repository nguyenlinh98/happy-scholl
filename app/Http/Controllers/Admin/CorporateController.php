<?php

namespace App\Http\Controllers\Admin;

use App\Models\Corporate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CorporateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $corporates = Corporate::all();

        return view('admin.corporate.index', ['corporates' => $corporates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $corporate = new Corporate();
        $corporate->prepare();

        return view('admin.corporate.form', ['corporate' => $corporate]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $corporate = new Corporate();
        $corporate->fill($request->all());
        $corporate->save();

        session()->flash('message', __('corporate.action.created'));

        return redirect(route('corporate.index'));
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Corporate $corporate)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Corporate $corporate)
    {
        $corporate->prepare();

        return view('admin.corporate.form', ['corporate' => $corporate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Corporate $corporate)
    {
        $corporate->fill($request->all());
        $corporate->save();

        session()->flash('message', __('corporate.action.updated'));

        return redirect(route('corporate.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Corporate $corporate)
    {
        $corporate->delete();
        session()->flash('message', __('corporate.action.deleted'));

        return redirect(route('corporate.index'));
    }
}
