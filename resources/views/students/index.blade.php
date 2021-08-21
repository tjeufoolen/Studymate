@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.breadcrumbs', [
            'pages' => [
                'Dashboard' => route('dashboard'),
                'Students' => route('students.index')
            ]
        ])@endcomponent

        <div class="d-flex justify-content-start align-items-center">
            <h2 class="py-3 text-left mr-auto p-2">Students</h2>

            @can('student_create')
                <a href="{{ route('students.create') }}">
                    <button dusk="create" class="btn btn-primary">Create Student</button>
                </a>
            @endcan
        </div>

        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Firstname</th>
                    <th>Lastname</th>
                    <th>Email</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($students as $student)
                    <tr>
                        <th scope="row">{{$student->id}}</th>
                        <td>{{$student->firstname}}</td>
                        <td>{{$student->lastname}}</td>
                        <td>{{$student->email}}</td>
                        <td class="d-flex justify-content-end">
                            <a href="{{ route('students.show', $student) }}">
                                <button class="btn btn-primary ml-2">View</button>
                            </a>

                            @can('student_test_index')
                                <a href="{{ route('students.tests.index', $student) }}">
                                    <button class="btn btn-primary ml-2">Tests</button>
                                </a>
                            @endcan

                            @can('student_edit')
                                <a href="{{ route('students.edit', $student) }}" dusk="edit">
                                    <button class="btn btn-primary ml-2">Edit</button>
                                </a>
                            @endcan

                            @can('student_destroy')
                                <form method="POST" action="{{ route('students.destroy', $student) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger ml-2" dusk="delete">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <p>There are currently no students to display.</p>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex mt-2 justify-content-center justify-content-md-end">
            {{$students->links()}}
        </div>
    </div>
@endsection
