<?php
namespace App\Http\Controllers;
use App\Models\AttendanceLog;
use App\Models\CallDisposition;
use App\Models\CallDispositionsDid;
use App\Models\CallType;
use App\Models\Holiday;
use App\Models\LeaveApplication;
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
            $date_from = parse_datetime_store($request->from.'17:00:00');
            $date_to = parse_datetime_store($request->to. '7:00:00');
            if ($request->agent != "") {
                $data['call_disp_lists'] = CallDisposition::select('*')->with(['qa_status','qa_assessment'])
                    ->whereIn('added_by', $request->agent)->where($where)
                    ->whereDate('added_on', '>=', $date_from)
                    ->whereDate('added_on', '<=', $date_to)->get();
            } else {
                $data['call_disp_lists'] = CallDisposition::select('*')->with('qa_status')->where($where)
                    ->whereDate('added_on', '>=', $date_from)
                    ->whereDate('added_on', '<=', $date_to)->get();
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
            $data['dids'] = CallDispositionsDid::where('did_id', 36)->get();
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
            $date_to = parse_datetime_store($request->to. '7:00:00');
            if(Auth::user()->role_id==13){
                $request->did_id=36;
                $data['call_disp_lists'] = CallDisposition::select('*')->with(['qa_status','qa_assessment'])
                    ->where('did_id', $request->did_id)->where($where)
                    ->whereDate('added_on', '>=', $date_from)
                    ->whereDate('added_on', '<=', $date_to)->get();
                return view('reports.partials.lead_report_list', $data);
            }
            if($request->did_id[0] == ""){
                $data['call_disp_lists'] = CallDisposition::select('*')->with(['qa_status','qa_assessment'])
                    ->where($where)
                    ->whereDate('added_on', '>=', $date_from)
                    ->whereDate('added_on', '<=', $date_to)->get();
            } else {
                $data['call_disp_lists'] = CallDisposition::select('*')->with(['qa_status','qa_assessment'])
                    ->whereIn('did_id', $request->did_id)->where($where)
                    ->whereDate('added_on', '>=', $date_from)
                    ->whereDate('added_on', '<=', $date_to)->get();
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
            $date_to = parse_datetime_store($request->to. '7:00:00');
            if ($request->agent != "") {
                $data['qa_lists'] = QualityAssurance::select('*')->with(['qa_status', 'call_type', 'call_disposition'])
                    ->whereIn('agent_id', $request->agent)->where('call_type_id', $disposition_type)
                    ->whereDate('added_on', '>=', $date_from)
                    ->whereDate('added_on', '<=', $date_to)->get();
            } else {
                $data['qa_lists'] = QualityAssurance::select('*')->with(['qa_status', 'call_type', 'call_disposition'])
                    ->where('call_type_id', $disposition_type)
                    ->whereDate('added_on', '>=', $date_from)
                    ->whereDate('added_on', '<=', $date_to)->get();
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
            $form_date = date($year.'-'.$month.'-01');
            $to_date = date("Y-m-t", strtotime($request->year_month));
            $holiday_count = $this->check_holidays($form_date, $to_date);
            $endDate = $to_date;
            $startDate = $form_date;
            $working_days = working_days($startDate, $endDate);
            $data['attendance_list'] = AttendanceLog::select(DB::raw('sum(late) as `lates`, sum(absent) as `absents`, sum(on_leave) as `leaves` , sum(half_leave) as `half_leaves` , count(user_id) as `attendance_marked` , MONTH(attendance_date) month'), 'user_id')
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
        } else{
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return view('reports.partials.attendance_report_monthly' , $data);
    }
    public function attendance_report_single()
    {
        $data['page_title'] = "Attendance Report - Atlantis BPO CRM";
        if(Auth::user()->role_id == 1){
            $data['agents'] = User::where('status', 1)->get();
        } else{
            $data['agents'] = User::where('manager_id',Auth::user()->user_id)->where('status', 1)->get();
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
            $holiday_count = $this->check_holidays($form_date, $to_date);
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
    private function check_holidays($form_date, $to_date)
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
}
