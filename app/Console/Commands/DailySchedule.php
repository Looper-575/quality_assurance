<?php
namespace App\Console\Commands;
use App\Models\EmployeePIP;
use App\Models\EmployeeSeparation;
use App\Models\User;
use Illuminate\Console\Command;
use App\Models\Employee;
use App\Models\EmployeeAssessment;
use App\Models\Notifications;
use Illuminate\Support\Facades\DB;
class DailySchedule extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //protected $signature = 'command:name';
    protected $signature = 'schedule:daily';
    /**
     * The console command description.
     *
     * @var string
     */
    //protected $description = 'Command description';
    protected $description = 'Appraisals Schedule';
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->schedule_all_employees_self_assessment();
        $this->schedule_employees_separation();
        $this->employees_pip_review_notification();
    }
    private function schedule_all_employees_self_assessment()
    {
        $users = Employee::with('employee:user_id,user_type')
            ->whereStatus(1)->select('user_id')->get()->toArray();
        foreach ($users as $user){
            $self_assessment = false;
            $employees = Employee::where('user_id', $user['user_id'])->first();
            // Previous appraisal record check
            $incomplete_evaluation = EmployeeAssessment::with('employees')
                ->where('user_id', $user['user_id'])
                ->where('hr_sign', 0)
                ->orderBy('added_on', 'desc')->first();
            $Previous_EmployeeAssessment = EmployeeAssessment::with('employees')
                ->where('user_id', $user['user_id'])
                ->where('hr_sign', 1)
                ->orderBy('added_on', 'desc')->first();
            if($Previous_EmployeeAssessment && !$incomplete_evaluation){
                $employee_assessment_id = $Previous_EmployeeAssessment->id;
                if($Previous_EmployeeAssessment->probation_extension == 'YES'){
                    if(strtotime($Previous_EmployeeAssessment->probation_extension_to_date) <= strtotime(get_date()) ) {
                        $self_assessment = true;
                        $from_date = date ( "Y-m-d" , strtotime ( $Previous_EmployeeAssessment->probation_extension_to_date));
                    }
                }else{
                    if(get_month_diff($Previous_EmployeeAssessment->evaluation_date, get_date()) >= 3) {
                        $self_assessment = true;
                        $from_date = date ( "Y-m-d" , strtotime ( $Previous_EmployeeAssessment->evaluation_date));
                    }
                }
            } else if(!$incomplete_evaluation) {
                $employee_assessment_id = 0; //for first evaluation
                if($employees->confirmation_date == Null){
                    if (get_month_diff($employees->joining_date, get_date()) >= 3) {
                        $self_assessment = true;
                        $from_date = date ( "Y-m-d" , strtotime ( $employees->joining_date));
                    }
                }else{
                    if (get_month_diff($employees->confirmation_date, get_date()) >= 3) {
                        $self_assessment = true;
                        $from_date = date ( "Y-m-d" , strtotime ( $employees->confirmation_date));
                    }
                }
            }
            if($self_assessment == true) {
            ////////////////////////////////////////////////
                $EmployeeAssessment_data = [
                    'added_by' => Auth::user()->user_id,
                    'user_id' => $user['user_id'],
                    'employee_id' => $employees->employee_id,
                    'hr_sign' => 0,
                    'manager_sign' => 0,
                    'employee_sign' => 0,
                    'from_date' => $from_date,
                    'to_date' => get_date()
                ];
                if($employees->confirmation_status == 'Confirmed'){
                    $EmployeeAssessment_data['confirmation_status'] = $employees->confirmation_status;
                }
                $employee_assessment_initiate = EmployeeAssessment::create($EmployeeAssessment_data);
                if($employee_assessment_initiate){
                  if($user['employee']['user_type'] == 'Employee' && !$incomplete_evaluation){
                        $send_email = false;
                        add_notifications('employee_assessments','employee_assessment',$employee_assessment_id,$user['user_id'],'Pending Self Evaluation',$send_email);
                    }
                }
            }
        }
    }
    private function schedule_employees_separation()
    {
        $users = Employee::with('employee:user_id,user_type')
            ->whereStatus(1)->select('user_id')->get()->toArray();
        foreach ($users as $user){
            $employees_separation = EmployeeSeparation::whereStatus(1)
                ->where('user_id',$user['user_id'])
                ->where('effective_from', 'Notice Period')
                ->orderBy('added_on', 'desc')->first();
            if($employees_separation){
                if(strtotime($employees_separation->separation_date) == strtotime(get_date()) ) {
                    // change user status to Separated
                    User::where('user_id', $employees_separation->user_id)->update(['status' => 3]);
                    // change user employee record status to Separated
                    Employee::where('user_id', $employees_separation->user_id)->update(['status' => 3]);
                }
            }
        }
    }
    private function employees_pip_review_notification()
    {
        $today = date('Y-m-d');
        $one_week_from_now = date('Y-m-d', strtotime("+7 days"));
        $users = Employee::with('employee:user_id,user_type')
            ->whereStatus(1)->select('user_id')->get()->toArray();
        foreach ($users as $user){
            $pip = EmployeePIP::where('user_id', $user['user_id'])
                              ->where('target_date','<=',$today)
                              ->where('manager_approve',0)
                              ->first();
            if($pip > 0){
                $send_email = false;
                add_notifications('employee_pip','employee_pip',$pip->pip_id,$pip->manager_id,"Employee's PIP target duration is completed" ,$send_email);
                $hr_user_ids = User::where('role_id', 5)->get()->pluck('user_id')->toArray();
                if(count($hr_user_ids)>0){
                    for($i=0; $i<count($hr_user_ids); $i++){
                        $send_email = false;
                        add_notifications('employee_pip','employee_pip',$pip->pip_id,$hr_user_ids[$i],"Employee's PIP target duration is completed" ,$send_email);
                    }
                }
            }
        }
    }
}
