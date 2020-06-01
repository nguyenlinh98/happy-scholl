<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seminar\CreateSeminarRequest;
use App\Http\Requests\Seminar\UpdateSeminarRequest;
use App\Models\Seminar;
use Illuminate\Http\Request;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ('reservation' === $request->query('view', 'reservation')) {
            $seminars = Seminar::where('status', Seminar::STATUS_RESERVATION)->get();
        } elseif ('distribution' === $request->query('view')) {
            $seminars = Seminar::where('status', Seminar::STATUS_DISTRIBUTED)->get();
        } else {
            abort(404);
        }

        return view('admin.seminar.index', ['seminars' => $seminars]);
    }

    public function confirm(CreateSeminarRequest $request, Seminar $seminar = null)
    {
        if (is_null($seminar)) {
            $seminar = new Seminar();
        }
        $seminar->confirm($request);

        return view('admin.seminar.confirm', ['seminar' => $seminar]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $seminar = new Seminar();
        $seminar->prepare();

        return view('admin.seminar.create', ['seminar' => $seminar]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.seminar.create')->withInput();
        }

        $seminar = new Seminar();
        $seminar->createNew($request);

        session()->flash('action', 'created');

        return redirect()->route('admin.seminar.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Seminar $seminar)
    {
        $seminar->loadMissing(['students']);

        return view('admin.seminar.show', ['seminar' => $seminar]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Seminar $seminar)
    {
        $seminar->prepareForEdit();

        return view('admin.seminar.edit', ['seminar' => $seminar]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSeminarRequest $request, Seminar $seminar)
    {
        if ($request->filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.seminar.edit', $seminar)->withInput();
        }

        $seminar->updateFrom($request);

        session()->flash('action', 'updated');

        return redirect()->route('admin.seminar.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Seminar $seminar)
    {
        $seminar->delete();

        session()->flash('action', 'deleted');

        return redirect()->route('admin.seminar.index');
    }
}
