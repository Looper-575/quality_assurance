<!-- View Modal -->
<div class="container-fluid" id="payslip_print" style="margin-top: -10px;overflow-y: auto;overflow-x: hidden;height: 300px;">
    <table class="table" style="width: 100%">
        <tr style="text-align:center; font-weight:600;">
            <td colspan='4'>
                <h4>Atlantis BPO Solutons</h4>
            </td>
        </tr>
        <tr style="text-align:center;">
            <td colspan="4">
                <h5 class="text-center">Payslip for the period of {{ date('M-Y', strtotime($payslip->salary_month)) }}</h5>
            </td>
        </tr>
        <tr>
            <th>Personel NO:</th>
            <td>{{$payslip->user->user_id}}</td>
            <th>Name</th>
            <td>{{$payslip->user->full_name}}</td>
        </tr>
        <!------2 row---->
        <tr>
            <th>Department</th>
            <td>{{$payslip->user->department->title}}</td>
            <th>Role</th>
            <td>{{$payslip->user->role->title}}</td>
        </tr>
    </table>
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
            <th><strong>Gross Allowance</strong></th>
            <th>{{$allo}}</th>
        </tr>
    </table>
    <br>
    <table class="table table-bordered table-striped" style="width: 100%">
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
            <th><strong>Gross Deductions</strong></th>
            <th>{{$ded}}</th>
        </tr>
    </table>
    <div class="row">
        <div class="col-6 offset-8">
            <h6> Gross Salary
                {{$payslip->gross_salary}}
            </h6>
        </div>
    </div>
    <br>
</div>
<button onclick="print_div('payslip_print')" class="btn btn-primary float-right" id="print_btn_id"> Print</button>
