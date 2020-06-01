<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Department\CreateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentSettingController extends Controller
{
    private $department;
    private $schoolId;

    public function __construct(Department $department)
    {
        $this->department = $department;
        $this->middleware(function ($request, $next) {
            $this->schoolId = hsp_school()->id;

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.department.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $department = new Department();
        $department->prepare();

        return view('admin.department.create', ['department' => $department]);
    }

    /**
     * Confirm stage before save.
     */
    public function confirm(CreateDepartmentRequest $request, Department $department = null)
    {
        if (is_null($department)) {
            $department = new Department();
        }

        $department->confirm();

        return view('admin.department.confirm', [
            'department' => $department,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateDepartmentRequest $request)
    {
        if ($request->filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.department_setting.create')->withInput();
        }

        $department = new Department();
        $department->createFromRequest($request, $this->schoolId);
        // session()->flash('action', 'created');
        return redirect()->route('admin.department_setting.list-department');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department_setting)
    {
        info(self::class.'::edit:start');

        $department_setting->prepareForEdit();

        return view('admin.department.edit', ['department' => $department_setting]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Department $department_setting)
    {
        if ($request->filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.department_setting.edit', $department_setting)->withInput();
        }

        info(self::class.'::update:start');
        $department = $department_setting;

        if ($request->filled('reject_x')) {
            // if user want to edit, redirect back to create page
            info(self::class.'::update:redirect');

            return redirect()->route('admin.department_setting.edit', $department)->withInput();
        }

        $department->updateFromRequest($request);
        session()->flash('action', 'updated');

        info(self::class.'::update:end');

        return redirect()->route('admin.department_setting.list-department');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function showList()
    {
        $department = Department::where('school_id', auth()->user()->school_id)->with(['managers'])->get();

        return view('admin.department.list', ['departments' => $department]);
    }
}
