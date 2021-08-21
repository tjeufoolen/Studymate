@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.breadcrumbs', [
            'pages' => [
                'Dashboard' => route('dashboard'),
                'Modules' => route('modules.index'),
                'Edit' => route('modules.edit', $module)
            ]
        ])@endcomponent

        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <h2 class="py-3 text-center">Edit module</h2>
                <form action="{{route('modules.update', $module)}}" method="POST">
                    @method('PATCH')
                    @csrf

                    @component('components.form.text', [
                        'attributes' => ['required'],
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
                        'attributes' => ['required'],
                        'value' => $module->credits
                    ])
                        @slot('name')
                            credits
                        @endslot
                        @slot('title')
                            Credits
                        @endslot
                    @endcomponent

                    @component('components.form.select', [
                        'attributes' => ['required'],
                        'items' => $terms,
                        'selected' => $module->term->id
                    ])
                        @slot('name')
                            term
                        @endslot
                        @slot('title')
                            Module Term
                        @endslot
                    @endcomponent

                    @component('components.form.select', [
                        'attributes' => ['required'],
                        'items' => $testTypes,
                        'selected' => $module->test->test_type_id
                    ])
                        @slot('name')
                            test_type
                        @endslot
                        @slot('title')
                            Test Type
                        @endslot
                    @endcomponent

                    @component('components.form.select', [
                        'attributes' => ['required'],
                        'items' => $teachers,
                        'selected' => $module->coordinator->id
                    ])
                        @slot('name')
                            coordinator
                        @endslot
                        @slot('title')
                            Module Coordinator
                        @endslot
                    @endcomponent

                    @component('components.form.selectmultiple', [
                        'attributes' => ['required'],
                        'items' => $teachers,
                        'selected' => $module->lectures->pluck('teacher_id')->toArray()
                    ])
                        @slot('name')
                            teachers
                        @endslot
                        @slot('title')
                            Teachers
                        @endslot
                    @endcomponent

                    @component('components.form.selectmultiple', [
                        'attributes' => ['required'],
                        'items' => $tags,
                        'selected' => $module->tags->pluck('id')->toArray()
                    ])
                        @slot('name')
                            tags
                        @endslot
                        @slot('title')
                            Module Tags
                        @endslot
                    @endcomponent

                    <div class="my-3 text-center">
                        @component('components.button', [
                            'type' => 'submit',
                            'classes' => 'btn btn-primary'
                        ])
                            @slot('title')
                                Save changes
                            @endslot
                        @endcomponent
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
