<?php

namespace App\Http\Controllers;

use App\Teacher;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function __construct()
    {
        $actions = ['index', 'show', 'create', 'edit', 'store', 'update', 'destroy'];
        foreach ($actions as $action) {
            $this->middleware('can:teacher_' . $action)->only($action);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return Factory|View
     */
    public function index()
    {
        $teachers = Teacher::paginate(10);
        return view('teachers.index', compact('teachers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        return view('teachers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        Teacher::create($this->validateTeacher($request));
        return redirect(route('teachers.index'));
    }

    private function validateTeacher(Request $request)
    {
        return $request->validate([
            'firstname' => 'required|max:100',
            'lastname' => 'required|max:100',
            'email' => 'required|email'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $teacher = Teacher::findOrFail($id);
        return response()->json($teacher);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Teacher $teacher
     * @return Factory|View
     */
    public function edit(Teacher $teacher)
    {
        return view('teachers.edit', ['teacher' => $teacher]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Teacher $teacher
     * @return RedirectResponse|Redirector
     */
    public function update(Request $request, Teacher $teacher)
    {
        $teacher->update($this->validateTeacher($request));
        return redirect(route('teachers.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse|Redirector
     */
    public function destroy($id)
    {
        Teacher::destroy($id);
        return redirect(route('teachers.index'));
    }
}
