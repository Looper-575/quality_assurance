<table class="table datatable table-striped" id="payroll_search_table">
    <thead>
    <tr>
        <th>Employee Name</th>
        <th>Salary Month</th>
        <th>EOBI Deduction</th>
        <th>Income Tax Deduction</th>
        <th>Other Deductions</th>
        <th>Basic Salary</th>
        <th>Gross Salary</th>
        <th>Account Number</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($payslips as $pay)
        <tr>
            <td>{{ $pay->user->full_name }}</td>
            <td>{{ date('M-Y', strtotime($pay->salary_month)) }}</td>
            <td>{{ $pay->eobi }}</td>
            <td>{{ $pay->income_tax }}</td>
            <td>{{ $pay->deduction_amount }}</td>
            <td>{{$pay->basic_salary}}</td>
            <td>{{intval($pay->gross_salary)}}</td>
            <td>{{$pay->user->employee->account_number}}</td>
            <td>
                <div class="btn-group btn-group-sm">
                    <button title="Reject" class="btn btn-primary" onclick="view_payroll(this);" value="{{$pay->payroll_id}}"><i class="fa fa-eye"></i></button>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
