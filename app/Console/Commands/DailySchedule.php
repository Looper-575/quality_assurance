<?php

namespace App\Console\Commands;

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
    }

    private function schedule_all_employees_self_assessment()
    {
        try {
            $users = Employee::with('employee:user_id,user_type')
                ->whereStatus(1)->select('user_id')->get()->toArray();
            foreach ($users as $user) {
                // dd($user['user_id'],$user['employee']['user_type']);
                $self_assessment = false;
                // Previous appraisal record check
                $incomplete_evaluation = EmployeeAssessment::with('employees')
                    ->where('user_id', $user['user_id'])
                    ->where('hr_sign', 0)
                    ->orderBy('added_on', 'desc')->first();
                $Previous_EmployeeAssessment = EmployeeAssessment::with('employees')
                    ->where('user_id', $user['user_id'])
                    ->where('hr_sign', 1)
                    ->orderBy('added_on', 'desc')->first();
                if ($Previous_EmployeeAssessment && !$incomplete_evaluation) {
                    $employee_assessment_id = $Previous_EmployeeAssessment->id;
                    if (get_month_diff($Previous_EmployeeAssessment->evaluation_date, get_date()) == 3) {
                        $self_assessment = true;
                    }
                } else if (!$incomplete_evaluation) {
                    $employee_assessment_id = 0; //for first evaluation
                    $employees = Employee::where('user_id', $user['user_id'])->first();
                    if (get_month_diff($employees->joining_date, get_date()) >= 3) {
                        $self_assessment = true;
                    }
                }
                if ($self_assessment == true) {
                    if ($user['employee']['user_type'] == 'Employee') {
                        $Notification_data = Notifications::where([
                            'reference_table' => 'employee_assessments',
                            'type' => 'Evaluation',
                            'reference_id' => $employee_assessment_id,
                            'user_id' => $user['user_id'],
                        ])->first();
                        if (!$incomplete_evaluation && !$Notification_data) {
                            add_notifications('employee_assessments', 'Evaluation', $employee_assessment_id, $user['user_id'], 'Pending Self Evaluation');
                        }
                    }
                }
                // return $self_assessment;
            }
        } catch (Exception $ex) {
            $log = $ex;
        } finally {
            $log = "Executed Successfully";
        }
        DB::table('cron_logs')->update([
            'title' => 'Appraisals Cron',
            'log' => $log,
            'execution_time' => get_date_time()
        ])->where('id',1);
    }
}

