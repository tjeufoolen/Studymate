@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.breadcrumbs', [
            'pages' => [
                'Dashboard' => route('dashboard'),
                'Teachers' => route('teachers.index'),
            ]
        ])@endcomponent

        <div class="d-flex justify-content-start align-items-center">
            <h2 class="py-3 text-left mr-auto p-2">Teachers</h2>
            @can('teacher_create')
                <a href="{{ route('teachers.create') }}">
                    <button dusk="create" class="btn btn-primary">Create Teacher</button>
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
                @forelse($teachers as $teacher)
                    <tr>
                        <th scope="row">{{$teacher->id}}</th>
                        <td>{{$teacher->firstname}}</td>
                        <td>{{$teacher->lastname}}</td>
                        <td>{{$teacher->email}}</td>
                        <td class="d-flex justify-content-end">
                            @can('teacher_edit')
                                <a href="{{ route('teachers.edit', $teacher) }}" dusk="edit">
                                    <button class="btn btn-primary ml-2">Edit</button>
                                </a>
                            @endcan

                            @can('teacher_destroy')
                                <form method="POST" action="{{ route('teachers.destroy', $teacher) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger ml-2" dusk="delete">Delete</button>
                                </form>
                            @endcan

                        </td>
                    </tr>
                @empty
                    <p>There are currently no teachers to display.</p>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex mt-2 justify-content-center justify-content-md-end">
            {{$teachers->links()}}
        </div>
    </div>
@endsection
