@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.breadcrumbs', [
            'pages' => [
                'Dashboard' => route('dashboard'),
                'Modules' => route('modules.index'),
                'Enroll' => route('enroll.index', $module)
            ]
        ])@endcomponent

        <h2>{{$module->name}} | enroll students</h2>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
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
                                   <div class="btn-group">
                                       <a class="nav-link btn btn-secondary py-0 rounded" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                           enroll
                                       </a>
                                       <div class="dropdown-menu">
                                           <h5 class="dropdown-item-text">Enroll student in:</h5>
                                           <div class="dropdown-divider"></div>
                                           @foreach($module->lectures as $lecture )

                                               <form method="POST" action="{{ route('enroll.update', ['student'=>$student, 'lecture'=>$lecture]) }}">
                                                   @csrf
                                                   @method('PUT')
                                                   <button type="submit" class="dropdown-item">Class: {{$lecture->id}} - {{$lecture->teacher->name}}</button>
                                               </form>

                                           @endforeach
                                       </div>
                                   </div>
                                </td>
                            </tr>
                        @empty
                            <p>There are currently no students to display.</p>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex mt-2 justify-content-center">
                    {{$students->links()}}
                </div>

            </div>
            <div class="col-12 col-lg-4">

                @forelse($module->lectures as $lecture)
                    <div class="dropdown">
                        <button class="btn border rounded-0 btn-light dropdown-toggle w-100 text-left lecture-class-selector" type="button" data-toggle="collapse" data-target="#lecture{{$lecture->id}}" aria-expanded="false" aria-controls="collapseExample">
                            Class: {{$lecture->id}}  -  {{$lecture->teacher->name}}
                        </button>
                    </div>

                <div class="collapse" id="lecture{{$lecture->id}}">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th class="w-auto">#</th>
                            <th class="w-50">Name</th>
                            <th class="w-25"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lecture->students as $student)
                            <tr>
                                <th scope="row">{{$student->id}}</th>
                                <td>{{$student->name}}</td>

                                <td>
                                    <form method="POST" action="{{ route('disenroll.update', ['student'=>$student, 'lecture'=>$lecture]) }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="dropdown-item text-white bg-danger py-1 rounded">remove</button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                @empty
                    <p>There are no lectures to display.</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection
