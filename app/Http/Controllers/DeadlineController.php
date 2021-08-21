<?php

namespace App\Http\Controllers;

use App\Lecture;
use App\Module;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeadlineController extends Controller
{
    public function __construct()
    {
        $actions = ['deadlines', 'nodeadlines', 'create', 'store'];
        foreach ($actions as $action) {
            $this->middleware('can:deadlines_' . $action)->only($action);
        }
    }

    public function deadlines(Request $request)
    {
        $lectures = $this->getLecturesWhereDeadline($request);
        return view('deadlines.deadlines', compact('lectures'));
    }

    private function getLecturesWhereDeadline(Request $request)
    {
        $lectures = Lecture::has('module.test')
            ->select('lectures.*')
            ->leftJoin('modules', 'modules.id', '=', 'lectures.module_id')
            ->leftJoin('tests', 'tests.module_id', '=', 'modules.id')
            ->whereNotNull('tests.deadline_at')
            ->where('tests.deadline_at', '>', Carbon::now());

        if ($request['sort'] != null) {
            $lectures = $this->sortLectures($lectures, strtolower($request['sort']), strtolower($request['direction']));
        }

        $lectures = $lectures->paginate(10);

        return $lectures;
    }

    public function sortLectures($lectures, $sortMethod, $sortDirection)
    {
        $sortDirection = ($sortDirection == "asc" || $sortDirection == "desc") ? $sortDirection : "asc";

        switch ($sortMethod) {
            case "teacher":
                $lectures->leftJoin('teachers', 'teachers.id', '=', 'lectures.teacher_id')
                    ->orderBy('teachers.firstname', $sortDirection)
                    ->orderBy('teachers.lastname', $sortDirection);
                break;
            case "module":
                $lectures = $lectures->orderBy('modules.name', $sortDirection);
                break;
            case "deadline":
                $lectures = $lectures->orderBy('tests.deadline_at', $sortDirection);
                break;
            case "category":
                $lectures = $lectures->leftJoin('test_types', 'test_types.id', '=', 'tests.test_type_id')
                    ->orderBy('test_types.name', $sortDirection);
                break;
        }

        return $lectures;
    }

    public function nodeadlines(Request $request)
    {
        $modules = Module::select('modules.*')
            ->leftJoin('tests', 'tests.module_id', '=', 'modules.id')
            ->whereNull('tests.deadline_at')
            ->paginate(10);

        return view('deadlines.nodeadlines', compact('modules'));
    }

    public function create(Module $module)
    {
        return view('deadlines.create', compact('module'));
    }

    public function store(Request $request, Module $module)
    {
        $request->validate([
            'datetime' => 'required|date|after:today',
        ]);

        $module->test->deadline_at = Carbon::parse($request['datetime'])->timestamp;
        $module->test->save();

        return redirect(route('deadlines.nodeadlines'));
    }
}
