<div class="{{ $classes ?? 'form-group' }} datetimepicker">
    <label for="{{ $name }}">{{ $title }}</label>
    <input
        type="datetime-local"
        class="form-control @error(strval($name)) is-invalid @enderror"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old(strval($name)) ?? \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}"
        @isset($attributes)
            @foreach($attributes as $attr)
                {{ $attr }}
            @endforeach
        @endisset
    >

    @error(strval($name))
        <div class="invalid-feedback">{{ $errors->first(strval($name)) }}</div>
    @enderror
</div>
