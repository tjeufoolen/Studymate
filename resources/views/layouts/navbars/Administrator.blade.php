@can('student_index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('students.index') }}">Students</a>
    </li>
@endcan
@can('teacher_index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('teachers.index') }}">Teachers</a>
    </li>
@endcan
@can('module_index')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('modules.index') }}">Modules</a>
    </li>
@endcan