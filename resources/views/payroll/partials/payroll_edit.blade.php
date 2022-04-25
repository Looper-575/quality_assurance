@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title float-left">
                    <h3 class="m-portlet__head-text">Edit Payroll</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form id="edit_payroll_form_id" method="post">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="name">Employee Name</label>
                            <input class="form-control" type="text" name="name" id="name" value="{{$payroll->user->full_name}}" disabled>
                            <input type="hidden" name="user_id" id="user_id" value="{{$payroll->user->user_id}}">
                            <input type="hidden" name="payroll_id" id="payroll_id" value="{{$payroll->payroll_id}}">
                            <input type="hidden" name="basic_salary" id="basic_salary" value="{{$payroll->basic_salary}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="salary_month">Salary Month</label>
                            <input class="form-control" type="text" name="salary_month" id="salary_month" value="<?php $yrdata = strtotime($payroll->salary_month); echo date('M-Y', $yrdata); ?>" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="basic_salary">Basic Salary</label>
                            <input class="form-control" type="text" name="basic_salary" id="basic_salary" value="{{$payroll->basic_salary}}" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label" for="gross_salary">Net Salary</label>
                            <input class="form-control" type="text" name="gross_salary" id="gross_salary" value="{{$payroll->gross_salary}}" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <h6 class="form-check-label" for="deductions">Deductions</h6>
                            @foreach($payroll->payroll_deduction as $deduction)
                                <div class="form-group">
                                    <label class="form-check-label" for="deduction">{{$deduction->title}}</label>
                                    <input class="form-control deductions" type="text" name="deduction[{{$deduction->id}}]" id="deduction" value="{{$deduction->amount}}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <h6 class="form-check-label" for="allowance">Allowance</h6>
                            @foreach($payroll->payroll_allowance as $allowance)
                                <div class="form-group">
                                    <label class="form-check-label" for="allowance">{{$allowance->title}}</label>
                                    <input class="form-control allowances" type="text" name="allowance[{{$allowance->id}}]" id="allowance" value="{{$allowance->amount}}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col">
                        <button type="button" class="btn btn-success float-right" onclick="save_payroll_form(this)" value="save">Save</button>
                        <button type="button" class="btn btn-primary float-right mx-2" onclick="save_payroll_form(this)" value="approve">Approve</button>
                        <button type="button" class="btn btn-danger float-right" onclick="save_payroll_form(this)" value=reject>Reject</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>
    <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $(".deductions, .allowances").keyup(function(){
            change_values();
        });
        function change_values() {
            let deduction_val  = 0;
            let allowance_val = 0;
            $('.deductions').each(function(){
                let deduction = $(this).val();
                deduction_val += parseFloat(deduction);
            });
            $('.allowances').each(function (){
                let allowace = $(this).val();
                allowance_val += parseFloat(allowace);
            });
            let basic_salary =  $('#basic_salary').val();
            let gross_salary_val = (basic_salary - deduction_val) + allowance_val;
            $('#gross_salary').val(gross_salary_val);
        }
        function save_payroll_form(me) {
            let type = me.value;
            let data = new FormData($('#edit_payroll_form_id')[0]);
            data.append('_token', '{{csrf_token()}}');
            data.append('type', type);

            let a = null;
            if(type == 'save' ){
                a = function() {
                    window.location.reload();
                }
            } else {
                a = function() {
                    window.location.href = "{{route('payroll_details')}}";
                }
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('payroll_save_edit')}}', data, arr);
        }
    </script>
@endsection

