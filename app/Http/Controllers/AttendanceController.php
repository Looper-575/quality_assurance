<?php
namespace App\Http\Controllers;
use App\Models\AttendanceLog;
use App\Models\Holiday;
use App\Models\LeaveApplication;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Illuminate\Support\Facades\Validator;
use Response;
use DB;
class AttendanceController extends Controller
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
    public function attendance()
    {
        $data['page_title'] = "Atlantis BPO CRM - Attendance";
        $data['managers'] = User::whereIn('role_id', [1,2, 3])->whereHas('user_team')->get();
        $data['agents'] = $this->get_attendance_sheet(Auth::user()->user_id);
        return view('attendance.mark' , $data);
    }
    public function get_manager_attendance($id)
    {
        $data['agents'] = $this->get_attendance_sheet($id);
        return view('attendance.manager_mark' , $data);
    }
    public function list()
    {
        $data['page_title'] = "Atlantis BPO CRM - Attendance List";
        $data['managers'] = User::whereIn('role_id', [1,2, 3])->get();
        return view('attendance.attendance_list' , $data);
    }
    public function mark_attendance(Request $request)
    {
        if($request->has('absent')) {
            AttendanceLog::where('attendance_id', $request->attendance_id)->update(['modified_by' => Auth::user()->user_id, 'late' => 0, 'absent' => $request->absent, 'time_in' => null, 'time_out' => null]);
        }
        if($request->time_in) {
            AttendanceLog::where('attendance_id', $request->attendance_id)->update(['modified_by' => Auth::user()->user_id, 'time_in' => $request->time_in]);
        }
        if($request->time_out) {
            AttendanceLog::where('attendance_id', $request->attendance_id)->update(['modified_by' => Auth::user()->user_id, 'time_out' => $request->time_out]);
        }
        if($request->has('late')) {
            AttendanceLog::where('attendance_id', $request->attendance_id)->update(['modified_by' => Auth::user()->user_id, 'late' => $request->late, 'absent' => 0]);
        }
        return Response::json(['success' => true], 200);
    }

    public function generate_attendance_report(Request $request)
    {
        $month = date("m",strtotime($request->year_month));
        $year = date("Y",strtotime($request->year_month));
        $manager = $request->team;
        $validator = Validator::make($request->all(),[
            'year_month' => 'required',
            'team' => 'required',
        ]);
        $form_date = date($year.'-'.$month.'-01');
//        $to_date = date($year.'-'.$month.'-d');
        $to_date = date("Y-m-t", strtotime($request->year_month));
        if($validator->passes()) {
            $check_holidays = Holiday::whereBetween('date_from', [$form_date, $to_date])->orWhereBetween('date_to', [$form_date, $to_date])->get();
            $holiday_count = 0;
            $from = '';
            $to = '';
            foreach ($check_holidays as $day){
                if($day->date_from >= $form_date){
                    $from = $day->date_from;
                }
                else{
                    $from = $form_date;
                }
                if($day->date_to <= $to_date){
                    $to = $day->date_to;
                }
                else{
                    $to = $to_date;
                }
                $holiday_count = 1 + $holiday_count + ((strtotime($to) - strtotime($from)) / (60 * 60 * 24));
            }
            $endDate = $to_date;
            $startDate = $form_date;
            $working_days = $this->working_days($startDate, $endDate);
            $team_id = Team::where('team_lead_id', $manager)->first();
            $team_id = $team_id->team_id;
            $user_ids = TeamMember::where('team_id', $team_id)->get()->pluck('user_id')->toArray();
            array_push($user_ids, $manager);
            $data['attendance_list'] = AttendanceLog::select(DB::raw('sum(late) as `lates`'), DB::raw('sum(absent) as `absents`'), DB::raw('sum(on_leave) as `leaves`'), DB::raw('sum(half_leave) as `half_leaves`'), DB::raw('count(user_id) as `attendance_marked`'), DB::raw('MONTH(attendance_date) month'), 'user_id')
//                ->with('user')->whereHas('user', function($q) use ($manager)
//                {
//                    $q->where('manager_id', $manager);
//                }
                ->whereIn('user_id', $user_ids)
                ->whereYear('attendance_date', $year)
                ->whereMonth('attendance_date', $month)
                ->groupBy('month', 'user_id')
                ->get();
            $data['leaves'] = LeaveApplication::with('user')->where(['approved_by_manager'=>1,'approved_by_hr'=>1])
                ->where('from', '>=', $startDate)
                ->where('to', '<=', $endDate)
                ->get();
            $response['status'] = "Success";
            $response['result'] = "Report Generated Successfully";
            $data['holiday_count'] = $holiday_count;
            $data['working_days'] = $working_days;
            $data['month'] = $form_date;
            return view('attendance.reports.attendance_report_list' , $data);
        }
        else{
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
    }
    public function single_list()
    {
        $data['page_title'] = "Atlantis BPO CRM - Attendance Single List";
        if(Auth::user()->role_id == 1){
            $data['agents'] = User::where('status', 1)->get();
        }
        else{
            $data['agents'] = User::where('manager_id',Auth::user()->user_id)->where('status', 1)->get();
        }
        return view('attendance.attendance_single_list' , $data);
    }
    public function generate_signle_attendance_report(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'form_date' => 'required',
            'to_date' => 'required',
            'user_id' => 'required',
        ]);
        $form_date = $request->form_date;
        $to_date = $request->to_date;
        $check_holidays = Holiday::whereBetween('date_from', [$form_date, $to_date])->orWhereBetween('date_to', [$form_date, $to_date])->get();
        if($validator->passes()) {
            $holiday_count = 0;
            $from = '';
            $to = '';
            foreach ($check_holidays as $day){
                if($day->date_from >= $form_date){
                    $from = $day->date_from;
                }
                else{
                    $from = $form_date;
                }
                if($day->date_to <= $to_date){
                    $to = $day->date_to;
                }
                else{
                    $to = $to_date;
                }
                $holiday_count = 1 + $holiday_count + ((strtotime($to) - strtotime($from)) / (60 * 60 * 24));
            }
            $working_days = $this->working_days($form_date, $to_date);
            $data['attendance_list'] = AttendanceLog::where('user_id', $request->user_id)->whereBetween('attendance_date', [$form_date, $to_date])->get();
            $data['agent_name'] = User::where('user_id', $request->user_id)->pluck('full_name')->first();
            $response['status'] = "Success";
            $response['result'] = "Report Generated Successfully";
            $data['holiday_count'] = $holiday_count;
            $data['working_days'] = $working_days;
            return view('attendance.reports.attendance_single_report_list' , $data);
        }
        else{
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
    }
    public function working_days($startDate, $endDate)
    {
        if ( strtotime($endDate) >= strtotime($startDate) ) {
            $holidays = array();
            $date = $startDate;
            $days = 0;
            while ($date != $endDate) {
                $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                $weekday = date("w", strtotime($date));
                if ( $weekday != 6 AND $weekday != 0 AND !in_array($date, $holidays) ) $days++;
            }
            return $days;
        }
        else {
            return "Please check the dates.";
        }
    }

    protected function get_attendance_sheet($manager_id)
    {
        $today = get_date();
        $date_today = date("Y-m-d"  ,strtotime($today));
        $hour = date("H"  ,strtotime(get_date_time()));
        $check_holiday = Holiday::where('date_from','<=', $date_today)->where('date_to','>=', $date_today)->get();
        $team = Team::with('shift')->where('team_lead_id', $manager_id)->where('status', 1)->first();
        $shift_check_in = (date("H"  ,strtotime($team->shift->check_in)) - 2);
        $users_id = TeamMember::where('team_id', $team->team_id)->pluck('user_id')->toArray();
        array_push($users_id, $manager_id);
        if($hour >= $shift_check_in && date('N', strtotime($today)) < 6 && $check_holiday->count() == 0) {
            $check_record = AttendanceLog::with('user')->where('attendance_date', $date_today)->where('added_by', $manager_id)->get();
            if($check_record->isEmpty()) {
                foreach ($users_id as $user_id) {
                    $attendance_log_check = AttendanceLog::where(['user_id'=>$user_id,'attendance_date'=>$date_today])->get();
                    if(count($attendance_log_check)>0){ } else {
                        $leave = LeaveApplication::where('added_by', $user_id)
                            ->where(['approved_by_manager'=>1,'approved_by_hr'=>1])
                            ->where('from', '<=', $date_today)
                            ->where('to', '>=', $date_today)
                            ->first();
                        $attendance_log = new AttendanceLog;
                        if($leave) {
                            if($leave->leave_type_id){
                                $attendance_log->half_leave = 1;
                            } else {
                                $attendance_log->on_leave = 1;
                            }
                        }
                        $attendance_log->user_id = $user_id;
                        $attendance_log->attendance_date = $date_today;
                        $attendance_log->added_by = $manager_id;
                        $attendance_log->save();
                    }
                }
                return AttendanceLog::with('user')->where('attendance_date', $date_today)->WhereIn('user_id', $users_id)->get();
            } else {
                return AttendanceLog::with('user')->where('attendance_date', $date_today)->whereIn('user_id',$users_id)->get();
            }
        } else {
            $last_day = date('Y-m-d', strtotime("-1 days"));
            $last_date = AttendanceLog::where('added_by', $manager_id)->orderBy('added_on', 'desc')->first();
            return AttendanceLog::with('user')->where('attendance_date', $last_date->attendance_date)->whereIn('user_id',$users_id)->get();
        }
    }
}
