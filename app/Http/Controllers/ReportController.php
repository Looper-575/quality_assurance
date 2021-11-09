<?php

namespace App\Http\Controllers;

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
            $data['call_disp_lists'] = CallDisposition::whereIn('added_by' , $request->agent)->where($where)->whereDate('added_on', '>=', parse_date_store($request->from))
                ->whereDate('added_on', '<=', parse_date_store($request->to))->get();
        } else {
            $data['call_disp_lists'] = CallDisposition::where($where)->whereDate('added_on', '>=', parse_date_store($request->from))
                ->whereDate('added_on', '<=', parse_date_store($request->to))->get();
        }
        return view('reports.partials.lead_report_list' , $data);
    }
}





