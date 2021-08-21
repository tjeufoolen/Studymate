<div class="{{ isset($classes) ? $classes : 'form-group' }}">
    <label for="{{ $name }}">{{ $title }}</label>
    <textarea
        class="form-control @error(strval($name))is-invalid @enderror"
        id="{{ $name }}"
        name="{{ $name }}"
        rows="{{ $rows ?? '' }}"
        cols="{{ $cols ?? ''}}"
        @isset($attributes)
            @foreach($attributes as $attr)
                {{ $attr }}
            @endforeach
        @endisset
    >{{ old(strval($name)) }}</textarea>

    @error(strval($name))
        <div class="invalid-feedback">{{ $errors->first(strval($name)) }}</div>
    @enderror
</div>
