@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.breadcrumbs', [
            'pages' => [
                'Dashboard' => route('dashboard'),
                'Modules' => route('modules.index')
            ]
        ])@endcomponent

        <div class="d-flex justify-content-start align-items-center">
            <h2 class="py-3 text-left mr-auto p-2">Modules</h2>

            @can('module_create')
                <a href="{{ route('modules.create') }}" dusk="create">
                    <button class="btn btn-primary">Create Module</button>
                </a>
            @endcan

        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Term</th>
                <th>Credits</th>
                <th></th>
                </tr>
                </thead>
                <tbody>
                @forelse($modules as $module)
                    <tr>
                        <th scope="row">{{$module->id}}</th>
                        <td>{{$module->name}}</td>
                        <td>{{$module->term->name}}</td>
                        <td>{{$module->credits}}</td>
                        <td class="d-flex justify-content-end">
                            @can('module_show')
                                <a href="{{ route('modules.show', $module) }}">
                                    <button class="btn btn-primary ml-2">View</button>
                                </a>
                            @endcan

                            @can('module_edit')
                                <a href="{{ route('modules.edit', $module) }}" dusk="edit">
                                    <button class="btn btn-primary ml-2">Edit</button>
                                </a>
                            @endcan

                            @can('module_enrollStudents')
                                <a href="{{ route('enroll.index', $module) }}">
                                    <button class="btn btn-primary ml-2">Enroll Students</button>
                                </a>
                            @endcan

                            @can('module_destroy')
                                <form method="POST" action="{{ route('modules.destroy', $module) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger ml-2" dusk="delete">Delete</button>
                                </form>
                            @endcan()
                        </td>
                    </tr>
                @empty
                    <p>There are currently no modules to display.</p>
                @endforelse
                </tbody>
            </table>
            <div class="d-flex flex-row-reverse">
                {{$modules->links()}}
            </div>
        </div>
    </div>
@endsection
