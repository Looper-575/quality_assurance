<table class="table table-bordered" id="employee_table_id">
    <thead>
    <tr>
        <th>S.No</th>
        <th>Name</th>
        <th>Email</th>
        <th>Position</th>
        <th>Gender</th>
        <th>Address</th>
        <th>Contact</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($employee_lists as $employee_list)
        <tr>
            <td>{{ $loop->index+1 }}</td>
            <td>{{ $employee_list->full_name }}</td>
            <td>{{ $employee_list->email }}</td>
            <td>{{ $employee_list->designation }}</td>
            <td>{{ $employee_list->gender }}</td>
            <td>{{ $employee_list->present_address }}</td>
            <td>{{ $employee_list->contact_number }}</td>
            <td>
                <div class="btn-group btn-group-sm">
                    <a href="{{route('employee_data_view',['employee_id' => $employee_list->employee_id])}}" id="{{$employee_list->employee_id}}" class="btn btn-primary" data-toggle="m-tooltip" data-placement="right" data-skin="dark" data-container="body">
                        <i class="la la-eye"></i>
                    </a>
                    @if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5)
                        <a title="Edit" class="btn text-white bg-warning edit_employee" id="{{$employee_list->employee_id}}" href="{{route('employee_form',['employee_id' => $employee_list->employee_id])}}"><i class="fa fa-edit"></i></a>
                        @if($employee_list->locked == 0)
                            <button title="Lock" class="btn btn-info" onclick="lock_employee_record(this);" value="{{$employee_list->employee_id}}"><i class="fa fa-lock"></i></button>
                        @endif
                        {{--                                <button title="Delete" class="btn btn-danger" onclick="delete_employee(this);" value="{{$employee_list->employee_id}}"><i class="fa fa-trash"></i></button>--}}
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
