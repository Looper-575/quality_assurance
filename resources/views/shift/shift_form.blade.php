@extends('layout.template')
@section('header_scripts')
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Create Shift</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form method="post" id="shift_form" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-check-label" for="from">Shift Title</label>
                            <input class="form-control" type="text" name="title" id="title" value="" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="check_in" >Check In</label>
                            <input class="form-control" type="time" name="check_in" value="" id="check_in" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="check_out" >Check Out</label>
                            <input class="form-control" type="time" name="check_out" value="" id="check_out" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <input type="hidden" id="user_ids" name="user_ids[]" value="">
                        <button type="submit"  class="btn btn-primary float-right"> Create</button>
                    </div>
                    <br>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        var user_ids = new Array();
        $('#all_user').on('change', function() {
            var user_id = $(this).val();
            var user_name = $("#all_user option:selected").text();

            $(this).children('option:selected').remove();

            user_ids.push(user_id);
            console.log(user_ids);
            $('[name=user_ids]').val(user_ids);
            $("#added_users:last").after('<tr id="row_'+user_id+'"><th scope="row" class="nr">'+user_id+'</th><td>'+user_name+'</td><td class="remove-user"><button type="button" onclick="reomve_user(\'' + user_id + '\',\'' + user_name + '\')" class="btn btn-danger">Remove form Shift</button></td></tr>');
        });
        function reomve_user(id,name) {
            $("#all_user").append('<option value="'+id+'">'+name+'</option>');
            $("#row_"+id+"").remove();
            user_ids = arrayRemoveVal(user_ids, id);
            $('[name=user_ids]').val(user_ids);
            console.log(id,name, user_ids);
        }
        function arrayRemoveVal(array, removeValue){
            var newArray = jQuery.grep(array, function(value) {return value != removeValue;});
            return newArray;
        }
        function view_qa(qa_id) {
            let data = new FormData();
            data.append('qa_id', qa_id);
            data.append('_token', '{{ csrf_token() }}');
            call_ajax_modal('POST', '{{route('qa_single_data')}}', data, 'Quality Assessment View');
        }
        //form submission;
        $('#shift_form').submit(function (e) {
            e.preventDefault();
            let data = new FormData(this);
            data.append('user_ids', user_ids);
            let a = function(){ window.location.reload(); };
            let arr = [a];
            call_ajax_with_functions('','{{route('save_shift_form')}}',data,arr);
        });
    </script>
@endsection


