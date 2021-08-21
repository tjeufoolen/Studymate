@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <h2>Welcome back, Administrator!</h2>
        <span>Choose a category below to start managing.</span>

        <div class="row justify-content-around my-5 mx-2">
            @can('student_index')
                <div class="col-md-4 my-1">
                    <a href="{{ route('students.index') }}"
                       class="text-white font-weight-bold py-5 bg-primary rounded d-block">
                        Students
                    </a>
                </div>
            @endcan
            @can('teacher_index')
                <div class="col-md-4 my-1">
                    <a href="{{ route('teachers.index') }}"
                       class="text-white font-weight-bold py-5 bg-primary rounded d-block">
                        Teachers
                    </a>
                </div>
            @endcan
            @can('module_index')
                <div class="col-md-4 my-1">
                    <a href="{{ route('modules.index') }}"
                       class="text-white font-weight-bold py-5 bg-primary rounded d-block">
                        Modules
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection
