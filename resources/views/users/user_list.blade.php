@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="justify-content: space-between;">
                    <h4>User List</h4>
                    <a class="btn btn-icon icon-left btn-primary" href="{{ route('users') }}">
                        <i class="fas fa-plus"></i> Add new</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped" id="chkbox_table">
                            <thead>
                            <tr>
                                {{-- <th class="text-center pt-3">
                                    <div class="custom-checkbox custom-checkbox-table custom-control">
                                        <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                               class="custom-control-input" id="checkbox-all">
                                        <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                    </div>
                                </th> --}}
                                <th>S.No</th>
                                <th>Namne</th>
                                <th>Email</th>
                                <th>Gender</th>
                                <th>Address</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <?php $i=1 ?>
                            <tbody>
                                @foreach ($user_lists as $user_list)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $user_list->full_name }}</td>
                                            <td>{{ $user_list->email }}</td>
                                            <td>{{ $user_list->gender }}</td>
                                            <td>{{ $user_list->postal_address }}</td>
                                            <td>{{ $user_list->contact_number }}</td>
                                            <td>{{ $user_list->status }}</td>
                                            <td>
                                                <button class="btn btn-primary" id="{{$user_list->user_id}}" value="{{$user_list->full_name}}">Edit</button>
                                                <button class="btn btn-danger" onclick="delete_user(this);" value="{{$user_list->user_id}}">Delete</button>
                                            </td>
                                        </tr>
                                @endforeach

                            
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
    <script>
        
        let role_form_modal = (function () {/*
 <div id="background_fade_form" style="z-index:9999999; height: 100% !important; min-height: 100%; width: 100%; position: fixed; top: 0; background-color: rgba(0, 0, 0, 0.7);display:none;">
 <div style="z-index:99999999;display: block; padding-right: 17px;" class="modal fade show" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog" role="document">
 <div class="modal-content">
 <div class="modal-header">
 <h4 class="modal-title" id="modal_title">User Role Form</h4>
 <button type="button" class="btn" onclick="$('#background_fade_form').fadeOut(function() { $(this).remove(); });" aria-hidden="true"><i class="fas fa-times"></i></button>
 </div>
 <div class="modal-body">
 <form id='user_role_form' action="javascript:save_user_role()" method="POST">
    @csrf
            <div class="form-group">
              <label for="title"><strong>Title</strong></label>
              <input type="text" class="form-control" name="title" id="role_title" >
              <input type="hidden" class="form-control" name="role_id" id="role_id" >
            </div>
            <button type="submit" class="btn btn-primary" > Submit </button>
        </form>
         </div>
         </div>
         </div>
         */}).toString().match(/[^]*\/\*([^]*)\*\/\}$/)[1];

        function show_form(){
            $('body').append(role_form_modal);
            $('#background_fade_form').fadeIn();
        }

        function save_user_role() {
            let form = document.getElementById('user_role_form');
            let data = new FormData(form);
            let a = function () {
                $('#background_fade_form').fadeOut(function() { $(this).remove(); });
            }
            let b = function() {
                window.location.reload();
            }
            let arr = [a,b];
            if($('#role_id').val()>0){
                call_ajax_with_functions('', '{{route('roles_update')}}', data, arr);
            } else {
                call_ajax_with_functions('', '{{route('roles_store')}}', data, arr);
            }
        }

        $('.edit_role').click(function () {
            this.id;
            this.value;
            $('body').append(role_form_modal);
            document.getElementById('role_title').value = this.value;
            document.getElementById('role_id').value = this.id;
            $('#background_fade_form').fadeIn();
        });




        function delete_user (me) {
            let id = me.value;
            let data = new FormData();
            data.append('user_id', id);
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
                    call_ajax('', '{{route('user_delete')}}', data);
                }
            })
        }
    </script> 
@endsection
