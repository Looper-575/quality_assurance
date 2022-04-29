<?php
namespace App\Http\Controllers;
use App\Models\AttendanceLog;
use App\Models\ManagerialRole;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $data['page_title'] = "Leave Application Form - Atlantis BPO CRM";
        $data['leave_types'] = LeaveType::where('status',1)->get();
        $data['leave'] = false;
        return view('leave_application.leave_form' , $data);
    }
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'from'=> 'required',
            'to'=> 'required_if:leave_type, != , half',
            'leave_type' => 'required',
            'half' => 'required_if:leave_type, == , half',
            'medical_report' => 'mimes:pdf,png,jpg,jpeg ',
            'no_leaves' => 'required_if:leave_type, != , half',
            'reason' => 'required',
        ]);
        if($validator->passes())
        {
            $manager_id = ManagerialRole::where('role_id', Auth::user()->role_id)->whereType('Manager')->first();
            $approved_by_manager = NULL;
            if($manager_id != Null && Auth::user()->role_id == $manager_id->role_id){
                $approved_by_manager = 1;
            }
            $leave_file = "";
            if($request->file('medical_report')) {
                $file = $request->file('medical_report');
                $leave_file = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('leave_applications'), $leave_file);
            }
            if($request->has('leave_id')) {
                LeaveApplication::where('leave_id', $request->leave_id)->update([
                    'added_by' => Auth::user()->user_id,
                    'leave_type_id' => $request->leave_type,
                    'from' => $request->from,
                    'to' => $request->to,
                    'half_type' => $request->half,
                    'no_leaves' => $request->no_leaves,
                    'approved_by_manager' => $approved_by_manager,
                    'attachement' => $leave_file,
                    'reason' => $request->reason,
                ]);
                $pending_leave_id = $request->leave_id;
            } else {
                $leave =new LeaveApplication();
                $leave->added_by = Auth::user()->user_id;
                $leave->leave_type_id = $request->leave_type;
                $leave->from = $request->from;
                $leave->to = $request->to;
                $leave->half_type = $request->half;
                $leave->approved_by_manager = $approved_by_manager;
                $leave->attachement = $leave_file;
                $leave->no_leaves  = $request->no_leaves;
                $leave->reason = $request->reason;
                $leave->save();
                $pending_leaves = $leave->fresh();
                $pending_leave_id = $pending_leaves->leave_id;
            }
            // NOTIFICATION for Pending Leave Approval by Manager
            $send_email = true;
            if($approved_by_manager == NULL){
                $manager_id = User::where('user_id', Auth::user()->user_id)->pluck('manager_id')->first();
                add_notifications('leave_applications','Leaves',$pending_leave_id,$manager_id,'Pending Leave Approval by Manager',$send_email);
            }
            if($approved_by_manager = 1){
                $hr_user_id = User::where('role_id', 5)->pluck('user_id')->first();
                add_notifications('leave_applications','Leaves',$pending_leave_id,$hr_user_id,'Pending Leave Approval by HR',$send_email);
            }
            $response['status'] = "Success";
            $response['result'] = "Added Successfully";
        } else {
            $response['status'] = "Failure!";
            $response['result'] = str_replace('3', 'Sick',$validator->errors()->toJson());
        }
        return response()->json($response);
    }
    public function edit(Request $request){
        $data['page_title'] = "Leave Application Form";
        $data['leave_types'] = LeaveType::where('status',1)->get();
        if(isset($request->id)){
            $data['leave'] = LeaveApplication::where('leave_id',$request->id)->get()[0];
        } else {
            $data['leave'] = false;
        }
        return view('leave_application.leave_form' , $data);
    }
    Public function delete(Request $request)
    {
        LeaveApplication::where('leave_id', $request->id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }
    public function list()
    {
        $data['page_title'] = "Leave Applications - Atlantis BPO CRM";
        $manager_id = ManagerialRole::where('role_id', Auth::user()->role_id)->orWhere([['type','=','Manager'],['type','=','Team Lead']])->first();
        if(isset($manager_id)){
            $manager_role_id = $manager_id->role_id;
        } else {
            $manager_role_id = 0;
        }
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5) {
            $data['leave_lists'] = LeaveApplication::where([
                ['status','=',1], ['approved_by_manager','=', 1],
                ['approved_by_hr','=', 1]
            ])->with('user')->get();
            $data['leave_lists_unapproved'] = LeaveApplication::where([
                ['status', '=' ,1],
            ])->where(function($query) {
                $query->where('approved_by_manager','=',NULL)
                    ->orWhere('approved_by_hr','=',NULL);
            })->with('user')->get();
            if(Auth::user()->role_id == 5){
                $data['leave_lists_unapproved'] = LeaveApplication::where([
                    ['status','=', 1],['approved_by_manager','=',1],['approved_by_hr','=',NULL]
                ])->with('user')->get();
            }
        } else if(Auth::user()->role_id == $manager_role_id){
            $data['leave_lists'] = LeaveApplication::where([
                ['status','=',1],
                ['approved_by_manager' ,'=',1],
                ['approved_by_hr' ,'=',1]
            ])->where(function($query) {
                $query->whereHas('user', function ($query) {
                    return $query->where('manager_id', '=', Auth::user()->user_id);
                })->orWhere('added_by','=',Auth::user()->user_id);
            })->get();
            $data['leave_lists_unapproved']= LeaveApplication::where([
                ['status','=',1],
            ])->where(function($query) {
                $query->where('approved_by_manager','=',NULL)
                    ->orWhere('approved_by_hr','=',NULL);
            })->where(function($query) {
                $query->whereHas('user', function ($query) {
                    return $query->where('manager_id', '=', Auth::user()->user_id);
                })->orWhere('added_by','=',Auth::user()->user_id);
            })->get();
        } else {
            $data['leave_lists'] = LeaveApplication::where([
                ['status','=', 1] ,
                ['added_by','=',Auth::user()->user_id],
                ['approved_by_manager' ,'=',1],
                ['approved_by_hr' ,'=',1],
            ])->with('user')->get();
            $data['leave_lists_unapproved'] = LeaveApplication::where([
                ['status', '=' ,1],['added_by','=',Auth::user()->user_id]
            ])->where(function($query) {
                $query->where('approved_by_manager','=',NULL)
                    ->orWhere('approved_by_hr','=',NULL);
            })->with('user')->get();
        }
        $data['manager_id'] = $manager_role_id;
        return view('leave_application.leave_list' , $data);
    }
    Public function reject(Request $request)
    {
        $manager_id = ManagerialRole::where('role_id', Auth::user()->role_id)->whereType('Manager')->first();
        if(Auth::user()->role_id == $manager_id->role_id){
            LeaveApplication::where('leave_id', $request->id)->update([
                'approved_by_manager' => 2,
                'approved_by_hr' => 2,
            ]);
        }
        elseif (Auth::user()->role_id == 5){
            LeaveApplication::where('leave_id', $request->id)->update([
                'approved_by_hr' => 2,
            ]);
        }
        $response['status'] = "Success";
        $response['result'] = "Application Rejected";
        return response()->json($response);
    }
    Public function approve(Request $request)
    {
        if (Auth::user()->role_id == 5) {
            $leave = LeaveApplication::where('leave_id', $request->id)->first();
            if($leave->leave_type_id == 4)
            {
                AttendanceLog::where('user_id', $leave->added_by)
                    ->where('attendance_date', $leave->from)
                    ->update(['applied_leave' => 0, 'on_leave' => 0, 'late' => 0, 'half_leave' => 1, 'absent' => 0]);
                LeaveApplication::where('leave_id', $request->id)->update([
                    'approved_by_hr' => 1,
                ]);
            }
            else if($leave->leave_type_id == 5)
            {
                AttendanceLog::where('user_id', $leave->added_by)
                    ->whereBetween('attendance_date', [$leave->from, $leave->to])
                    ->update(['applied_leave' => 0, 'on_leave' => 0, 'late' => 0, 'half_leave' => 0, 'absent' => 1]);
                LeaveApplication::where('leave_id', $request->id)->update([
                    'approved_by_hr' => 1,
                ]);
            }
             else {
                 AttendanceLog::where('user_id', $leave->added_by)
                     ->whereBetween('attendance_date', [$leave->from, $leave->to])
                     ->update(['applied_leave' => 1, 'on_leave' => 0, 'late' => 0, 'half_leave' => 0, 'absent' => 0]);
                 LeaveApplication::where('leave_id', $request->id)->update([
                     'approved_by_hr' => 1,
                 ]);
             }
        }
        else {
            LeaveApplication::where('leave_id', $request->id)->update([
                'approved_by_manager' => 1,
            ]);
            $send_email = true;
            $hr_user_id = User::where('role_id', 5)->pluck('user_id')->first();
            add_notifications('leave_applications','Leaves',$request->id,$hr_user_id,'Pending Leave Approval by HR',$send_email);
        }
        $response['status'] = "Success";
        $response['result'] = "Application Accepted";
        return response()->json($response);
    }
    public function team_leave_form()
    {
        $data['page_title'] = "Team Leave Application Form - Atlantis BPO CRM";
        $data['leave_types'] = LeaveType::where('status',1)->get();
        $data['agents'] = Team::with('team_member.user')->has('team_member.user')->where('team_lead_id', Auth::user()->user_id)->first();
        $data['leave'] = false;
        return view('leave_application.team_leave_form' , $data);
    }
    public function team_leave_save(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'from'=> 'required',
            'to'=> 'required_if:leave_type, != , half',
            'leave_type' => 'required',
            'half' => 'required_if:leave_type, == , half',
            'medical_report' => 'mimes:pdf,png,jpg,jpeg ',
            'no_leaves' => 'required_if:leave_type, != , half',
            'reason' => 'required',
            'team_member' => 'required',
        ]);
        if($validator->passes())
        {
            $added_by = $request->team_member;
            if(isset($request->leave_id)) {
                LeaveApplication::where('leave_id', $request->leave_id)->update([
                    'added_by' => $added_by,
                    'leave_type_id' => $request->leave_type,
                    'from' => $request->from,
                    'to' => $request->to,
                    'half_type' => $request->half_type,
                    'attachement' => $request->attachement,
                    'no_leaves' =>$request->no_leaves,
                    'reason' => $request->reason,
                ]);
                $leave_id = $request->leave_id;
            } else {
                $leave = new LeaveApplication();
                $leave->added_by = $added_by;
                $leave->leave_type_id = $request->leave_type;
                $leave->from = $request->from;
                $leave->to = $request->to;
                $leave->half_type = $request->half;
                $leave->no_leaves = $request->no_leaves;
                $leave->approved_by_manager = 1;
                $leave_file = "";
                if($request->file('medical_report')) {
                    $file = $request->file('medical_report');
                    $leave_file = time() . rand(1, 100) . '.' . $file->extension();
                    $file->move(public_path('leave_applications'), $leave_file);
                }
                $leave->attachement = $leave_file;
                $leave->no_leaves  = $request->no_leaves;
                $leave->reason = $request->reason;
                $leave->save();
                $new_leave_record_get = $leave->fresh();
                $leave_id = $new_leave_record_get->leave_id;
            }
            $send_email = true;
            $hr_user_id = User::where('role_id', 5)->pluck('user_id')->first();
            add_notifications('leave_applications','Leaves',$leave_id,$hr_user_id,'Pending Leave Approval by HR',$send_email);
            $response['status'] = "Success";
            $response['result'] = "Added Successfully";
        } else {
            $response['status'] = "Failure!";
            $response['result'] = str_replace('3', 'Sick',$validator->errors()->toJson());
        }
        return response()->json($response);
    }
    public function get_employee_leaves_bucket(Request $request){
        return get_leave_bucket_leaves($request->team_member_id);
    }
}
