<?php /** @noinspection ALL */
namespace App\Http\Controllers;
use App\Http\Middleware\PreventRequestsDuringMaintenance;
use App\Models\CallDispositionsService;
use App\Models\AttendanceLog;
use App\Models\Employee;
use App\Models\EmployeeAssessment;
use App\Models\Enquiry;
use App\Models\LeaveApplication;
use App\Models\ManagerialRole;
use App\Models\Notifications;
use App\Models\Task;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\CallDisposition;
use Illuminate\Support\Facades\DB;
use DateTime;
class DashboardController extends Controller
{
    /**
     * Home page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $role = Auth::user()->role_id;
        if($role==1){
            return $this->provider_dashboard();
        } else if($role==2 || $role==3)  {
            return $this->team_dashboard();
        } else if($role==4 || $role == 22) {
            return $this->csr_dashboard();
        } else if($role==10) {
            return $this->qa_dashboard();
        } else if($role==13) {
            return $this->vendor_dashboard();
        } else if($role==5) {
            return $this->hr_dashboard();
        } else if($role==16 || $role==17 || $role==18 || $role==19) {
            return $this->dev_team_dashboard();
        } else {
            return $this->default();
        }
    }

    public function default()
    {
        $data['page_title'] = "Dashboard - Atlantis BPO CRM";
        return view('dashboard.default_dashboard',$data);
    }

    private function dev_team_dashboard(){
        $data['page_title'] = "Development Team Dashboard - Atlantis BPO CRM";
        // Current Month Attendance Log
        // MY Attendance Log
        $attendance_log = AttendanceLog::with('user.employee')
            ->select(DB::raw('sum(late) as `lates`, sum(absent) as `absents`, sum(on_leave) as `leaves` , sum(applied_leave) as `applied_leave`, sum(half_leave) as `half_leaves` , count(user_id) as `attendance_marked`, ANY_VALUE(user_id) as user_id, ANY_VALUE(attendance_date) as attendance_date'))
            ->where('user_id', Auth::user()->user_id)
            ->where(DB::raw("(DATE_FORMAT(attendance_date,'%m'))"),date('m'))
            ->first();
        if($attendance_log){
            if($attendance_log->lates != null){
                $data['lates'] = $attendance_log->lates;
            }else{
                $data['lates'] = 0;
            }
            if($attendance_log->absents != null){
                $data['absents'] = $attendance_log->absents;
            }else{
                $data['absents'] = 0;
            }
            if($attendance_log->leaves != null){
                $data['on_leave'] = $attendance_log->leaves;
            }else{
                $data['on_leave'] = 0;
            }
            if($attendance_log->half_leaves != null){
                $data['half_leaves'] = $attendance_log->half_leaves;
            }else{
                $data['half_leaves'] = 0;
            }
            $data['presents'] = $attendance_log->attendance_marked - $attendance_log->absents - $attendance_log->leaves;
        }else{
            $data['lates'] = 0;
            $data['absents'] = 0;
            $data['on_leave'] = 0;
            $data['presents'] = 0;
            $data['unmarked'] = 0;
            $data['half_leaves'] = 0;
        }
        /* **************************** */
        // MY Team Members Attendance Log
        $my_team_id = Team::whereStatus(1)->where('team_lead_id',Auth::user()->user_id)->pluck('team_id')->first();
        if($my_team_id){
            $team_members = TeamMember::where('team_id',$my_team_id)->get()->pluck('user_id');
            $team_attendance_log = AttendanceLog::select(DB::raw('sum(late) as `lates`, sum(absent) as `absents`, sum(on_leave) as `leaves` , sum(applied_leave) as `applied_leave`, sum(half_leave) as `half_leaves` , count(user_id) as `attendance_marked`, ANY_VALUE(user_id) as user_id'))
                ->whereIn('user_id', $team_members)
                ->where(DB::raw("(DATE_FORMAT(attendance_date,'%m'))"),date('m'))
                //->groupBy('user_id') // GIVES SEPERATE RECORD FOR EACH TEAM MEMBER
                ->first();
            if($team_attendance_log){
                if($team_attendance_log->lates != null){
                    $data['team_lates'] = $team_attendance_log->lates;
                }else{
                    $data['team_lates'] = 0;
                }
                if($team_attendance_log->absents != null){
                    $data['team_absents'] = $team_attendance_log->absents;
                }else{
                    $data['team_absents'] = 0;
                }
                if($team_attendance_log->leaves != null){
                    $data['team_on_leave'] = $team_attendance_log->leaves;
                }else{
                    $data['team_on_leave'] = 0;
                }
                if($team_attendance_log->half_leaves != null){
                    $data['team_half_leaves'] = $team_attendance_log->half_leaves;
                }else{
                    $data['team_half_leaves'] = 0;
                }
            }else{
                $data['team_lates'] = 0;
                $data['team_absents'] = 0;
                $data['team_on_leave'] = 0;
                $data['team_half_leaves'] = 0;
            }
            $data['have_team'] = true;
        }else{
            $data['have_team'] = false;
        }
        /* **************************** */
        $all_events = array();
        // Own Tasks
        $own_tasks = Task::where('assigned_to',Auth::user()->user_id)->whereStatus(0)->get()->toArray();
        $my_pending_tasks = 0;
        if($own_tasks) {
            $my_pending_tasks = count($own_tasks);
            $own_tasks_events[] = array();
            foreach ($own_tasks as $task) {
                $task_description = strip_tags(htmlspecialchars_decode($task['description']));
                $own_tasks_events = array(
                    "title" => $task['title']." assigned to me",
                    "start" => $task['start_date'],
                    "end" => $task['end_date'],
                    "url" => "tasks_list",
                    "className" => "m-fc-event--solid-warning",
                    "description" => substr_replace($task_description, "...", 70));
                $all_events[] = $own_tasks_events;
            }
        }
        // MY Department Task or team tasks whom i manage
        $manager = ManagerialRole::Where('type','Manager')->where('role_id', Auth::user()->role_id)->first();
        $manager_team_pending_tasks = 0;
        if($manager){
            $manager_team = User::where('manager_id',Auth::user()->user_id)->get();
            $manager_team_tasks_events[] = array();
            foreach ($manager_team as $team_member) {
                $team_tasks = Task::with('users')->whereStatus(0)->where('assigned_to',$team_member->user_id)->get()->toArray();
                if($team_tasks) {
                    $manager_team_pending_tasks += count($team_tasks);
                    foreach ($team_tasks as $task) {
                        $task_description = strip_tags(htmlspecialchars_decode($task['description']));
                        $manager_team_tasks_events = array(
                            "title" => $task['title']." assigned to ".$task['users']['full_name'],
                            "start" => $task['start_date'],
                            "end" => $task['end_date'],
                            "url" => "tasks_list",
                            "description" => substr_replace($task_description, "...", 70));
                        if($task['added_by'] == Auth::user()->user_id){
                            $manager_team_tasks_events['className'] = 'm-fc-event--solid-info';
                        }else{
                            $manager_team_tasks_events['className'] = 'm-fc-event--solid-primary';
                        }
                        $all_events[] = $manager_team_tasks_events;
                    }
                }
            }
        }
        /////////////////////////////////////////////////////
        // Task created by me (ASSIGNED)
        $my_created_tasks_count = Task::where('added_by',Auth::user()->user_id)
                                 ->whereStatus(0)->whereNotNull('assigned_to')->count();
        // Task created by me (but Not ASSIGNED Yet)
        $unassigned_tasks_count = 0;
        $my_unassigned_created_tasks = Task::where('added_by',Auth::user()->user_id)
                                 ->whereStatus(0)->whereNull('assigned_to')->get()->toArray();
        if($my_unassigned_created_tasks){
            $unassigned_tasks_count = count($my_unassigned_created_tasks);
            $my_unassigned_created_tasks_events[] = array();
            foreach($my_unassigned_created_tasks as $task) {
                $task_description = strip_tags(htmlspecialchars_decode($task['description']));
                $my_unassigned_created_tasks = array(
                    "title" => $task['title'],
                    "start" => $task['start_date'],
                    "end" => $task['end_date'],
                    "url" => "tasks_list",
                    "className" => "m-fc-event--solid-danger",
                    "description" => substr_replace($task_description, "...", 70));
                $all_events[] = $my_unassigned_created_tasks;
            }
        }
        ///////////////////////////////////////////
        $birthday = Employee::select(DB::raw("full_name , DATE_FORMAT(date_of_birth,'%m-%d') as birthday"))->whereStatus(1)
            ->whereHas('employee', function ($query){
                $query->where('status', 1);
            })->get()->toArray();
        $birthday_events[] = array();
        foreach($birthday as $event) {
            $birthday_start = date("Y").'-'.$event['birthday'].' 00:00:00';
            $birthday_end = date("Y").'-'.$event['birthday'].' 23:59:59';
            $birthday_events = array(
                "title" => $event['full_name']."'s Birthday",
                "start" => $birthday_start,
                "end" => $birthday_end,
                "className" => "m-fc-event--solid-info",
                "description" => $event['full_name']."'s Birthday");
            $all_events[] = $birthday_events;
        }
        /// ////////////////////////////////////////////
        $all_events = json_encode($all_events);
        $all_events = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $all_events);
        $data['calendar_events'] = $all_events;
        $data['my_pending_tasks'] = $my_pending_tasks;
        $data['manager_team_pending_tasks'] = $manager_team_pending_tasks;
        $data['my_created_tasks_count'] = $my_created_tasks_count;
        $data['unassigned_tasks_count'] = $unassigned_tasks_count;
        return view('dashboard.dev_team_dashboard',$data);
    }
    private function hr_dashboard()
    {
        $data['page_title'] = "HR Dashboard - Atlantis BPO CRM";
        $team_member_count = TeamMember::count();
        $team_leads_count = Team::whereStatus(1)->count();
        $total_users = $team_leads_count + $team_member_count;
        $attendance_log = AttendanceLog::with('user.employee')
            ->select(DB::raw('sum(late) as `lates`, sum(absent) as `absents`, sum(on_leave) as `leaves` , sum(applied_leave) as `applied_leave`, sum(half_leave) as `half_leaves` , count(user_id) as `attendance_marked`, ANY_VALUE(user_id) as user_id'))
            ->where('attendance_date', get_date())
            ->first();
        if($attendance_log){
            if($attendance_log->lates != null){
                $data['lates'] = $attendance_log->lates;
            }else{
                $data['lates'] = 0;
            }
            if($attendance_log->absents != null){
                $data['absents'] = $attendance_log->absents;
            }else{
                $data['absents'] = 0;
            }
            if($attendance_log->leaves != null){
                $data['on_leave'] = $attendance_log->leaves;
            }else{
                $data['on_leave'] = 0;
            }
            $data['presents'] = $attendance_log->attendance_marked - $attendance_log->absents - $attendance_log->leaves;
            $data['unmarked'] = $total_users - $attendance_log->attendance_marked;
        }else{
            $data['lates'] = 0;
            $data['absents'] = 0;
            $data['on_leave'] = 0;
            $data['presents'] = 0;
            $data['unmarked'] = 0;
        }
        // pending_leaves_for_approval
        $pending_leaves_for_approval_by_manager = LeaveApplication::whereStatus(1)->where('approved_by_manager',NULL)->count();
        $pending_leaves_for_approval_by_hr = LeaveApplication::whereStatus(1)->where('approved_by_hr',NULL)->count();
        $data['pending_approval_manager'] = $pending_leaves_for_approval_by_manager;
        $data['pending_approval_hr'] = $pending_leaves_for_approval_by_hr;
        // Birthdays & Appraisal
        $all_events = array();
        // Appraisals pending and upcoming
        $appraisals = $this->get_employees_assessment_for_calender();
        $data['pending_appraisals'] = count($appraisals);
        $appraisal_notifications[] = array();
        foreach($appraisals as $appraisal) {
            $start_date_time = $appraisal['appraisal_date'].' 00:00:00';
            $end_date_time = $appraisal['appraisal_date'].' 23:59:59';
            $appraisal_notifications = array(
                "title" => $appraisal['employee_name']."'s Evaluation",
                "start" => $start_date_time,
                "end" => $end_date_time,
                "className" => "m-fc-event--primary",
                "description" => $appraisal['employee_name']."'s Evaluation is pending");
            $all_events[] = $appraisal_notifications;
        }
        // Appraisal pending for HR Approval
        $hr_pending_appraisals = EmployeeAssessment::with('employees')
            ->where('hr_sign', '!=', 1)
            ->orderBy('added_on', 'desc')->get()->toArray();
        $data['hr_pending_appraisals'] = count($hr_pending_appraisals);
        $hr_pending_appraisal_notifications[] = array();
        foreach($hr_pending_appraisals as $hr_pending_appraisal) {
            $new_appraisal_date = date("Y-m-d", strtotime("+3 month", strtotime($hr_pending_appraisal['evaluation_date'])));
            $start_date_time = $new_appraisal_date.' 00:00:00';
            $end_date_time = $new_appraisal_date.' 23:59:59';
            $hr_pending_appraisal_notifications = array(
                "title" => $hr_pending_appraisal['employees']['full_name']."'s Evaluation",
                "start" => $start_date_time,
                "end" => $end_date_time,
                "className" => "m-fc-event--brand",
                "url" => "employee_assessment",
                "description" => $hr_pending_appraisal['employees']['full_name']."'s HR Evaluation is pending");
            $all_events[] = $hr_pending_appraisal_notifications;
        }
       // dd($data['hr_pending_appraisals'], $hr_pending_appraisals);
        /////////////////////////////////////////////////////////
        $birthday = Employee::with('employee')->select(DB::raw("full_name , DATE_FORMAT(date_of_birth,'%m-%d') as birthday"))->whereStatus(1)
            ->whereHas('employee', function ($query){
                $query->where('status', 1);
            })
            ->get()->toArray();
        $birthday_events[] = array();
        foreach($birthday as $event) {
            $birthday_start = date("Y").'-'.$event['birthday'].' 00:00:00';
            $birthday_end = date("Y").'-'.$event['birthday'].' 23:59:59';
            $birthday_events = array(
                "title" => $event['full_name']."'s Birthday",
                "start" => $birthday_start,
                "end" => $birthday_end,
                "className" => "m-fc-event--solid-info",
                "description" => $event['full_name']."'s Birthday");
            $all_events[] = $birthday_events;
        }
        $all_events = json_encode($all_events);
        $all_events = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $all_events);
        $data['calendar_events'] = $all_events;
        return view('dashboard.hr_dashboard',$data);
    }
    private function admin_dashboard()
    {
        $data['page_title'] = "Admin Dashboard - Atlantis CRM";
        $data['small_nav'] = true;
        $today = get_date();
        $datetime = new DateTime($today);
        $date_today = date("d", strtotime($today));
        // daily counts
        $hour = date("H", strtotime(get_date_time()));
        if ($hour >= 17) {
            $from_date = date("Y-m-d", strtotime($today));
            $to_date = date("Y-m-d", strtotime($today));
            $from_date = $from_date . ' 17:00:00';
            $to_date = $to_date . ' 23:59:59';
        } else {
            $from_date = date("Y-m-d", strtotime("-1 Day", strtotime($today)));
            $to_date = date("Y-m-d", strtotime($today));
            $from_date = $from_date . ' 17:00:00';
            $to_date = $to_date . ' 17:00:00';
        }
        $data['daily_counts'] = $this->get_rgo_counts($from_date, $to_date);
        // 6 months sales/calls graph data
        // sales
        $dates[] = get_date_interval();
        $to_date = $dates[0]['to_date'];
        $from_date = $dates[0]['from_date'];
        $data['sale_made'] = CallDisposition::where(['status' => 1, 'disposition_type' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['call_back'] = CallDisposition::where(['status' => 1, 'disposition_type' => 2])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['customer_service'] = CallDisposition::where(['status' => 1, 'disposition_type' => 3])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['no_answer'] = CallDisposition::where(['status' => 1, 'disposition_type' => 4])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['call_transferred'] = CallDisposition::where(['status' => 1, 'disposition_type' => 5])->whereBetween('added_on', [$from_date, $to_date])->count();
        // ^ months Sales Graph
        $data['six_months_dispositions_count'] = $this->get_6_months_dipositions_count($from_date, $to_date);
        $data['six_months_sales_count'] = $this->get_6_months_rgo_counts($from_date, $to_date);
        // STATS TABLE
        $data['provider_based_stats'] = CallDispositionsService::select('provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))->where(['status' => 1])->with('call_disposition')->whereBetween('added_on', [$from_date, $to_date])->groupBy('provider_name')->get();
        return view('dashboard.dashboard', $data);
    }
    private function team_dashboard()
    {
        $data['page_title'] = "Lead Dashboard - Atlantis CRM";
        $data['small_nav'] = true;
        $today = get_date();
        $datetime = new DateTime($today);
        $date_today = date("d"  ,strtotime($today));
        // daily counts
        $hour = date("H"  ,strtotime(get_date_time()));
        if($hour >= 17) {
            $from_date = date("Y-m-d"  ,strtotime($today));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 23:59:59';
        } else {
            $from_date = date("Y-m-d"  ,strtotime("-1 Day" , strtotime($today)));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 17:00:00';
        }
        $data['daily_counts'] = $this->get_rgo_counts($from_date,$to_date);
        // 6 months sales/calls graph data
        $dates[] = get_date_interval();
        $to_date = $dates[0]['to_date'];
        $from_date = $dates[0]['from_date'];
        $data['sale_made'] = CallDisposition::where(['status' => 1,'disposition_type' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['call_back'] = CallDisposition::where(['status' => 1,'disposition_type' => 2])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['customer_service'] = CallDisposition::where(['status' => 1,'disposition_type' => 3])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['no_answer'] = CallDisposition::where(['status' => 1,'disposition_type' => 4])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['call_transferred'] = CallDisposition::where(['status' => 1,'disposition_type' => 5])->whereBetween('added_on', [$from_date, $to_date])->count();
        // STATS TABLE
        $data['six_months_dispositions_count'] = $this->get_6_months_dipositions_count($from_date,$to_date);
        $data['six_months_sales_count'] =  $this->get_6_months_rgo_counts($from_date, $to_date);
        // main table team based
        //team abdullah
        $team_abdullah = $this->get_team_counts($from_date, $to_date, 4);
        $total = 0;
        foreach ($team_abdullah[0] as $item) {
            $data['team_abdullah'][$item->provider_name] = $item;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        $data['team_abdullah']['others'] = $team_abdullah[1][0] ;
        $data['team_abdullah']['total'] = $total + ($data['team_abdullah']['others']->cable + $data['team_abdullah']['others']->phone + $data['team_abdullah']['others']->internet + $data['team_abdullah']['others']->mobile);
        // team amroz
        $team_amroz = $this->get_team_counts($from_date, $to_date, 6);
        $total = 0;
        foreach ($team_amroz[0] as $item) {
            $data['team_amroz'][$item->provider_name] = $item;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        $data['team_amroz']['others'] = $team_amroz[1][0] ;
        $data['team_amroz']['total'] = $total + ($data['team_amroz']['others']->cable + $data['team_amroz']['others']->phone + $data['team_amroz']['others']->internet + $data['team_amroz']['others']->mobile);
        // details team based data
        $total = 0;
        $user_id = Auth::user()->user_id;
        $team_stats = $this->get_team_detailed_counts($from_date, $to_date, $user_id, $user_id==4 ? 6 : 0);
        foreach ($team_stats[0] as $item) {
            $data['my_team_stats'][$item->full_name][$item->provider_name] = $item;
            $data['my_team_stats'][$item->full_name]['total'][] = $item->cable+$item->phone+$item->internet+$item->mobile;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        foreach ($team_stats[1] as $item) {
            $data['my_team_stats'][$item->full_name]['total'][] = [];
            $data['my_team_stats'][$item->full_name]['others'] = $item;
            $data['my_team_stats'][$item->full_name]['total'][] += $item->cable+$item->phone+$item->internet+$item->mobile;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        $data['my_team_stats']['total'] = $total;
        $all_sales = $this->get_all_sales_stats_counts($from_date, $to_date);
        $total = 0;
        foreach ($all_sales[0] as $item) {
            $data['all_sales_stats'][$item->full_name][$item->provider_name] = $item;
            $data['all_sales_stats'][$item->full_name]['total'][] = $item->cable+$item->phone+$item->internet+$item->mobile;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        foreach ($all_sales[1] as $item) {
            $data['all_sales_stats'][$item->full_name]['others'] = $item;
            $data['all_sales_stats'][$item->full_name]['total'][] = $item->cable+$item->phone+$item->internet+$item->mobile;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        $data['all_sales_stats']['misc'] = [];
        foreach ($all_sales[2] as $item) {
            if (array_key_exists($item->provider_name,$data['all_sales_stats']['misc']))
            {
                $data['all_sales_stats']['misc'][$item->provider_name]->cable += $item->cable;
                $data['all_sales_stats']['misc'][$item->provider_name]->phone += $item->phone;
                $data['all_sales_stats']['misc'][$item->provider_name]->internet += $item->internet;
                $data['all_sales_stats']['misc'][$item->provider_name]->mobile += $item->mobile;
            } else {
                $data['all_sales_stats']['misc'][$item->provider_name] = $item;
            }
            $data['all_sales_stats']['misc']['total'][] = $item->cable+$item->phone+$item->internet+$item->mobile;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        $data['all_sales_stats']['misc']['others'] = [];
        $data['all_sales_stats']['misc']['total'][] = [];
        foreach ($all_sales[3] as $item) {
            $data['all_sales_stats']['misc']['others'] = $item;
            $data['all_sales_stats']['misc']['total'][] += $item->cable+$item->phone+$item->internet+$item->mobile;
            $total += $item->cable+$item->phone+$item->internet+$item->mobile;
        }
        $data['all_sales_stats']['total'] = $total;
        return view('dashboard.team_dashboard' , $data);
    }
    private function csr_dashboard()
    {
        $data['page_title'] = "CSR Dashboard - Atlantis CRM";
        $data['small_nav'] = true;
        $today = get_date();
        $datetime = new DateTime($today);
        $date_today = date("d"  ,strtotime($today));
        // daily rgu and paly count
        $hour = date("H"  ,strtotime(get_date_time()));
        if($hour >= 17) {
            $from_date = date("Y-m-d"  ,strtotime($today));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 23:59:59';
        } else {
            $from_date = date("Y-m-d"  ,strtotime("-1 Day" , strtotime($today)));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 17:00:00';
        }
        $uid =Auth::user()->user_id;
        $data['daily_stats'] = DB::select('SELECT call_dispositions_services.provider_name, SUM(call_dispositions_services.mobile) as mobile,SUM(call_dispositions_services.mobile + call_dispositions_services.internet + call_dispositions_services.phone +call_dispositions_services.cable ) As total_sales FROM call_dispositions JOIN call_dispositions_services ON call_dispositions.call_id =call_dispositions_services.call_id WHERE  call_dispositions.added_on>="'.$from_date.'" AND call_dispositions.added_on<="'.$to_date.'" AND call_dispositions.added_by="'.$uid.'" AND call_dispositions_services.provider_name IS NOT NULL GROUP BY call_dispositions_services.provider_name ORDER BY total_sales DESC');
        $data["services_sold_daily"] = DB::select('SELECT count(case when call_dispositions.services_sold = "1" then 1 else null end) as single_play, count(case when call_dispositions.services_sold = "2" then 1 else null end) as double_play, count(case when call_dispositions.services_sold = "3" then 1 else null end) as triple_play, count(case when call_dispositions.services_sold = "4" then 1 else null end) as quad_play FROM call_dispositions WHERE call_dispositions.added_on>="'.$from_date.'" AND call_dispositions.added_on<="'.$to_date.'" AND call_dispositions.added_by="'.$uid.'"');
        $total_sale = 0;
        foreach ($data['daily_stats'] as $stat){
            $total_sale = $total_sale + $stat->total_sales;
        }
        $data['daily_total'] = $total_sale;
        $data['daily_status'] = DB::select("SELECT * FROM (SELECT AVG(monitor_percentage) AS average FROM qa_with_color_badge WHERE(added_on >= '".$from_date."' AND added_on <= '".$to_date."' AND agent_id = '".$uid."') ) as avg_table INNER JOIN qa_performance_badge ON (avg_table.average >= qa_performance_badge.min AND avg_table.average <= qa_performance_badge.max)");
        $data["services_sold_daily"] = DB::select('SELECT count(case when call_dispositions.services_sold = "1" then 1 else null end) as single_play, count(case when call_dispositions.services_sold = "2" then 1 else null end) as double_play, count(case when call_dispositions.services_sold = "3" then 1 else null end) as triple_play, count(case when call_dispositions.services_sold = "4" then 1 else null end) as quad_play FROM call_dispositions WHERE call_dispositions.added_on>="'.$from_date.'" AND call_dispositions.added_on<="'.$to_date.'" AND call_dispositions.added_by="'.$uid.'"');
        // sales
        $dates[] = get_date_interval();
        $to_date = $dates[0]['to_date'];
        $from_date = $dates[0]['from_date'];
        $month  = date('m', strtotime($today));
        $year  = date('Y', strtotime($today));
        $data['attendance_list'] = AttendanceLog::select(DB::raw('sum(late) as `lates`, sum(absent) as `absents`, sum(on_leave) as `leaves` ,sum(applied_leave) as `applied_leave`, sum(half_leave) as `half_leaves` , count(user_id) as `attendance_marked`', 'ANY_VALUE(user_id)'))
            ->where('user_id', Auth::user()->user_id)
            ->whereYear('attendance_date', $year)
            ->whereMonth('attendance_date', $month)
            ->first();
        $data['monthly_stats'] = DB::select('SELECT call_dispositions_services.provider_name, SUM(call_dispositions_services.mobile) as mobile,SUM(call_dispositions_services.mobile + call_dispositions_services.internet + call_dispositions_services.phone +call_dispositions_services.cable ) As total_sales FROM call_dispositions JOIN call_dispositions_services ON call_dispositions.call_id =call_dispositions_services.call_id WHERE call_dispositions.status=1 AND call_dispositions.added_on>="'.$from_date.'" AND call_dispositions.added_on<="'.$to_date.'" AND call_dispositions.added_by="'.$uid.'" AND call_dispositions_services.provider_name IS NOT NULL GROUP BY call_dispositions_services.provider_name ORDER BY total_sales DESC');
        $data["services_sold_monthly"] = DB::select('SELECT count(case when call_dispositions.services_sold = "1" then 1 else null end) as single_play, count(case when call_dispositions.services_sold = "2" then 1 else null end) as double_play, count(case when call_dispositions.services_sold = "3" then 1 else null end) as triple_play, count(case when call_dispositions.services_sold = "4" then 1 else null end) as quad_play FROM call_dispositions WHERE call_dispositions.status=1 AND call_dispositions.added_on>="'.$from_date.'" AND call_dispositions.added_on<="'.$to_date.'" AND call_dispositions.added_by="'.$uid.'"');
        $total_sale = 0;
        foreach ($data['monthly_stats'] as $stat){
            $total_sale = $total_sale + $stat->total_sales;
        }
        $data['monthly_total'] = $total_sale;
        $data['monthly_status'] = DB::select("SELECT * FROM (SELECT AVG(monitor_percentage) AS average FROM qa_with_color_badge WHERE(added_on >= '".$from_date."' AND added_on <= '".$to_date."' AND agent_id = '".$uid."') ) as avg_table INNER JOIN qa_performance_badge ON (avg_table.average >= qa_performance_badge.min AND avg_table.average <= qa_performance_badge.max)");
        return view('dashboard.agent_dashboard' , $data);
    }
    private function qa_dashboard()
    {
        $data['page_title'] = "QA Dashboard - Atlantis CRM";
        $data['small_nav'] = true;
        return view('dashboard.qa_dashboard' , $data);
    }
    private function vendor_dashboard(){
        $data['page_title'] = "Vendor Dashboard - Atlantis CRM";
        $data['small_nav'] = true;
        $did_id = explode(',',Auth::user()->vendor_did_id);
        $today = get_date();
        $datetime = new DateTime($today);
        $date_today = date("d"  ,strtotime($today));
        // daily counts
        $hour = date("H"  ,strtotime(get_date_time()));
        if($hour >= 17) {
            $from_date = date("Y-m-d"  ,strtotime($today));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 23:59:59';
        } else {
            $from_date = date("Y-m-d"  ,strtotime("-1 Day" , strtotime($today)));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 17:00:00';
        }
        $data['providers_daily'] = $this->get_did_wise_providers_sale($from_date,$to_date,$did_id);
        $data['rgu_daily'] = $this->get_did_wise_provider_rgo($from_date,$to_date,$did_id);
        $dates[] = get_date_interval();
        $to_date = $dates[0]['to_date'];
        $from_date = $dates[0]['from_date'];
        $data['providers_monthly'] = $this->get_did_wise_providers_sale($from_date,$to_date,$did_id);
        $data['rgu_monthly'] = $this->get_did_wise_provider_rgo($from_date,$to_date,$did_id);
        return view('dashboard.vendor_dashboard' , $data);
    }
    private function provider_dashboard(){
        $data['page_title'] = 'Provider Dashboard - Atlantis CRM';
        $data['small_nav'] = true;
        $today = get_date();
        $datetime = new DateTime($today);
        $date_today = date("d"  ,strtotime($today));
        // daily counts
        $hour = date("H"  ,strtotime(get_date_time()));
        if($hour >= 17) {
            $from_date = date("Y-m-d"  ,strtotime($today));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 23:59:59';
        } else {
            $from_date = date("Y-m-d"  ,strtotime("-1 Day" , strtotime($today)));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 17:00:00';
        }
        $data['providers_all'] = $this->get_providers_sale('2021-01-01 17:00:00',$to_date);
        $data['rgu_all'] = $this->get_provider_rgo('2021-01-01 17:00:00',$to_date);
        $data['providers_daily'] = $this->get_providers_sale($from_date,$to_date);
        $data['rgu_daily'] = $this->get_provider_rgo($from_date,$to_date);
        $data['daily_disp'] = CallDisposition::where('status', 1)->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['daily_sale_made'] = CallDisposition::where(['status' => 1,'disposition_type' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['daily_call_back'] = CallDisposition::where(['status' => 1,'disposition_type' => 2])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['daily_customer_service'] = CallDisposition::where(['status' => 1,'disposition_type' => 3])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['daily_no_answer'] = CallDisposition::where(['status' => 1,'disposition_type' => 4])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['daily_call_transferred'] = CallDisposition::where(['status' => 1,'disposition_type' => 5])->whereBetween('added_on', [$from_date, $to_date])->count();
        $dates[] = get_date_interval();
        $to_date = $dates[0]['to_date'];
        $from_date = $dates[0]['from_date'];
        $data['providers_monthly'] = $this->get_providers_sale($from_date,$to_date);
        $data['rgu_monthly'] = $this->get_provider_rgo($from_date,$to_date);
        $data['monthly_sale_made'] = CallDisposition::where(['status' => 1,'disposition_type' => 1])->whereDate('added_on', '>=', $from_date)->whereDate('added_on', '<=', $to_date)->count();
        $data['monthly_call_back'] = CallDisposition::where(['status' => 1,'disposition_type' => 2])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['monthly_customer_service'] = CallDisposition::where(['status' => 1,'disposition_type' => 3])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['monthly_no_answer'] = CallDisposition::where(['status' => 1,'disposition_type' => 4])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['monthly_call_transferred'] = CallDisposition::where(['status' => 1,'disposition_type' => 5])->whereBetween('added_on', [$from_date, $to_date])->count();
        $data['six_months_dispositions_count'] = $this->get_6_months_dipositions_count($from_date,$to_date);
        //Total Counts
        $data['total_sale_made'] = CallDisposition::where(['status' => 1,'disposition_type' => 1])->count();
        $data['total_call_back'] = CallDisposition::where(['status' => 1,'disposition_type' => 2])->count();
        $data['total_customer_service'] = CallDisposition::where(['status' => 1,'disposition_type' => 3])->count();
        $data['total_no_answer'] = CallDisposition::where(['status' => 1,'disposition_type' => 4])->count();
        $data['total_call_transferred'] = CallDisposition::where(['status' => 1,'disposition_type' => 5])->count();
        $data['total_dispositions'] = CallDisposition::where(['status' => 1])->count();
        return view('dashboard.provider_dashboard' , $data);
    }
    private function get_rgo_counts($from_date, $to_date)
    {
        $single_play = DB::table('all_sales')->where('services_sold', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $double_play = DB::table('all_sales')->where('services_sold', 2)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $triple_play = DB::table('all_sales')->where('services_sold', 3)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $quad_play = DB::table('all_sales')->where('services_sold', 4)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $services = DB::table('all_sales')->select('provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile, count(case when services_sold = "1" then 1 else null end) as single_play, count(case when services_sold = "2" then 1 else null end) as double_play, count(case when services_sold = "3" then 1 else null end) as triple_play, count(case when services_sold = "4" then 1 else null end) as quad_play'))
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
    private function get_agent_rgo_counts($from_date, $to_date, $user_id)
    {
        $single_play = DB::table('all_sales')->where(['services_sold'=> 1, 'added_by'=>$user_id])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $double_play = DB::table('all_sales')->where(['services_sold'=> 2, 'added_by'=>$user_id])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $triple_play = DB::table('all_sales')->where(['services_sold'=> 3, 'added_by'=>$user_id])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $quad_play = DB::table('all_sales')->where(['services_sold'=> 4, 'added_by'=>$user_id])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $total_rgu = ($single_play+($double_play*2)+($triple_play*3)+($quad_play*4));
        $total_sales = ($single_play+$double_play+$triple_play+$quad_play);
        return [
            'single_play' => $single_play,
            'double_play' => $double_play,
            'triple_play' => $triple_play,
            'quad_play' => $quad_play,
            'total_rgu' => $total_rgu,
            'total_sales' => $total_sales
        ];
    }
    private  function get_6_months_dipositions_count($from_date, $to_date) {
        $data['one_month'] = CallDisposition::where(['status' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-1 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['two_month'] = CallDisposition::where(['status' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-2 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['three_month'] = CallDisposition::where(['status' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-3 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['four_month'] = CallDisposition::where(['status' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-4 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['five_month'] = CallDisposition::where(['status' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-5 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['six_month'] = CallDisposition::where(['status' => 1])->whereBetween('added_on', [$from_date, $to_date])->count();
        return $data;
    }
    private function get_6_months_rgo_counts($from_date, $to_date)
    {
        $data['one_month'] = $this->get_rgo_counts($from_date, $to_date);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-1 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['two_month'] = $this->get_rgo_counts($from_date, $to_date);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-2 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['three_month'] = $this->get_rgo_counts($from_date, $to_date);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-3 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['four_month'] = $this->get_rgo_counts($from_date, $to_date);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-4 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['five_month'] = $this->get_rgo_counts($from_date, $to_date);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-5 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['six_month'] = $this->get_rgo_counts($from_date, $to_date);
        return $data;
    }
    private function get_team_counts($from_date, $to_date, $manager_id)
    {
        $team_members = DB::select(DB::raw("SELECT GROUP_CONCAT(team_members.user_id) as members FROM `teams` INNER JOIN team_members ON team_members.team_id=teams.team_id WHERE team_lead_id=$manager_id;"))[0]->members;
        $team_members = explode(',', $team_members);
        $data = DB::table('all_sales')->select('provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))->whereIn('added_by',$team_members)->whereIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])->whereBetween('added_on', [$from_date, $to_date])->groupBy('provider_name')->get();
        $others = DB::table('all_sales')->select(DB::raw('"others" as provider_name'), DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))->whereIn('added_by',$team_members)->whereNotIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])->whereBetween('added_on', [$from_date, $to_date])->get();
        return [$data , $others];
    }
    private function get_all_sales_stats_counts($from_date, $to_date)
    {
        $csr_provider = DB::table('all_sales')->select('full_name', 'provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))
            ->whereIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])
            ->whereIn('role_id', [4,22])
            ->whereBetween('added_on', [$from_date, $to_date])
            ->groupBy('provider_name','added_by')->get();
        $csr_others_provider = DB::table('all_sales')->select('full_name', DB::raw('"others" as provider_name'), DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))
            ->whereIn('role_id', [4,22])
            ->whereNotIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])
            ->whereBetween('added_on', [$from_date, $to_date])
            ->groupBy('added_by')->get();
        $misc_provider = DB::table('all_sales')->select('provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))
            ->whereIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])
            ->where('role_id','!=', 4)
            ->where('role_id','!=', 22)
            ->whereBetween('added_on', [$from_date, $to_date])
            ->groupBy('provider_name','added_by')->get();
        $misc_others_provider = DB::table('all_sales')->select( DB::raw('"others" as provider_name'), DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))
            ->where('role_id','!=', 4)
            ->where('role_id','!=', 22)
            ->whereNotIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])
            ->whereBetween('added_on', [$from_date, $to_date])
            ->groupBy('added_by')->get();
        return [$csr_provider , $csr_others_provider, $misc_provider, $misc_others_provider];
    }
    private function get_team_detailed_counts($from_date, $to_date, $manager_id, $exclude)
    {
        $data = DB::table('all_sales')->select('full_name', 'provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))->orWhere(['manager_id'=>$manager_id, 'added_by'=>$manager_id])->whereIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])->whereBetween('added_on', [$from_date, $to_date])->where('added_by','!=', $exclude)->groupBy('provider_name','added_by')->get();
        $others = DB::table('all_sales')->select('full_name', DB::raw('"others" as provider_name'), DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile'))->orWhere(['manager_id'=>$manager_id, 'added_by'=>$manager_id])->whereNotIn('provider_name',['spectrum','cox','suddenlink','att','directtv','earthlink','frontier','mediacom','optimum','hughesnet'])->whereBetween('added_on', [$from_date, $to_date])->where('added_by','!=', $exclude)->groupBy('added_by')->get();
        return [$data , $others];
    }
    private function get_did_wise_rgo_counts($from_date, $to_date,$did_id)
    {
        $single_play = DB::table('all_sales')->whereIn('did_id', $did_id)->where(['services_sold' => 1])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $double_play = DB::table('all_sales')->whereIn('did_id', $did_id)->where(['services_sold' => 2])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $triple_play = DB::table('all_sales')->whereIn('did_id', $did_id)->where(['services_sold' => 3])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $quad_play = DB::table('all_sales')->whereIn('did_id', $did_id)->where(['services_sold' => 4])->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $services = DB::table('all_sales')->select('provider_name', DB::raw('count(provider_name) as count, sum(internet) as internet, sum(cable) as cable, sum(phone) as phone, sum(mobile) as mobile, count(case when services_sold = "1" then 1 else null end) as single_play, count(case when services_sold = "2" then 1 else null end) as double_play, count(case when services_sold = "3" then 1 else null end) as triple_play, count(case when services_sold = "4" then 1 else null end) as quad_play'))->whereIn('provider_name',['spectrum'])->whereBetween('added_on', [$from_date, $to_date])->groupBy('provider_name')->limit(5)->get();
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
    private function get_did_wise_6_months_dipositions_count($from_date, $to_date,$did_id){
        $data['one_month'] = CallDisposition::where(['status' => 1,'did_id'=>$did_id])
            ->whereDate('added_on', '>=', $from_date)
            ->whereDate('added_on', '<=', $to_date)->count();
        return $data;
    }
    private function get_did_wise_6_months_rgo_counts($from_date, $to_date,$did_id)
    {
        $data['one_month'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-1 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['two_month'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-2 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['three_month'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-3 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['four_month'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-4 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['five_month'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);
        $to_date = date("Y-m"  ,strtotime($from_date));
        $from_date = date("Y-m"  ,strtotime("-5 Month" , strtotime($from_date)));
        $from_date = $from_date.'-29 17:00:00';
        $to_date = $to_date.'-29 17:00:00';
        $data['six_month'] = $this->get_did_wise_rgo_counts($from_date, $to_date,$did_id);
        return $data;
    }
    private function get_providers_sale($from_date,$to_date){
        $data = DB::select('SELECT provider_name, SUM(internet) as internet, SUM(mobile) as mobile, SUM(cable) as cable, SUM(phone) as phone,
count(case when services_sold = "1" then 1 else null end) as single_play,
count(case when services_sold = "2" then 1 else null end) as double_play,
count(case when services_sold = "3" then 1 else null end) as triple_play,
count(case when services_sold = "4" then 1 else null end) as quad_play,
count(case when internet = "1" AND phone = "1" AND mobile = "0" AND cable = "0" then 1 else null end) as ip,
count(case when internet = "1" AND cable = "1" AND mobile = "0" AND phone = "0" then 1 else null end) as ic,
count(case when phone = "1" AND cable = "1" AND mobile = "0" AND internet = "0" then 1 else null end) as pc,
SUM(services_sold) As total_sales
FROM all_sales  WHERE added_on>="'.$from_date.'" AND added_on<="'.$to_date.'" AND provider_name IS NOT NULL  GROUP BY provider_name ORDER BY total_sales DESC');
        return $data;
    }
    private function get_provider_rgo($from_date, $to_date)
    {
        $single_play = DB::table('all_sales')->where('services_sold', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $double_play = DB::table('all_sales')->where('services_sold', 2)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $triple_play = DB::table('all_sales')->where('services_sold', 3)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $quad_play = DB::table('all_sales')->where('services_sold', 4)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $cable = DB::table('all_sales')->where('cable', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $internet = DB::table('all_sales')->where('internet', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $phone = DB::table('all_sales')->where('phone', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $mobile = DB::table('all_sales')->where('mobile', 1)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $total_rgu = ($single_play+($double_play*2)+($triple_play*3)+($quad_play*4));
        return [
            'total_rgu' => $total_rgu,
            'cable' => $cable,
            'internet' => $internet,
            'phone' => $phone,
            'mobile' => $mobile,
        ];
    }
    private function get_did_wise_providers_sale($from_date,$to_date,$did){
        $data = DB::select('SELECT provider_name, SUM(internet) as internet, SUM(mobile) as mobile, SUM(cable) as cable, SUM(phone) as phone,
count(case when services_sold = "1" then 1 else null end) as single_play,
count(case when services_sold = "2" then 1 else null end) as double_play,
count(case when services_sold = "3" then 1 else null end) as triple_play,
count(case when services_sold = "4" then 1 else null end) as quad_play,
count(case when internet = "1" AND phone = "1" AND mobile = "0" AND cable = "0" then 1 else null end) as ip,
count(case when internet = "1" AND cable = "1" AND mobile = "0" AND phone = "0" then 1 else null end) as ic,
count(case when phone = "1" AND cable = "1" AND mobile = "0" AND internet = "0" then 1 else null end) as pc,
SUM(services_sold) As total_sales
FROM all_sales  WHERE added_on>="'.$from_date.'" AND added_on<="'.$to_date.'" AND  did_id IN ('.implode(",", $did).')  AND provider_name IS NOT NULL  GROUP BY provider_name ORDER BY total_sales DESC');
        return $data;
    }
    private function get_did_wise_provider_rgo($from_date, $to_date,$did)
    {
        $single_play = DB::table('all_sales')->where('services_sold', 1) ->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $double_play = DB::table('all_sales')->where('services_sold', 2)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $triple_play = DB::table('all_sales')->where('services_sold', 3)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $quad_play = DB::table('all_sales')->where('services_sold', 4)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $cable = DB::table('all_sales')->where('cable', 1)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $internet = DB::table('all_sales')->where('internet', 1)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $phone = DB::table('all_sales')->where('phone', 1)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $mobile = DB::table('all_sales')->where('mobile', 1)->whereIn('did_id', $did)->whereBetween('added_on', [$from_date, $to_date])->count('call_id');
        $total_rgu = ($single_play+($double_play*2)+($triple_play*3)+($quad_play*4));
        return [
            'total_rgu' => $total_rgu,
            'cable' => $cable,
            'internet' => $internet,
            'phone' => $phone,
            'mobile' => $mobile,
        ];
    }
    private function update_sales_chart(Request $request){
        $today = get_date();
        $datetime = new DateTime($today);
        $date_today = date("d"  ,strtotime($today));
        // daily rgu and paly count
        $hour = date("H"  ,strtotime(get_date_time()));
        if($hour >= 17){
            $from_date = date("Y-m-d"  ,strtotime($today));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 23:59:59';
        } else {
            $from_date = date("Y-m-d"  ,strtotime("-1 Day" , strtotime($today)));
            $to_date = date("Y-m-d"  ,strtotime($today));
            $from_date = $from_date.' 17:00:00';
            $to_date = $to_date.' 17:00:00';
        }
        $uid =Auth::user()->user_id;
        $data['daily_stats'] = DB::select('SELECT call_dispositions_services.provider_name, SUM(call_dispositions_services.mobile) as mobile,SUM(call_dispositions_services.mobile + call_dispositions_services.internet + call_dispositions_services.phone +call_dispositions_services.cable ) As total_sales FROM call_dispositions JOIN call_dispositions_services ON call_dispositions.call_id =call_dispositions_services.call_id WHERE  call_dispositions.added_on>="'.$from_date.'" AND call_dispositions.added_on<="'.$to_date.'" AND call_dispositions.added_by="'.$uid.'" AND call_dispositions_services.provider_name IS NOT NULL GROUP BY call_dispositions_services.provider_name ORDER BY total_sales DESC');
        $data["services_sold_daily"] = DB::select('SELECT count(case when call_dispositions.services_sold = "1" then 1 else null end) as single_play, count(case when call_dispositions.services_sold = "2" then 1 else null end) as double_play, count(case when call_dispositions.services_sold = "3" then 1 else null end) as triple_play, count(case when call_dispositions.services_sold = "4" then 1 else null end) as quad_play FROM call_dispositions WHERE call_dispositions.added_on>="'.$from_date.'" AND call_dispositions.added_on<="'.$to_date.'" AND call_dispositions.added_by="'.$uid.'"');
        $total_sale = 0;
        foreach ($data['daily_stats'] as $stat){
            $total_sale = $total_sale + $stat->total_sales;
        }
        $data['daily_total'] = $total_sale;
        // sales
        $dates[] = get_date_interval();
        $to_date = $dates[0]['to_date'];
        $from_date = $dates[0]['from_date'];
        $month  = date('m', strtotime($today));
        $year  = date('Y', strtotime($today));
        $data['attendance_list'] = AttendanceLog::select(DB::raw('sum(late) as `lates`, sum(absent) as `absents`, sum(on_leave) as `leaves` ,sum(applied_leave) as `applied_leave`, sum(half_leave) as `half_leaves` , count(user_id) as `attendance_marked`'), 'user_id')
            ->where('user_id', Auth::user()->user_id)
            ->whereYear('attendance_date', $year)
            ->whereMonth('attendance_date', $month)
            ->first();
        //  $data['monthly_counts'] = $this->get_agent_rgo_counts($from_date,$to_date, $uid);
        // $data['attendance_list'] = AttendanceLog::where('user_id', 14)->whereBetween('attendance_date', [$form_date, $to_date])->get();
        $data['monthly_stats'] = DB::select('SELECT call_dispositions_services.provider_name, SUM(call_dispositions_services.mobile) as mobile,SUM(call_dispositions_services.mobile + call_dispositions_services.internet + call_dispositions_services.phone +call_dispositions_services.cable ) As total_sales FROM call_dispositions JOIN call_dispositions_services ON call_dispositions.call_id =call_dispositions_services.call_id WHERE  call_dispositions.added_on>="'.$from_date.'" AND call_dispositions.added_on<="'.$to_date.'" AND call_dispositions.added_by="'.$uid.'" AND call_dispositions_services.provider_name IS NOT NULL GROUP BY call_dispositions_services.provider_name ORDER BY total_sales DESC');
        $data["services_sold_monthly"] = DB::select('SELECT count(case when call_dispositions.services_sold = "1" then 1 else null end) as single_play, count(case when call_dispositions.services_sold = "2" then 1 else null end) as double_play, count(case when call_dispositions.services_sold = "3" then 1 else null end) as triple_play, count(case when call_dispositions.services_sold = "4" then 1 else null end) as quad_play FROM call_dispositions WHERE call_dispositions.added_on>="'.$from_date.'" AND call_dispositions.added_on<="'.$to_date.'" AND call_dispositions.added_by="'.$uid.'"');
        $total_sale = 0;
        foreach ($data['monthly_stats'] as $stat){
            $total_sale = $total_sale + $stat->total_sales;
        }
        $data['monthly_total'] = $total_sale;
        return view('dashboard.partial.csr_sales_chart',$data);
    }
    private function get_employees_assessment_for_calender()
    {
        $data = array();
        $employees = Employee::with('employee:user_id,user_type,status')
            ->whereStatus(1)->select('user_id','full_name','joining_date','confirmation_date')
            ->whereHas('employee', function ($query){
                $query->where('status', 1);
            })
            ->get()->toArray();
        foreach ($employees as $employee){
            $employee_assessment = false;
            // Already Appraisal record check to get last appraisal date
            $check_evaluation_record = EmployeeAssessment::with('employees')
                ->where('user_id', $employee['user_id'])
                ->where('hr_sign', 1)
                ->orderBy('added_on', 'desc')->first();
            if($check_evaluation_record != NULL){
                if($check_evaluation_record->probation_extension == 'YES'){
                    $new_appraisal_date = date("Y-m-d", strtotime($check_evaluation_record->probation_extension_to_date));
                }else{
                    $new_appraisal_date = date("Y-m-d", strtotime("+3 month", strtotime($check_evaluation_record->evaluation_date)));
                }
            }else{
                $employees = Employee::where('user_id', $employee['user_id'])->first();
                if($employees->confirmation_date == Null){
                    $new_appraisal_date = date("Y-m-d", strtotime("+3 month", strtotime($employees->joining_date)));
                }else{
                    $new_appraisal_date = date("Y-m-d", strtotime("+3 month", strtotime($employees->confirmation_date)));
                }
            }
            $data[] = array(
                'employee_name' => $employee['full_name'],
                'appraisal_date' => $new_appraisal_date,
            );
        }
        return $data;
    }
}
