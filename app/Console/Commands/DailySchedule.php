<?php
namespace App\Console\Commands;
use App\Models\EmployeePIP;
use App\Models\EmployeeSeparation;
use App\Models\LeavesBucket;
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
        $this->create_leave_bucket();
        $this->check_probation_period();
    }
    private function schedule_all_employees_self_assessment()
    {
        $user_ids = User::whereUserType('Employee')->whereStatus(1)->pluck('user_id')->toArray();
        foreach ($user_ids as $user_id){
            $employees = Employee::where('user_id', $user_id)->first();
            $self_assessment = false;
            // Previous appraisal record check
            $incomplete_evaluation = EmployeeAssessment::with('employees')
                ->where('user_id', $user_id)
                ->where('hr_sign', 0)
                ->orderBy('added_on', 'desc')->first();
            $Previous_EmployeeAssessment = EmployeeAssessment::with('employees')
                ->where('user_id', $user_id)
                ->where('hr_sign', 1)
                ->orderBy('added_on', 'desc')->first();
            if(!$incomplete_evaluation){
                if($Previous_EmployeeAssessment && $Previous_EmployeeAssessment->probation_extension == 'YES' && strtotime($Previous_EmployeeAssessment->probation_extension_to_date) <= strtotime(get_date())){
                    $self_assessment = true;
                    $from_date = date ( "Y-m-d" , strtotime ( $Previous_EmployeeAssessment->probation_extension_to_date));
                }
                else if($Previous_EmployeeAssessment && get_month_diff($Previous_EmployeeAssessment->evaluation_date, get_date()) >= 3){
                    $self_assessment = true;
                    $from_date = date ( "Y-m-d" , strtotime ( $Previous_EmployeeAssessment->evaluation_date));
                } else if(!$Previous_EmployeeAssessment && $employees && $employees->confirmation_date == Null && get_month_diff($employees->joining_date, get_date()) >= 3){
                    $employee_assessment_id = 0; //for first evaluation
                    $self_assessment = true;
                    $from_date = date ( "Y-m-d" , strtotime ( $employees->joining_date));
                }
            }
            if($self_assessment == true){
                $EmployeeAssessment_data = [
                    'added_by' => 1,
                    'user_id' => $user_id,
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
                $employee_assessment_id = $employee_assessment_initiate->id;
                if($employee_assessment_initiate){
                    $send_email = false;
                    add_notifications('employee_assessments','employee_assessment',$employee_assessment_id,$user_id,'Pending Self Evaluation',$send_email);
                    $manager_id = User::where('user_id', $user_id)->where('user_type','Employee')->pluck('manager_id')->first();
                    add_notifications('employee_assessments','employee_assessment',$employee_assessment_id,$manager_id,'Pending Manager Evaluation',$send_email);
                }
                echo "Employee Assessment Created!\n";
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
    private function create_leave_bucket(){
        try {
            $expire_bucket = LeavesBucket::with('user')->whereDate('start_date','<', now()->subYear())->whereHas('user', function ($query){
                $query->whereStatus(1);
            })->get();
            foreach ($expire_bucket as $bucket){
                $expiryDate = date('Y-m-d', strtotime('+1 year', strtotime($bucket->start_date)) );
                LeavesBucket::whereUserId($bucket->user_id)->update(['start_date' => $expiryDate, 'status' => 0]);

                $send_email = false;
                // notification for hr to approve leave bucket
                add_notifications('leaves_bucket','leaves_bucket',$bucket->bucket_id,43, "Pending Leave Bucket Approvel" ,$send_email);
                echo "Leaves Bucket Created!\n";
            }
        } catch (Exception $e) {
            echo "Check record for leaves bucket\n";
            echo $e;
            return false;
        }
    }
    private function check_probation_period()
    {
        $employee = Employee::whereStatus(1)->where('employment_status', 'Probation')->get();
        foreach ($employee as $emp){
            $notification_date = date('Y-m-d', strtotime($emp->joining_date. ' + 2 months + 14 days'));
            if($notification_date == date('Y-m-d')){
                $send_email = false;
                // notification for hr to create employee assessment
                add_notifications('employee','employee_assessment',$employee->employee_id,43, "Create Employee Assessment of ".$emp->full_name ,$send_email);
                echo "Assessment Notification Created!\n";
            }
        }
    }
}
