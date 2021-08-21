<?php

namespace App\Http\Controllers;

use App\Student;
use App\Term;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function __construct()
    {
        $actions = ['index', 'create', 'edit', 'store', 'update', 'destroy'];
        foreach ($actions as $action) {
            $this->middleware('can:student_' . $action)->only($action);
        }
    }

    public function index()
    {
        $students = Student::paginate(10);
        return view('students.index', compact('students'));
    }

    public function show(Request $request, Student $student)
    {
        $semester = intval($request['semester']);
        $quarter = intval($request['quarter']);
        $module = intval($request['module']);

        # Validate input and update if necessary
        // Check if semester exists
        $semesterExists = (Term::firstWhere('semester', $semester) != null) ? true : false;
        if (!$semesterExists) {
            $semester = Term::orderBy('semester')->first()->semester;
        }

        // Check if quarter exists within semester
        $semesterExists = (Term::firstWhere(['semester' => $semester, 'quarter' => $quarter]) != null) ? true : false;
        if (!$semesterExists) {
            $quarter = Term::where('semester', $semester)->orderBy('semester')->orderBy('quarter')->first()->quarter;
        }

        // Set term
        $term = Term::firstWhere(['semester' => $semester, 'quarter' => $quarter]);

        // Get module if it exists within semester and quarter
        $module = $student->modules()->firstWhere(['term_id' => $term->id, 'id' => $module]);
        if (!isset($module)) {
            $module = $student->modules()->where('term_id', $term->id)->orderBy('name')->first();
        }

        // Check if user is in lecture;
        $lecture = (isset($module)) ? $student->lectures()->firstWhere('module_id', $module->id) : null;

        # Get all possible select options
        $semesters = Term::query()->distinct()->pluck('semester');
        $quarters = Term::query()->where('semester', $semester)->distinct()->pluck('quarter');
        $modules = $student->modules()->where('term_id', $term->id)->get();
        $completedModules = $student->completedModules()->where('term_id', $term->id)->get();

        return view('students.show',
            compact(
                'student',
                'semester',
                'quarter',
                'module',
                'lecture',
                'semesters',
                'quarters',
                'modules',
                'completedModules'
            )
        );
    }

    public function create()
    {
        return view('students.create');
    }

    public function edit(Student $student)
    {
        return view('students.edit', ['student' => $student]);
    }

    public function store(Request $request)
    {
        Student::create($this->validateStudent($request));
        return redirect(route('students.index'));
    }

    private function validateStudent(Request $request)
    {
        return $request->validate([
            'firstname' => 'required|max:100',
            'lastname' => 'required|max:100',
            'email' => 'required|email'
        ]);
    }

    public function update(Request $request, Student $student)
    {
        $student->update($this->validateStudent($request));
        return redirect(route('students.index'));
    }

    public function destroy($id)
    {
        Student::destroy($id);
        return redirect(route('students.index'));
    }
}
