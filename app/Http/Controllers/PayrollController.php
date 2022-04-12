<?php
namespace App\Http\Controllers;
use App\Models\Allowance;
use App\Models\AttendanceLog;
use App\Models\Deduction;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\Payroll;
use App\Models\PayrollAllowance;
use App\Models\PayrollDeduction;
use App\Models\TaxDeduction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class PayrollController extends Controller
{
    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function create_payroll()
    {
        $data['page_title'] = "Create Payroll - Atlantis BPO CRM";
        $data['users'] = User::has('employee')->where('user_type', 'Employee')->where('status', 1)->get();
        return view('payroll.index', $data);
    }

    public function payroll_details()
    {
        $data['page_title'] = "Payroll - Atlantis BPO CRM";
        $data['payroll'] = Payroll::with('user', 'added', 'payroll_deduction', 'payroll_allowance')->whereStatus(1)->whereHrApproved(2)->get();
        return view('payroll.payroll_details', $data);
    }

    public function generate_pay_role(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'year_month' => 'required',
            'user' => 'required',
        ]);
        if($validator->passes()) {
            $month = date("m",strtotime($request->year_month));
            $year = date("Y",strtotime($request->year_month));
            if($request->user[0] == 0) {
                $user_ids = User::has('Employee')->where('user_type', 'Employee')->where('status', 1)->get()->pluck('user_id')->toArray();
            } else {
                $user_ids = $request->user;
            }
            $form_date = date($year.'-'.$month.'-01');
            $to_date = date("Y-m-t", strtotime($request->year_month));
            $holiday_count = $this->check_holidays($form_date, $to_date);
            $endDate = $to_date;
            $startDate = $form_date;
            $working_days = working_days($startDate, $endDate);
            $payroll = Payroll::where('salary_month', date("Y-m-d", strtotime($request->year_month)))->whereStatus(1)
                ->where(function ($query1) {
                    return $query1->where('hr_approved', 1)
                        ->orWhere('hr_approved', 2);
                })->get()->pluck('user_id')->toArray();
            foreach ($payroll as $user_payroll){
                if (($key = array_search($user_payroll, $user_ids)) !== false) {
                    unset($user_ids[$key]);
                }
            }
            $attendance_list = AttendanceLog::with('user.employee')->select(DB::raw('sum(late) as `lates`, sum(absent) as `absents`, sum(on_leave) as `leaves` , sum(applied_leave) as `applied_leave`, sum(half_leave) as `half_leaves` , count(user_id) as `attendance_marked` , MONTH(attendance_date) month'), 'user_id')
                ->whereIn('user_id', $user_ids)
                ->whereYear('attendance_date', $year)
                ->whereMonth('attendance_date', $month)
                ->groupBy('month', 'user_id')
                ->get();
            for ($i=0; $i<count($attendance_list); $i++){
                $attendance_list[$i]->allowance = $this->employee_allowance($attendance_list[$i]->user->user_id, $attendance_list[$i]->leaves, $attendance_list[$i]->absents, $form_date);
                $attendance_list[$i]->deductions = $this->employee_deduction($attendance_list[$i]->user->employee, $attendance_list[$i], $attendance_list[$i]->allowance['play']);
            }
            $data['attendance_list'] = $attendance_list;
            $data['holiday_count'] = $holiday_count;
            $data['working_days'] = $working_days;
            $data['month'] = $form_date;
            $response['status'] = "Success";
            $response['result'] = "Pay Role Generated Successfully";
        } else{
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return view('payroll.partials.payroll' , $data);
    }

    public function payroll_save(Request $request){
        DB::beginTransaction();
        try {
            foreach ($request['user_id'] as $key => $value){
            $model = new Payroll;
            $model->user_id = $value;
            $model->salary_month = $request['salary_month'][$key];
            $model->attendance_marked = $request['attendance_marked'][$key];
            $model->attendance_not_marked = $request['attendance_not_marked'][$key];
            $model->leaves = $request['leaves'][$key];
            $model->half_leaves = $request['half_leaves'][$key];
            $model->lates = $request['lates'][$key];
            $model->absents = $request['absents'][$key];
            $model->leaves_of_late = $request['leaves_of_late'][$key];
            $model->leaves_of_half = $request['leaves_of_half'][$key];
            $model->presents = $request['presents'][$key];
            $model->deduction_bucket = $request['deduction_bucket'][$key];
            $model->basic_salary = $request['basic_salary'][$key];
            $model->gross_salary = $request['gross_salary'][$key];
            $model->added_by = Auth::user()->user_id;
            $model->save();
            $payroll_id = $model->payroll_id;
            if($request->has('deduction_title') == true) {
                foreach ($request['deduction_title'][$value] as $index => $deductions) {
                    $pay_ded = new PayrollDeduction();
                    $pay_ded->payroll_id = $payroll_id;
                    $pay_ded->title = $deductions;
                    $pay_ded->amount = $request['deduction_value'][$value][$index];
                    $pay_ded->save();
                }
            }
            if($request->has('allowance_title') == true) {
                foreach ($request['allowance_title'][$value] as $index => $deductions) {
                    $pay_ded = new PayrollAllowance();
                    $pay_ded->payroll_id = $payroll_id;
                    $pay_ded->title = $deductions;
                    $pay_ded->amount = $request['allowance_value'][$value][$index];
                    $pay_ded->save();
                }
            }
        }
        } catch (\Exception $ex){
            DB::rollBack();
            $response['status'] = "Failure";
            $response['result'] = "Server Errors please try again!";
        } finally {
            $response['status'] = "Success";
            $response['result'] = "Saved Successfully";
            DB::commit();
        }
        return response()->json($response);
    }

    public function payroll_reject(Request $request){
        Payroll::where('payroll_id', $request->id)->update([
            'status' => 0,
            'hr_approved' => 3,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Rejected Successfully";
        return response()->json($response);
    }

    public function payroll_approve(Request $request){
        Payroll::where('payroll_id', $request->id)->update([
            'status' => 1,
            'hr_approved' => 1,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Approved Successfully";
        return response()->json($response);
    }

    private function check_holidays($form_date, $to_date)
    {
        $check_holidays = Holiday::whereBetween('date_from', [$form_date, $to_date])->orWhereBetween('date_to', [$form_date, $to_date])->get();
        $holiday_count = 0;
        foreach ($check_holidays as $day){
            if($day->date_from >= $form_date){
                $from = $day->date_from;
            } else {
                $from = $form_date;
            }
            if($day->date_to <= $to_date){
                $to = $day->date_to;
            } else {
                $to = $to_date;
            }
            $holiday_count = 1 + $holiday_count + ((strtotime($to) - strtotime($from)) / (60 * 60 * 24));
        }
        return $holiday_count;
    }

    public function deduction()
    {
        $data['page_title'] = "Deduction - Atlantis BPO CRM";
        $data['deductions'] = Deduction::where('status', 1)->get();
        $data['departments'] = Department::where('status', 1)->get();
        return view('payroll.deduction' , $data);
    }

    public function save_deduction_form(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'type' => 'required',
            'department_id' => 'required',
            'role_id' => 'required',
            'value' => 'required',
        ]);
        if($validator->passes()) {
            $model = Deduction::updateOrCreate([
                'deduction_id' => $request->deduction_id,
            ], [
                'title' => $request->title,
                'type' => $request->type,
                'department_id' => $request->department_id,
                'role_id' => $request->role_id,
                'value' => $request->value,
                'added_by' => Auth::user()->user_id,
            ]);
            $response['status'] = "Success";
            $response['result'] = "Deduction Added Successfully";
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    public function deduction_delete(Request $request)
    {
        Deduction::where('deduction_id', $request->id)->update(['status' => 0]);
        $response['status'] = "Success";
        $response['result'] = "Deduction Deleted Successfully";
        return response()->json($response);
    }

    public function allowance()
    {
        $data['page_title'] = "Allowance - Atlantis BPO CRM";
        $data['allowances'] = Allowance::where('status', 1)->get();
        $data['departments'] = Department::where('status', 1)->get();
        return view('payroll.allowance' , $data);
    }

    public function save_allowance_form(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => 'required',
            'type' => 'required',
            'department_id' => 'required',
            'role_id' => 'required',
            'value' => 'required',
        ]);
        if($validator->passes()) {
            $provider = '';
            if (isset($request->provider)) {
                if ($request->provider[0] == 'All') {
                    $provider = 'all';
                } else {
                    $provider = implode(",", $request->provider);
                }
            }
            $model = Allowance::updateOrCreate([
                'allowance_id' => $request->allowance_id,
            ], [
                'title' => $request->title,
                'type' => slugify($request->type),
                'allowance_value' => $request->value,
                'department_id' => $request->department_id,
                'role_id' => $request->role_id,
                'bench_mark_type' => slugify($request->bench_mark_type),
                'bench_mark_criteria' => slugify($request->bench_mark_criteria),
                'bench_mark_value' => $request->bench_mark_value,
                'provider' => $provider,
                'added_by' => Auth::user()->user_id,
            ]);
            $response['status'] = "Success";
            $response['result'] = "Allowance Added Successfully";
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    public function allowance_delete(Request $request)
    {
        Allowance::where('allowance_id', $request->id)->update(['status' => 0]);
        $response['status'] = "Success";
        $response['result'] = "Allowance Deleted Successfully";
        return response()->json($response);
    }

    public function get_department_role(Request $request)
    {
        $model = User::with('role')->where('department_id', $request->department_id)->groupBy('role_id')->get();
        return response()->json($model);
    }

    public function tax_deduction()
    {
        $data['page_title'] = "Tax Deduction - Atlantis BPO CRM";
        $data['deductions'] = TaxDeduction::whereStatus( 1)->get();
        $data['departments'] = Department::where('status', 1)->get();
        return view('payroll.tax_deduction' , $data);
    }

    public function save_tax_deduction_form(Request $request)
    {
        if($request->tax_deduction_id != null){
            $model = TaxDeduction::where('tax_deduction_id', $request->tax_deduction_id)->first();
            $model->from = $request->from[0];
            $model->to = $request->to[0];
            $model->value =$request->value[0];
            $model->modified_by = Auth::user()->user_id;
            $model->save();
            $response['status'] = "Success";
            $response['result'] = "Tax Deduction Updated Successfully";
        } else{
            foreach ($request->from as $key => $item){
                $model = new TaxDeduction();
                $model->from = $request->from[$key];
                $model->to = $request->to[$key];
                $model->value =$request->value[$key];
                $model->added_by = Auth::user()->user_id;
                $model->save();
            }

            $response['status'] = "Success";
            $response['result'] = "Tax Deduction Added Successfully";
        }
        return response()->json($response);
    }

    public function tax_deduction_delete(Request $request)
    {
        TaxDeduction::where('tax_deduction_id', $request->id)->update(['status' => 0]);
        $response['status'] = "Success";
        $response['result'] = "Tax Deduction Deleted Successfully";
        return response()->json($response);
    }

    public function payroll_edit($payroll_id)
    {
        $data['page_title'] = "Edit Payroll - Atlantis BPO CRM";
        $data['payroll'] = Payroll::with('user', 'added', 'payroll_deduction', 'payroll_allowance')
            ->wherePayrollId($payroll_id)->whereStatus(1)->whereHrApproved(2)->first();
        $form_date = $data['payroll']->salary_month;
        $to_date = date("Y-m-t", strtotime($data['payroll']->salary_month));
        $endDate = $to_date;
        $startDate = $form_date;
        $data['attendance'] =  AttendanceLog::with('user')
            ->whereBetween('attendance_date', [$startDate, $endDate])
            ->where('user_id', $data['payroll']->user_id)->get();
        return view('payroll.partials.payroll_edit', $data);
    }

    public function payroll_save_edit(Request $request)
    {
        $deduction_val = 0;
        foreach ($request->deduction as $index => $deductions){
            PayrollDeduction::where('id', $index)->update([
                'amount' => $deductions,
            ]);
            $deduction_val += $deductions;
        }
        $allowance_val = 0;
        if($request->has('allowance') == true){
            foreach ($request->allowance as $index => $allowance){
                PayrollAllowance::where('id', $index)->update([
                    'amount' => $allowance,
                ]);
                $allowance_val += $allowance;
            }
        }
        $gross_salary = $allowance_val + $request->basic_salary - $deduction_val;
        if($request->type  == 'save'){
            $hr_approved = 2;
            $status = 1;
        } elseif ($request->type == 'approve'){
            $hr_approved = 1;
            $status = 1;
        } else {
            $hr_approved = 3;
            $status = 0;
        }
        Payroll::where('payroll_id', $request->payroll_id)->update([
            'status' => $status,
            'gross_salary' => $gross_salary,
            'hr_approved' => $hr_approved,
        ]);
        $response['status'] = "Success";
        $response['result'] = 'Payroll Updated Successfully';
        return response()->json($response);
    }

    public function payslips()
    {
        $data['page_title'] = "Payslips - Atlantis BPO CRM";
        if(Auth::user()->role_id == 1){
            $data['payslips'] = Payroll::whereStatus(1)->whereHrApproved(1)->orderBy('payroll_id', 'desc')->get();
        } else {
            $data['payslips'] = Payroll::whereUserId(Auth::user()->user_id)->whereStatus(1)->whereHrApproved(1)->orderBy('payroll_id', 'desc')->get();
        }
        return view('payroll.payslips', $data);
    }

    public function view_payslip(Request $request)
    {
        $data['payslip'] = Payroll::with('user', 'user.department', 'user.role', 'payroll_deduction', 'payroll_allowance')
            ->wherePayrollId($request->id)->whereStatus(1)
            ->whereHrApproved(1)
            ->orderBy('payroll_id', 'desc')->first();
        return view('payroll.partials.view_payslip', $data);
    }

    public function convenience_allowance()
    {
        $data['page_title'] = "Convenience Allowance - Atlantis BPO CRM";
        $data['user_convenience'] = User::with('employee')
            ->whereHas('employee', function($q) {
            $q->where('conveyance_allowance', 1);
        })
            ->whereStatus(1)->get();
        $data['users'] = User::with('employee')
            ->whereHas('employee', function($q) {
            $q->where('conveyance_allowance', 0);
        })
            ->whereStatus(1)->get();

        return view('payroll.convenience_allowance', $data);
    }

    public function add_convenience_allowance(Request $request)
    {

        Employee::where('user_id', $request->user_id)->update([
            'conveyance_allowance' => 1,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Conveyance Allowance Added Successfully";
        return response()->json($response);
    }

    public function remove_convenience_allowance(Request $request)
    {
        Employee::where('user_id', $request->id)->update([
            'conveyance_allowance' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Conveyance Allowance Removed Successfully";
        return response()->json($response);
    }

    private function employee_deduction($user, $attendace_log, $allowance)
    {
        $fixed_deduction = \App\Models\Deduction::select(DB::raw('sum(value) as fixed_deduction'))
            ->where('type', 'Fixed')
            ->where(function ($query) use($user) {
                return $query->where('department_id', $user->department_id)
                    ->orWhere('department_id',0);
            })
            ->where(function ($query1) use($user) {
                return $query1->where('role_id', $user->role_id)
                    ->orWhere('role_id',0);
            })
            ->whereStatus(1)->get();
        $fixed_deduction = $fixed_deduction[0]['fixed_deduction'];
        $pct_deduction = \App\Models\Deduction::select(DB::raw('sum(value) as pct_deduction'))
            ->where('type', 'Percentage')
            ->where(function ($query2) use($user) {
                return $query2->where('department_id', $user->department_id)
                    ->orWhere('department_id',0);
            })
            ->where(function ($query3) use($user) {
                return $query3->where('role_id', $user->role_id)
                    ->orWhere('role_id',0);
            })
            ->whereStatus(1)->get();
        $pct_deduction = $user->net_salary *  $pct_deduction[0]['pct_deduction'] / 100;

        $late_absents = ($attendace_log->lates/3>=1) ? intval($attendace_log->lates/3) : 0;
        $half_leavs_absents = ($attendace_log->half_leaves/2>=1) ? intval($attendace_log->half_leaves/2) : 0;
        $leaves_bucket = DB::table('leave_bucket_view')->where('user_id',$user->user_id)->first();
        $total_leaves = $late_absents+$half_leavs_absents;
        if($leaves_bucket != null){
            $remaining_casual_sick = ($leaves_bucket->casual_bucket+$leaves_bucket->sick_bucket)-(($leaves_bucket->casual+$leaves_bucket->sick)-$leaves_bucket->payroll_deductions);
            if($remaining_casual_sick < ($leaves_bucket->casual_bucket+$leaves_bucket->sick_bucket)){
                if($remaining_casual_sick >= $total_leaves){
                    $half_and_late_deductions=0;
                } else if($remaining_casual_sick > 0) {
                    $half_and_late_deductions = $total_leaves-$remaining_casual_sick;
                }
            } else {
                $half_and_late_deductions = $total_leaves;
            }
        } else {
            $half_and_late_deductions = $total_leaves;
        }
        // if $half_and_late_deductions > 0
        $leaves_deducted_from_bucket=0;
        if($half_and_late_deductions > 0 && $half_and_late_deductions < $total_leaves) {
            $leaves_deducted_from_bucket = $total_leaves - $half_and_late_deductions;
        } else if($half_and_late_deductions == 0) {
            $leaves_deducted_from_bucket = $total_leaves;
        }
        // deduction_in_salary  AND deduction_from_bucket
        $daily_wage = $user->net_salary/22;
        $absent_deductions = $daily_wage*$attendace_log->absents;
        $half_and_late_deductions_amount = $daily_wage*$half_and_late_deductions;
        $total_absents_deduction = $absent_deductions+$half_and_late_deductions_amount;
        $deduction_details = \App\Models\Deduction::where('type', '!=', 'convenience')
            ->where(function ($query) use($user) {
                return $query->where('department_id', $user->department_id)
                    ->orWhere('department_id',0);
            })
            ->where(function ($query1) use($user) {
                return $query1->where('role_id', $user->role_id)
                    ->orWhere('role_id',0);
            })
            ->whereStatus(1)->get()->pluck('title', 'value')->toArray();
        // calculating tax
        $tax_deduction_val = $this->calculate_income_tax($user, $allowance);
        $deduction_details[$tax_deduction_val] = 'Income Tax';
        $deduction_details[$total_absents_deduction] = 'Absentees Deductions';
        $convenience_deduction = \App\Models\Deduction::select(DB::raw('sum(value) as convenience'))->where('type', 'convenience')->whereStatus(1)->get();
        if($user->conveyance_allowance == 1){
            $convenience_deduction = $convenience_deduction[0]['convenience'];
            $deduction_details[$convenience_deduction] = 'Convenience Allowance';
        } else {
            $convenience_deduction = 0;
        }
        $total_deductions = $convenience_deduction + $tax_deduction_val + $pct_deduction + $fixed_deduction + $total_absents_deduction;
        return [
            'total_deductions' => $total_deductions,
            'deduction_bucket' => $leaves_deducted_from_bucket,
            'details' => $deduction_details,
            'leaves_of_late' => $late_absents,
            'leaves_of_half' => $half_leavs_absents
        ];
    }

    private function employee_allowance($user_id, $num_of_leave, $num_of_absent, $month)
    {
        $user = User::whereUserId($user_id)->whereStatus(1)->first();
        $dependability_allowance = \App\Models\Allowance::where('type', 'dependability')
            ->where(function ($query) use($user) {
                return $query->where('department_id', $user->department_id)
                    ->orWhere('department_id',0);
            })
            ->where(function ($query1) use($user) {
                return $query1->where('role_id', $user->role_id)
                    ->orWhere('role_id',0);
            })
            ->whereStatus(1)->get();
        $total_leaves = $num_of_leave + $num_of_absent;
        $details = array();
        $dependability = 0;
        foreach ($dependability_allowance as $depend){
            $dependability = $depend->allowance_value;
            if ($total_leaves == 0) {
                $dependability = $dependability;
                $details[$depend->title] = $dependability;
            } else if ($total_leaves == 1) {
                $dependability = $dependability / 2;
                $details[$depend->title] = $dependability;
            } else if ($total_leaves > 1) {
                $dependability = 0;
                $details[$depend->title] = $dependability;
            }
        }
        $year = date('Y', strtotime($month));
        $change_month = date('m', strtotime($month));
        if((0 == $year % 4) & (0 != $year % 100) | (0 == $year % 400))
        {
            $from_date = date('Y-m-29',(strtotime ( '-1 month' , strtotime ( $month) ) ));
            $to_date = date('Y-m-29',(strtotime ( $month)));
        } else {
            if($change_month == 02){
                $from_date = date('Y-m-29',(strtotime ( '-1 month' , strtotime ( $month) ) ));
                $to_date = date('Y-m-28',(strtotime ( $month)));
            } elseif ($change_month == 03){
                $from_date = date('Y-m-28',(strtotime ( '-1 month' , strtotime ( $month) ) ));
                $to_date = date('Y-m-29',(strtotime ( $month)));
            } else {
                $to_date = date('Y-m-29',(strtotime ( $month)));
                $from_date = date('Y-m-29',(strtotime ( '-1 month' , strtotime ( $month) ) ));
            }
        }
        $from_date = $from_date.' 17:00:00';
        $to_date = $to_date.' 17:00:00';
        $rgu_bench_mark_allowance = \App\Models\Allowance::select('*','department_id', 'role_id')
            ->where('type', 'rgu-bench-mark')
            ->where(function ($query) use ($user){
                $query->where('department_id', $user->department_id)
                    ->orWhere('department_id', 0);
            })
            ->whereStatus(1)->get();
        $rgu_bench_mark = 0;
        foreach ($rgu_bench_mark_allowance as $rgu){
            if($rgu->role_id == 0 || $user->role_id == $rgu->role_id){
                $sales = get_user_total_rgu($from_date, $to_date, $user->user_id, $rgu->provider);
                if($rgu->bench_mark_type == 'rgu'){
                    $tem_val = 0;
                    if($sales['total_rgu'] >= $rgu->bench_mark_value){
                        if($rgu->bench_mark_criteria == 'fixed'){
                            $tem_val += $rgu->allowance_value;
                            $rgu_bench_mark += $rgu->allowance_value;
                        } else {
                            $val = intdiv($sales['total_rgu'],$rgu->bench_mark_value);
                            $rgu_bench_mark += $val * $rgu->allowance_value;
                            $tem_val += $val * $rgu->allowance_value;
                        }
                        $details[$rgu->title] = $tem_val;
                    }
                }
                if($rgu->bench_mark_type == 'single-play'){
                    $play = 1;
                    $single_play = get_user_play($user->user_id,$from_date, $to_date, $rgu->provider, $play);
                    if($single_play >= $rgu->bench_mark_value){
                        $tem_val = 0;
                        if($rgu->bench_mark_criteria == 'fixed'){
                            $rgu_bench_mark += $rgu->allowance_value;
                            $tem_val += $rgu->allowance_value;
                        } else {
                            $val = intdiv($single_play, $rgu->bench_mark_value);
                            $rgu_bench_mark += $val * $rgu->allowance_value;
                            $tem_val += $val * $rgu->allowance_value;
                        }
                        $details[$rgu->title] = $tem_val;
                    }
                }
                if($rgu->bench_mark_type == 'double-play'){
                    $play = 2;
                    $single2 = get_user_play($user->user_id,$from_date, $to_date, $rgu->provider, $play);
                    if($single2 >= $rgu->bench_mark_value){
                        $tem_val = 0;
                        if($rgu->bench_mark_criteria == 'fixed'){
                            $rgu_bench_mark += $rgu->allowance_value;
                            $tem_val += $rgu->allowance_value;
                        } else {
                            $val = intdiv($single2,$rgu->bench_mark_value);
                            $rgu_bench_mark += $val * $rgu->allowance_value;
                            $tem_val += $val * $rgu->allowance_value;
                        }
                        $details[$rgu->title] = $tem_val;
                    }
                }
                if($rgu->bench_mark_type == 'triple-play'){
                    $play = 3;
                    $single3 = get_user_play($user->user_id,$from_date, $to_date, $rgu->provider, $play);
                    if($single3 >= $rgu->bench_mark_value){
                        $tem_val = 0;
                        if($rgu->bench_mark_criteria == 'fixed'){
                            $rgu_bench_mark += $rgu->allowance_value;
                            $tem_val += $rgu->allowance_value;
                        } else {
                            $val = intdiv($single3,$rgu->bench_mark_value);
                            $rgu_bench_mark += $val * $rgu->allowance_value;
                            $tem_val += $val * $rgu->allowance_value;
                        }
                        $details[$rgu->title] = $tem_val;
                    }
                }
                if($rgu->bench_mark_type == 'mobile'){
                    $play = 'mobile';
                    $mobile_sales = get_user_play($user->user_id,$from_date, $to_date, $rgu->provider, $play);
                    if($mobile_sales >= $rgu->bench_mark_value){
                        $tem_val = 0;
                        if($rgu->bench_mark_criteria == 'fixed'){
                            $rgu_bench_mark += $rgu->allowance_value;
                            $tem_val += $rgu->allowance_value;
                        } else {
                            $val = intdiv($mobile_sales,$rgu->bench_mark_value);
                            $rgu_bench_mark += $val * $rgu->allowance_value;
                            $tem_val += $val * $rgu->allowance_value;
                        }
                        $details[$rgu->title] = $tem_val;
                    }
                }
            }
            $rgu_bench_mark =+ $rgu_bench_mark;
        }
        return [
            'play' => $rgu_bench_mark + $dependability,
            'details' => $details
        ];
    }

    private function calculate_income_tax($user, $allowance)
    {
        if(!$user->net_salary) { die('Salary not available for employee '.$user->full_name); }
        // basic salary plus all allowances
        $salary = $user->net_salary + $allowance;
        // total salary minus medical allowance
        $salary = ($salary)-(($salary*10)/100);
        $annul_salary = $salary*12;
        $tax_deduction = \App\Models\TaxDeduction::whereStatus(1)
            ->where(function ($query) use ($annul_salary) {
                $query->where('from', '<', $annul_salary);
                $query->where('to', '>', $annul_salary);
            })
            ->first();
        if(!$tax_deduction) {die('Tax Slab not found for '.$user->full_name);}
        $amount = $annul_salary - $tax_deduction->from;
        $tax_deduction_val = 0;
        if($tax_deduction->value != 0){
            $tax_deduction_val = (($tax_deduction->amount + ($tax_deduction->value/100) * $amount))/12;
        }
        return $tax_deduction_val;
    }
}
