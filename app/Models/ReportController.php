<?php

namespace App\Http\Controllers;

use App\Models\AttendanceLog;
use App\Models\CallDisposition;
use App\Models\Enquiry;
use App\Models\UserRole;
//use http\Client\Curl\User;
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

    // functions for Disposistion Lead Report

    public function disposition_report_form()
    {
        $data['page_title'] = "Atlantis BPO CRM - Call Disposition Form";
        $data['agents']= User::where([
            'role_id' => 4,
            'status' => 1 ,
        ])->get();
        $data['disposition_types'] = CallDispositionsTypes::where([
            'status' => 1,
        ])->get();
        return view('reports.lead_report_form' , $data);
    }
    public function generate_disposition_report(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'from' => 'required',
            'to' => 'required',
        ]);
        $where = array();
        if($request->disposition_type != "") {
            $where['disposition_type'] = $request->disposition_type;
        }
        if($request->agent != ""){
            $data['call_disp_lists'] = CallDisposition::select('*')->with('qa_status')->whereIn('added_by' , $request->agent)->where($where)->whereDate('added_on', '>=', parse_date_store($request->from))
                ->whereDate('added_on', '<=', parse_date_store($request->to))->get();
        } else {
            $data['call_disp_lists'] = CallDisposition::select('*')->with('qa_status')->where($where)->whereDate('added_on', '>=', parse_date_store($request->from))
                ->whereDate('added_on', '<=', parse_date_store($request->to))->get();
        }
        return view('reports.partials.lead_report_list' , $data);
    }
    public function generate_attendance_report(Request $request)
    {
        $month = date("m",strtotime($request->year_month));
        $year = date("Y",strtotime($request->year_month));

        $manager = $request->team;
//        $manager = 23;

        $validator = Validator::make($request->all(),[
            'year_month' => 'required',
            'team' => 'required',
        ]);
        if($validator->passes()) {
            $data['attendance_list'] = AttendanceLog::select(DB::raw('sum(late) as `lates`'), DB::raw('sum(absent) as `absents`'), DB::raw('sum(on_leave) as `leaves`'), DB::raw('count(user_id) as `working_days`'), DB::raw('MONTH(attendance_date) month'), 'user_id')
                ->with('user')->whereHas('user', function($q) use ($manager)
                    {
                        $q->where('manager_id', $manager);
                    })
                ->whereYear('attendance_date', $year)
                ->whereMonth('attendance_date', $month)
                ->groupBy('month', 'user_id')
                ->get();

            $response['status'] = "Success";
            $response['result'] = "Report Generated Successfully";

            return view('reports.partials.attendance_report_list' , $data);
        }
        else{
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
    }
}





