@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Team List</h3>
                </div>
                <div class="float-right mt-3">
                    <a id="add_new_btn#" href="{{route('team_create')}}" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
                        <span><i class="la la-phone-square"></i><span>Add New</span></span>
                    </a>
                    <div class="m-separator m-separator--dashed d-xl-none"></div>
                </div>
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
                                <button type="button" title="Edit Team" class="btn btn-primary edit_btn d-none" value="{{json_encode($team)}}"><i class="la la-edit"></i> </button>
                                <a class="btn btn-primary" title="Update Team" href="{{route('add_member_in_team' , $team->team_id)}}" >
                                    <i class="la la-edit"> </i>
                                </a>
                                <button type="button" title="Delete Team" class="btn btn-danger detele_btn" value="{{$team->team_id}}"><i class="la la-trash"></i> </button>
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
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
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
        $('#team_form').submit(function (e) {
            e.preventDefault();
            $('#team_form_modal').fadeOut();
            let form = document.getElementById('team_form');
            let data = new FormData(form);
            let a = function() {
                window.location.href = "{{route('team_list')}}";
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
