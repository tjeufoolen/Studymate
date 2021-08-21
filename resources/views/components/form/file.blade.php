<label>{{ $title ?? '' }}</label>
<div class="{{ $classes ?? 'custom-file' }}">
    <input
        type="file"
        class="custom-file-input"
        id="{{ $name }}"
        name="{{ $name }}"
    @isset($attributes)
        @foreach($attributes as $attr)
            {{ $attr }}
            @endforeach
        @endisset
    >
    <label class="custom-file-label" for="{{ $name }}">{{ $placeholder ?? '' }}</label>

    @error(strval($name))
    <div class="invalid-feedback">{{ $errors->first(strval($name)) }}</div>
    @enderror
</div>
