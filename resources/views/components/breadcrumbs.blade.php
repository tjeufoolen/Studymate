<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        @foreach($pages as $name => $uri)
            @if(!$loop->last)
                <li class="breadcrumb-item"><a href="{{ $uri }}">{{ $name }}</a></li>
            @else
                <li class="breadcrumb-item active" aria-current="page">{{ $name }}</li>
            @endif
        @endforeach
    </ol>
</nav>
