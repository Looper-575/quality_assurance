<?php
namespace App\Http\Controllers;
use App\Models\AttendanceLog;
use App\Models\Department;
use App\Models\EmployeeObjectives;
use App\Models\EvaluationStandards;
use App\Models\Holiday;
use App\Models\LeavesBucket;
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
        $manager_id = User::where('manager_id', Auth::user()->user_id)->where('user_type','Employee')->get()->pluck('manager_id')->toArray();
        $data['is_admin'] = false;
        $data['is_hrm'] = false;
        $data['is_manager'] = false;
        $data['is_employee'] = false;
        $data['EmployeeAssessment_SELF'] = EmployeeAssessment::with('employees.employee', 'evaluation_standards')->where('user_id', Auth::user()->user_id)->get();
        if(Auth::user()->role_id == 1){
            $data['is_admin'] = true;
            $data['EmployeeAssessment_SELF'] = false;
            $data['EmployeeAssessment'] = EmployeeAssessment::with('employees.employee', 'evaluation_standards')->orderBy('id', 'DESC')->get();
        }else if(Auth::user()->role_id == 5){
            $data['is_hrm'] = true;
            // get employee under HR manager
            $data['EmployeeAssessment'] = EmployeeAssessment::with('employees.employee', 'evaluation_standards')->where('user_id', '!=', Auth::user()->user_id)->orderBy('id', 'DESC')->get();
        }else if(in_array(Auth::user()->user_id, $manager_id)){
            $data['is_manager'] = true;
            // get employee under logged in manager
            $user_ids = User::where('manager_id', Auth::user()->user_id)->where('user_type','Employee')->get()->pluck('user_id')->toArray();
            $data['EmployeeAssessment'] = EmployeeAssessment::with('employees.employee', 'evaluation_standards')->whereIn('user_id', $user_ids)->orderBy('id', 'DESC')->get();
        }else{
            $data['is_employee'] = true;
            $data['EmployeeAssessment'] = false;
        }
        $Initiated_EmployeeAssessment = EmployeeAssessment::with('employees.employee')
            ->where('user_id', Auth::user()->user_id)
            ->where('employee_sign', 0)
            ->orderBy('added_on', 'desc')->first();
        if($Initiated_EmployeeAssessment){
            $data['emp_assessment'] = true;
        }else{
            $data['emp_assessment'] = false;
        }
        return view('employee_assessment.employee_assessment_list' , $data);
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
        $data['initiated_employee_assessment'] = false;
        if(isset($request->id)) {
            // FOR MANAGER && HR ASSESSMENTS
            $EmployeeAssessment = EmployeeAssessment::with('employees.employee', 'evaluation_standards')
                ->where('id', $request->id)->first();

            $data['EmployeeAssessment'] = $EmployeeAssessment;
            // Previous appraisal record check
            $Previous_EmployeeAssessment = EmployeeAssessment::where('user_id', $EmployeeAssessment->user_id)
                ->where('id', '!=' ,$request->id)
                ->where('hr_sign',1)
                ->orderBy('added_on', 'desc')->get();
            if(isset($Previous_EmployeeAssessment[0]->confirmation_status)) {
                $data['prob_status'] = $Previous_EmployeeAssessment[0]->confirmation_status;
            }else{
                $data['prob_status'] = $EmployeeAssessment->employees->employment_status;
            }
            $empolyee_filled_evaluation_standards = EvaluationStandards::where('assessment_id',$request->id)
                ->where('remarker_id', $EmployeeAssessment->user_id)->first();
            $user_manager = User::where('user_id', $EmployeeAssessment->user_id)->first();
            if($empolyee_filled_evaluation_standards){
                $data['empolyee_filled_evaluation_standards'] = $empolyee_filled_evaluation_standards;
            }else{
                $data['empolyee_filled_evaluation_standards'] = false;
            }
            $manager_filled_evaluation_standards = EvaluationStandards::where([
                'remarker_id' => $user_manager->manager_id,
                'assessment_id' => $request->id
            ])->first();
            if($manager_filled_evaluation_standards){
                $data['manager_filled_evaluation_standards'] = $manager_filled_evaluation_standards;
            }else{
                $data['manager_filled_evaluation_standards'] = false;
            }

            $diff = abs(strtotime($EmployeeAssessment->employees->joining_date) - strtotime(get_date()));
            $years = floor($diff / (365*60*60*24));
            $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
            $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

            $total_service = $years." Year ".$months." Months ". $days." Days";
            $data['total_service'] = $total_service;
            $data['previous_overall_ratings'] = [];
            $data['employee_previous_objectives'] = false;
            $to_date = null;
            if(count($Previous_EmployeeAssessment) > 0){
                foreach ($Previous_EmployeeAssessment as $Confirmations) {
                    array_push($data['previous_overall_ratings'],$Confirmations->overall_rating);
                }
                $data['employee_previous_objectives'] = EmployeeObjectives::where('assessment_id',$Previous_EmployeeAssessment[0]->id)
                    ->orderBy('added_on', 'desc')->get();
            }
            if(count($Previous_EmployeeAssessment) > 0){
                if($Previous_EmployeeAssessment[0]->evaluation_date != ''){
                    $from_date = date ( "Y\-m\-d" , strtotime ( $Previous_EmployeeAssessment[0]->evaluation_date ));
                }else if($EmployeeAssessment){
                    $from_date = date ( "Y\-m\-d" , strtotime ( $EmployeeAssessment->from_date ));
                    $to_date = date ( "Y\-m\-d" , strtotime ( $EmployeeAssessment->to_date ));
                }else{
                    $employees = Employee::where('user_id', $Previous_EmployeeAssessment[0]->user_id)->first();
                    if($employees->confirmation_date == Null){
                        $from_date = date ( "Y\-m\-d" , strtotime ( $employees->joining_date ));
                    }else{
                        $from_date = date ( "Y\-m\-d" , strtotime ( $employees->confirmation_date ));
                    }
                }
            }else{
                $employees = Employee::where('user_id', $EmployeeAssessment->user_id)->first();
                if($employees->confirmation_date == Null){
                    $from_date = date ( "Y\-m\-d" , strtotime ( $employees->joining_date ));
                }else{
                    $from_date = date ( "Y\-m\-d" , strtotime ( $employees->confirmation_date ));
                }
            }
            if($to_date == NULL){
                $to_date = get_date();
            }
            $data['attendance_log'] = $this->get_attendance_log($from_date, $to_date,$EmployeeAssessment->user_id);
            if($EmployeeAssessment->employee_sign == 0){
                $data['initiated_employee_assessment'] = true;
            }

            if(Auth::user()->role_id == 1){
                $data['is_admin'] = true;
            }

            if($EmployeeAssessment->employees->employee->manager_id == Auth::user()->user_id){
                $data['is_manager'] = true;
                if($EmployeeAssessment->manager_sign == 1 && Auth::user()->role_id == 5){
                    $data['is_hrm'] = true;
                    $data['is_manager'] = false;
                }
            } else{
                $data['is_employee'] = true;
                if($EmployeeAssessment->manager_sign == 1 && $EmployeeAssessment->employee_sign == 1 && Auth::user()->role_id == 5){
                    $data['is_hrm'] = true;
                    $data['is_manager'] = false;
                    $data['is_employee'] = false;
                }
            }
        }else{
            // FOR ALL EMPLOYEES SELF ASSESSMENT
            $data['EmployeeAssessment'] = false;
        }
        return view('employee_assessment.employee_assessment_form',$data);
    }
    public function employee_assessment_save(Request $request){
        $validator = '';
        if(isset($request->esa_duties)){
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'user_id' => 'required',
                'employee_id' => 'required',
                'esa_duties' => 'required',
                'esa_achievements' => 'required',
                'esa_future_aims' => 'required'
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
                'from_date' => 'required',
                'to_date' => 'required',
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
            $EmployeeAssessment = EmployeeAssessment::where('id', $request->id)->first();
            $EmployeeAssessment_data = '';
            if($EmployeeAssessment){
                $user_id = $EmployeeAssessment->user_id;
            }
            if(isset($request->esa_duties)){
                $confirmation_status = 'Probation';
                // Previous appraisal record check
                $Previous_EmployeeAssessment = EmployeeAssessment::where('user_id', $request->user_id)
                    ->orderBy('added_on', 'desc')->first();
                if($Previous_EmployeeAssessment){
                    $confirmation_status = $Previous_EmployeeAssessment->confirmation_status;
                }
                $EmployeeAssessment_data = [
                    'added_by' => Auth::user()->user_id,
                    'user_id' => $request->user_id,
                    'employee_id' => $request->employee_id,
                    'esa_duties' => $request->esa_duties,
                    'esa_achievements' => $request->esa_achievements,
                    'esa_future_aims' => $request->esa_future_aims,
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
                if(isset($request->objective) && $request->objective[0] != NULL){
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
                    'from_date' => $request->from_date,
                    'to_date' => $request->to_date,
                    'total_service' => $request->total_service,
                    'attendance' => $request->attendance,
                    'tardiness' => $request->tardiness,
                    'written_warning' => $request->written_warning,
                    'verbal_warning' => $request->verbal_warning,
                    'hr_comments' => $request->hr_comments,
                    'hr_sign' => 1,
                    'evaluation_date' => get_date(),
                    'confirmation_status' => $request->confirmation_status,
                    'increment' => $request->increment
                ];
                $employee_data = Employee::with('employee')->where('user_id', $user_id)->first();
                $employee_salary_increment = $employee_data->net_salary + $request->increment;
                Employee::where('user_id', $user_id)->update(['net_salary' => $employee_salary_increment]);
                if($request->employee_current_status == 'Nesting'){
                    // if employee must pass to probation status after nesting then will be confirmd later
                    $EmployeeAssessment_data['confirmation_status'] = 'Probation';
                    Employee::where('user_id', $user_id)->update([
                        'employment_status' => 'Probation'
                    ]);
                }else {
                    if($request->confirmation_status == 'Confirmed'){
                        if($employee_data->confirmation_date == NULL){
                            Employee::where('user_id', $user_id)->update([
                                'employment_status' => $request->confirmation_status,
                                'confirmation_date' => get_date()
                            ]);
                        }
                        $EmployeeAssessment_data['probation_extension'] = 'NO';
                        $EmployeeAssessment_data['probation_extension_to_date'] = NULL;
                        $Leaves_Bucket_record = LeavesBucket::where('user_id',$user_id)->count();
                        if($Leaves_Bucket_record == 0 && ($employee_data->employment_status == 'Confirmed' || $request->employment_status == 'Confirmed')) {
                            generate_single_employee_leaves_bucket($request->user_id);
                        }
                    }else{
                        Employee::where('user_id', $user_id)->update([
                            'employment_status' => $request->confirmation_status
                        ]);
                        if($request->probation_extension == 'YES'){
                            Employee::where('user_id', $user_id)->update([
                                'employment_status' => 'Probation'
                            ]);
                            $EmployeeAssessment_data['confirmation_status'] = 'Probation';
                            $EmployeeAssessment_data['probation_extension'] = 'YES';
                            $EmployeeAssessment_data['probation_extension_to_date'] = $request->probation_extension_to_date;
                        }
                    }
                }
            }
            if($EmployeeAssessment){
                EmployeeAssessment::where('id', $EmployeeAssessment->id)->update($EmployeeAssessment_data);
                $employee_assessment_id = $EmployeeAssessment->id;
            } else {
                $prob = EmployeeAssessment::create($EmployeeAssessment_data);
                $employee_assessment_id = $prob->id;
            }
            // NOTIFICATIONs and EVAL STANARDS DATA Save from here onwards
            if(isset($request->esa_duties)) {
                // NOTIFICATION TRAY
                $send_email = false;
                $manager_id = User::where('user_id', Auth::user()->user_id)->where('user_type','Employee')->pluck('manager_id')->first();
                add_notifications('employee_assessments','employee_assessment',$employee_assessment_id,$manager_id,'Pending Manager Evaluation',$send_email);
            }
            if(isset($request->manager_comments)){
                // Notification Tray
                $hr_user_ids = User::where('role_id', 5)->get()->pluck('user_id')->toArray();
                if(count($hr_user_ids)>0){
                    for($i=0; $i<count($hr_user_ids); $i++){
                        $send_email = false;
                        add_notifications('employee_assessments','employee_assessment',$employee_assessment_id,$hr_user_ids[$i],'Pending HR Evaluation',$send_email);
                    }
                }
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
                    $hr_user_ids = User::where('role_id', 5)->get()->pluck('user_id')->toArray();
                    if(count($hr_user_ids)>0){
                        for($i=0; $i<count($hr_user_ids); $i++){
                            $send_email = false;
                            add_notifications('employee_assessments','employee_assessment',$employee_assessment_id,$hr_user_ids[$i],'Pending HR Evaluation',$send_email);
                        }
                    }
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
                'quality_of_work' => $request->quality_of_work,
                'quantity_of_work' => $request->quantity_of_work,
                'organization_planning' => $request->organization_planning,
                'productivity' => $request->productivity,
                'reliability' => $request->reliability,
                'attitude' => $request->attitude,
                'last_eval_objectives_achieved' => $request->last_eval_objectives_achieved,
                'WOW' => $request->WOW
            ];
            if(isset($request->hr_comments) || isset($request->manager_comments)) {
                $Eval_data['leadership'] = $request->leadership;
                $Eval_data['coaching'] = $request->coaching;
                $Eval_data['supervision'] = $request->supervision;
            }
            if(isset($request->hr_comments)) {
                // check employee is manager or not
                $manager_id = User::where('manager_id', Auth::user()->user_id)->where('user_type','Employee')->get()->pluck('manager_id')->toArray();
                if(in_array($employee_record->employee->user_id, $manager_id)){
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
            ])->first();
            if($EvaluationStandards){
                EvaluationStandards::where('eval_id', $EvaluationStandards->eval_id)->update($Eval_data);
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
        $data['is_admin'] = false;
        $data['is_hrm'] = false;
        $data['is_manager'] = false;
        $data['is_employee'] = false;

        if(isset($request->id)) {
            $EmployeeAssessment_data = EmployeeAssessment::with('employees.employee')->where('id', $request->id)->first();
            $data['EmployeeAssessment'] = $EmployeeAssessment_data;
            $data['employee_self_evaluation'] = EvaluationStandards::where([
                                                    'remarker_id' => $EmployeeAssessment_data->user_id,
                                                    'assessment_id' => $request->id
                                                ])->first();
            $user_manager = User::where('user_id', $EmployeeAssessment_data->user_id)->first();
            $manager_details = User::where('user_id', $user_manager->manager_id)->first();
            $data['manager_name'] = $manager_details->full_name;
            $data['employee_manager_evaluation'] = EvaluationStandards::where([
                                                        'remarker_id' => $user_manager->manager_id,
                                                        'assessment_id' => $request->id
                                                    ])->first();
            $HR_manager = User::where('role_id', 5)->first();
            $data['hr_name'] = $HR_manager->full_name;
            $data['employee_hr_evaluation'] = EvaluationStandards::where([
                                                    'remarker_id' => $HR_manager->user_id,
                                                    'assessment_id' => $request->id
                                                ])->first();
            $data['standards_average'] = $this->calculate_overall_rating_avg($EmployeeAssessment_data->id,$EmployeeAssessment_data->user_id);
            $data['employee_objectives'] = EmployeeObjectives::where('assessment_id',$EmployeeAssessment_data->id)
                ->orderBy('added_on', 'desc')->get();
            if(Auth::user()->role_id == 1){
                $data['is_admin'] = true;
            }

            if($EmployeeAssessment_data->employees->employee->manager_id == Auth::user()->user_id){
                $data['is_manager'] = true;
                if($EmployeeAssessment_data->manager_sign == 1 && Auth::user()->role_id == 5){
                    $data['is_hrm'] = true;
                    $data['is_manager'] = false;
                }
            } else{
                $data['is_employee'] = true;
                if($EmployeeAssessment_data->user_id != Auth::user()->user_id && Auth::user()->role_id == 5){
                    $data['is_hrm'] = true;
                    $data['is_manager'] = false;
                    $data['is_employee'] = false;
                }
            }
        }else{
            $data['EmployeeAssessment'] = false;
            $data['employee_self_evaluation'] = false;
            $data['employee_manager_evaluation'] = false;
            $data['employee_hr_evaluation'] = false;
            $data['standards_average'] = false;
            $data['employee_objectives'] = false;
          }
        return view('employee_assessment.view_employee_assessment', $data);
    }
    public function get_employee_details(Request $request)
    {
        $data = Employee::with('department')->where('user_id', $request->user_id)->first();
        return response()->json($data);
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
    private function check_holidays($from_date, $to_date, $user_id)
    {
        $department_id = User::whereUserId($user_id)->whereStatus(1)->pluck('department_id')->first();
        $check_holidays = Holiday::where(function ($query_dpt) use($department_id) {
            return $query_dpt->where('department_id', $department_id)
                ->orWhere('department_id',0);
        })
            ->where(function ($query) use($user_id) {
                return $query->whereRaw('FIND_IN_SET("'.$user_id.'",user_id)')
                    ->orWhere('user_id',0);
            })
            ->where(function ($query_date) use($from_date, $to_date) {
                return $query_date->whereBetween('date_from', [$from_date, $to_date])
                    ->orWhereBetween('date_to', [$from_date, $to_date]);
            })
            ->get();
        $holiday_count = 0;
        foreach ($check_holidays as $day){
            $holiday_count = 1;
            if($day->date_from >= $from_date){
                $from = $day->date_from;
            } else {
                $from = $from_date;
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
    public function get_attendance_log($from_date, $to_date, $user_id){
        $holiday_count = $this->check_holidays($from_date, $to_date, $user_id);
        $working_days = working_days($from_date, $to_date);
        $attendance_log = AttendanceLog::select(DB::raw('sum(late) as `lates`, sum(absent) as `absents`, sum(on_leave) as `leaves` , sum(half_leave) as `half_leaves` , count(user_id) as `attendance_marked` , MONTH(attendance_date) month'), 'user_id')
            ->where('user_id', $user_id)
            ->whereBetween('attendance_date', [$from_date, $to_date])
            ->groupBy('user_id','month')
            ->get();
        $presents = $lates = $total_marked_attendances = 0;
        foreach ($attendance_log as $attendance){
            $total_marked_attendances += $attendance->attendance_marked;
            $total_presents =  $attendance->attendance_marked - ($attendance->absents + $attendance->leaves);
            $presents += $total_presents;
            $lates += $attendance->lates;
        }
        if($presents != 0){
            $lates = number_format(($lates / $presents) * 100, 1);
        }else{
            $lates = 0;
        }
        if($working_days == 0){$working_days = 1;}
        $presents = number_format((($presents + $holiday_count) / $working_days) * 100, 1);
        $attendance = ['presents' => $presents, 'late' => $lates ];
        return $attendance;
    }

    public function initiate_employee_assessment_form(Request $request){
        $user_ids = EmployeeAssessment::where('employee_sign', 0)
            ->orwhere('manager_sign',0)
            ->orwhere('hr_sign',0)
            ->pluck('user_id')->toArray();
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['users'] = User::has('employee')->whereStatus(1)->whereNotIn('user_id',$user_ids)->where('user_type','Employee')->get();
        }
        return view('employee_assessment.initiate_employee_assessment_form', $data);
    }
    public function employee_assessment_initiate(Request $request)
    {
        $Previous_EmployeeAssessment = EmployeeAssessment::where('user_id', $request->user_id)
            ->orderBy('added_on', 'desc')->first();
        if($Previous_EmployeeAssessment){
            $user_id = $Previous_EmployeeAssessment->user_id;
            $employee_id = $Previous_EmployeeAssessment->employee_id;
            $confirmation_status = $Previous_EmployeeAssessment->confirmation_status;
        }else{
            $user_id = $request->user_id;
            $employee_data = Employee::where('user_id',$user_id)->orderBy('employee_id','DESC')->first();
            $employee_id = $employee_data->employee_id;
            $confirmation_status = $employee_data->employement_status;
        }
        $EmployeeAssessment_data = [
            'added_by' => Auth::user()->user_id,
            'user_id' => $user_id,
            'employee_id' => $employee_id,
            'hr_sign' => 0,
            'manager_sign' => 0,
            'employee_sign' => 0,
            'from_date' => $request->from_date,
            'to_date' => $request->to_date
        ];
        if($confirmation_status == 'Confirmed'){
            $EmployeeAssessment_data['confirmation_status'] = $confirmation_status;
        }
        $employee_assessment_initiate = EmployeeAssessment::create($EmployeeAssessment_data);
        if($employee_assessment_initiate){
            $send_email = false;
            add_notifications('employee_assessments','employee_assessment',$employee_assessment_initiate->id,$user_id,'Pending Self Evaluation',$send_email);
            $manager_id = User::where('user_id', $user_id)->where('user_type','Employee')->pluck('manager_id')->first();
            add_notifications('employee_assessments','employee_assessment',$employee_assessment_initiate->id,$manager_id,'Pending Manager Evaluation',$send_email);
            $response['status'] = "Success";
            $response['result'] = "Employee Assessment Initiated Successfully";
        }else{
            $response['status'] = "Failure";
            $response['result'] = "Some Error in Query";
        }
        return response()->json($response);
    }
    public function get_manager_users_data(Request $request)
    {
        $data['employee'] = User::whereStatus(1)->where('manager_id', $request->manager_id)->get();
        return response()->json($data);
    }
}
