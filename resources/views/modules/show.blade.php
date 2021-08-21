@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.breadcrumbs', [
            'pages' => [
                'Dashboard' => route('dashboard'),
                'Modules' => route('modules.index'),
                $module->name => route('modules.show', $module)
            ]
        ])@endcomponent

        <div class="row justify-content-center">
            <div class="col-12 col-lg-4">
                <h2 class="py-3 text-center">{{$module->name}}</h2>
                <form action="{{route('modules.store')}}" method="POST">
                    @csrf

                    @component('components.form.text', [
                        'attributes' => ['required', 'readonly'],
                        'value' => $module->name
                    ])
                        @slot('name')
                            name
                        @endslot
                        @slot('title')
                            Name
                        @endslot
                    @endcomponent

                    @component('components.form.text', [
                        'attributes' => ['required', 'readonly'],
                        'value' => $module->credits
                    ])
                        @slot('name')
                            credits
                        @endslot
                        @slot('title')
                            Credits
                        @endslot
                    @endcomponent

                    @component('components.form.text', [
                        'attributes' => ['required', 'readonly'],
                        'value' => $module->term->name
                    ])
                        @slot('name')
                            term
                        @endslot
                        @slot('title')
                            Module Term
                        @endslot
                    @endcomponent

                    @component('components.form.text', [
                        'attributes' => ['required', 'readonly'],
                        'value' => $module->test->test_type->name
                    ])
                        @slot('name')
                            test_type
                        @endslot
                        @slot('title')
                            Test Type
                        @endslot
                    @endcomponent

                    @isset($module->test->deadline)
                        @component('components.form.datetimePicker', [
                            'attributes' => ['required', 'readonly'],
                            'value' => $module->test->deadline
                        ])
                            @slot('name')
                                datetime
                            @endslot
                            @slot('title')
                                Deadline | Time of examination
                            @endslot
                        @endcomponent
                    @endisset

                    @component('components.form.text', [
                        'attributes' => ['required', 'readonly'],
                        'value' => $module->coordinator->name
                    ])
                        @slot('name')
                            coordinator
                        @endslot
                        @slot('title')
                            Module Coordinator
                        @endslot
                    @endcomponent

                    <div class="form-group">
                        <label for="teachers">Teachers</label>
                        <ul name="teachers" id="teachers">
                            @foreach($module->lectures as $lecture)
                                <li>{{$lecture->teacher->name}}</li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="form-group">
                        <label for="tags">Module Tags</label>
                        <ul class="list-unstyled m-0" name="tags" id="tags">
                            @foreach($module->tags as $tag)
                                <li class="d-inline-block my-1"><span
                                        class="bage badge-secondary px-2 py-1 rounded">{{$tag->name}}</span></li>
                            @endforeach
                        </ul>
                    </div>
                </form>
            </div>
            <div class="col-12 col-lg-8">

                @forelse($lectures as $lecture)
                    <h5>Class: {{$lecture->id}} - {{$lecture->teacher->name}}</h5>
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th class="w-25">#</th>
                            <th class="w-50">Name</th>
                            <th class="w-50">Completed at</th>
                            <th class="w-50">Grade</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lecture->students as $student)
                            <tr>
                                <th scope="row">{{$student->id}}</th>
                                <td>{{$student->name}}</td>
                                <td>{{$student->pivot->submitted_at}}</td>
                                <td>{{$student->pivot->grade}}</td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                @empty
                    <p>There are no lectures to display.</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection
