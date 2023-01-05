<?php
namespace App\Http\Controllers;
use App\Models\AttendanceLog;
use App\Models\CallDisposition;
use App\Models\CallDispositionsDid;
use App\Models\CallType;
use App\Models\Employee;
use App\Models\Holiday;
use App\Models\LeaveApplication;
use App\Models\LeaveBucketView;
use App\Models\QualityAssurance;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\CallDispositionsTypes;
use App\Models\User;

class ReportController extends Controller
{
    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }
    public function disposition_report_form()
    {
        $data['page_title'] = "Call Disposition Report - Atlantis BPO CRM";
        $data['small_nav'] = true;
        $data['agents'] = User::where([
            'role_id' => 4,
            'status' => 1,
        ])->get();
        $data['disposition_types'] = CallDispositionsTypes::where([
            'status' => 1,
        ])->get();
        return view('reports.lead_report_form', $data);
    }
    public function generate_disposition_report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
        ]);
        if ($validator->passes()) {
            $where = array();
            if ($request->disposition_type != "") {
                $where['disposition_type'] = $request->disposition_type;
            }
            $date_from = parse_datetime_store($request->from.' 17:00:00');
            $date_to = parse_datetime_store($request->to.' 12:00:00');
            if ($request->agent != "") {
                $data['call_disp_lists'] = CallDisposition::select('*')->with(['qa_status','qa_assessment'])
                    ->whereIn('added_by', $request->agent)->where($where)
                    ->where([['added_on', '>=', $date_from],['added_on', '<=', $date_to]])->get();
                $data['total'] =  DB::table('call_dispositions')
                    ->join('call_dispositions_services', 'call_dispositions.call_id', '=', 'call_dispositions_services.call_id')
                    ->select(DB::raw('SUM(call_dispositions_services.mobile) as mobile,SUM(call_dispositions_services.internet) as internet,SUM(call_dispositions_services.cable) as cable,SUM(call_dispositions_services.phone) as phone,SUM(call_dispositions_services.mobile + call_dispositions_services.internet + call_dispositions_services.phone +call_dispositions_services.cable ) As total_sales ,count(case when call_dispositions.services_sold = "1" then 1 else null end) as single_play, count(case when call_dispositions.services_sold = "2" then 1 else null end) as double_play, count(case when call_dispositions.services_sold = "3" then 1 else null end) as triple_play, count(case when call_dispositions.services_sold = "4" then 1 else null end) as quad_play'))
                    ->where($where)
                    ->whereIn('call_dispositions.added_by', $request->agent)->where($where)
                    ->where([['call_dispositions.added_on', '>=', $date_from],['call_dispositions.added_on', '<=', $date_to]])->first();

            } else {
                $data['call_disp_lists'] = CallDisposition::select('*')->with('qa_status')->where($where)
                    ->where([['added_on', '>=', $date_from],['added_on', '<=', $date_to]])->get();
                $data['total'] = DB::table('call_dispositions')
                    ->join('call_dispositions_services', 'call_dispositions.call_id', '=', 'call_dispositions_services.call_id')
                    ->select(DB::raw('SUM(call_dispositions_services.mobile) as mobile,SUM(call_dispositions_services.internet) as internet,SUM(call_dispositions_services.cable) as cable,SUM(call_dispositions_services.phone) as phone,SUM(call_dispositions_services.mobile + call_dispositions_services.internet + call_dispositions_services.phone +call_dispositions_services.cable ) As total_sales ,count(case when call_dispositions.services_sold = "1" then 1 else null end) as single_play, count(case when call_dispositions.services_sold = "2" then 1 else null end) as double_play, count(case when call_dispositions.services_sold = "3" then 1 else null end) as triple_play, count(case when call_dispositions.services_sold = "4" then 1 else null end) as quad_play'))
                    ->where($where)
                    ->where([['call_dispositions.added_on', '>=', $date_from],['call_dispositions.added_on', '<=', $date_to]])->first();
            }
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return view('reports.partials.lead_report_list', $data);
    }
    public function did_report_form()
    {
        $data['page_title'] = "Call Disposition Report - Atlantis BPO CRM";
        $data['small_nav'] = true;
        if(Auth::user()->role_id == 13) {
            $data['dids'] = CallDispositionsDid::whereIn('did_id', explode(',',Auth::user()->vendor_did_id))->get();
        } else {
            $data['dids'] = CallDispositionsDid::where('status', 1)->get();
        }
        $data['disposition_types'] = CallDispositionsTypes::where([
            'status' => 1,
        ])->get();
        return view('reports.did_report_form', $data);
    }
    public function generate_did_report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
            'did_id' => 'required',
        ]);
        if ($validator->passes()) {
            $where = array();
            $where['status'] = 1;
            if ($request->disposition_type != "") {
                $where['disposition_type'] = $request->disposition_type;
            }
            $date_from = parse_datetime_store($request->from.'17:00:00');
            $date_to = parse_datetime_store($request->to. '12:00:00');
            if(Auth::user()->role_id==13){
                if($request->did_id[0]==""){
                    $data['call_disp_lists'] = CallDisposition::select('*')->with(['qa_status','qa_assessment'])
                        ->whereIn('did_id', explode(',',Auth::user()->vendor_did_id))->where($where)
                        ->where([['added_on', '>=', $date_from],['added_on', '<=', $date_to]])->get();

                    $data['total'] =  DB::table('call_dispositions')
                        ->join('call_dispositions_services', 'call_dispositions.call_id', '=', 'call_dispositions_services.call_id')
                        ->select(DB::raw('SUM(call_dispositions_services.mobile) as mobile,SUM(call_dispositions_services.internet) as internet,SUM(call_dispositions_services.cable) as cable,SUM(call_dispositions_services.phone) as phone,SUM(call_dispositions_services.mobile + call_dispositions_services.internet + call_dispositions_services.phone +call_dispositions_services.cable ) As total_sales ,count(case when call_dispositions.services_sold = "1" then 1 else null end) as single_play, count(case when call_dispositions.services_sold = "2" then 1 else null end) as double_play, count(case when call_dispositions.services_sold = "3" then 1 else null end) as triple_play, count(case when call_dispositions.services_sold = "4" then 1 else null end) as quad_play'))
                        ->where('call_dispositions.status',1)
                        ->whereIn('did_id', explode(',',Auth::user()->vendor_did_id))
                        ->where([['call_dispositions.added_on', '>=', $date_from],['call_dispositions.added_on', '<=', $date_to]])->first();

                } else {
                    $data['call_disp_lists'] = CallDisposition::select('*')->with(['qa_status','qa_assessment'])
                        ->whereIn('did_id', $request->did_id)->where($where)
                        ->where([['added_on', '>=', $date_from],['added_on', '<=', $date_to]])->get();

                    $data['total'] =  DB::table('call_dispositions')
                        ->join('call_dispositions_services', 'call_dispositions.call_id', '=', 'call_dispositions_services.call_id')
                        ->select(DB::raw('SUM(call_dispositions_services.mobile) as mobile,SUM(call_dispositions_services.internet) as internet,SUM(call_dispositions_services.cable) as cable,SUM(call_dispositions_services.phone) as phone,SUM(call_dispositions_services.mobile + call_dispositions_services.internet + call_dispositions_services.phone +call_dispositions_services.cable ) As total_sales ,count(case when call_dispositions.services_sold = "1" then 1 else null end) as single_play, count(case when call_dispositions.services_sold = "2" then 1 else null end) as double_play, count(case when call_dispositions.services_sold = "3" then 1 else null end) as triple_play, count(case when call_dispositions.services_sold = "4" then 1 else null end) as quad_play'))
                        ->where('call_dispositions.status',1)
                        ->whereIn('did_id', $request->did_id)
                        ->where([['call_dispositions.added_on', '>=', $date_from],['call_dispositions.added_on', '<=', $date_to]])->first();
                }
                return view('reports.partials.lead_report_list', $data);
            }
            if($request->did_id[0] == ""){
                $data['call_disp_lists'] = CallDisposition::select('*')->with(['qa_status','qa_assessment'])
                    ->where($where)
                    ->where([['added_on', '>=', $date_from],['added_on', '<=', $date_to]])->get();

                $data['total'] =  DB::table('call_dispositions')
                    ->join('call_dispositions_services', 'call_dispositions.call_id', '=', 'call_dispositions_services.call_id')
                    ->select(DB::raw('SUM(call_dispositions_services.mobile) as mobile,SUM(call_dispositions_services.internet) as internet,SUM(call_dispositions_services.cable) as cable,SUM(call_dispositions_services.phone) as phone,SUM(call_dispositions_services.mobile + call_dispositions_services.internet + call_dispositions_services.phone +call_dispositions_services.cable ) As total_sales ,count(case when call_dispositions.services_sold = "1" then 1 else null end) as single_play, count(case when call_dispositions.services_sold = "2" then 1 else null end) as double_play, count(case when call_dispositions.services_sold = "3" then 1 else null end) as triple_play, count(case when call_dispositions.services_sold = "4" then 1 else null end) as quad_play'))
                    ->where('call_dispositions.status',1)
                    ->where([['call_dispositions.added_on', '>=', $date_from],['call_dispositions.added_on', '<=', $date_to]])->first();
            } else {
                $data['call_disp_lists'] = CallDisposition::select('*')->with(['qa_status','qa_assessment'])
                    ->whereIn('did_id', $request->did_id)->where($where)
                    ->where([['added_on', '>=', $date_from],['added_on', '<=', $date_to]])->get();

                $data['total'] =  DB::table('call_dispositions')
                    ->join('call_dispositions_services', 'call_dispositions.call_id', '=', 'call_dispositions_services.call_id')
                    ->select(DB::raw('SUM(call_dispositions_services.mobile) as mobile,SUM(call_dispositions_services.internet) as internet,SUM(call_dispositions_services.cable) as cable,SUM(call_dispositions_services.phone) as phone,SUM(call_dispositions_services.mobile + call_dispositions_services.internet + call_dispositions_services.phone +call_dispositions_services.cable ) As total_sales ,count(case when call_dispositions.services_sold = "1" then 1 else null end) as single_play, count(case when call_dispositions.services_sold = "2" then 1 else null end) as double_play, count(case when call_dispositions.services_sold = "3" then 1 else null end) as triple_play, count(case when call_dispositions.services_sold = "4" then 1 else null end) as quad_play'))
                    ->where('call_dispositions.status',1)
                    ->whereIn('did_id', $request->did_id)
                    ->where([['call_dispositions.added_on', '>=', $date_from],['call_dispositions.added_on', '<=', $date_to]])->first();
            }
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return view('reports.partials.lead_report_list', $data);
    }
    public function qa_report_form()
    {
        $data['page_title'] = "Atlantis BPO CRM - QA Report";
        $data['small_nav'] = true;
        $data['agents'] = User::where([
            'role_id' => 4,
            'status' => 1,
        ])->get();
        $data['disposition_types'] = CallType::where([
            'status' => 1,
        ])->get();
        return view('reports.qa_report_form', $data);
    }
    public function generate_qa_report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
        ]);
        if ($validator->passes()) {
            if ($request->disposition_type == 1) {
                $disposition_type = $request->disposition_type;
            } else {
                $disposition_type = 2;
            }
            $date_from = parse_datetime_store($request->from.'17:00:00');
            $date_to = parse_datetime_store($request->to. '12:00:00');
            if ($request->agent != "") {
                $data['qa_lists'] = QualityAssurance::select('*')->with(['qa_status', 'call_type', 'call_disposition'])
                    ->whereIn('agent_id', $request->agent)->where('call_type_id', $disposition_type)
                    ->where([['added_on', '>=', $date_from],['added_on', '<=', $date_to]])->get();
            } else {
                $data['qa_lists'] = QualityAssurance::select('*')->with(['qa_status', 'call_type', 'call_disposition'])
                    ->where('call_type_id', $disposition_type)
                    ->where([['added_on', '>=', $date_from],['added_on', '<=', $date_to]])->get();
            }
            $data['call_type'] = $request->disposition_type;
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return view('reports.partials.qa_report_list', $data);
    }
    public function attendance_report_monthly()
    {
        $data['page_title'] = "Attendance Report - Atlantis BPO CRM";
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['managers'] = Team::where('status', 1)->get();
        } else {
            $data['managers'] = Team::where('department_id', Auth::user()->department_id)->where('status', 1)->get();
        }
        return view('reports.attendance_report_monthly', $data);
    }
    public function generate_monthly_attendance_report(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'year_month' => 'required',
            'team' => 'required',
        ]);
        if($validator->passes()) {
            $month = date("m",strtotime($request->year_month));
            $year = date("Y",strtotime($request->year_month));
            if($request->team > 0){
                $manager = $request->team;
                $team_id = Team::where('team_lead_id', $manager)->first();
                $team_id = $team_id->team_id;
                $user_ids = TeamMember::where('team_id', $team_id)->get()->pluck('user_id')->toArray();
                array_push($user_ids, $manager);
            }
            else{
                $user_ids = User::get()->pluck('user_id')->toArray();
                array_push($user_ids, 0);
            }
            $month = date("m",strtotime($request->year_month));
            $year = date("Y",strtotime($request->year_month));

            $change_month = date('m', strtotime($request->year_month));
            if((0 == $year % 4) & (0 != $year % 100) | (0 == $year % 400))
            {
                $startDate = date('Y-m-29',(strtotime ( '-1 month' , strtotime ( $request->year_month) ) ));
                $endDate = date('Y-m-28',(strtotime ( $request->year_month)));
            } else {
                if($change_month == 02){
                    $startDate = date('Y-m-29',(strtotime ( '-1 month' , strtotime ( $request->year_month) ) ));
                    $endDate = date('Y-m-28',(strtotime ( '+1 month' , strtotime ( $request->year_month) ) ));
                } elseif ($change_month == 03){
                    $startDate = date('Y-m-t',(strtotime ( $request->year_month) ));
                    $endDate = date('Y-m-28',(strtotime ( $request->year_month)));
                } else {
                    $startDate = date('Y-m-29',(strtotime ( '-1 month' , strtotime ( $request->year_month) ) ));
                    $endDate = date('Y-m-28',(strtotime ( $request->year_month)));
                }
            }
            $to_date = $endDate;
            $form_date = $startDate;
            $working_days = working_days($startDate, $endDate);
            $attendance_list = AttendanceLog::select(DB::raw('count(user_id) as `attendance_marked`, sum(late) as `lates`, sum(absent) as `absents`, sum(on_leave) as `leaves` , sum(half_leave) as `half_leaves`'), 'user_id')
                ->whereIn('user_id', $user_ids)
                ->where('attendance_date','>=',  $startDate)
                ->where('attendance_date','<=',  $endDate)
                ->groupBy('user_id')
                ->get();
            for ($i=0; $i<count($attendance_list); $i++){
                $attendance_list[$i]->holiday_count = $this->check_holidays($form_date, $to_date,$attendance_list[$i]->user->department_id, $attendance_list[$i]->user->user_id,$attendance_list[$i]->user->role_id);
            }
            $data['leaves'] = LeaveApplication::with('user')->where(['approved_by_manager'=>1,'approved_by_hr'=>1])
                ->where('from', '>=', $startDate)
                ->where('to', '<=', $endDate)
                ->get();
            $data['attendance_list'] = $attendance_list;
            $data['working_days'] = $working_days;
            $data['month'] = $form_date;
            $response['status'] = "Success";
            $response['result'] = "Report Generated Successfully";
        } else{
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return view('reports.partials.attendance_report_monthly' , $data);
    }
    public function attendance_report_single()
    {
        $data['page_title'] = "Attendance Report - Atlantis BPO CRM";
        $team = Team::where('team_lead_id', Auth::user()->user_id)->where('status', 1)->first();
        $data['self'] = false;
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['agents'] = User::where('status', 1)->get();
        }else if($team) {
            $team_users = TeamMember::where('team_id', $team->team_id)->pluck('user_id')->toArray();
            array_push($team_users, Auth::user()->user_id);
            $data['agents'] = User::whereIn('user_id',$team_users)->where('status', 1)->get();
        } else {
            $data['agents'] = User::where('user_id', Auth::user()->user_id)->where('status', 1)->get();
            $data['self'] = true;
        }
        return view('reports.attendance_report_single' , $data);
    }
    public function generate_single_attendance_report(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'form_date' => 'required',
            'to_date' => 'required',
            'user_id' => 'required',
        ]);
        if($validator->passes()) {
            $form_date = $request->form_date;
            $to_date = $request->to_date;
            $user = User::whereUserId($request->user_id)->first();
            $holiday_count = $this->check_holidays($form_date, $to_date,$user->department_id, $user->user_id, $user->role_id);
            $working_days = working_days($form_date, $to_date);
            $data['attendance_list'] = AttendanceLog::where('user_id', $request->user_id)->whereBetween('attendance_date', [$form_date, $to_date])->get();
            $data['agent_name'] = User::where('user_id', $request->user_id)->pluck('full_name')->first();
            $response['status'] = "Success";
            $response['result'] = "Report Generated Successfully";
            $data['holiday_count'] = $holiday_count;
            $data['working_days'] = $working_days;
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return view('reports.partials.attendance_single_report_list' , $data);
    }
    private function check_holidays($form_date, $to_date, $department_id, $user_id, $role_id)
    {
        $check_holidays = Holiday::where(function ($query_dpt) use($department_id) {
            return $query_dpt->where('department_id', $department_id)
                ->orWhere('department_id',0);
        })
            ->where(function ($query_role) use($role_id) {
                return $query_role->whereRaw('FIND_IN_SET("'.$role_id.'",role_id)')
                    ->orWhere('role_id',0);
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
            $holiday_count = $holiday_count+1;
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

    public function leaves_taken_report_monthly()
    {
        $data['page_title'] = "Monthly Leaves Taken Report - Atlantis BPO CRM";
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['users'] = User::where('status', 1)->get();
        } else {
            $team = Team::where('team_lead_id', Auth::user()->user_id)->where('status', 1)->first();
            $team_users = TeamMember::where('team_id', $team->team_id)->pluck('user_id')->toArray();
            array_push($team_users, Auth::user()->user_id);
            $data['users'] = User::whereIn('user_id',$team_users)->where('status', 1)->get();
        }
        return view('reports.leaves_taken_report_monthly', $data);
    }
    public function generate_monthly_leaves_taken_report(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'user_id' => 'required'
        ]);
        if($validator->passes()) {
            $from_date = Employee::where('user_id',$request->user_id)->pluck('joining_date')->first();// Employee Joining Date
            $today_date = get_date();
            $to_date = date("Y-m-t", strtotime($today_date));
            $endDate = $to_date;
            $startDate = $from_date;
            $working_days = working_days($startDate, $endDate);
            $data['leaves_taken'] = LeaveApplication::select(
                DB::raw('sum(no_leaves) as leaves_taken, MONTH(added_on) month, ANY_VALUE(added_by) as added_by'))
                ->with('user')->where(['approved_by_manager'=>1,'approved_by_hr'=>1])
                ->where('added_by', $request->user_id)
                ->whereBetween('from', [$startDate,$endDate])
                ->whereBetween('to', [$startDate,$endDate])
                ->whereStatus(1)
                ->groupBy('added_by', 'month')
                ->get();
            $user = User::where('user_id',$request->user_id)->first();
            $data['employee_name'] = User::where('user_id',$request->user_id)->pluck('full_name')->first();
            $holiday_count = $this->check_holidays($from_date, $to_date,$user->department_id, $user->user_id, $user->role_id);
            $data['holiday_count'] = $holiday_count;
            $data['working_days'] = $working_days;
            $data['start_month'] = $from_date;
            $data['curr_month'] = $to_date;
            $response['status'] = "Success";
            $response['result'] = "Report Generated Successfully";
        } else{
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return view('reports.partials.leaves_taken_report_monthly' , $data);
    }
    public function leave_report()
    {
        $data['page_title'] = "Employee Leaves Report - Atlantis BPO CRM";
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['reports'] = LeaveBucketView::with('user')->get();
        } else {
            $data['reports'] = LeaveBucketView::with('user')->whereUserId(Auth::user()->user_id)->get();
        }
        return view('reports.leave_report' , $data);
    }
    public function view_leave_report(Request $request)
    {
        $payroll =  DB::table('payrolls')
            ->select('user_id', 'salary_month', 'leaves', 'half_leaves', 'lates', 'absents')
            ->where('user_id', $request->user_id)
            ->where('status', 1)
            ->where('hr_approved', 1);
        $data['report'] =  AttendanceLog::with('leave.leaveType')
            ->select('user_id', 'attendance_date', 'applied_leave', 'half_leave', 'late', 'absent')
            ->where('user_id', $request->user_id)
            ->where(function ($query) {
                return $query->where('applied_leave', 1)
                    ->orWhere('on_leave',1);
            })
            ->union($payroll)
            ->orderBy('attendance_date', 'ASC')
            ->get();
        $data['user_id'] = $request->user_id;
        return view('reports.partials.leave_report' , $data);
    }
    public function qa_avg_report_form()
    {
        $data['page_title'] = "Atlantis BPO CRM - QA Report";
        $data['small_nav'] = true;
        $data['agents'] = User::where([
            'role_id' => 4,
            'status' => 1,
        ])->get();
        $data['disposition_types'] = CallType::where([
            'status' => 1,
        ])->get();
        return view('reports.qa_avg_report_form', $data);
    }
    public function generate_qa_avg_report(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'from' => 'required',
            'to' => 'required',
        ]);
        if ($validator->passes()) {
            $date_from = parse_datetime_store($request->from.'17:00:00');
            $date_to = parse_datetime_store($request->to. '12:00:00');
            $data['qa_bage'] = DB::table('qa_performance_badge')->get();

            $query = QualityAssurance::selectRaw('AVG(monitor_percentage) as monitor_percentage, ANY_VALUE(agent_id) as agent_id, COUNT(qa_id) as sales_count, COUNT(case when monitor_percentage = 0 then 1 end) as fatal')
                ->with(['agent'])
                ->where([['added_on', '>=', $date_from],['added_on', '<=', $date_to]]);
            if ($request->agent != "") {
                $query = $query->whereIn('agent_id', $request->agent);
            }
            if($request->disposition_type != null){
                $query = $query->where('call_type_id', $request->disposition_type);
            }
            $data['qa_lists'] = $query->groupBy('agent_id')->get();
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return view('reports.partials.qa_avg_report_list', $data);
    }
}
