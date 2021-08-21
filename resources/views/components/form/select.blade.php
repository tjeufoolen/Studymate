<div class="{{ isset($classes) ? $classes : 'form-group' }}">
    <label for="{{ $name }}">{{ $title }}</label>
    <select
        class="form-control"
        id="{{ $name }}"
        name="{{ $name }}"
    @isset($attributes)
        @foreach($attributes as $attr)
            {{ $attr }}
            @endforeach
        @endisset
    >

        @isset($items)
            @foreach ($items as $item)
                <option
                    @if(old(strval($name)) != null){{ $item->id == old(strval($name)) ? 'selected' : '' }}
                    @elseif(isset($selected)){{ $item->id == $selected ? 'selected' : '' }} @endif

                    value="{{ $item->id }}"
                >
                    {{ $item->name }}
                </option>
            @endforeach
        @endisset
    </select>

    @error(strval($name))
    <div class="invalid-feedback">{{ $errors->first(strval($name)) }}</div>
    @enderror
</div>
