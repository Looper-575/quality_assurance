<?php
$has_permissions = get_route_permissions( Auth::user()->role->role_id, 'modules_list');
?>
<table class="datatable table table-bordered" id="approved_table">
        <thead>
        <tr>
            <th>S.no</th>
            <th>Project</th>
            <th>Module</th>
            <th>Added by</th>
            <th>Added On</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach($project_modules as $module)
            <tr>
                <td>{{$loop->index+1}}</td>
                <td>{{$module->projects->title}}</td>
                <td>{{ $module->module_name}}</td>
                <td>{{$module->users->full_name}}</td>
                <td>{{ parse_datetime_get($module->added_on)}}</td>
                <td>{{$module->approved == 1?'Approved':'Pending'}}</td>
                <td>
                    @if($has_permissions->view == 1)
                        <a href="{{route('single_module_detail',$module->id)}}" class="btn btn-primary">View</a>
                    @endif
                    @if($module->approved !== 1 && $module->added_by == Auth::user()->user_id)
                        <a href="{{route('module_form',['id'=>$module->id])}}" class="btn btn-info">Edit</a>
                    @endif

                    @if($has_permissions->update == 1 && $module->approved !== 1)
                        <button id="{{$module->id}}" onclick="approveModule(this)"  class="btn btn-success">Approve</button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
</table>

