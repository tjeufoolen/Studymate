@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.breadcrumbs', [
            'pages' => [
                'Dashboard' => route('dashboard'),
                'Modules' => route('modules.index'),
                'Create' => route('modules.create')
            ]
        ])@endcomponent

        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <h2 class="py-3 text-center">Create module</h2>
                <form action="{{route('modules.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @component('components.form.text', [
                        'attributes' => ['required']
                    ])
                        @slot('name')
                            name
                        @endslot
                        @slot('title')
                            Name
                        @endslot
                    @endcomponent

                    @component('components.form.text', [
                        'attributes' => ['required']
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
                        'items' => $terms
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
                        'items' => $testTypes
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
                        'items' => $teachers
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
                        'items' => $teachers
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
                        'items' => $tags
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
