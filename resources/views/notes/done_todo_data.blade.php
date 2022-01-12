@foreach($done_todos as $todo)
    <label class="l-bg-cyan-dark m-checkbox mt-2 rounded font-17 w-100">
        <s>{{ $todo->title }}</s>
    </label>
@endforeach
