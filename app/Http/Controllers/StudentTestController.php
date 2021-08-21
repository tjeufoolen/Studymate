<?php

namespace App\Http\Controllers;

use App\Lecture;
use App\Student;
use App\TestType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StudentTestController extends Controller
{
    public function __construct()
    {
        $actions = ['index', 'update'];
        foreach ($actions as $action) {
            $this->middleware('can:student_test_' . $action)->only($action);
        }
    }

    public function index(Student $student)
    {
        return view('students.tests.index', ['student' => $student]);
    }

    public function update(Request $request, Student $student, Lecture $lecture)
    {
        switch ($lecture->module->test->test_type->name) {
            case TestType::$ASSESSMENT:
                $request->validate([
                    'file' => 'required|mimes:zip'
                ]);

                $fileName = $this->storeFile($student->id, $lecture->id);
                $lecture->students()->updateExistingPivot($student->id,
                    ['file' => $fileName, 'submitted_at' => Carbon::now()]);
                break;
            case TestType::$EXAMINATION:
                $lecture->students()->updateExistingPivot($student->id, ['submitted_at' => Carbon::now()]);
                break;
        }

        return back();
    }

    private function storeFile($studentId, $lectureId)
    {
        $fileName = Carbon::now()->timestamp . '.' . request()->file->getClientOriginalExtension();
        $filePath = request()->file->storeAs(
            'public/submissions/' . $lectureId . '/' . $studentId, $fileName
        );

        return $fileName;
    }

    public function grade(Request $request, Student $student, Lecture $lecture)
    {
        $request->validate([
            'grade' => 'required|numeric|min:1|max:10'
        ]);

        $lecture->students()->updateExistingPivot($student->id,
            ['grade' => $request['grade'], 'graded_at' => Carbon::now()]);

        return back();
    }
}
