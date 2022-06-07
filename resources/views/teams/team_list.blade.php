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
                        <div class="m-portlet__head-tools float-right">
                            <ul class="nav nav-tabs m-tabs-line m-tabs-line--success m-tabs-line--2x m-tabs-line--right" role="tablist">
                                <li class="nav-item m-tabs__item">
                                    <a href="{{route('team_create')}}" class="nav-link m-tabs__link">
                                        <span class="add-new-button"><i class="fa fa-plus"></i><span>Add New</span></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
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
    </script>
@endsection
