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
        $data['managers'] = User::whereIn('role_id', [1,2, 3])->whereHas('user_team')->get();
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
            AttendanceLog::where('attendance_id', $request->attendance_id)->update(['modified_by' => Auth::user()->user_id, 'on_leave' => $request->on_leave, 'half_leave' => 0]);
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
        $users_id = TeamMember::where('team_id', $team->team_id)->pluck('user_id')->toArray();
        array_push($users_id, $manager_id);
        if($hour >= $shift_check_in && date('N', strtotime($today)) < 6 && $check_holiday->count() == 0) {
            $check_record = AttendanceLog::with('user')->where('attendance_date', $date_today)->where('added_by', $manager_id)->get();
            if($check_record->isEmpty()) {
                DB::beginTransaction();
                try {
                    foreach ($users_id as $user_id) {
                        $attendance_log_check = AttendanceLog::where(['user_id' => $user_id, 'attendance_date' => $date_today])->get();
                        if (count($attendance_log_check) > 0) {
                        } else {
                            $leave = LeaveApplication::where('added_by', $user_id)
                                ->where(['approved_by_manager' => 1, 'approved_by_hr' => 1])
                                ->where('from', '<=', $date_today)
                                ->where('to', '>=', $date_today)
                                ->first();
                            $attendance_log = new AttendanceLog;
                            if ($leave) {
                                if ($leave->leave_type_id) {
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
                } catch (\Exception $ex){
                    DB::rollBack();
                } finally {
                    DB::commit();
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
