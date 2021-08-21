@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Student information -->
        <div class="row mb-2">
            <!-- Personal information -->
            <div class="col-lg-5 border rounded py-3 px-4 text-center text-md-left m-2 m-md-0">
                <div class="row align-items-center h-100">
                    <div class="col-12">
                        <h2>{{ $student->name }}</h2>

                        <div class="py-2">
                            <span class="font-weight-bold d-block">Student number</span>
                            <span class="d-block">{{ $student->id }}</span>
                        </div>

                        <div class="py-2">
                            <span class="font-weight-bold d-block">E-mail</span>
                            <span class="d-block">{{ $student->email }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Global study progress -->
            <div class="col-lg-5 border rounded py-3 px-4 text-center text-md-left mx-2 mb-2 m-md-0">
                <span class="h3">Global study progress</span>

                <div class="row align-items-center">
                    <div class="col-md-4 p-3">
                        <canvas id="studyProgressChart"
                                width="400"
                                height="400"
                                style="max-width: 300px; margin: 0 auto"
                                data-credits="{{ $student->credits }}"
                                data-available-credits="{{ $student->availableCredits }}">
                        </canvas>
                    </div>
                    <div class="col-md-8">
                        <div class="py-2">
                            <span class="font-weight-bold d-block">Total achieved credits</span>
                            <span class="d-block">{{ $student->credits }}</span>
                        </div>
                        <div class="py-2">
                            <span class="font-weight-bold d-block">Total available credits</span>
                            <span class="d-block">{{ $student->availableCredits }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 border rounded py-3 px-4 text-center mx-2 mb-2 m-md-0">
                <div class="row align-items-center h-100">
                    <div class="col-12">
                        <span class="font-weight-bold d-block mb-2">Share this page</span>
                        <a href="{{ route('qrcode', $student->id) }}" class="btn btn-secondary w-100" role="button">Generate
                            QR-Code</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Module searcher -->
        <form method="GET" class="px-2 p-md-0">
            <div class="row bg-secondary text-white pt-2 pb-3 rounded align-items-end">
                <div class="col-md-3 mt-2 mt-md-0">
                    <div class="form-group mb-0">
                        <label for="semester">Semester</label>
                        <select
                            class="form-control"
                            id="semester"
                            name="semester"
                            onchange="this.form.submit()"
                        >
                            @foreach ($semesters as $item)
                                <option
                                    @if ($semester != null) {{ ($item == $semester) ? 'selected' : '' }} @endif
                                    value="{{ $item }}"
                                >
                                    Semester {{ $item }}
                                </option>
                            @endforeach
                        </select>

                        @error('semester')
                        <div class="invalid-feedback">{{ $errors->first('semester') }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-3 mt-2 mt-md-0">
                    <div class="form-group mb-0">
                        <label for="quarter">Quarter</label>
                        <select
                            class="form-control"
                            id="quarter"
                            name="quarter"
                            onchange="this.form.submit()"
                            @if(sizeof($quarters) == 0) disabled @endif
                        >
                            @foreach ($quarters as $item)
                                <option
                                    @if ($quarter != null) {{ ($item == $quarter) ? 'selected' : '' }} @endif
                                    value="{{ $item }}"
                                >
                                    Quarter {{ $item }}
                                </option>
                            @endforeach
                        </select>

                        @error('quarter')
                        <div class="invalid-feedback">{{ $errors->first('quarter') }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-4 mt-2 mt-md-0">
                    <div class="form-group mb-0">
                        <label for="module">Module</label>

                        <select
                            class="form-control"
                            id="module"
                            name="module"
                            onchange="this.form.submit()"
                            @if(!isset($modules) || sizeof($modules) == 0) disabled @endif
                        >
                            @if ($modules != null)
                                @foreach ($modules as $item)
                                    <option
                                        @if ($module != null) {{ ($item->id == $module->id) ? 'selected' : '' }} @endif
                                        value="{{ $item->id }}"
                                    >
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            @endif
                        </select>

                        @error('module')
                        <div class="invalid-feedback">{{ $errors->first('module') }}</div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-2 mt-4 mt-md-0">
                    @component('components.button', [
                        'title' => 'submit',
                        'classes' => 'btn btn-primary w-100'
                    ])
                        @slot('title')
                            Bekijken
                        @endslot
                    @endcomponent
                </div>
            </div>
        </form>

        <!-- Quarter info -->
        @if ($quarter != null )
            <div class="quarter-info p-4 my-1 border rounded">
                <div class="row align-items-center">
                    <div class="col-lg-4">
                        <h2>Quarter {{ $quarter }}</h2>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-6">
                                <span class="d-block">Total credits achieved</span>
                            </div>
                            <div class="col-6 text-right">
                                <span>{{ $completedModules->sum('credits') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="row">
                            <div class="col-6">
                                <span class="d-block">Total credits available</span>
                            </div>
                            <div class="col-6 text-right">
                                <span>{{ $modules->sum('credits') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    <!-- Module info -->
        @if (!empty($module) && !empty($lecture))
            <div class="module-info border rounded p-4 mt-1 mb-5">
                <div class="row align-items-end">
                    <div class="col-lg-4">
                        <h2>{{ $module->name }}</h2>

                        <div class="pt-2">
                            <span class="font-weight-bold d-block">Credits</span>
                            <div class="row">
                                <div class="col-6">
                                    <span
                                        class="d-block">Total {{ ($lecture->grade >= 5.5) ? 'achieved' : 'available' }}</span>
                                </div>
                                <div class="col-6 text-right">
                                    <span>{{ $module->credits }}</span>
                                </div>
                            </div>
                        </div>

                        @isset($lecture->graded_at)
                            <div class="pt-2">
                                <span class="font-weight-bold d-block">Results</span>
                                <div class="row">
                                    <div class="col-6"><span>Grade</span></div>
                                    <div class="col-6 text-right"><span>{{ $lecture->grade }}</span></div>
                                </div>

                                @isset($lecture->submitted_at)
                                    <div class="row">
                                        <div class="col-6"><span>Submitted on</span></div>
                                        <div class="col-6 text-right">
                                            <span>{{ $lecture->submitted_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @endisset
                            </div>
                        @endisset
                    </div>

                    <div class="col-lg-4">
                        <div class="pt-2">
                            <span class="font-weight-bold d-block">Coordinator</span>
                            <span class="d-block">{{ $module->coordinator->name }}</span>
                        </div>
                        <div class="pt-2">
                            <span class="font-weight-bold d-block">Teacher</span>
                            <span class="d-block">{{ $lecture->teacher->name }}</span>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="pt-2">
                            <span class="font-weight-bold d-block">Test category</span>
                            <span class="d-block">{{ ucfirst($module->test->test_type->name) }}</span>
                        </div>
                        <div class="pt-2">
                            <span class="font-weight-bold d-block">Tags</span>
                            <div class="tags">
                                <ul class="list-unstyled mb-0 mt-1" name="tags" id="tags">
                                    @foreach($module->tags as $tag)
                                        <li class="d-inline-block"><span
                                                class="bage badge-secondary px-2 py-1 rounded">{{$tag->name}}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"
            integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI="
            crossorigin="anonymous"></script>
    <script src="{{ asset('js/studyProgressChart.js') }}"></script>
@endsection
