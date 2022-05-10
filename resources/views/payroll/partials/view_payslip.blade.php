<!-- View Modal -->
<div class="container-fluid" id="payslip_print" style="margin-top: -10px;overflow-y: auto;overflow-x: hidden;height: 300px;">
    <div class="row text-center">
        <img alt="Atlantis BPO Solutons" src="{{asset('assets/img/logo-full.png')}}" width="200">
        <div class="col-12">
            <h4>Atlantis BPO Solutons</h4>
            <h5 class="text-center py-3">Payslip for the period of {{ date('M-Y', strtotime($payslip->salary_month)) }}</h5>
        </div>
    </div>
    <div class="row">
        <div class="col-3"><p>Name:</p></div>
        <div class="col-3"><p>{{$payslip->user->full_name}}</p></div>
        <div class="col-3"><p>Contact No:</p></div>
        <div class="col-3"><p>{{$payslip->user->contact_number}}</p></div>
        <div class="col-3"><p>Department:</p></div>
        <div class="col-3"><p>{{$payslip->user->department->title}}</p></div>
        <div class="col-3"><p>Designation:</p></div>
        <div class="col-3"><p>{{$payslip->user->employee->designation}}</p></div>
        <div class="col-3"><p>Basic Salary:</p></div>
        <div class="col-3"><p>{{intval($payslip->basic_salary)}}</p></div>
        <div class="col-3"><p>Working Days:</p></div>
        <div class="col-3"><p>{{$payslip->working_days - $payslip->holiday_count - $payslip->leaves - $payslip->attendance_not_marked}}</p></div>
        <div class="col-3"><p>Holidays:</p></div>
        <div class="col-3"><p>{{$payslip->holiday_count}}</p></div>
        <div class="col-3"><p>Absents:</p></div>
        <div class="col-3"><p>{{$payslip->absents + $payslip->attendance_not_marked}}</p></div>
        <div class="col-3"><p>Leaves:</p></div>
        <div class="col-3"><p>{{$payslip->leaves}}</p></div>
        <div class="col-3"><p>Lates:</p></div>
        <div class="col-3"><p>{{$payslip->lates}}</p></div>
        <div class="col-3"><p>Half Day:</p></div>
        <div class="col-3"><p>{{$payslip->half_leaves}}</p></div>
    </div>
    <br/>
    <table class="table table-bordered table-striped" style="width: 100%">
        <tr>
            <th>Allowance</th>
            <th>Amount</th>
        </tr>
        <?php $allo = 0; ?>
        @foreach($payslip->payroll_allowance as $allowance)
        <tr>
                <td>{{$allowance->title}}</td>
                <td>{{$allowance->amount}}</td>
            <?php $allo += $allowance->amount; ?>
        </tr>
        @endforeach
        <tr>
            <th><strong>Total Allowance</strong></th>
            <th>{{$allo}}</th>
        </tr>
        <tr><td colspan="2"></td></tr>
        <tr>
            <th>Deductions</th>
            <th>Amount</th>
        </tr>
        <?php $ded = 0; ?>
        @foreach($payslip->payroll_deduction as $deduction)
        <tr>
                <td>{{$deduction->title}}</td>
                <td>{{$deduction->amount}}</td>
            <?php $ded += $deduction->amount; ?>
        </tr>
        @endforeach
        <tr>
            <th><strong>Total Deductions</strong></th>
            <th>{{$ded}}</th>
        </tr>
        <tr>
            <td colspan="2"></td>
        </tr>
        <tr style="border: 0px !important;">
            <td style="border-left: 0px !important; border-bottom: 0px !important;"><h4 class="float-right">Net Salary:</h4></td>
            <td ><h4>{{intval($payslip->gross_salary)}}</h4></td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <p><small>“This document is computer generated and does not require any signature or the Company’s stamp in order to be considered valid”.</small></p>
</div>
<button onclick="print_div('payslip_print')" class="btn btn-primary float-right" id="print_btn_id"> Print</button>
