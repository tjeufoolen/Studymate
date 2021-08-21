@can('deadlines_deadlines')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('deadlines.deadlines') }}">Deadlines</a>
    </li>
@endcan
@can('deadlines_nodeadlines')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('deadlines.nodeadlines') }}">Schedule modules</a>
    </li>
@endcan