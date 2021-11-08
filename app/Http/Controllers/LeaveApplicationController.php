<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\LeaveApplication;
use App\Models\LeaveType;


class LeaveApplicationController extends Controller
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
    public function index(){
        $data['page_title'] = "Leave Application Form";
        $data['leave_types'] = LeaveType::get();
        return view('leave_application.leave_form' , $data);
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'from'=> 'required',
            'to'=> 'required',

            'leave_type' => 'required',
            'half' => 'required_if:leave_type, == , half',
            'medical_report' => 'required_if:leave_type, == , 3',
            'no_leaves' => 'required_if:leave_type, != , half',
            'reason' => 'required',
        ]);
        if($validator->passes())
        {
            $leave =new LeaveApplication();
            $leave->added_by = Auth::user()->user_id;
            $leave->leave_type_id = $request->leave_type;
            $leave->from = $request->from;
            $leave->to = $request->to;
            $leave->half_type = $request->half;
            $leave_file = "";
            if($request->file('medical_report'))
            {
                $file = $request->file('medical_report');
                $leave_file = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('leave_applications'), $leave_file);
            }
            $leave->attachement = $leave_file;
            $leave->no_leaves  = $request->no_leaves;
            $leave->reason = $request->reason;
            $leave->save();
            $response['status'] = "Success";
            $response['result'] = "Added Successfully";
        }
        else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    public function list()
    {
        $data['page_title'] = "Atlantis BPO CRM - Call Dispositions List";
        $data['leave_lists'] = LeaveApplication::where([
            'status' => 1,
        ])->with(['leaveType'])->get();
        return view('leave_application.leave_list' , $data);
    }



//    public  function edit($id){
//        $data['page_title'] = "Atlantis BPO CRM - Call Disposition Form";
//        $data['leave_edit'] = LeaveApplication::where('id' , $id)->with(['LeaveType'])->get()[0];
//    }
}



