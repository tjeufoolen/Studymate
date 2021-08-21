@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.breadcrumbs', [
            'pages' => [
                'Dashboard' => route('dashboard'),
                'Schedule modules' => route('deadlines.nodeadlines'),
            ]
        ])@endcomponent

        <h2 class="mt-5">Schedule modules</h2>

        <!-- Lectures -->
        <div class="table-responsive mt-3">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Category</th>
                    <th scope="col">Module</th>
                    <th scope="col">Tags</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($modules as $module)
                    <tr>
                        <th scope="row">{{ $module->id }}</th>
                        <td>{{ ucfirst($module->test->test_type->name) }}</td>
                        <td>{{ $module->name }}</td>
                        <td>
                            <ul class="list-unstyled mb-0 mt-1"
                                id="tags"
                                style="min-width: 150px; max-width: 300px;">
                                @foreach($module->tags as $tag)
                                    <li class="d-inline-block">
                                            <span class="bage badge-secondary px-2 rounded">
                                                {{$tag->name}}
                                            </span>
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <a dusk="schedule" href="{{ route('deadlines.create', $module->id) }}" class="btn btn-primary py-1">Schedule</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-3">
                            <span>There are currently no modules without a deadline.</span>
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

        {{ $modules->links() }}
    </div>
@endsection
