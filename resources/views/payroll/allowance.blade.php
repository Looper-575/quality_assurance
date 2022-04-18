@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .select2-container{
            width: 100% !important;
        }
        .dependent, .dependent-mobile{
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Allowance</h3>
                </div>
                <div class="float-right mt-3">
                        <a id="add_new_btn" href="javascript:;" class="btn btn-primary m-btn m-btn--custom m-btn--icon m-btn--air m-btn--pill">
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
                    <th>Type</th>
                    <th>Value</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($allowances as $index => $menu)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$menu->title}}</td>
                        <td>{{ ucwords(str_replace('-', ' ', $menu->type))}}</td>
                        <td>{{$menu->allowance_value}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary edit_btn" title="Edit Menu" value="{{json_encode($menu)}}"><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger detele_btn" title="Delete Menu" value="{{$menu->allowance_id}}"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- View Modal -->
    <div class="modal fade" id="add_new_modal" tabindex="-1" aria-labelledby="add_new_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_modalLabel">Allowance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="add_form_id" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-check-label" for="title">Allowance Title</label>
                                    <input class="form-control" type="text" name="title" id="title" value="" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="department_id">Department</label>
                                    <select class="form-control mt-2" name="department_id" id="department_id" required>
                                        <option value="">Please Select</option>
                                        <option value="0">All</option>
                                        @foreach($departments as $dpt)
                                            <option value="{{$dpt->department_id}}">{{$dpt->title}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label mb-2" for="role_id">Role</label>
                                    <select class="form-control mt-2 select2" name="role_id[]" id="role_id" multiple="multiple" required>
                                        <option value="0">All</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-check-label" for="type">Type</label>
                                    <select class="form-control mt-2" name="type" id="type" required>
                                        <option value="">Please Select</option>
                                        <option value="dependability">Dependability Allowance</option>
{{--                                        <option value="added-incentive">Added Incentive</option>--}}
                                        <option value="rgu-bench-mark">RGU Bench Mark</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 dependent">
                                <div class="form-group">
                                    <label class="form-check-label" for="bench_mark_type">Bench Mark Type</label>
                                    <select class="form-control mt-2" name="bench_mark_type" id="bench_mark_type">
                                        <option value="">Please Select</option>
{{--                                        <option value="rgu">RGU</option>--}}
                                        <option value="single-play">Single Play</option>
                                        <option value="double-play">Double Play</option>
                                        <option value="triple-play">Triple Play</option>
                                        <option value="mobile">Mobile</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 dependent">
                                <div class="form-group">
                                    <label class="form-check-label" for="provider">Providers</label>
                                    <select class="form-control select2 mt-2" name="provider[]" id="provider" multiple="multiple">
                                        <option value="">Please Select</option>
                                        <option value="all">All</option>
                                        <option value="spectrum">Spectrum</option>
                                        <option value="cox">Cox</option>
                                        <option value="suddenlink">Suddenlink</option>
                                        <option value="att">AT&T</option>
                                        <option value="earthLink">EarthLink</option>
                                        <option value="frontier">Frontier</option>
                                        <option value="mediacom">MediaCom</option>
                                        <option value="optimum">Optimum</option>
                                        <option value="directtv">Direct TV</option>
                                        <option value="hughesnet">Hughesnet</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 dependent bench_mark_criteria">
                                <div class="form-group">
                                    <label class="form-check-label" for="bench_mark_criteria">Bench Mark Criteria</label>
                                    <select class="form-control mt-2" name="bench_mark_criteria" id="bench_mark_criteria">
                                        <option value="">Please Select</option>
                                        <option value="fixed">Fixed</option>
                                        <option value="recurring">Recurring</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6 dependent">
                                <div class="form-group">
                                    <label class="form-check-label" for="bench_mark_value">Bench Mark Value</label>
                                    <input class="form-control" type="number" name="bench_mark_value" value="" id="bench_mark_value">
                                </div>
                            </div>
                            <div class="col-6 dependent-mobile">
                                <div class="form-group">
                                    <label class="form-check-label" for="before">Before Bench Mark</label>
                                    <input class="form-control" type="number" name="before" value="" id="before">
                                </div>
                            </div>
                            <div class="col-6 dependent-mobile">
                                <div class="form-group">
                                    <label class="form-check-label" for="after">After Bench Mark</label>
                                    <input class="form-control" type="number" name="after" value="" id="after">
                                </div>
                            </div>
                            <div class="col-6 bench-mark-value">
                                <div class="form-group">
                                    <label class="form-check-label" for="value">Value</label>
                                    <input class="form-control" type="number" name="value" value="" id="value" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" id="allowance_id" name="allowance_id" value="">
                                <button type="submit"  class="btn btn-primary float-right"> Save</button>
                            </div>
                            <br>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script>
        $(document).ready(function (){
            $(".select2").select2();
        });
        function set_role(department_id, role_id = null)
        {
            $.ajax({
                type:'get',
                url:'get_department_role',
                data:{
                    department_id: department_id,
                },
                success: function( response ) {
                    $('#role_id').empty().append('');
                    var role_id = $('#role_id');
                    role_id.append(
                        $('<option></option>').val(0).html('All')
                    );
                    $.each(response, function(val, data) {
                        role_id.append(
                            $('<option></option>').val(data.role.role_id).html(data.role.title)
                        );
                    });
                }
            }).then(function(){
                if(role_id != null){
                    // $('#role_id').val(role_id);
                    $("#role_id").select2().select2('val', [role_id]);
                }
            });
        }
        $('#department_id').on('change', function() {
            let department_id = this.value;
            set_role(department_id);
        });
        $('#type').on('change', function() {
            if(this.value == 'rgu-bench-mark' || this.value == 'added-incentive'){
                $('.dependent').css('display', 'block');
            } else {
                $('#bench_mark_type').val('');
                $('#bench_mark_criteria').val('');
                $('#bench_mark_value').val('');
                $("#provider").select2().select2('val', [' ']);
                $('.dependent').css('display', 'none');
            }
        });
        $('#bench_mark_type').on('change', function () {
            if(this.value == 'mobile'){
                $('.dependent-mobile').css('display', 'block');
                $('.bench_mark_criteria').css('display', 'none');
                $('.bench-mark-value').css('display', 'none');
                $('#value').prop('required',false);
            } else {
                $('.dependent-mobile').css('display', 'none');
                $('.bench_mark_criteria').css('display', 'block');
                $('.bench-mark-value').css('display', 'block');
            }
        });
        $('.detele_btn').click( function () {
            let id = this.value;
            let me = this;
            let data = new FormData();
            data.append('id', id);
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
                    call_ajax('', '{{route('allowance_delete')}}', data);
                }
            })
        });
        $('#add_new_btn').click(function () {
            $('#add_form_id').resetForm();
            $("#provider").select2().select2('val', [' ']);
            $("#role_id").select2().select2('val', [' ']);
            $('#add_new_modal').modal('toggle');
        });

        $('#add_form_id').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('add_form_id');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('save_allowance_form')}}', data, arr);
        });

        $('.edit_btn').click( function () {
            let data = JSON.parse(this.value);
            $('#allowance_id').val(data.allowance_id);
            $('#title').val(data.title);
            $('#type').val(data.type);
            $('#department_id').val(data.department_id);
            $('#value').val(data.allowance_value);
            $('#bench_mark_type').val(data.bench_mark_type);
            $('#bench_mark_criteria').val(data.bench_mark_criteria);
            $('#bench_mark_value').val(data.bench_mark_value);
            $('#before').val(data.before);
            $('#after').val(data.after);
            let provider = data.provider.split(',');
            $("#provider").select2().select2('val', [provider]);
            if(data.type == 'rgu-bench-mark' || data.type == 'added-incentive'){
                $('.dependent').css('display', 'block');
            } else {
                $('.dependent').css('display', 'none');
            }
            if(data.bench_mark_type == 'mobile'){
                $('.dependent-mobile').css('display', 'block');
                $('.bench_mark_criteria').css('display', 'none');
                $('.bench-mark-value').css('display', 'none');
                $('#value').prop('required',false);
            } else {
                $('.dependent-mobile').css('display', 'none');
                $('.bench_mark_criteria').css('display', 'block');
                $('.bench-mark-value').css('display', 'block');
            }
            $('#add_new_modal').modal('toggle');
            let roles = data.role_id.split(',');
            set_role(data.department_id, roles);
        });
    </script>
@endsection
