@foreach($pending_todos as $p_todo)

    <div class="todo_card mb-3 w-100">
        <div class="dropdown">
            <button class="position-absolute note_btns btn btn-outline-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill m-btn--air dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="right: -33px">
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" onclick="make_done_todo({{$p_todo->note_id}})" href="javascript:;" data-toggle="m-tooltip" title="Mark Todo Done" data-placement="right" data-skin="dark"	data-container="body">
                    Mark Done
                </a>
                <a class="dropdown-item" onclick="edit_todo({{$p_todo->note_id}},'{{$p_todo->title}}')" href="javascript:;" data-toggle="m-tooltip" title="Edit Todo" data-placement="right" data-skin="dark" data-container="body">
                    Edit
                </a>
                <a  class="dropdown-item" onclick="delete_todo({{$p_todo->note_id}})" href="javascript:;" data-toggle="m-tooltip" title="Delete Todo" data-placement="right" data-skin="dark" data-container="body">
                    Delete
                </a>
            </div>
        </div>
        {{ $p_todo->title }}
    </div>
@endforeach
