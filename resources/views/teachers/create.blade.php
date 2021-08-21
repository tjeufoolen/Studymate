@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.breadcrumbs', [
            'pages' => [
                'Dashboard' => route('dashboard'),
                'Teachers' => route('teachers.index'),
                'Create' => route('teachers.create'),
            ]
        ])@endcomponent

        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <h2 class="py-3 text-center">Create teachers</h2>
                <form action="{{route('teachers.store')}}" method="POST">
                    @csrf

                    @component('components.form.text', [
                        'attributes' => ['required']
                    ])
                        @slot('name')
                            firstname
                        @endslot
                        @slot('title')
                            Firstname
                        @endslot
                    @endcomponent

                    @component('components.form.text', [
                        'attributes' => ['required']
                    ])
                        @slot('name')
                            lastname
                        @endslot
                        @slot('title')
                            Lastname
                        @endslot
                    @endcomponent

                    @component('components.form.text', [
                        'attributes' => ['required']
                    ])
                        @slot('name')
                            email
                        @endslot
                        @slot('title')
                            E-Mail
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
