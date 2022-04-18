@extends('layout.template')
@section('header_scripts')
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Tax Deduction</h3>
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
                    <th>From</th>
                    <th>To</th>
                    <th>Amount</th>
                    <th>Value(%)</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($deductions as $index => $menu)
                    <tr>
                        <td>{{$index+1}}</td>
                        <td>{{$menu->from}}</td>
                        <td>{{$menu->to}}</td>
                        <td>{{$menu->amount}}</td>
                        <td>{{$menu->value}}</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-primary edit_btn" title="Edit Menu" value="{{json_encode($menu)}}"><i class="fa fa-edit"></i></button>
                                    <button type="button" class="btn btn-danger detele_btn" title="Delete Menu" value="{{$menu->tax_deduction_id}}"><i class="fa fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <!-- View Modal -->
    <div class="modal fade" id="add_new_modal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="add_new_modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="add_new_modalLabel">Tax Deduction</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" id="data_form_id" enctype="multipart/form-data">
                        @csrf
                        <div id="add_more_div">
                            <div class="row" id="new_val">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-check-label" for="from">From</label>
                                        <input type="numeric" class="form-control" name="from[]" id="from"  required>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-check-label" for="to_id">To</label>
                                        <input type="numeric" class="form-control" name="to[]" id="to_id"  required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label class="form-check-label" for="amount_id">Amount</label>
                                        <input type="numeric" class="form-control" name="amount[]" id="amount_id"  required>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <label class="form-check-label" for="value">Value(%)</label>
                                        <input type="numeric" class="form-control" name="value[]" id="value"  required>
                                    </div>
                                </div>
                                <div class="col-2 mt-4">
                                    <button type="button" class="btn btn-success" id="add_more_id" onclick="add_more(this)">Add More</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <input type="hidden" name="tax_deduction_id" value="" id="tax_deduction_id">
                                <button type="submit"  class="btn btn-primary float-right" id="save_id"> Save</button>
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
    <script>
        function add_more(me) {
            let new_row = $(me).closest('#new_val').clone();
            $('#add_more_div').prepend(new_row)
            new_row.find('input').val('');
            $(me).closest('#new_val').find('button').removeClass('btn-primary').addClass('btn-danger').removeAttr('onclick').attr('onclick', 'remove_row(this)').html('Remove');
        }
        function remove_row(me) {
            $(me).closest('.row').fadeOut('slow', function (){
                this.remove();
            })
        }
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
                        $('<option></option>').val('').html('Please Select')
                    );
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
                    $('#role_id').val(role_id);
                }
            });
        }
        $('#department_id').on('change', function() {
            let department_id = this.value;
            set_role(department_id);
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
                    call_ajax('', '{{route('tax_deduction_delete')}}', data);
                }
            })
        });
        $('#add_new_btn').click(function () {
            $('#data_form_id').resetForm();
            $('#tax_deduction_id').val('');
            $('#save_id').html('Save');
            $('#add_more_id').addClass('d-block');
            $('#add_more_id').removeClass('d-none');
            $('#add_new_modal').modal('toggle');
        });

        $('#data_form_id').submit(function (e) {
            e.preventDefault();
            let form = document.getElementById('data_form_id');
            let data = new FormData(form);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('save_tax_deduction_form')}}', data, arr);
        });

        $('.edit_btn').click( function () {
            let data = JSON.parse(this.value);
            console.log(data.tax_deduction_id);
            $('#save_id').html('Update');
            $('#add_more_id').addClass('d-none');
            $('#add_more_id').removeClass('d-block');
            $('#tax_deduction_id').val(data.tax_deduction_id);
            $('#from').val(data.from);
            $('#to_id').val(data.to);
            $('#value').val(data.value);
            $('#amount_id').val(data.amount);
            $('#add_new_modal').modal('toggle');
        });
    </script>
@endsection
