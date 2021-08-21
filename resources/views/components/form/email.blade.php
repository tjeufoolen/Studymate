<div class="{{ $classes ?? 'form-group' }}">
    <label for="{{ $name }}">{{ $title }}</label>
    <input
        type="email"
        class="form-control @error(strval($name)) is-invalid @enderror"
        id="{{ $name }}"
        name="{{ $name }}"
        value="{{ old(strval($name)) }}"
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
