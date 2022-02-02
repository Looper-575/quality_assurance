@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Update Team</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form method="post" id="add_member_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="title">Title </label>
                            <input class="form-control" type="text" name="title" value="{{$team_edit->title}}" id="title" placeholder="Enter Title.." required>
                            <input class="form-control" type="hidden" name="team_id" value="{{$team_edit->team_id}}" id="team_id" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <label class="form-check-label" for="shift_id">Shift</label>
                        <select class="form-control select2" name="shift_id" id="shift_id">
                            <option value="">Select Shift</option>
                            @foreach($shifts as $shift)
                                <option {{$team_edit->shift_id == $shift->shift_id ? 'selected' : ''}} value="{{$shift->shift_id}}"> {{$shift->title}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-check-label" for="team_lead_id">Team Lead</label>
                        <select class="form-control select2" name="team_lead_id" id="team_lead_id" required>
                            <option value="">Select Team Lead</option>
                            @foreach($team_leads as $agent)
                                <option {{$team_edit->team_lead_id == $agent->user_id ? 'selected' : ''}} value="{{$agent->user_id }}"> {{$agent->full_name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-check-label" for="team_type_id">Department</label>
                        <select class="form-control select2" name="department_id" id="team_type_id" required>
                            <option value="">Select Department</option>
                            @foreach($types as $type)
                                <option {{$team_edit->department_id == $type->department_id ? 'selected' : ''}} value="{{$type->department_id }}"> {{$type->title}}  </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 pt-4">
                        <label class="form-check-label" for="all_user">All User</label>
                        <select class="form-control select2" name="all_user" id="all_user">
                            <option value="">Select User</option>
                            @foreach($agents as $agent)
                                <option value="{{$agent->user_id}}"> {{@$agent->full_name}} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 py-5">
                        <label class="form-check-label" for="user_in_shift">User In Shift</label>
                        <table class="table text-center" border="1">
                            <thead>
                            <tr>
{{--                                <th scope="col">User ID</th>--}}
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody id="added_users">
                            @foreach($team_edit->team_member as $index => $data)
                                <tr id="row_{{$data->user->user_id}}">
{{--                                    <td scope="row" class="nr">--}}
{{--                                        {{$data->user_id}}--}}
{{--                                    </td>--}}
                                    <td>
                                        {{$data->user->full_name}}
                                    </td>
                                    <td class="remove-user">
                                        <button type="button" onclick="reomve_user({{$data->user->user_id}}, '{{$data->user->full_name}}')" class="btn btn-danger">Remove form Team</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input type="hidden" id="user_ids" name="user_ids[]" value="">
                        <button type="submit" class="btn btn-primary float-right">Update</button>
                    </div>
                    <br>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        let user_ids = new Array();
        $( document ).ready(function() {
            <?php $user_ids = array();
            foreach ($team_edit->team_member as $data):
                $user_ids = $data->user_id;
                ?>;
            user_ids.push(<?php echo $user_ids; ?>);
            <?php endforeach; ?>
        });
        $('#team_lead_id').on('change', function() {
            var manager_id = $(this).val();
            var url = '{{ route("get_manager_agents",":id") }}';
            url = url.replace(':id',manager_id);
            $.ajax({
                type:'get',
                url:url,
                success: function( resp ) {
                    user_ids.length = 0;
                    var html = '';

                    var tbody_start = '<tbody id="added_users">';
                    var tbody_end = '</tbody>';

                    $.each(resp.manager_agents, function(i,j) {
                        user_ids.push(j.user_id);
                        html = html+'<tr id="row_'+j.user_id+'"><td>'+j.full_name+'</td><td class="remove-user"><button type="button" onclick="reomve_user(\'' + j.user_id + '\',\'' + j.full_name + '\')" class="btn btn-danger">Remove form Team</button></td></tr>';
                    });
                    document.getElementById('added_users').innerHTML = tbody_start+html+tbody_end;
                    $('[name=user_ids]').val(user_ids);

                    var all_user_html = '<option value="">Select User</option>';
                    $.each(resp.agents, function(i,k) {
                        all_user_html = all_user_html+'<option value="'+k.user_id+'">'+k.full_name+'</option>';
                     });
                    document.getElementById('all_user').innerHTML = all_user_html;
                }
            });
        });
        $('#all_user').on('change', function() {
            var user_id = $(this).val();
            var user_name = $("#all_user option:selected").text();
            $(this).children('option:selected').remove();

            user_ids.push(user_id);
            $('[name=user_ids]').val(user_ids);
            $("#added_users").append('<tr id="row_'+user_id+'"><td>'+user_name+'</td><td class="remove-user"><button type="button" onclick="reomve_user(\'' + user_id + '\',\'' + user_name + '\')" class="btn btn-danger">Remove form Team</button></td></tr>');
        });
        function reomve_user(id, name) {
            $("#all_user").append('<option value="'+id+'">'+name+'</option>');
            $("#row_"+id+"").remove();
            user_ids = arrayRemoveVal(user_ids, id);
            $('[name=user_ids]').val(user_ids);
            console.log(id, name, user_ids);
        }
        function arrayRemoveVal(array, removeValue){
            var newArray = jQuery.grep(array, function(value) {return value != removeValue;});
            return newArray;
        }
        //form submission;
        $('#add_member_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            data.append('user_ids', user_ids);
            let a = function(){
                window.location.reload();
            };
            let arr = [a];
            call_ajax_with_functions('','{{route('save_add_member_form')}}',data,arr);
        });
    </script>
@endsection
