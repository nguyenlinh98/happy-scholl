<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RequireFeedback\CreateRequireFeedbackRequest;
use App\Http\Requests\RequireFeedback\UpdateRequireFeedbackRequest;
use App\Models\RequireFeedback;
use App\Models\RequireFeedbackStatuses;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class RequireFeedbackController extends Controller
{
    private $requireFeedback;
    private $schoolId;

    public function __construct(RequireFeedback $requireFeedbacks)
    {
        $this->requireFeedback = $requireFeedbacks;
        $this->middleware(function ($request, $next) {
            $this->schoolId = \Auth::user()->school_id;
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
        $requireFeedbacks = RequireFeedback::where('school_id', $this->schoolId)
        ->where('status',RequireFeedback::STATUS_DISTRIBUTED)->get();

        return view('admin.require-feedback.index', ['requireFeedbacks' => $requireFeedbacks]);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $requireFeedbacks = RequireFeedback::where('school_id', $this->schoolId)
        ->where('status',RequireFeedback::STATUS_NOT_YET)->get();

        return view('admin.require-feedback.list', ['requireFeedbacks' => $requireFeedbacks]);
    }

    // public function search(RequireFeedback $requireFeedback, SchoolClass $class, Request $request){
    //     //dd( $requireFeedback);
    //     // $requireFeedback = $requireFeedback::where('feedback', $request->search);
    //     // if (isset($request->search)) {
    //     //     $requireFeedback = $requireFeedback::where('feedback', $request->search);
    //         // $requireFeedback = RequireFeedback::query()->withStudentStatusForClass($class)
    //         //     ->leftJoin('require_feedback_statuses', 'require_feedbacks.id','=', 'require_feedback_statuses.require_feedback_id' )
    //         //     ->where('require_feedback_statuses.feedback' , '=', (int) $request->search )
    //         //     ->where('require_feedbacks.id' , '=', $requireFeedback->id )
    //         //     ->first();
    //     // }

    //     $countStudent = RequireFeedbackStatuses::query()->where('require_feedback_id', $requireFeedback->id )->where('feedback', '!=', 0)->count();
    //     return view('admin.require-feedback.class', ['schoolClass' => $class, 'requireFeedback' => $requireFeedback, 'countStudent' => $countStudent]);
    // }

    public function class(RequireFeedback $requireFeedback, SchoolClass $class)
    {
        $countStudent = RequireFeedbackStatuses::where('require_feedback_id', $requireFeedback->id )->where('feedback', '!=', 0)->count();
        return view('admin.require-feedback.class', ['schoolClass' => $class, 'requireFeedback' => $requireFeedback, 'countStudent' => $countStudent]);
    }

    public function classes(RequireFeedback $requireFeedback)
    {
        $requireFeedback->loadMissing('receivers.receiver');
        $classes = $requireFeedback->receivers->pluck('receiver');

        return view('admin.require-feedback.classes', ['schoolClasses' => $classes, 'requireFeedback' => $requireFeedback]);
    }
    /**
     * Confirm form submit.
     */
    public function confirm(CreateRequireFeedbackRequest $request, RequireFeedback $requireFeedback = null)
    {
        info(self::class.'::confirm:start');

        if (is_null($requireFeedback)) {
            $requireFeedback = new RequireFeedback();
        }

        $requireFeedback->prepareToConfirm($request);

        info(self::class.'::confirm:end');

        return view('admin.require-feedback.confirm', ['requireFeedback' => $requireFeedback]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $requireFeedback = new RequireFeedback();
        $requireFeedback->prepare();

        return view('admin.require-feedback.create', ['requireFeedback' => $requireFeedback, 'title' => __('requireFeedback.index')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequireFeedbackRequest $request)
    {
        info(self::class.'::store:start');

        if ($request->filled('reject_x')) {
            // if user want to edit, redirect back to create page
            info(self::class.'::store:redirect');

            return redirect()->route('admin.require_feedback.create')->withInput();
        }

        $requireFeedback = new RequireFeedback();
        $requireFeedback->createFromRequest($request, $this->schoolId);

        session()->flash('action', 'created');
        info(self::class.'::store:end');

        return redirect()->route('admin.require_feedback.list');
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
        $requireFeedbacks = $this->requireFeedback->findorfail($id);

        return view('admin.require-feedback.show', ['requireFeedbacks' => $requireFeedbacks]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param mixed $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(RequireFeedback $requireFeedback)
    {
        info(self::class.'::edit:start');

        $requireFeedback->prepare();
        $requireFeedback->prepareClassDepartmentGroupRelationship('receivers', 'required_feedback_for_', 'receiver');

        info(self::class.'::edit:end');

        return view('admin.require-feedback.edit', ['requireFeedback' => $requireFeedback]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequireFeedbackRequest $request, RequireFeedback $requireFeedback)
    {
        info(self::class.'::update:start');

        if ($request->filled('reject_x')) {
            // if user want to edit, redirect back to create page
            info(self::class.'::update:redirect');

            return redirect()->route('admin.require_feedback.edit', $requireFeedback)->withInput();
        }

        $requireFeedback->updateFromRequest($request);
        session()->flash('action', 'updated');

        info(self::class.'::update:end');

        return redirect()->route('admin.require_feedback.index');
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
}
