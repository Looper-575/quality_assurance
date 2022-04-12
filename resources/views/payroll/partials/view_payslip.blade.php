<!-- View Modal -->
<div class="container-fluid" id="payslip_print">
    <table style="width: 100%!important;">
        <tbody>
        <tr>
            <td colspan="2">
                <h5 class="text-center">Payslip for the period of {{ date('M-Y', strtotime($payslip->salary_month)) }}</h5></td>
        </tr>
        <tr>
            <td><p class="">Employee:  {{$payslip->user->full_name}}</p></td>
            <td><p class="">Gross Salary:  {{$payslip->gross_salary}}</p></td>
        </tr>
        <tr>
            <td><p class="">Department:  {{$payslip->user->department->title}}</p></td>
            <td><p class="">Role:  {{$payslip->user->role->title}}</p></td>
        </tr>
        <tr>
            <td><h6>Deductions</h6></td>
            <td><h6>Allowances</h6></td>
        </tr>
        <tr>
            <td>
                @foreach($payslip->payroll_deduction as $deduction)
                    <p class="">{{$deduction->title}}:  {{$deduction->amount}}</p>
                @endforeach
            </td>
            <td>
                @foreach($payslip->payroll_allowance as $allowance)
                    <p class="">{{$allowance->title}}:  {{$allowance->amount}}</p>
                @endforeach
            </td>
        </tr>
        </tbody>
    </table>
    <button onclick="print_payslip()" class="btn btn-primary float-right" id="print_btn_id"> Print</button>
</div>
