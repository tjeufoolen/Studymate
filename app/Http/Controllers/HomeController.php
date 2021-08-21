<?php

namespace App\Http\Controllers;

use App\Student;
use Endroid\QrCode\QrCode;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (sizeof($request->all()) == 0) {
            return view('index');
        }

        $request->validate(['student_number' => 'required|string']);

        return redirect(route('students.show', $request->get('student_number')));
    }

    public function qrcode(Student $student)
    {
        $qrCode = new QrCode(route('students.show', $student->id));

        return response($qrCode->writeString(), 200)
            ->header('Content-Type', $qrCode->getContentType());
    }
}
