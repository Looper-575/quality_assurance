@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div id="emp_separation_form"  class="m-portlet m-portlet--mobile p-3">
        <div class="m-portlet__body">
            <div class="row">
                <div class="col-12">
                    <div class="m-portlet__head-title float-left">
                        <img alt="AtlantisBPO Solutions" src="{{asset('assets/img/logo-full.png')}}" width="150"/>
                    </div>
                    <div class="float-right mt-3">
                        <h3><b>FINAL SETTLEMENT ADVICE</b></h3>
                        <div class="m-separator m-separator--dashed d-xl-none"></div>
                    </div>
                </div>
            </div><br>
            <div class="m-separator m-separator--dashed m-separator--lg"></div>
            <form id="final_settlement_form" action="javascript:save_final_settlement()" method="post">
                <div class="container-fluid">
                @csrf
                <input type="hidden" id="separation_id" name="separation_id" value="{{$separation->separation_id}}">
                <input type="hidden" id="last_working_day" name="last_working_day" value="{{ $separation->separation_date }}">
                <input type="hidden" id="length_of_service" name="length_of_service" value="{{total_service($separation->user->employee->joining_date, $separation->separation_date)}}">
                <div class="row mx-1">
                    <div class="col-12 p-3" style="border: 2px solid #000000 !important;">
                        <table class="table table-sm table-borderless mb-0">
                            <tbody>
                            <tr>
                                <td>Name:</td>
                                <td class="text-capitalize">{{ $separation->user->full_name }}</td>
                                <td colspan="2"></td>
                            </tr>
                            <tr>
                                <td>Designation:</td>
                                <td>{{ $separation->user->employee->designation }}</td>
                                <td>Department</td>
                                <td>{{ $separation->user->department->title ?? ''}}</td>
                            </tr>
                            <tr>
                                <td>Date of Appointment:</td>
                                <td>{{ $separation->user->employee->joining_date }}</td>
                                <td>Date of Resignation:</td>
                                <td>{{ $separation->resignation_date }}</td>
                            </tr>
                            <tr>
                                <td>Last Day Worked:</td>
                                <td>{{ $separation->separation_date }}</td>
                                <td>Length of Service:</td>
                                <td>{{total_service($separation->user->employee->joining_date, $separation->separation_date)}}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="m-separator m-separator--dashed m-separator--sm"></div>
                <div class="row">
                    <div class="col-12 mt-2">
                        <p><b>Detail:</b> <span>{{$separation->type}}</span>
                            <span class="m-l-100"><b>Notice Period:</b> {{$separation->notice_period}}</span>
                            <span class="m-l-100"><b>Served:</b> {{working_days($separation->resignation_date, $separation->separation_date)}} Days</span>
                            </p>
                        <p class="mb-0"><b>
                            @foreach($payroll as $payroll_log)
                                <span>
                                    @if($payroll_log->notice_period == 'No')
                                        Salary for the month of
                                        {{date('F Y', strtotime($payroll_log->to_date))}},
                                    @endif
                                    @if($payroll_log->notice_period == 'Yes')
                                            {{$payroll_log->attendance_marked-$payroll_log->absents}}
                                        working days for the month of {{date('F Y', strtotime($payroll_log->to_date))}}.
                                    @endif
                                </span>
                            @endforeach
                        </b></p>
                    </div>
                </div>
                <div class="m-separator m-separator--dashed m-separator--sm"></div>
                <div class="row">
                        <div class="col-6 d-flex form-check p-3">
                            <div class="w-100 p-3" style="border: 2px solid #000000 !important;">
                            <p><b>Clearance: </b>All deduction items other than those listed here under have been received.</p>
                            @if($final_settlement)
                                <p><b>Amount to be Deducted : {{$final_settlement->asset_deduction_amount}}</b>
                            <?php $assets_not_returned = explode(',',$final_settlement->assets_not_returned) ?>
                                @foreach($assets_not_returned as $asset)
                                    <p>{{$asset}}</p>
                                @endforeach
                            @else
                                @if($separation->assets_list != NULL)
                                    <p><b>Amount to be Deducted :</b>
                                            <input type="number" name="asset_deduction_amount" id="asset_deduction_amount" readonly></p>
                                    <div class="m-form__group form-group">
                                        <label>Please select the Deductions</label>
                                        <div class="m-checkbox-list">
                                        <label class="m-checkbox">
                                            <input type="checkbox" id="assets_not_returned" name="assets_not_returned"
                                                   data-asset="all" data-price="0" value="0">Select All <span></span>
                                        </label>
                                            <?php $assets_list = json_decode($separation->assets_list); ?>
                                            @foreach ($assets_list as $key => $asset)
                                                <label class="m-checkbox">
                                                    <input type="checkbox" name="assets_not_returned[]" data-asset="{{$asset->item}}" data-price="{{$asset->price}}" class="asset_checkbox" value="{{$asset->item}}">
                                                    {{ $asset->item }} ({{ $asset->price }})<span></span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                            @endif
                            </div>
                        </div>
                        <div class="col-6 d-flex form-check p-3">
                            <div class="w-100 p-3" style="border: 2px solid #000000 !important;">
                            <p><b>Earning Dues (in Days)</b></p>
                            @foreach($payroll as $payroll_log)
                                <p>Salary ({{date('F Y', strtotime($payroll_log->form_date))}}) : Rs {{intval($payroll_log->user->employee->net_salary)}}</p>
                                <p>Salary ({{date('F Y', strtotime($payroll_log->form_date))}} ({{$payroll_log->attendance_marked-$payroll_log->absents}} days)) : Rs {{intval($payroll_log->user->employee->net_salary - $payroll_log->deductions['total_deductions'])}}</p>
                                <p>Dated : {{$payroll_log->form_date}} To {{$payroll_log->to_date}}</p>
                            @endforeach
                            </div>
                        </div>
                </div>
                <div class="m-separator m-separator--dashed m-separator--sm"></div>
                <div class="row my-2">
                    <div class="col-12">
                        <h4 class="text-center">TO BE FILLED BY ACCOUNTS DEPARTMENT</h4>
                        <h6 class="text-center">Clearance for all Accounting matters to be done by the Accounting Department.</h6>

                        <div class="" style="border: 2px solid #000000 !important; border-top: 2px solid #000000 !important;">
                            <table class="table table-bordered m-0">
                            <tr>
                                <td class="p-3" colspan=2 >
                                    <b>EARNINGS</b>
                                </td>
                                <td class="p-3" colspan=2>
                                    <b>DEDUCTIONS</b>
                                </td>
                                <td class="p-3" style="width: 260px;">
                                    <b>NET AMOUNT PAYABLE</b>
                                </td>
                            </tr>
                            @foreach($payroll as $loop_count => $payroll_log)
                                <tr>
                                    <td class="p-3" colspan="2">
                                        Salary {{date('"F Y"', strtotime($payroll_log->to_date))}}
                                        <span class="float-right">Rs. {{intval($payroll_log->user->employee->net_salary - ($payroll_log->allowance ? $payroll_log->allowance['details']['Medical']:0))}}</span>
                                        <br>
                                        @if($payroll_log->allowance != 0)
                                            @foreach($payroll_log->allowance['details'] as $index => $allowance)
                                                {{$index}} <span class="float-right">Rs. {{intval($allowance)}}</span><br>
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class="p-3" colspan="2">
                                        @foreach($payroll_log->deductions['details'] as $index => $deduction)
                                            {{$index}} <span class="float-right">Rs. {{intval($deduction)}}</span><br>
                                        @endforeach
                                            @if($loop_count == 0)
                                                <span>Other Deductions <span class="float-right">Rs.<span id="assets_deduction"> {{ ($final_settlement == null ? 0 : $final_settlement->asset_deduction_amount) }}</span></span></span>
                                            @endif
                                    </td>
                                    @if($loop_count != 0 || count($payroll)==1)
                                        <td class="p-3" rowspan="2" style="rowspan: 2;">
                                            <h1 class="float-right pr-5">Rs. <span class="total_salary_id">{{intval($total_salary - ($payroll_log->allowance ? $payroll_log->allowance['details']['Medical']:0))}}</span></h1>
                                            <input type="hidden" name="salary_paid" id="salary_paid" value="{{intval($total_salary - ($payroll_log->allowance ? $payroll_log->allowance['details']['Medical']:0))}}">
                                        </td>
                                    @else
                                    @endif
                                </tr>
                            @endforeach
                                <tr>
                                    <td  class="p-3" colspan="2">
                                        @if($payroll_log->allowance != 0)
                                            @foreach($last_month_sales['details'] as $index => $allowance)
                                                {{$index}} <span class="float-right">Rs. {{intval($allowance)}}</span><br>
                                            @endforeach
                                        @endif
                                    </td>
                                </tr>
                            <tr>
                                <td colspan="2">
                                    <b class="p-3" >
                                        Total: <span class="float-right"> {{intval($total_earnings)}}</span>
                                    </b>
                                </td>
                                <td colspan="2">
                                    <b  class="p-3">
                                        Total: <span class="float-right" id="total_deductions">{{intval($total_deductions)}}</span>
                                    </b>
                                </td>
                            </tr>
                        </table>
                        </div>

                    </div>
                </div>
                <div class="m-separator m-separator--dashed m-separator--sm pt-3"></div>
                <div class="row mx-1">
                        <div class="col-4 form-check p-3" style="border: 2px solid #000000 !important;">
                                <br><br><br><br><br><br><br><br><br>
                                <p>______________________________</p>
                            <p><b>HR signatures</b></p>
                        </div>
                        <div class="col-8 form-check p-3" style="border: 2px solid #000000; border-left: 0px !important;">
                            <p class="text-center">I have received <b>(Rs. <span class="total_salary_id"></span>)</b> as full & final settlement of my dues.
                                I have no claim whatsoever Against the Atlantis BPO Solutions Private Limited
                                    in respect of my employment or Resignation/Termination/Dismissal.</p>
                            <br><br><br><br><br>
                            <p>________________________</p>
                            <p><b>Recipient :</b> {{ $separation->user->full_name }}
                            <span class="float-right"><b>Dated :</b> {{get_date()}}</span></p>
                        </div>
                </div>
                <div class="pt-3">
                    @if(!$final_settlement)
                    <button type="submit" class="btn btn-success float-right px-4">Save</button>
                    @else
                        <button onclick="print_div('emp_separation_form')" type="button" class="btn btn-primary float-right px-4 mx-2">Print</button>
                    @endif
                </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('footer_scripts')
    <style>
        .col_border {
            border:1px solid black;
            border-style: solid;
            outline: 1px solid black;
            outline-style: solid;
        }
    </style>
    <script type='text/javascript'>
        function save_final_settlement(){
            let data = new FormData($('#final_settlement_form')[0]);
            let a = function() {
                window.location.reload();
            }
            let arr = [a];
            call_ajax_with_functions('', '{{route('save_final_settlement')}}', data, arr);
        }
        $(document).ready(function(){
            let total_salary = <?php echo intval($total_salary)?>;
            let total_deductions = <?php echo intval($total_deductions)?>;
            let total_asset_value =  <?php echo ($final_settlement == null ? 0:$final_settlement->asset_deduction_amount) ?>;
            $('.total_salary_id').html(total_salary-total_asset_value);
            $('#salary_paid').val(total_salary-total_asset_value);
            $('#asset_deduction_amount').val(total_asset_value);
            $('#total_deductions').html(total_deductions+total_asset_value);
            // Check or Uncheck All checkboxes
            $("#assets_not_returned").change(function(){
                let data_asset = [];
                let checked = $(this).is(':checked');
                if(checked){
                    $(".asset_checkbox").each(function(){
                        $(this).prop("checked",true);
                        total_asset_value += $(this).data('price');
                    });
                }else{
                    $(".asset_checkbox").each(function(){
                        $(this).prop("checked",false);
                        total_asset_value = 0;
                    });
                }
                $('#asset_deduction_amount').val(total_asset_value);
                $('#assets_deduction').html(total_asset_value);
                $('.total_salary_id').html(total_salary-total_asset_value);
                $('#salary_paid').val(total_salary-total_asset_value);
                $('#total_deductions').html(total_deductions+total_asset_value);
            });
            // Changing state of CheckAll asset_checkbox
            $(".asset_checkbox").click(function(){
                if($(".asset_checkbox").length == $(".asset_checkbox:checked").length) {
                    $("#assets_not_returned").prop("checked", true);
                } else {
                    $("#assets_not_returned").prop("checked", false);
                }
            });
            ///////////////////////////////////////////////////
            $(".asset_checkbox").click(function(){
                let checked = $(this).is(':checked');
                if(checked){
                    total_asset_value += $(this).data('price');
                }else{
                    total_asset_value -= $(this).data('price');
                }
                $('#asset_deduction_amount').val(total_asset_value);
                $('#assets_deduction').html(total_asset_value);
                $('.total_salary_id').html(total_salary-total_asset_value);
                $('#salary_paid').val(total_salary-total_asset_value);
                $('#total_deductions').html(total_deductions+total_asset_value);
            });
        });
    </script>
@endsection
