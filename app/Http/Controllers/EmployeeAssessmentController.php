<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\Department;
use App\Models\EmployeeObjectives;
use App\Models\EvaluationStandards;
use App\Models\Holiday;
use App\Models\LeavesBucket;
use App\Models\ManagerialRole;
use App\Models\Notifications;
use App\Models\EmployeeAssessment;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;

class EmployeeAssessmentController extends Controller
{
    public function __construct() { }
    public function index()
    {
        $data['page_title'] = "Employee Assessments List - Atlantis BPO CRM";
        // Employee record checking
        if(Auth::user()->user_type == 'Employee'){
            $employee_record = Employee::where('user_id', Auth::user()->user_id)->first();
            if(empty($employee_record)){
                $data['message'] = 'Please first fill your employee record.';
                return redirect('/employee_form_wizard')->with($data);
            }
        }
        $manager_ids = ManagerialRole::whereType('Manager')->whereStatus(1)->pluck('role_id')->toArray();
        $data['is_admin'] = false;
        $data['is_hrm'] = false;
        $data['is_manager'] = false;
        $data['is_employee'] = false;
        if(Auth::user()->role_id == 1){
            $data['is_admin'] = true;
            $data['EmployeeAssessment_SELF'] = false;
            $data['EmployeeAssessment'] = EmployeeAssessment::with('employees')->orderBy('id', 'DESC')->get();
        }else if(Auth::user()->role_id == 5){
            $data['is_hrm'] = true;
            $data['EmployeeAssessment_SELF'] = EmployeeAssessment::with('employees')->where('user_id', Auth::user()->user_id)->get();
            $data['EmployeeAssessment'] = EmployeeAssessment::with('employees')->where('user_id', '!=', Auth::user()->user_id)->orderBy('id', 'DESC')->get();
        }else if(in_array(Auth::user()->role_id, $manager_ids)){
            $data['is_manager'] = true;
            $data['EmployeeAssessment_SELF'] = EmployeeAssessment::with('employees')->where('user_id', Auth::user()->user_id)->get();
            $login_manager_id = Auth::user()->user_id;
            // get employee under logged in manager
            $user_ids = User::where('manager_id', $login_manager_id)->where('user_type','Employee')->get()->pluck('user_id')->toArray();
            $data['EmployeeAssessment'] = EmployeeAssessment::with('employees')->whereIn('user_id', $user_ids)->orderBy('id', 'DESC')->get();
        }else{
            $data['is_employee'] = true;
            $data['EmployeeAssessment_SELF'] = EmployeeAssessment::with('employees')->where('user_id', Auth::user()->user_id)->get();
            $data['EmployeeAssessment'] = false;
        }
      //  $data['self_assessment'] = false;
        $data['self_assessment'] = $this->self_assessment_button_enable();
        return view('employee_assessment.index' , $data);
    }
    public function employee_assessment_form(Request $request)
    {
        $data['page_title'] = "Employee Assessment Form - Atlantis BPO CRM";
        $data['users'] = User::whereStatus(1)->where('user_type','Employee')->get();
        $data['departments'] = Department::whereStatus(1)->orderBy('department_id', 'DESC')->get();
        $data['is_admin'] = false;
        $data['is_hrm'] = false;
        $data['is_manager'] = false;
        $data['is_employee'] = false;
        $manager_ids = ManagerialRole::whereType('Manager')->whereStatus(1)->pluck('role_id')->toArray();
        if(Auth::user()->role_id == 1){
            $data['is_admin'] = true;
        }else if(Auth::user()->role_id == 5){
            $data['is_hrm'] = true;
        } else if(in_array(Auth::user()->role_id, $manager_ids)){
            $data['is_manager'] = true;
        } else{
            $data['is_employee'] = true;
        }
        if(isset($request->id)) {
            // FOR MANAGER && HR ASSESSMENTS
            $EmployeeAssessment = EmployeeAssessment::with('employees', 'evaluation_standards')
                ->where('id', $request->id)->first();
            $data['EmployeeAssessment'] = $EmployeeAssessment;
            // Previous appraisal record check
            $Previous_EmployeeAssessment = EmployeeAssessment::where('user_id', $EmployeeAssessment->user_id)
                ->where('id', '!=' ,$request->id)
                ->orderBy('added_on', 'desc')->get();
            if(count($Previous_EmployeeAssessment) > 0 && $Previous_EmployeeAssessment[0]->evaluation_date){
                $period = get_period($Previous_EmployeeAssessment[0]->evaluation_date, get_date());
            }else{
                $period = get_period($EmployeeAssessment->employees->joining_date, get_date());
            }
            if(isset($Previous_EmployeeAssessment[0]->confirmation_status)) {
                $data['prob_status'] = $Previous_EmployeeAssessment[0]->confirmation_status;
            }else{
                $data['prob_status'] = false;
            }
            $data['emp_manager_evaluation_standards'] = EvaluationStandards::where('assessment_id',$request->id)->get();
            $data['period'] = $period;
            $data['total_service'] = total_service($EmployeeAssessment->employees->joining_date, get_date());

            $data['previous_overall_ratings'] = [];
            $data['employee_previous_objectives'] = false;
            if(count($Previous_EmployeeAssessment) > 0 ){
                foreach ($Previous_EmployeeAssessment as $Confirmations) {
                    array_push($data['previous_overall_ratings'],$Confirmations->overall_rating);
                }
                $data['employee_previous_objectives'] = EmployeeObjectives::where('assessment_id',$Previous_EmployeeAssessment[0]->id)
                    ->orderBy('added_on', 'desc')->get();
            }
            $form_date = date ( "Y\-m\-d" , strtotime ( "-3 Months" ));
            $to_date = get_date();
            $data['attendance_log'] = $this->get_attendance_log($form_date, $to_date,$EmployeeAssessment->user_id);
        }else{
            // FOR ALL EMPLOYEES SELF ASSESSMENT
            $data['EmployeeAssessment'] = false;
        }
        return view('employee_assessment.employee_assessment_form',$data);
    }
    public function employee_assessment_save(Request $request){
        $validator = '';
        if(isset($request->ESA_duties)){
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'user_id' => 'required',
                'employee_id' => 'required',
                'ESA_duties' => 'required',
                'ESA_achievements' => 'required',
                'ESA_future_aims' => 'required'
            ]);
        }
        if(isset($request->manager_comments)){
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'manager_comments' => 'required',
                'manager_additional_comments' => 'required'
            ]);
        }
        if(isset($request->hr_comments)){
            $validator = Validator::make($request->all(), [
                'period' => 'required',
                'total_service' => 'required',
                'attendance' => 'required',
                'tardiness' => 'required',
                'written_warning' => 'required',
                'verbal_warning' => 'required',
                'hr_comments' => 'required',
                'increment' => 'required'
            ]);
        }
        $eval_validator = Validator::make($request->all(), [
            'discipline' => 'required',
            'punctuality' => 'required',
            'work_dedication' => 'required',
            'performance' => 'required',
            'peer_behaviour' => 'required',
            'customer_handling' => 'required',
            'customer_service' => 'required',
            'job_knowledge' => 'required',
            'technical_application' => 'required',
            'efficiency' => 'required',
            'dependability' => 'required',
            'communication' => 'required',
            'team_work' => 'required',
            'decision_making' => 'required',
            'problem_solving' => 'required',
            'adaptability' => 'required',
            'independence' => 'required',
            'initiative' => 'required',
            'quality_of_work' => 'required',
            'quantity_of_work' => 'required',
            'organization_planning' => 'required',
            'productivity' => 'required',
            'reliability' => 'required',
            'attitude' => 'required',
            'last_eval_objectives_achieved' => 'required',
            'WOW' => 'required'
        ]);
        if($validator->passes() && $eval_validator->passes()){
            $EmployeeAssessment = EmployeeAssessment::where('id', $request->id)->get();
            $EmployeeAssessment_data = '';
            if(count($EmployeeAssessment)>0){
                $user_id = $EmployeeAssessment[0]->user_id;
            }
            if(isset($request->ESA_duties)){
                $confirmation_status = 'Probation';
                // Previous appraisal record check
                $Previous_EmployeeAssessment = EmployeeAssessment::where('user_id', $request->user_id)
                    ->orderBy('added_on', 'desc')->first();
                if($Previous_EmployeeAssessment){
                    $confirmation_status = $Previous_EmployeeAssessment->confirmation_status;
                }
                //'employee_comments' => $request->employee_comments,
                $EmployeeAssessment_data = [
                    'added_by' => Auth::user()->user_id,
                    'user_id' => $request->user_id,
                    'employee_id' => $request->employee_id,
                    'ESA_duties' => $request->ESA_duties,
                    'ESA_achievements' => $request->ESA_achievements,
                    'ESA_future_aims' => $request->ESA_future_aims,
                    'employee_sign' => 1,
                    'employee_sign_date' => get_date(),
                    'confirmation_status' => $confirmation_status
                ];
                $user_id = $request->user_id;
            }
            if(isset($request->manager_comments)){
                $EmployeeAssessment_data = [
                    'manager_comments' => $request->manager_comments,
                    'manager_additional_comments' => $request->manager_additional_comments,
                    'manager_sign' => 1
                ];
              //  UPDATE Previous Evaluation Objectives REMARKS;
                if(isset($request->previous_objective_id)){
                    for($i=0, $i_max=count($request->previous_objective_id); $i<$i_max; $i++) {
                        EmployeeObjectives::where('id', $request->previous_objective_id[$i])
                            ->update(array('remarks' => $request->previous_remarks[$i]));
                    }
                }
                if(isset($request->objective)){
                    for($i=0, $i_max=count($request->objective); $i<$i_max; $i++) {
                        EmployeeObjectives::create(array(
                            'added_by' =>  Auth::user()->user_id,
                            'user_id' => $user_id,
                            'assessment_id' => $request->id,
                            'objective' => $request->objective[$i],
                            'measurement_index' => $request->measurement_index[$i],
                            'remarks' => $request->remarks[$i],
                            'timeline' => $request->timeline[$i]
                        ));
                    }
                }
            }
            if(isset($request->hr_comments)){
                $EmployeeAssessment_data = [
                    'period' => $request->period,
                    'total_service' => $request->total_service,
                    'attendance' => $request->attendance,
                    'tardiness' => $request->tardiness,
                    'written_warning' => $request->written_warning,
                    'verbal_warning' => $request->verbal_warning,
                    'hr_comments' => $request->hr_comments,
                    'hr_sign' => 1,
                    'probation_extension' => $request->probation_extension,
                    'probation_extension_months' => $request->probation_extension_months,
                    'evaluation_date' => get_date(),
                    'confirmation_status' => $request->confirmation_status,
                    'increment' => $request->increment
                ];
                $employee_data = Employee::with('employee')->where('user_id', $user_id)->first();
                $employee_salary_increment = $employee_data->net_salary + $request->increment;
                Employee::where('user_id', $user_id)->update(['net_salary' => $employee_salary_increment]);
                if($request->confirmation_status == 'Confirmed'){
                    Employee::where('user_id', $user_id)->update([
                                'employment_status' => $request->confirmation_status,
                                'confirmation_date' => get_date()
                                ]);
                    $Leaves_Bucket_record = LeavesBucket::where('user_id',$user_id)->count();
                    if($Leaves_Bucket_record == 0 && ($employee_data->employment_status == 'Confirmed' || $request->employment_status == 'Confirmed')) {
                        generate_single_employee_leaves_bucket($request->user_id);
//                        LeavesBucket::create(['user_id' => $request->user_id,
//                            'start_date' => get_date(),
//                            'annual_leaves' => 10,
//                            'sick_leaves' => 5,
//                            'casual_leaves' => 4
//                        ]);
                    }
                }
            }
            if(count($EmployeeAssessment)>0){
                EmployeeAssessment::where('id', $EmployeeAssessment[0]->id)->update($EmployeeAssessment_data);
                $employee_assessment_id = $EmployeeAssessment[0]->id;
            } else {
                $prob = EmployeeAssessment::create($EmployeeAssessment_data);
                $employee_assessment_id = $prob->id;
            }
            if(isset($request->ESA_duties)) {
                // NOTIFICATION TRAY
                $manager_id = User::where('user_id', Auth::user()->user_id)->where('user_type','Employee')->pluck('manager_id')->first();
                add_notifications('employee_assessments','Evaluation',$employee_assessment_id,$manager_id,'Pending Manager Evaluation');
            }
            if(isset($request->manager_comments)){
                // Notification Tray
                $hr_user_id = User::where('role_id', 5)->pluck('user_id')->first();
                add_notifications('employee_assessments','Evaluation',$employee_assessment_id,$hr_user_id,'Pending HR Evaluation');
            }
            // if admin is doing both manager and hr evaluations
            $employee_record = Employee::with('employee')->where('user_id', $user_id)->first();
            if(Auth::user()->role_id == 1){
                $HR_manager = User::where('role_id', 5)->first();
                if(isset($request->hr_comments)){
                    $remarker_id = $HR_manager->user_id;
                }else if(isset($request->manager_comments)){
                    $remarker_id = $employee_record->employee->manager_id;
                    // NOTIFICATION TRAY
                    add_notifications('employee_assessments','Evaluation',$employee_assessment_id,$HR_manager->user_id,'Pending HR Evaluation');
                }
            }else{
                $remarker_id = Auth::user()->user_id;
            }
            $Eval_data = [
                'assessment_id'=> $employee_assessment_id,
                'user_id'=> $user_id,
                'remarker_id'=> $remarker_id,
                'discipline' => $request->discipline,
                'punctuality' => $request->punctuality,
                'work_dedication' => $request->work_dedication,
                'performance' => $request->performance,
                'peer_behaviour' => $request->peer_behaviour,
                'customer_handling' => $request->customer_handling,
                'customer_service' => $request->customer_service,
                'job_knowledge' => $request->job_knowledge,
                'technical_application' => $request->technical_application,
                'efficiency' => $request->efficiency,
                'dependability' => $request->dependability,
                'communication' => $request->communication,
                'team_work' => $request->team_work,
                'decision_making' => $request->decision_making,
                'problem_solving' => $request->problem_solving,
                'adaptability' => $request->adaptability,
                'independence' => $request->independence,
                'initiative' => $request->initiative,
                'supervision' => $request->supervision,
                'quality_of_work' => $request->quality_of_work,
                'quantity_of_work' => $request->quantity_of_work,
                'organization_planning' => $request->organization_planning,
                'productivity' => $request->productivity,
                'reliability' => $request->reliability,
                'attitude' => $request->attitude,
                'last_eval_objectives_achieved' => $request->last_eval_objectives_achieved,
                'WOW' => $request->WOW,
                'coaching' => $request->coaching,
                'leadership' => $request->leadership
            ];
            if(isset($request->hr_comments)) {
                // check employee is manager or not
                $manager_ids = ManagerialRole::whereType('Manager')->whereStatus(1)->pluck('role_id')->toArray();
                if(in_array($employee_record->employee->role_id, $manager_ids)){
                    $is_manager = 1;
                }else{
                    $is_manager = 0;
                }
                $hr_rating_average = $this->calculate_rating($Eval_data,$is_manager);
                $overall_rating = ['overall_rating' => $hr_rating_average];
                EmployeeAssessment::where('id', $employee_assessment_id)->update($overall_rating);
            }
            $EvaluationStandards = EvaluationStandards::where([
                'assessment_id' => $request->id,
                'user_id' => $user_id,
                'remarker_id'  => $remarker_id
            ])->get();

            if(count($EvaluationStandards)>0){
                EvaluationStandards::where('eval_id', $EvaluationStandards[0]->eval_id)->update($Eval_data);
            } else {
                EvaluationStandards::create($Eval_data);
            }
            $response['status'] = 'success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function view_employee_assessment(Request $request)
    {
        $data['page_title'] = "View Performance Improvement Plan Details - Atlantis BPO CRM";
        if(isset($request->id)) {
            $EmployeeAssessment_data = EmployeeAssessment::with('employees')->where('id', $request->id)->first();
            $data['EmployeeAssessment'] = $EmployeeAssessment_data;
            $data['employee_self_evaluation'] = EvaluationStandards::where([
                                                    'remarker_id' => $EmployeeAssessment_data->user_id,
                                                    'assessment_id' => $request->id
                                                ])->get();
            $user_manager = User::where('user_id', $EmployeeAssessment_data->user_id)->first();
            $manager_details = User::where('user_id', $user_manager->manager_id)->first();
            $data['manager_name'] = $manager_details->full_name;
            $data['employee_manager_evaluation'] = EvaluationStandards::where([
                                                        'remarker_id' => $user_manager->manager_id,
                                                        'assessment_id' => $request->id
                                                    ])->get();
            $HR_manager = User::where('role_id', 5)->first();
            $data['hr_name'] = $HR_manager->full_name;
            $data['employee_hr_evaluation'] = EvaluationStandards::where([
                                                    'remarker_id' => $HR_manager->user_id,
                                                    'assessment_id' => $request->id
                                                ])->get();
            $data['standards_average'] = $this->calculate_overall_rating_avg($EmployeeAssessment_data->id,$EmployeeAssessment_data->user_id);
            $data['employee_objectives'] = EmployeeObjectives::where('assessment_id',$EmployeeAssessment_data->id)
                ->orderBy('added_on', 'desc')->get();
        }else{
            $data['EmployeeAssessment'] = false;
            $data['employee_self_evaluation'] = false;
            $data['employee_manager_evaluation'] = false;
            $data['employee_hr_evaluation'] = false;
            $data['standards_average'] = false;
            $data['employee_objectives'] = false;
        }
        $form_date = date ( "Y\-m\-d" , strtotime ( "-3 Months" ));
        $to_date = get_date();
        $data['attendance_log'] = $this->get_attendance_log($form_date, $to_date,$EmployeeAssessment_data->user_id);
        return view('employee_assessment.view_employee_assessment', $data);
    }
    public function get_employee_details(Request $request)
    {
        $data = Employee::with('department')->where('user_id', $request->user_id)->first();
        return response()->json($data);
    }
    public function self_assessment_button_enable()
    {
        $self_assessment = false;
        // Incomplete  OR Previous appraisal record check
        $incomplete_evaluation = EmployeeAssessment::with('employees')
            ->where('user_id', Auth::user()->user_id)
            ->where('hr_sign', 0)
            ->orderBy('added_on', 'desc')->first();
        $Previous_EmployeeAssessment = EmployeeAssessment::with('employees')
            ->where('user_id', Auth::user()->user_id)
            ->where('hr_sign', 1)
            ->orderBy('added_on', 'desc')->first();
        if($Previous_EmployeeAssessment && !$incomplete_evaluation){
            $employee_assessment_id = $Previous_EmployeeAssessment->id;
            if(get_month_diff($Previous_EmployeeAssessment->evaluation_date, get_date()) >= 3) {
                $self_assessment = true;
            }
        }else if(!$incomplete_evaluation) {
            $employee_assessment_id = 0; //for first evaluation
            if(Auth::user()->user_type == 'Employee'){
                $employees = Employee::where('user_id', Auth::user()->user_id)->first();
                if (get_month_diff($employees->joining_date, get_date()) >= 3) {
                    $self_assessment = true;
                }
            }
        }
        if($self_assessment == true){
            if(Auth::user()->role_id != 1){
                $Notification_data = Notifications::where([
                    'reference_table' => 'employee_assessments',
                    'type' => 'Evaluation',
                    'reference_id' => $employee_assessment_id,
                    'user_id' => Auth::user()->user_id,
                ])->first();
                if(!$incomplete_evaluation && !$Notification_data ){
                    add_notifications('employee_assessments','Evaluation',$employee_assessment_id,Auth::user()->user_id,'Pending Self Evaluation');
                }
            }
        }
        return $self_assessment;
    }
    public function calculate_rating($data,$is_manager)
    {
        $for_managers = 0;
        if($is_manager == 1){
          $for_managers = intval($data['supervision']) + intval($data['coaching']) + intval($data['leadership']);
          $total_standards = 29;
        }else {
            $total_standards = 26;
        }
        $sum_of_standards =  intval($data['discipline']) + intval($data['punctuality']) + intval($data['work_dedication'])
            + intval($data['performance']) + intval($data['peer_behaviour']) + intval($data['customer_handling'])
            + intval($data['customer_service']) + intval($data['job_knowledge']) + intval($data['technical_application'])
            + intval($data['efficiency']) + intval($data['dependability']) + intval($data['communication'])
            + intval($data['team_work']) + intval($data['decision_making']) + intval($data['problem_solving'])
            + intval($data['adaptability']) + intval($data['independence']) + intval($data['initiative'])
            + intval($data['quality_of_work']) + intval($data['quantity_of_work']) + intval($data['organization_planning'])
            + intval($data['productivity']) + intval($data['reliability']) + intval($data['attitude'])
            + intval($data['WOW']) + intval($data['last_eval_objectives_achieved'])
            + $for_managers;
        $standards_average = $sum_of_standards/$total_standards;
        return $standards_average;
    }
    public function calculate_overall_rating_avg($assessment_id,$user_id)
    {
        $sum_of_overall_ratings =0;
        $EmployeeAssessment_data = EmployeeAssessment::where('user_id', $user_id)
                                        ->orderby('added_on','desc')
                                        ->take(4)->get();
        foreach($EmployeeAssessment_data as $prob_data){
            $sum_of_overall_ratings += $prob_data->overall_rating;
        }
        $avg = (count($EmployeeAssessment_data) > 0) ? count($EmployeeAssessment_data) : 1;
        $standards_average = $sum_of_overall_ratings/$avg;
        return $standards_average;
    }
    public function check_holidays($form_date, $to_date)
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
    public function get_attendance_log($form_date, $to_date, $user_id){
        $holiday_count = $this->check_holidays($form_date, $to_date);
        $working_days = working_days($form_date, $to_date);
        //  dd($holiday_count, $working_days, $data['attendance_log']);
        $attendance_log = AttendanceLog::select(DB::raw('sum(late) as `lates`, sum(absent) as `absents`, sum(on_leave) as `leaves` , sum(half_leave) as `half_leaves` , count(user_id) as `attendance_marked` , MONTH(attendance_date) month'), 'user_id')
            ->where('user_id', $user_id)
            ->whereBetween('attendance_date', [$form_date, $to_date])
            ->groupBy('user_id','month')
            ->get();
        $presents = $lates = $total_marked_attendances = 0;
        foreach ($attendance_log as $attendance){
            $total_marked_attendances += $attendance->attendance_marked;
            $total_presents =  $attendance->attendance_marked - ($attendance->absents + $attendance->leaves);
            $presents += $total_presents;
            $lates += $attendance->lates;
        }
        $unmarked_attendance_days = $working_days - $holiday_count - $total_marked_attendances;
        $total_working_days = $working_days - $holiday_count - $unmarked_attendance_days;
        $presents = floor($presents / $total_working_days * 100);
        $lates = floor($lates / $total_working_days * 100);
        $attendance = ['presents' => $presents, 'late' => $lates ];
        return $attendance;
    }
}