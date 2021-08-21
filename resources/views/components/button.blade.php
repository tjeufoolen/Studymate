<button class="{{ isset($classes) ? $classes : 'btn' }}"
        @isset($type)
        type="{{ $type }}"
    @endisset
@isset($attributes)
    @foreach($attributes as $attr)
        {{ $attr }}
        @endforeach
    @endisset>
    {{ $title }}
</button>
