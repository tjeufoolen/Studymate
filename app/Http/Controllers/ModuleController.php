<?php

namespace App\Http\Controllers;

use App\Lecture;
use App\Module;
use App\Student;
use App\Tag;
use App\Teacher;
use App\Term;
use App\Test;
use App\TestType;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class ModuleController extends Controller
{
    public function __construct()
    {
        $actions = ['index', 'show', 'create', 'edit', 'store', 'update', 'destroy'];
        foreach ($actions as $action) {
            $this->middleware('can:module_' . $action)->only($action);
        }

        $this->middleware('can:module_enrollStudents')->only(['enrollIndex', 'enroll', 'disenroll']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $modules = Module::paginate(10);
        return view('modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $testTypes = TestType::all()->unique();
        $teachers = Teacher::orderBy('lastname')->get()->unique();
        $terms = Term::orderBy('semester')->orderBy('quarter')->get()->unique();
        $tags = Tag::orderBy('id')->get()->unique();

        return view('modules.create',
            ['testTypes' => $testTypes, 'teachers' => $teachers, 'terms' => $terms, 'tags' => $tags]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        $request = $this->validateModule($request);

        $module = Module::create([
            'name' => $request["name"],
            'credits' => $request["credits"],
            'coordinator_id' => $request["coordinator"],
            'term_id' => $request["term"]
        ]);

        Test::create(['test_type_id' => $request["test_type"], 'module_id' => $module->id]);

        foreach ($request["tags"] as $tag) {
            $module->tags()->save(Tag::find($tag));
        }

        foreach ($request["teachers"] as $teacher) {
            Lecture::create(['teacher_id' => $teacher, 'module_id' => $module["id"]]);
        }

        return redirect(route('modules.index'));
    }

    private function validateModule(Request $request)
    {
        return $request->validate([
            'name' => 'required|max:100|unique:modules,name',
            'credits' => 'required|integer|min:0|max:10',
            'term' => 'required|integer',
            'test_type' => 'required',
            'coordinator' => 'required',
            'teachers' => 'required',
            'tags' => 'required'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Factory|View
     */
    public function show(Module $module)
    {
        $testTypes = TestType::all()->unique();
        $teachers = Teacher::orderBy('lastname')->get()->unique();
        $terms = Term::orderBy('semester')->orderBy('quarter')->get()->unique();
        $tags = Tag::orderBy('id')->get()->unique();
        $lectures = $module->lectures;

        return view('modules.show', [
            'module' => $module,
            'testTypes' => $testTypes,
            'teachers' => $teachers,
            'terms' => $terms,
            'tags' => $tags,
            'lectures' => $lectures
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Module $module
     * @return Factory|View
     */
    public function edit(Module $module)
    {
        $testTypes = TestType::all()->unique();
        $teachers = Teacher::orderBy('lastname')->get()->unique();
        $terms = Term::orderBy('semester')->orderBy('quarter')->get()->unique();
        $tags = Tag::orderBy('id')->get()->unique();

        return view('modules.edit', [
            'module' => $module,
            'testTypes' => $testTypes,
            'teachers' => $teachers,
            'terms' => $terms,
            'tags' => $tags
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Module $module
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, Module $module)
    {
        $request = $this->validateUpdateModule($request, $module->id);

        $module->test->update(['test_type_id' => $request["test_type"]]);
        $module->update([
            'name' => $request["name"],
            'credits' => $request["credits"],
            'coordinator_id' => $request["coordinator"],
            'term_id' => $request["term"]
        ]);

        $module->tags()->detach();
        foreach ($request["tags"] as $tag) {
            $module->tags()->attach(Tag::find($tag));
        }

        $currentTeachers = [];
        foreach ($module->lectures as $lecture) {
            array_push($currentTeachers, $lecture->teacher->id);
        }

        foreach ($request["teachers"] as $teacher) {
            if (!in_array($teacher, $currentTeachers)) {
                Lecture::firstOrCreate(['teacher_id' => $teacher, 'module_id' => $module["id"]]);
            } else {
                unset($currentTeachers[array_search($teacher, $currentTeachers)]);
            }
        }
        foreach ($currentTeachers as $teacher) {
            Lecture::where('teacher_id', '=', $teacher)
                ->where('module_id', '=', $module->id)
                ->delete();
        }

        return redirect(route('modules.index'));
    }

    private function validateUpdateModule(Request $request, $currentId)
    {
        return $request->validate([
            'name' => 'required|max:100|unique:modules,name,' . $currentId,
            'credits' => 'required|integer|min:0|max:10',
            'term' => 'required|integer',
            'test_type' => 'required',
            'coordinator' => 'required',
            'teachers' => 'required',
            'tags' => 'required'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        Module::destroy($id);
        return redirect(route('modules.index'));
    }

    public function enrollIndex(Module $module)
    {
        $students = Student::whereNotIn('id', $module->students()->pluck('id')->toArray())->paginate(10);
        return view('modules.enrollIndex', ['module' => $module, 'students' => $students]);
    }

    public function enroll(Student $student, Lecture $lecture)
    {
        $lecture->students()->attach($student);
        return back();
    }

    public function disenroll(Student $student, Lecture $lecture)
    {
        $lecture->students()->detach($student);
        return back();
    }
}
