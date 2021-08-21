@extends('layouts.app')

@section('content')
    <div class="container text-center my-5">
        <h2>Welcome back, Deadline Manager!</h2>
        <span>Watch all deadlines or schedule one yourself using the links below.</span>

        <div class="row justify-content-around my-5 mx-2">
            @can('deadlines_deadlines')
                <div class="col-md-6 my-1">
                    <a href="{{ route('deadlines.deadlines') }}"
                       class="text-white font-weight-bold py-5 bg-primary rounded d-block">
                        Deadlines
                    </a>
                </div>
            @endcan
            @can('deadlines_nodeadlines')
                <div class="col-md-6 my-1">
                    <a href="{{ route('deadlines.nodeadlines') }}"
                       class="text-white font-weight-bold py-5 bg-primary rounded d-block">
                        Schedule modules
                    </a>
                </div>
            @endcan
        </div>
    </div>
@endsection
