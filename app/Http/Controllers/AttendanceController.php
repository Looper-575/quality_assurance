<?php
namespace App\Http\Controllers;
use App\Models\AttendanceLog;
use App\Models\Holiday;
use App\Models\LeaveApplication;
use App\Models\ManagerialRole;
use App\Models\ShiftUser;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $data['page_title'] = "Attendance - Atlantis BPO CRM";
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['teams'] = Team::where('status', 1)->get();
        } else {
            $data['teams'] = Team::where('department_id', Auth::user()->department_id)->where('status', 1)->get();
        }
        $data['agents'] = $this->get_attendance_sheet(Auth::user()->user_id);
        return view('attendance.mark' , $data);
    }
    public function get_manager_attendance($id)
    {
        $data['agents'] = $this->get_attendance_sheet($id);
        return view('attendance.partials.manager_mark' , $data);
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
        if($request->has('half_leave')) {
            AttendanceLog::where('attendance_id', $request->attendance_id)->update(['modified_by' => Auth::user()->user_id, 'half_leave' => $request->half_leave, 'on_leave' => 0]);
        }
        if($request->has('on_leave')) {
            AttendanceLog::where('attendance_id', $request->attendance_id)->update(['modified_by' => Auth::user()->user_id, 'on_leave' => $request->on_leave, 'half_leave' => 0, 'time_out' => null]);
        }
        return response()->json(['success' => true], 200);
    }
    protected function get_attendance_sheet($manager_id)
    {
        $today = get_date();
        $date_today = date("Y-m-d"  ,strtotime($today));
        $hour = date("H"  ,strtotime(get_date_time()));
        $check_holiday = Holiday::where('date_from','<=', $date_today)->where('date_to','>=', $date_today)->get();
        $team = Team::with('shift')->where('team_lead_id', $manager_id)->where('status', 1)->first();
        if(!$team){
            return null;
        }
        $shift_check_in = (date("H"  ,strtotime($team->shift->check_in)) - 2);
        $users_id = TeamMember::with('user')->whereHas('user', function ($query) {
            return $query->where('status', 1);
        })->where('team_id', $team->team_id)->pluck('user_id')->toArray();
//        array_push($users_id, $manager_id);
        if($hour >= $shift_check_in && date('N', strtotime($today)) < 6) { //&& $check_holiday->count() == 0
            $check_record = AttendanceLog::with('user')->where('attendance_date', $date_today)->where('added_by', $manager_id)->get();
            $att_users_id = $check_record->pluck('user_id')->toArray();
            $new_users_in_team = array_diff($users_id,$att_users_id);
            if(count($new_users_in_team)>0){
                $this->create_attendance_sheet($new_users_in_team, $date_today, $team ,$manager_id);
            }
            if($check_record->isEmpty()) {
                $this->create_attendance_sheet($users_id, $date_today, $team ,$manager_id);
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

    private function create_attendance_sheet($users_id, $date_today, $team ,$manager_id)
    {
        DB::beginTransaction();
        try {
            foreach ($users_id as $user_id) {
                $user = User::whereUserId($user_id)->first();
                $check_holiday = Holiday::where('date_from','<=', $date_today)->where('date_to','>=', $date_today)
                    ->where(function ($query_dpt) use($user) {
                        return $query_dpt->where('department_id',$user->department_id)
                            ->orWhere('department_id',0);
                    })
                    ->where(function ($query_role) use($user) {
                        return $query_role->whereRaw('FIND_IN_SET("'.$user->role_id.'",role_id)')
                            ->orWhere('role_id',0);
                    })
                    ->where(function ($query1) use($user_id) {
                        return $query1->whereRaw('FIND_IN_SET("'.$user_id.'",user_id)')
                            ->orWhere('user_id',0);
                    })
                    ->first();
                $attendance_log_check = AttendanceLog::where(['user_id' => $user_id, 'attendance_date' => $date_today])->get();

                if (count($attendance_log_check) > 0 || $check_holiday != null) {
                    //if attendance already created and user on holiday then don't create attendance
                } else {
                    $leave = LeaveApplication::where('added_by', $user)
                        ->where(['approved_by_manager' => 1, 'approved_by_hr' => 1])
                        ->where('leave_type_id', '!=', 4)
                        ->where('from', '<=', $date_today)
                        ->where('to','>=',$date_today)
                        ->first();
                    $half_leave = LeaveApplication::where('added_by', $user)
                        ->where(['approved_by_manager' => 1, 'approved_by_hr' => 1])
                        ->where('leave_type_id', 4)
                        ->where('from', '=', $date_today)
                        ->first();
                    $attendance_log = new AttendanceLog;
                    if ($half_leave) {
                        $attendance_log->half_leave = 1;
                    }
                    if ($leave) {
                        if($leave->leave_type_id == 6) {
                            $attendance_log->absent = 1;
                        } else {
                            $attendance_log->applied_leave = 1;
                        }
                    }
                    $attendance_log->time_out = $team->shift->check_out;
                    $attendance_log->user_id = $user_id;
                    $attendance_log->attendance_date = $date_today;
                    $attendance_log->added_by = $manager_id;
                    $attendance_log->save();
                }
            }
        } catch (\Exception $ex){
            DB::rollBack();
        } finally {
            DB::commit();
        }
    }

    public function check_attendance()
    {
        $data['page_title'] = "Check Attendance - Atlantis BPO CRM";
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['teams'] = Team::where('status', 1)->get();
        } else {
            $data['teams'] = Team::where('department_id', Auth::user()->department_id)->where('status', 1)->get();
        }
        $data['agents'] = null;
        return view('attendance.check_attendance' , $data);
    }
    public function check_back_date_attendance(Request $request)
    {
        $team = Team::where('team_id', $request->team_id)->with('team_member')->first();
        $members = [];
        foreach ($team->team_member as $member){
            $members[] = $member->user_id;
        }
        array_push($members, $team->team_lead_id);
        $date_today = date("Y-m-d"  ,strtotime($request->attendance_date));
        $data['not_marked'] = false;
        if(date('N', strtotime($date_today)) < 6) {
            $data['agents'] =  AttendanceLog::with('user')->where('attendance_date', $date_today)->whereIn('user_id', $members)->get();
            if(count($data['agents']) == 0) {
                $data['not_marked'] = true;
            }
        } else {
            $data['agents'] = null;
        }
        return view('attendance.partials.back_date_attendance' , $data);
    }
    public function create_back_date_attendance(Request $request)
    {
        $date_today = date("Y-m-d"  ,strtotime($request->attendance_date));
        $team = Team::with('shift')->where('team_id', $request->team_id)->where('status', 1)->first();
        $manager_id = $team->team_lead_id;
        if(!$team){
            return null;
        }
        $users_id = TeamMember::where('team_id', $team->team_id)->pluck('user_id')->toArray();
        array_push($users_id, $manager_id);
        $this->create_attendance_sheet($users_id, $date_today, $team ,$manager_id);
        $data['agents'] =  AttendanceLog::with('user')->where('attendance_date', $date_today)->where('added_by', $manager_id)->get();
        $data['not_marked'] = false;
        $data['holiday'] = false;
        return view('attendance.partials.back_date_attendance' , $data);
    }
    public function fill_attendance_time_out()
    {
        $attendance_log_check = AttendanceLog::where('time_out', null)->get();
        foreach ($attendance_log_check as $log){
            $user_shift_time_out = TeamMember::has('team.shift')->where('user_id', $log->user_id)->first();
            if(isset($user_shift_time_out->team)){
                AttendanceLog::where('attendance_id', $log->attendance_id)->update(['time_out' => $user_shift_time_out->team->shift->check_out]);
            } else {
                $user_shift_time_out = Team::where('team_lead_id', $log->user_id)->first();
                if(isset($user_shift_time_out)){
                    AttendanceLog::where('attendance_id', $log->attendance_id)->update(['time_out' => $user_shift_time_out->shift->check_out]);
                }
            }
        }
        return 'Success';
    }
}
