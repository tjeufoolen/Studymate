@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.breadcrumbs', [
            'pages' => [
                'Dashboard' => route('dashboard'),
                'Schedule modules' => route('deadlines.nodeadlines'),
                $module->name => route('deadlines.create', $module->id),
            ]
        ])@endcomponent

        <div class="row justify-content-center my-5">
            <div class="col-12 col-lg-8">
                <h2 class="text-center">{{ $module->name }}</h2>

                <div class="mt-5">
                    <form action="{{ route('deadlines.store', $module->id) }}" method="POST">
                        @csrf

                        @component('components.form.datetimePicker', [
                            'attributes' => ['required'],
                        ])
                            @slot('name')
                                datetime
                            @endslot
                            @slot('title')
                                Deadline | Time of examination
                            @endslot
                        @endcomponent

                        <div class="row justify-content-end">
                            <div class="col-lg-3 text-right">
                                @component('components.button', [
                                    'classes' => 'btn btn-primary w-100',
                                    'type' => 'submit'
                                ])
                                    @slot('title')
                                        Schedule
                                    @endslot
                                @endcomponent
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection