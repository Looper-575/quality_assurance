<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\Employee;
use App\Models\EmployeeFinalSettlement;
use App\Models\EmployeeSeparation;
use App\Models\Holiday;
use App\Models\ManagerialRole;
use App\Models\Payroll;
use App\Models\PayrollAllowanceSetting;
use App\Models\PayrollDeductionSetting;
use App\Models\PayrollTaxSlab;
use App\Models\Shift;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\UserRole;
use Mockery\Exception;


class EmployeeSeparationController extends Controller
{
    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        $data['page_title'] = "Atlantis BPO CRM - Employee Separations Details List";
        $data['employee_separation'] = EmployeeSeparation::with('user.employee', 'employee_separation')->doesntHave('employee_separation')->where('status',1)->orderBy('separation_id', 'DESC')->get();
        $data['sparated_employee'] = EmployeeSeparation::with('user.employee', 'employee_separation')->has('employee_separation')->where('status',1)->orderBy('separation_id', 'DESC')->get();
        $data['is_admin'] = false;
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['is_admin'] = true;
        }
        return view('employee_separation.employee_separation_list' , $data);
    }
    public function separation_form(Request $request){
        $data['page_title'] = "Employee Separation Form - Atlantis BPO CRM";
        $data['users'] = User::doesnthave('employee_separation')->has('employee')->where('status',1)->where('user_type', 'Employee')->orderBy('user_id', 'DESC')->get();
        if(isset($request->separation_id)){
            $data['separation'] = EmployeeSeparation::with('user.employee', 'user.department')->where('separation_id',$request->separation_id)->first();
            $data['users'] = User::has('employee')->where('user_type', 'Employee')->orderBy('user_id', 'DESC')->get();
        }
        return view('employee_separation.separation_form',$data);
    }
    public function separation_save(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'type' => 'required',
            'notice_period' => 'required',
            'reason' => 'required',
            'general_comments' => 'required',
            'resignation_date' => 'required',
            'separation_date' => 'required',
            'disable_user_account' => 'required',
            'bonus_deduction' => 'required',
        ]);
        if ($validator->passes()) {
            $assets_list_array = array();
            if($request->assets_list != NULL){
                for($i=0, $i_max=count($request->assets_list); $i<$i_max; $i++) {
                    $assets_list_array[] = array("item" => $request->assets_list[$i], "price" => $request->assets_price[$i]);
                }
                $assets_list_array = json_encode($assets_list_array);
            }
            $separation = EmployeeSeparation::where('separation_id', $request->separation_id)->first();
            $separation_data = [
                    'added_by' => Auth::user()->user_id,
                    'user_id' => $request->user_id,
                    'type' => $request->type,
                    'notice_period' => $request->notice_period,
                    'reason' => $request->reason,
                    'general_comments' => $request->general_comments,
                    'resignation_date' => $request->resignation_date,
                    'separation_date' => $request->separation_date,
                    'disable_user_account' => $request->disable_user_account,
                    'bonus_deduction' => $request->bonus_deduction,
                ];
//            if(!empty($assets_list_array)){
                $separation_data['assets_list'] = $assets_list_array;
//            }
            if($separation){
                EmployeeSeparation::where('separation_id', $separation->separation_id)->update($separation_data);
            } else {
                EmployeeSeparation::create($separation_data);
            }
            if($request->disable_user_account == 'Immediate'){
                // change user status to Separated
                User::where('user_id', $request->user_id)->update(['status' => 3]);
                // change user employee record status to Separated
                Employee::where('user_id', $request->user_id)->update(['status' => 3]);
            }else if($request->disable_user_account == 'Upon Separation'){
                // change user employee record status to Notice Period
                Employee::where('user_id', $request->user_id)->update(['status' => 2]);
            }
            $response['status'] = 'Success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'Failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function separation_view(Request $request){
        $data['page_title'] = "Employee Separation Details - Atlantis BPO CRM";
        if(isset($request->separation_id)) {
            $separation = EmployeeSeparation::with('user.employee', 'user.department')->where('separation_id',$request->separation_id)->first();
            $check_payroll = Payroll::whereUserId($separation->user_id)->whereStatus(1)->whereHrApproved(1)->orderBy('payroll_id','DESC')->first();
            if($check_payroll != null){
                $form_date = date('Y-m', strtotime(date("Y-m", strtotime($check_payroll->salary_month)) . "+1 months")).'-01';
            } else {
                $form_date = date('Y-m-d', strtotime($separation->user->employee->joining_date));
            }
            $to_date = $separation->separation_date;
            $attendance_log = AttendanceLog::with('user.employee')->select(DB::raw('sum(late) as `lates`, sum(absent) as `absents`, sum(on_leave) as `leaves` , sum(applied_leave) as `applied_leave`, sum(half_leave) as `half_leaves` , count(user_id) as `attendance_marked` , MONTH(attendance_date) month , YEAR(attendance_date) year , ANY_VALUE(user_id) as user_id'))
                ->where('user_id', $separation->user_id)
                ->whereBetween('attendance_date', [$form_date, $to_date])
                ->groupBy('year', 'month')
                ->get();
            $total_earnings = 0;
            $total_deductions = 0;
            $total_salary = 0;
            $medical_allowance_val = $this->get_payroll_config();
            for ($i=0; $i<count($attendance_log); $i++) {
                $form_date = date($attendance_log[$i]->year.'-'.$attendance_log[$i]->month.'-01');
                $month=date("m",strtotime($separation->separation_date));
                $resignation_month=date("m",strtotime($separation->resignation_date));
                $to_date = date("Y-m-t", strtotime($form_date));
                $attendance_log[$i]->notice_period = 'No';
                if($month == $attendance_log[$i]->month){
                    $attendance_log[$i]->notice_period = 'Yes';
//                    $to_date = $separation->separation_date;
                }

                // get attendance log before resignation date :- we deduct all lates and half leaves form leave bucket before resignation date
                $before_resignation = null;
                if($resignation_month == $attendance_log[$i]->month){
                    $last_payroll = Payroll::where('user_id', $separation->user_id)->latest()->first();
                    if($last_payroll === NULL){
                        $last_carry_forward = 0;
                    } else {
                        $last_carry_forward = $last_payroll->carry_forward_half_day+1;
                    }
                    $before_resignation = AttendanceLog::select(DB::raw('sum(late) as `lates`, sum(absent) as `absents`, sum(on_leave+applied_leave) as `leaves` , sum(applied_leave) as `applied_leave`, sum(half_leave) as `half_leaves` , count(user_id) as `attendance_marked` , MONTH(attendance_date) month , YEAR(attendance_date) year , ANY_VALUE(user_id) as user_id'))
                        ->where('user_id', $separation->user_id)
                        ->whereBetween('attendance_date', [$form_date, $separation->resignation_date])
                        ->groupBy('year', 'month')
                        ->first();
                    $attendance_log[$i]['half_leaves'] = $attendance_log[$i]->half_leaves - $before_resignation->half_leaves;
                    $before_resignation['half_leaves'] = $before_resignation->half_leaves + $last_carry_forward;
                }

                $attendance_log[$i]->to_date = $to_date;
                $attendance_log[$i]->form_date = $form_date;
                $attendance_log[$i]->working_days = working_days($form_date, $to_date);
                $attendance_log[$i]->medical_allowance = ($attendance_log[$i]->user->employee->net_salary*$medical_allowance_val->medical)/100;
                $attendance_log[$i]->holiday_count = $this->check_holidays($form_date, $to_date, $attendance_log[$i]->user->department_id, $attendance_log[$i]->user->user_id);
                if($separation->bonus_deduction == 0){
                    $attendance_log[$i]->allowance = $this->employee_allowance($attendance_log[$i]->user->user_id, $attendance_log[$i], $form_date, $attendance_log[$i]->working_days);
                    $total_allowance = $attendance_log[$i]->allowance['total_allowance'];
                } else {
                    $total_allowance = 0;
                    $attendance_log[$i]->allowance = 0;
                }
                $attendance_log[$i]->deductions = $this->employee_deduction($attendance_log[$i]->user->employee, $attendance_log[$i], $total_allowance, $attendance_log[$i]->working_days, $attendance_log[$i]->holiday_count, $to_date, $before_resignation);
                $total_salary += ($attendance_log[$i]->user->employee->net_salary+($total_allowance-$attendance_log[$i]->medical_allowance))-$attendance_log[$i]->deductions['total_deductions'];
                if($separation->bonus_deduction == 0){
                    $total_earnings += $total_allowance + $attendance_log[$i]->user->employee->net_salary - $attendance_log[$i]->medical_allowance;
                } else {
                    $total_earnings += $total_allowance + $attendance_log[$i]->user->employee->net_salary;
                }
                $total_deductions += $attendance_log[$i]->deductions['total_deductions'];
            }
            $last_month_sales = [];
            if($separation->bonus_deduction == 0){
                $last_month_sales = $this->employee_allowance($separation->user->user_id, false, $separation->separation_date, false);
                $total_earnings = $total_earnings + $last_month_sales['total_allowance'];
                $total_salary = $total_salary + $last_month_sales['total_allowance'];
            }
            $data['separation'] = $separation;
            $data['payroll'] = $attendance_log;
            $data['total_earnings'] = $total_earnings;
            $data['total_salary'] = $total_salary;
            $data['total_deductions'] = $total_deductions;
            $data['last_month_sales'] = $last_month_sales;
            $data['final_settlement'] = EmployeeFinalSettlement::where('separation_id', $request->separation_id)->first();
        }else{
            $data['separation'] = false;
        }
        return view('employee_separation.separation_details_view', $data);
    }
    public function view_undertaking_form(Request $request){
        $data['page_title'] = "Employee Undertaking Form - Atlantis BPO CRM";
        if(isset($request->separation_id)) {
            $data['separation'] = EmployeeSeparation::with('user.employee', 'user.department')->where('separation_id',$request->separation_id)->first();
        }else{
            $data['separation'] = false;
        }
        return view('employee_separation.partial.employee_undertaking_form', $data);
    }
    public function save_final_settlement(Request $request)
    {
        $asset_not_returned = '';
        if($request->has('assets_not_returned')){
            $asset_not_returned = implode(',', $request->assets_not_returned);
        }
        EmployeeFinalSettlement::updateOrCreate([
            'separation_id' => $request->separation_id,
        ], [
            'last_working_day' => $request->last_working_day,
            'length_of_service' => $request->length_of_service,
            'salary_paid' => $request->salary_paid,
            'asset_deduction_amount' => $request->asset_deduction_amount,
            'assets_not_returned' => $asset_not_returned,
            'added_by' => Auth::user()->user_id,
            'modified_by' => Auth::user()->user_id
        ]);
        User::whereUserId($request->user_id)->update(['status'=> 3]);
        $response['status'] = "Success";
        $response['result'] = "Added Successfully";
        return response()->json($response);
    }
    public function delete_final_settlement(Request $request)
    {
        $user_id = EmployeeSeparation::where('separation_id', $request->separation_id)->pluck('user_id')->first();
        EmployeeFinalSettlement::where('separation_id', $request->separation_id)->delete();
        User::whereUserId($user_id)->update(['status'=> 1]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }

    ///////////////////////////////////////////////////
    private function check_holidays($form_date, $to_date,$department_id, $user_id)
    {
        $check_holidays = Holiday::where(function ($query_dpt) use($department_id) {
            return $query_dpt->where('department_id', $department_id)
                ->orWhere('department_id',0);
        })
            ->where(function ($query) use($user_id) {
                return $query->whereRaw('FIND_IN_SET("'.$user_id.'",user_id)')
                    ->orWhere('user_id',0);
            })
            ->where(function ($query_date) use($form_date, $to_date) {
                return $query_date->whereBetween('date_from', [$form_date, $to_date])
                    ->orWhereBetween('date_to', [$form_date, $to_date]);
            })
            ->get();
        $holiday_count = 0;
        foreach ($check_holidays as $day){
            $holiday_count = 1;
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
            $start = strtotime($from);
            $end = strtotime($to);
            while(date('Y-m-d', $start) < date('Y-m-d', $end)){
                $holiday_count += date('N', $start) < 6 ? 1 : 0;
                $start = strtotime("+1 day", $start);
            }
        }
        return $holiday_count;
    }
    private function calculate_deductions($user)
    {
        $fixed_deduction_before_tax = PayrollDeductionSetting::select(DB::raw('sum(value) as fixed_deduction_before_tax'))
            ->where('type' , 'other')
            ->where('criteria', 'Fixed')
            ->where('before_tax', 1)
            ->where(function ($query) use($user) {
                return $query->where('department_id', $user->department_id)
                    ->orWhere('department_id',0);
            })
            ->where(function ($query1) use($user) {
                return $query1->whereRaw('FIND_IN_SET("'.$user->role_id.'",role_id)')
                    ->orWhere('role_id',0);
            })
            ->whereStatus(1)->get();
        $fixed_deduction_before_tax = $fixed_deduction_before_tax[0]['fixed_deduction_before_tax'];

        $fixed_deduction_after_tax = PayrollDeductionSetting::select(DB::raw('sum(value) as fixed_deduction_after_tax'))
            ->where('type', 'other')
            ->where('criteria', 'Fixed')
            ->where('before_tax', 0)
            ->where(function ($query) use($user) {
                return $query->where('department_id', $user->department_id)
                    ->orWhere('department_id',0);
            })
            ->where(function ($query1) use($user) {
                return $query1->whereRaw('FIND_IN_SET("'.$user->role_id.'",role_id)')
                    ->orWhere('role_id',0);
            })
            ->whereStatus(1)->get();

        $fixed_deduction_after_tax = $fixed_deduction_after_tax[0]['fixed_deduction_after_tax'];
        $pct_deduction_before_tax  = PayrollDeductionSetting::select(DB::raw('sum(value) as pct_deduction_before_tax'))
            ->where('type', 'other')
            ->where('criteria', 'Percentage')
            ->where(function ($query2) use($user) {
                return $query2->where('department_id', $user->department_id)
                    ->orWhere('department_id',0);
            })
            ->where('before_tax', 1)
            ->where(function ($query3) use($user) {
                return $query3->whereRaw('FIND_IN_SET("'.$user->role_id.'",role_id)')
                    ->orWhere('role_id',0);
            })
            ->whereStatus(1)->get();
        $pct_deduction_before_tax = $user->net_salary *  $pct_deduction_before_tax[0]['pct_deduction_before_tax'] / 100;
        $pct_deduction_after_tax = PayrollDeductionSetting::select(DB::raw('sum(value) as pct_deduction_after_tax'))
            ->where('type', 'other')
            ->where('criteria', 'Percentage')
            ->where(function ($query2) use($user) {
                return $query2->where('department_id', $user->department_id)
                    ->orWhere('department_id',0);
            })
            ->where('before_tax', 0)
            ->where(function ($query3) use($user) {
                return $query3->whereRaw('FIND_IN_SET("'.$user->role_id.'",role_id)')
                    ->orWhere('role_id',0);
            })
            ->whereStatus(1)->get();
        $pct_deduction_after_tax = $user->net_salary *  $pct_deduction_after_tax[0]['pct_deduction_after_tax'] / 100;
        return [
            'before_tax_deduction' => $pct_deduction_before_tax+$fixed_deduction_before_tax,
            'after_tax_deduction' => $pct_deduction_after_tax+$fixed_deduction_after_tax,
        ];
    }
    private function employee_deduction($user, $attendace_log, $allowance, $working_days, $holiday_count, $to_date, $before_resignation)
    {
        $before_resignation_half_leaves = 0;
        if($before_resignation != null){
            $before_resignation_half_leaves = $before_resignation->half_leaves;
        }
        $carry_forward_half_day = ($before_resignation_half_leaves) % 2;
        $number = explode('.',($before_resignation_half_leaves / 2));
        $half_day_leave_absent = $number[0];

        $leaves_bucket = DB::table('leave_bucket_view')->where('user_id',$user->user_id)->first();
        $total_leaves = $half_day_leave_absent;

        $half_leaves_deducted_from_bucket = 0;
        if($leaves_bucket != null){
            $half_leaves_deduction = 0;
            $remaining_casual_sick = ($leaves_bucket->casual_bucket+$leaves_bucket->sick_bucket)-(($leaves_bucket->casual+$leaves_bucket->sick)-$leaves_bucket->payroll_deductions);
            if($remaining_casual_sick >= $total_leaves) {
                $half_leaves_deduction = 0;
                $half_leaves_deducted_from_bucket = $total_leaves;
            } else{
                $half_leaves_deduction = $total_leaves-$remaining_casual_sick;
                $half_leaves_deducted_from_bucket = $remaining_casual_sick;
            }
        } else {
            $half_leaves_deduction = $total_leaves;
        }

        $daily_wage = $user->net_salary/22;
        // lates deduction from salary :- 2 lates = 1 half day
        $lates_calc = ((($attendace_log->lates + $carry_forward_half_day*2)/ 4)/.5);
        $lates_number_of_half_day = explode('.',$lates_calc);

        $lates_number_of_half_day = $lates_number_of_half_day[0];
        $lates_deductions = $daily_wage*($lates_number_of_half_day/2);

        // Absent deduction from salary
        $absent_deductions = $daily_wage*$attendace_log->absents + $carry_forward_half_day;
        $half_day_deductions_amount = $daily_wage*$half_leaves_deduction;
        $total_absents_deduction = $absent_deductions+$half_day_deductions_amount+$lates_deductions;

        $deduction_details = PayrollDeductionSetting::where('type', '!=', 'transport')
            ->where(function ($query) use($user) {
                return $query->where('department_id', $user->department_id)
                    ->orWhere('department_id',0);
            })
            ->where(function ($query1) use($user) {
                return $query1->whereRaw('FIND_IN_SET("'.$user->role_id.'",role_id)')
                    ->orWhere('role_id',0);
            })
            ->whereStatus(1)->get()->pluck('value','title',)->toArray();
        $unmarked_days_wage = ($working_days - ($attendace_log->attendance_marked + $holiday_count)) * ($user->net_salary/$working_days);
        if($total_absents_deduction + $unmarked_days_wage != 0){
            $deduction_details['Absent/Late/Half'] = $total_absents_deduction + $unmarked_days_wage;
        }
        $convenience_deduction = PayrollDeductionSetting::select(DB::raw('sum(value) as transport'))->where('type', 'transport')->whereStatus(1)->get();
        if($user->conveyance_allowance == 1 && $convenience_deduction != null){
            $check_last_date = date("Y-m-d", strtotime($to_date));
            $from_date= date("Y-m-01", strtotime($to_date));
            if($to_date < $check_last_date){
                $month_working_days = working_days($from_date,$check_last_date);
                $working_days = working_days($from_date,$to_date);
                $convenience_deduction = ($convenience_deduction[0]['transport'] / $month_working_days) * $working_days;
            }else{
                $convenience_deduction = $convenience_deduction[0]['transport'];
            }
            $deduction_details['transport'] = $convenience_deduction;
        } else {
            $convenience_deduction = 0;
        }
        $calculated_deductions = $this->calculate_deductions($user);
        $attendance_log_deduction = $unmarked_days_wage+$convenience_deduction+$total_absents_deduction;
        // calculating tax
        $tax_deduction_val = $this->calculate_income_tax($user, $allowance, $attendance_log_deduction, $calculated_deductions, $attendace_log);
        if($tax_deduction_val != 0){
            $deduction_details['Income Tax'] = $tax_deduction_val;
        }
        $total_deductions =  $tax_deduction_val +  $attendance_log_deduction;
        return [
            'total_deductions' => $total_deductions + $calculated_deductions['after_tax_deduction'],
//            'deduction_bucket' => $leaves_deducted_from_bucket,
            'details' => $deduction_details,
//            'leaves_of_late' => $late_absents,
//            'leaves_of_half' => $half_leavs_absents
        ];
    }
    private function employee_allowance($user_id, $attendace_log, $month, $working_days)
    {
        // Bonuses for last month
        $month = date('Y-m-01',(strtotime ( '-1 month' , strtotime ( $month) ) ));
        $user = User::with('employee')->whereUserId($user_id)->first();
        $dependability_allowance = PayrollAllowanceSetting::where('type', 'dependability')
            ->where(function ($query) use($user) {
                return $query->where('department_id', $user->department_id)
                    ->orWhere('department_id',0);
            })
            ->where(function ($query1) use($user) {
                return $query1->whereRaw('FIND_IN_SET("'.$user->role_id.'",role_id)')
                    ->orWhere('role_id',0);
            })
            ->whereStatus(1)->get();
        $details = array();
        $dependability = 0;
        if($attendace_log == false){
            $total_leaves = 0;
            $medical_allowance = 0;
            $month = $month;
        } else {
            // Bonuses for last month 73533ba679bbbde62288e6854779a15f1fbca988
            $medical_allowance = $attendace_log->medical_allowance;
            $unmarked = $working_days - ($attendace_log->attendance_marked + $attendace_log->holiday_count);
            $total_leaves = $attendace_log->leaves +  $attendace_log->absents;
            $month = $attendace_log->form_date;
            $dependability = 0;
            foreach ($dependability_allowance as $depend){
                $dependability = $depend->allowance_value;
                if ($total_leaves == 0) {
                    $dependability = $dependability;
                    if($dependability != 0){
                        $details[$depend->title] = $dependability;
                    }
                } else if ($total_leaves == 1) {
                    $dependability = $dependability / 2;
                    if($dependability != 0){
                        $details[$depend->title] = $dependability;
                    }
                } else if ($total_leaves > 1) {
                    $dependability = 0;
                    if($dependability != 0){
                        $details[$depend->title] = $dependability;
                    }
                }
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
        // manager team RGU count
        $is_manager = ManagerialRole::where('role_id',$user->role_id)->first();
        $manager_team_count = 0;
        if($user->department_id == 3 && $is_manager != null){
            $team_stats = $this->get_team_detailed_counts($from_date, $to_date, $user->user_id, $user->user_id==4 ? 6 : 0);
            $manager_team_per_rgu_value = $this->get_payroll_config();
            $manager_team_count= $team_stats->manager_team_count*$manager_team_per_rgu_value->team_lead;
        }
        $rgu_bench_mark_allowance = PayrollAllowanceSetting::select('*','department_id', 'role_id')
            ->where('type', 'rgu-bench-mark')
            ->where(function ($query) use ($user){
                $query->where('department_id', $user->department_id)
                    ->orWhere('department_id', 0); // for all depts
            })
            ->whereStatus(1)->get();
        $total_allowance = array(
            'sp'=>0,
            'dp'=>0,
            'tp'=>0,
            'rgu'=>0,
            'mobile'=>0,
            'dependebility'=>$dependability,
            'medical'=>$medical_allowance,
            'manager_team_count'=>$manager_team_count,
        );
        if($medical_allowance != 0){
            $details['Medical'] = $medical_allowance;
        }
        if($manager_team_count != 0){
            $details['Manager Team Allowance'] = $manager_team_count;
        }
        foreach ($rgu_bench_mark_allowance as $rgu){
            if($rgu->role_id == 0 || $user->role_id == $rgu->role_id){
                if($rgu->bench_mark_type == 'single-play'){
                    $single_play = $this->get_user_play($user->user_id,$from_date, $to_date, $rgu->provider, 1);
                    if($single_play >= $rgu->bench_mark_value){
                        $tem_val = 0;
                        if($rgu->bench_mark_criteria == 'fixed'){
                            $total_allowance['sp'] += $rgu->allowance_value;
                            $tem_val += $rgu->allowance_value;
                        } else {
                            $val = intdiv($single_play, $rgu->bench_mark_value);
                            $total_allowance['sp'] += $val * $rgu->allowance_value;
                            $tem_val += $val * $rgu->allowance_value;
                        }
                        $details[$rgu->title] = $tem_val;
                    }
                }
                if($rgu->bench_mark_type == 'double-play'){
                    $single2 = $this->get_user_play($user->user_id,$from_date, $to_date, $rgu->provider, 2);
                    if($single2 >= $rgu->bench_mark_value){
                        $tem_val = 0;
                        if($rgu->bench_mark_criteria == 'fixed'){
                            $total_allowance['dp'] += $rgu->allowance_value;
                            $tem_val += $rgu->allowance_value;
                        } else {
                            $val = intdiv($single2,$rgu->bench_mark_value);
                            $total_allowance['dp'] += $val * $rgu->allowance_value;
                            $tem_val += $val * $rgu->allowance_value;
                        }
                        $details[$rgu->title] = $tem_val;
                    }
                }
                if($rgu->bench_mark_type == 'triple-play'){
                    $single3 = $this->get_user_play($user->user_id,$from_date, $to_date, $rgu->provider, 3);
                    if($single3 >= $rgu->bench_mark_value){
                        $tem_val = 0;
                        if($rgu->bench_mark_criteria == 'fixed'){
                            $total_allowance['tp'] += $rgu->allowance_value;
                            $tem_val += $rgu->allowance_value;
                        } else {
                            $val = intdiv($single3,$rgu->bench_mark_value);
                            $total_allowance['tp'] += $val * $rgu->allowance_value;
                            $tem_val += $val * $rgu->allowance_value;
                        }
                        $details[$rgu->title] = $tem_val;
                    }
                }
                //Total RGU Allowance
                $sales = $this->get_user_total_rgu($from_date, $to_date, $user->user_id, $rgu->provider);
                $payroll_config = $this->get_payroll_config();
                // over 40 rguw bonus
                if($sales['total_rgu'] > $payroll_config->rgu_bench_mark){
                    $details['RGU Bonus (over 40)'] = ($sales['total_rgu']-$payroll_config->rgu_bench_mark)*$payroll_config->per_rgu;
                    $total_allowance['rgu'] = $details['RGU Bonus (over 40)'];
                }
                // Mobile Bonus 20540 35558
                if($rgu->bench_mark_type == 'mobile') {
                    $allowance_amount = 0;
                    $mobile_sales = $this->get_user_play($user->user_id, $from_date, $to_date, $rgu->provider, 'mobile');
                    if($sales['total_rgu'] > $payroll_config->rgu_bench_mark) {
                        $rgu_remaining_after_without_mobile = $sales['total_rgu'] - $mobile_sales; // 50-13 = 37
                        if($rgu_remaining_after_without_mobile >= $payroll_config->rgu_bench_mark) {
                            $allowance_amount = $rgu->after * $mobile_sales; // greater then bench_mark i.e 1500
                        } else {
                            // mobile = 7, RGU = 45, after_mobile = 38
                            // if after deducting mobile rgus are less than 40
                            $rgu_val_before = $payroll_config->rgu_bench_mark - $rgu_remaining_after_without_mobile; // 40 - 38 = 2
                            $rgu_val_after = $mobile_sales-$rgu_val_before;
                            $allowance_amount = ($rgu_val_before*$rgu->before);
                            $allowance_amount += ($rgu_val_after*$rgu->after);
                        }
                    } else {
                        $allowance_amount = ($mobile_sales*$rgu->before);
                    }
                    $total_allowance['mobile'] += $allowance_amount;
                    if($allowance_amount>0){
                        $details['Mobile Allowance'] = $allowance_amount;
                    }
                }
            }
        }
        return [
            'allowances' => $total_allowance,
            'total_allowance' => $total_allowance['sp']+$total_allowance['dp']+$total_allowance['tp']+$total_allowance['mobile']+$total_allowance['rgu']+$total_allowance['dependebility']+$total_allowance['medical']+$total_allowance['manager_team_count'],
            'details' => $details,
            'allowance_month' => $to_date
        ];
    }
    private function calculate_income_tax($user, $allowance, $deduction, $calculated_deductions, $attendace_log)
    {
        // calculation income tax
        if(!$user->net_salary) { die('Salary not available for employee '.$user->full_name); }
        // basic salary plus all allowances and minus all deductions
        $basic_salary = $user->net_salary;
        // total salary minus medical allowance 10%
        $salary = $basic_salary-$attendace_log->medical_allowance;
        $salary = ($salary + ($allowance - $attendace_log->medical_allowance)) - ($deduction + $calculated_deductions['before_tax_deduction'] + $calculated_deductions['after_tax_deduction']);
        $annul_salary = $salary*12;
        $tax_deduction = PayrollTaxSlab::whereStatus(1)
            ->where(function ($query) use ($annul_salary) {
                $query->where('from', '<=', $annul_salary);
                $query->where('to', '>=', $annul_salary);
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
    private function get_user_total_rgu($from_date, $to_date, $user_id, $provider){
        $provider = explode(',', $provider);
        $single_play = DB::table('all_sales')->where('added_by', $user_id)->where('services_sold', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $double_play = DB::table('all_sales')->where('added_by', $user_id)->where('services_sold', 2)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $triple_play = DB::table('all_sales')->where('added_by', $user_id)->where('services_sold', 3)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $quad_play = DB::table('all_sales')->where('added_by', $user_id)->where('services_sold', 4)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $services = DB::table('all_sales')->where('added_by', $user_id)->select('provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile, count(case when services_sold = "1" then 1 else null end) as single_play, count(case when services_sold = "2" then 1 else null end) as double_play, count(case when services_sold = "3" then 1 else null end) as triple_play, count(case when services_sold = "4" then 1 else null end) as quad_play'))
            ->whereBetween('added_on', [$from_date, $to_date])
            ->groupBy('provider_name')->limit(5)->get();
        $total_rgu = ($single_play+($double_play*2)+($triple_play*3)+($quad_play*4));
        $total_sales = ($single_play+$double_play+$triple_play+$quad_play);
        return [
            'services' => $services,
            'single_play' => $single_play,
            'double_play' => $double_play,
            'triple_play' => $triple_play,
            'quad_play' => $quad_play,
            'total_rgu' => $total_rgu,
            'total_sales' => $total_sales
        ];
    }
    private function get_user_play($user_id, $from_date, $to_date, $provider, $play)
    {
        $provider = explode(',', $provider);
        if ($provider[0] == 'all') {
            $sales_play = DB::table('call_dispositions')
                ->join('call_dispositions_services', 'call_dispositions.call_id', '=', 'call_dispositions_services.call_id')
                ->where('call_dispositions.added_by', $user_id)
                ->whereBetween('call_dispositions.added_on', [$from_date, $to_date])
                ->whereRaw('(cable+internet+phone) = ' . $play)
                ->count('call_dispositions_services.call_id');
        } else {
            $sales_play = DB::table('call_dispositions')
                ->join('call_dispositions_services', 'call_dispositions.call_id', '=', 'call_dispositions_services.call_id')
                ->where('call_dispositions.added_by', $user_id)
                ->whereIn('call_dispositions_services.provider_name', $provider)
                ->whereBetween('call_dispositions.added_on', [$from_date, $to_date])
                ->whereRaw('(cable+internet+phone) = ' . $play)
                ->count('call_dispositions_services.call_id');
        }
        if($play == 'mobile'){
            if ($provider[0] == 'all') {
                $sales_play = DB::table('call_dispositions')
                    ->join('call_dispositions_services', 'call_dispositions.call_id', '=', 'call_dispositions_services.call_id')
                    ->where('call_dispositions.added_by', $user_id)
                    ->whereBetween('call_dispositions.added_on', [$from_date, $to_date])
                    ->where('call_dispositions_services.mobile', '!=', 0)
                    ->count('call_dispositions_services.call_id');
            } else {
                $sales_play = DB::table('call_dispositions')
                    ->join('call_dispositions_services', 'call_dispositions.call_id', '=', 'call_dispositions_services.call_id')
                    ->where('call_dispositions.added_by', $user_id)
                    ->whereIn('call_dispositions_services.provider_name', $provider)
                    ->whereBetween('call_dispositions.added_on', [$from_date, $to_date])
                    ->where('call_dispositions_services.mobile', '!=', 0)
                    ->count('call_dispositions_services.call_id');
            }
        }
        return $sales_play;
    }
    private function get_team_detailed_counts($from_date, $to_date, $manager_id, $exclude){
        $manager_team_count = DB::table('all_sales')->select(DB::raw('sum(internet + cable + phone + mobile) as manager_team_count'))
            ->orWhere(['manager_id'=>$manager_id, 'added_by'=>$manager_id])
            ->whereBetween('added_on', [$from_date, $to_date])
            ->where('added_by','!=', $exclude)
            ->groupBy('manager_id')->first();
        return $manager_team_count;
    }
    private function get_payroll_config(){
        $payroll_config = DB::table('payroll_config')->whereStatus(1)->first();
        return $payroll_config;
    }
}
