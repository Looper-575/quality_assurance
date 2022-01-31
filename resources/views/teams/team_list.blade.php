@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <?php
    $has_permissions = get_route_permissions( Auth::user()->role->role_id, @request()->route()->getName());
    ?>
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Teams</h3>
                </div>
                @if($has_permissions->add == 1)
                <div class="float-right mt-3">
                    <a id="add_new_btn#" href="{{route('team_create')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                        <span><i class="la la-phone-square"></i><span>Add New</span></span>
                    </a>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
                @endif
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="datatable table table-bordered" id="html_table">
                <thead>
                <tr>
                    <th>S.No.</th>
                    <th>Title</th>
                    <th>Department</th>
                    <th>Team Lead</th>
                    <th>Shift</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($teams as $team)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$team->title}}</td>
                        <td>{{$team->team_type->title}}</td>
                        <td>{{$team->team_lead->full_name}}</td>
                        <td>{{@$team->shift->title}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                @if($has_permissions->update == 1)
                                <a class="btn btn-primary" title="Update Team" href="{{route('add_member_in_team' , $team->team_id)}}" >
                                    <i class="la la-edit"> </i>
                                </a>
                                @endif
                                @if(Auth::user()->role_id == 1)
                                <button type="button" title="Delete Team" class="btn btn-danger detele_btn" value="{{$team->team_id}}"><i class="la la-trash"></i> </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <div id="team_form_modal" style="z-index:9999999; height: 100% !important; min-height: 100%; width: 100%; position: fixed; top: 0; background-color: rgba(0, 0, 0, 0.7);display:none;">
        <div style="z-index:99999999;display: block; padding-right: 17px; top: 100px" class="modal fade show" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog user_roles_modal modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="modal_title">Team</h4>
                        <button type="button" class="btn btn-danger" onclick="$('#team_form_modal').fadeOut();" aria-hidden="true"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" id="team_form">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-check-label" for="title">Title </label>
                                        <input class="form-control" type="text" name="title" id="title" placeholder="Enter Title.." required>
                                        <input class="form-control" type="hidden" name="team_id" id="team_id" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-check-label" for="shift_id">Shift</label>
                                    <select class="form-control select2" name="shift_id" id="shift_id">
                                        <option value="">Select Shift </option>
                                        @foreach($shifts as $shift)
                                            <option value="{{$shift->shift_id}}"> {{$shift->title}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-check-label" for="team_lead_id">Team Lead</label>
                                    <select class="form-control select2" name="team_lead_id" id="team_lead_id" required>
                                        <option value=""> Select Team Lead </option>
                                        @foreach($team_leads as $agent)
                                            <option value="{{$agent->user_id}}"> {{$agent->full_name}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label class="form-check-label" for="team_type_id">Team Type</label>
                                    <select class="form-control select2" name="team_type_id" id="team_type_id" required>
                                        <option value=""> Select User </option>
                                        @foreach($types as $agent)
                                            <option value="{{$agent->department_id}}"> {{$agent->title}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit"  class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $('.detele_btn').click( function () {
            let id = this.value;
            let me = this;
            let data = new FormData();
            data.append('team_id', id);
            data.append('_token', "{{csrf_token()}}");
            swal({
                title: "Are you sure?",
                text: "Do you really want to delete this record? You will not be able to recover this.",
                icon: "warning",
                buttons: [
                    'No, cancel it!',
                    'Yes, I am sure!'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    $(me).closest('tr').fadeOut('slow', function (){
                        $(this).remove();
                    });
                    call_ajax('', '{{route('team_delete')}}', data);
                }
            })
        });
        $('#add_new_btn').click(function () {
            $('#team_type_id').val(null);
            $('#title').val(null);
            $('#team_form_modal').fadeIn();
        });

        $('#team_form').submit(function (e) {
            e.preventDefault();
            $('#team_form_modal').fadeOut();
            let form = document.getElementById('team_form');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('team_save')}}', data, arr);
        });

        $('.edit_btn').click( function () {
            let data = JSON.parse(this.value);
            $('#team_id').val(data.team_id);
            $('#shift_id').val(data.shift_id);
            $('#team_lead_id').val(data.team_lead_id);
            $('#team_type_id').val(data.team_type.department_id);
            $('#title').val(data.title);
            $('#team_form_modal').fadeIn();

        });

    </script>
@endsection
