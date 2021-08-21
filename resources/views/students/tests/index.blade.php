@extends('layouts.app')

@section('content')
    <div class="container">
        @component('components.breadcrumbs', [
            'pages' => [
                'Dashboard' => route('dashboard'),
                'Modules' => route('modules.index')
            ]
        ])@endcomponent

        @forelse($student->lectures()->orderBy('graded_at')->orderBy('submitted_at')->get() as $lecture)
            <div class="dropdown">
                <button class="btn border rounded-0 btn-light dropdown-toggle w-100 text-left lecture-class-selector"
                        type="button" data-toggle="collapse" data-target="#lecture{{$lecture->id}}"
                        aria-expanded="false" aria-controls="collapseExample">
                    {{$lecture->module->name}}
                    @if($lecture->pivot->grade >= 5.5 )
                        <span class="badge badge-success">Passed</span>
                    @elseif(isset($lecture->pivot->grade) && $lecture->pivot->grade < 5.5)
                        <span class="badge badge-danger">Failed</span>
                    @elseif(isset($lecture->pivot->submitted_at))
                        <span class="badge badge-warning">Needs grading</span>
                    @endif
                </button>
            </div>

            <div class="collapse" id="lecture{{$lecture->id}}">
                <div class="row">
                    <div class="col-4 p-4">
                        <table>
                            <tr>
                                <th class="pr-3">Grade:</th>
                                <td>{{($lecture->pivot->grade != null) ? $lecture->pivot->grade : 'Not yet graded'}}</td>
                            </tr>
                            <tr>
                                <th class="pr-3">Submitted at:</th>
                                <td>{{($lecture->pivot->submitted_at != null) ? \Carbon\Carbon::parse($lecture->submitted_at)->diffForHumans() : 'Not yet submitted'}}</td>
                            </tr>
                            <tr>
                                <th class="pr-3">Category:</th>
                                <td>{{ ucfirst($lecture->module->test->test_type->name) }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-4 p-4">
                        @switch($lecture->module->test->test_type->name)
                            @case(\App\TestType::$ASSESSMENT)
                                @isset($lecture->pivot->file)
                                    <label for="download">Submitted file</label>
                                    <div class="input-group">
                                        <input id="download" class="form-control" type="text" value="{{$lecture->pivot->file}}" readonly>
                                        <a class="btn btn-light border" target="_blank"
                                           href="{{asset('storage/submissions/' . $lecture->id . '/' . $student->id . '/' . $lecture->pivot->file)}}"
                                           role="button">
                                            Download
                                        </a>
                                    </div>
                                @else
                                    <form action="{{ route('students.tests.update', ['student'=>$student, 'lecture'=>$lecture]) }}"
                                          method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="file" name="file">
                                            <label class="custom-file-label" for="file">Choose file</label>
                                        </div>

                                        <button type="submit" class="btn btn-primary float-right my-3">Submit</button>
                                    </form>
                                @endisset
                                @break
                            @case(\App\TestType::$EXAMINATION)
                                @if(!isset($lecture->pivot->submitted_at))
                                    <form action="{{ route('students.tests.update', ['student'=>$student, 'lecture'=>$lecture]) }}"
                                          method="POST">
                                        @csrf

                                        <button type="submit" class="btn btn-primary float-right my-3">Complete</button>
                                    </form>
                                @endif
                                @break
                        @endswitch
                    </div>

                    <div class="col-4 p-4">
                        @if(isset($lecture->pivot->submitted_at))
                            <form action="{{ route('students.tests.grade', ['student'=>$student, 'lecture'=>$lecture]) }}"
                                  method="POST">
                                @csrf

                                @component('components.form.text')
                                    @slot('name')
                                        grade
                                    @endslot
                                    @slot('title')
                                        Grade
                                    @endslot
                                @endcomponent
                                <button type="submit" class="btn btn-primary float-right">Grade</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

        @empty
            <p>There are no tests to display.</p>
        @endforelse

    </div>
@endsection
