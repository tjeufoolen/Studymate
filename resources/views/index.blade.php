@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1>Welcome!</h1>
            <p>Please specify your student number to check out your educational progress.</p>

            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <form method="GET">
                        <div class="input-group mb-3">
                            <input type="text"
                                   class="form-control @error('student_number') is-invalid @enderror"
                                   placeholder="123456"
                                   aria-label="student_number"
                                   aria-describedby="button-addon2"
                                   name="student_number"
                                   value="{{ old('student_number') }}">

                            <div class="input-group-append">
                                <button
                                    class="btn btn-outline-secondary @error('student_number') btn-danger text-white border-danger @enderror"
                                    type="submit"
                                    id="button-addon2">
                                    Zoeken
                                </button>
                            </div>
                        </div>

                        @error('student_number')
                        <div class="invalid-feedback">{{ $errors->first('student_number') }}</div>
                        @enderror
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
