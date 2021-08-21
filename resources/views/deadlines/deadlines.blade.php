@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.breadcrumbs', [
            'pages' => [
                'Dashboard' => route('dashboard'),
                'Deadlines' => route('deadlines.deadlines'),
            ]
        ])@endcomponent

        <div class="row mt-5">
            <div class="col-lg-6">
                <h2>Deadlines</h2>
            </div>
            <div class="col-lg-6">
                <div class="deadline-sorting">
                    <form method="GET">
                        @csrf
                        <input type="hidden" name="page" value="{{ request('page') }}">

                        <div class="row">
                            <div class="col-md-6 col-lg-5">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="sort">Sorting</label>
                                    </div>
                                    <select class="custom-select"
                                            id="sort"
                                            name="sort">
                                        <option selected {{ request('sort') == null ? 'selected' : '' }}>Choose...
                                        </option>
                                        <option value="teacher" {{ request('sort') === "teacher" ? 'selected' : '' }}>
                                            Teacher
                                        </option>
                                        <option value="module" {{ request('sort') === "module" ? 'selected' : '' }}>
                                            Module
                                        </option>
                                        <option value="deadline" {{ request('sort') === "deadline" ? 'selected' : '' }}>
                                            Deadline
                                        </option>
                                        <option value="category" {{ request('sort') === "category" ? 'selected' : '' }}>
                                            Category
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-5">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <label class="input-group-text" for="direction">Direction</label>
                                    </div>
                                    <select class="custom-select"
                                            id="direction"
                                            name="direction">
                                        <option value="asc" {{ request('direction') === "asc" ? 'selected' : '' }}>
                                            Ascending
                                        </option>
                                        <option value="desc" {{ request('direction') === "desc" ? 'selected' : '' }}>
                                            Descending
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2">
                                @component('components.button', [
                                    'classes' => 'btn btn-secondary w-100',
                                    'type' => 'submit'
                                ])
                                    @slot('title')
                                        Sort
                                    @endslot
                                @endcomponent
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Deadlines -->
        <div class="table-responsive mt-3">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category</th>
                    <th scope="col">Module</th>
                    <th scope="col">Teacher</th>
                    <th scope="col">Deadline</th>
                    <th scope="col">Tags</th>
                </tr>
                </thead>
                <tbody>
                @forelse($lectures as $lecture)
                    <tr>
                        <th scope="row">{{ $lecture->id }}</th>
                        <td>{{ ucfirst($lecture->module->test->test_type->name) }}</td>
                        <td>{{ $lecture->module->name }}</td>
                        <td>{{ $lecture->teacher->name }}</td>
                        <td>{{ $lecture->module->test->deadline_at->diffForHumans() }}</td>
                        <td>
                            <ul class="list-unstyled mb-0 mt-1"
                                id="tags"
                                style="min-width: 150px; max-width: 300px;">
                                @foreach($lecture->module->tags as $tag)
                                    <li class="d-inline-block">
                                            <span class="bage badge-secondary px-2 rounded">
                                                {{$tag->name}}
                                            </span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">
                            <span>There are currently no tests with a deadline.</span>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $lectures->appends(request()->except('page'))->links() }}
    </div>
@endsection
