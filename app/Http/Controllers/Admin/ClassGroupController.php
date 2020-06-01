<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClassGroup\CreateClassGroupRequest;
use App\Http\Requests\ClassGroup\MassDeleteClassGroupRequest;
use App\Http\Requests\ClassGroup\UpdateClassGroupRequest;
use App\Models\ClassGroup;
use App\Models\SchoolClass;
use Exception;
use Illuminate\Support\Facades\DB;

class ClassGroupController extends Controller
{
    private $classGroup;

    public function __construct(ClassGroup $classGroup)
    {
        $this->classGroup = $classGroup;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $classGroups = ClassGroup::where('school_id', auth()->user()->school_id)->with(['classes'])->get();

        return view('admin.classGroup.index', [
            'classGroups' => $classGroups,
            'classes' => SchoolClass::where('school_id', auth()->user()->school_id)->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $classGroup = new ClassGroup();
        $classGroup->prepare();

        return view('admin.classGroup.create', [
            'classGroup' => $classGroup,
        ]);
    }

    /**
     * Confirm stage before save.
     */
    public function confirm(CreateClassGroupRequest $request, ClassGroup $classGroup = null)
    {
        if (is_null($classGroup)) {
            $classGroup = new ClassGroup();
        }

        $classGroup->confirm();

        return view('admin.classGroup.confirm', [
            'classGroup' => $classGroup,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateClassGroupRequest $request)
    {
       if($request-> filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.cgroup.create')->withInput();
        }

        $classGroup = new ClassGroup();
        $classGroup->school_id = auth()->user()->school_id;
        $classGroup->createFromRequest($request);

        session()->flash('message', __('cgroup.action.created'));

        return redirect()->route('admin.cgroup.index');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ClassGroup $classGroup)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassGroup $cgroup)
    {
        $cgroup->prepareForEdit();

        return view('admin.classGroup.edit', [
            'classGroup' => $cgroup,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateClassGroupRequest $request, ClassGroup $cgroup)
    {
       if($request-> filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.cgroup.edit', ['cgroup' => $cgroup])->withInput();
        }

        DB::beginTransaction();
        try {
            $cgroup->updateFromRequest($request);
            DB::commit();
            session()->flash('message', __('cgroup.action.updated'));

            return redirect()->route('admin.cgroup.index');
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassGroup $classGroup)
    {
        $classGroup->delete();

        session()->flash('message', __('cgroup.action.deleted'));

        return redirect()->route('cgroup.index');
    }

    public function deleteMulti(MassDeleteClassGroupRequest $request)
    {
        DB::beginTransaction();
        try {
            $ids = $request->class_group_ids;
            foreach ($ids as $id) {
                $classGroup = ClassGroup::query()->where('id', '=', $id)->first();
                if (null != $classGroup) {
                    $classGroup->delete();
                    session()->flash('message', __('cgroup.action.deleted'));
                }
            }
            $classGroups = ClassGroup::where('school_id', auth()->user()->school_id)->with(['classes'])->get();
            DB::commit();

            return view('admin.classGroup.index', [
                'classGroups' => $classGroups,
                'classes' => SchoolClass::where('school_id', auth()->user()->school_id)->get(),
            ]);
        } catch (\Exception $exception) {
            DB::rollBack();

            return view('admin.classGroup.index', [
                'classGroups' => $classGroups,
                'classes' => SchoolClass::where('school_id', auth()->user()->school_id)->get(),
            ]);
        }
    }
}
