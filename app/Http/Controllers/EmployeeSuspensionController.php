<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\EmployeeSuspension;
use App\Models\Shift;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\UserRole;
use Mockery\Exception;


class EmployeeSuspensionController extends Controller
{
    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {    }

    public function index()
    {
        $data['page_title'] = "Atlantis BPO CRM - Employee Suspensions";
        $data['employee_suspension'] = EmployeeSuspension::with('user')->whereStatus(1)->orderBy('suspension_id', 'DESC')->get();
        $data['archived_employee_suspension'] = EmployeeSuspension::with('user')->whereStatus(0)->orderBy('suspension_id', 'DESC')->get();
        $data['is_admin'] = false;
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['is_admin'] = true;
        }
        return view('employee_suspension.employee_suspension_list' , $data);
    }
    public function suspension_form(Request $request){
        $data['page_title'] = "Employee Suspension Form - Atlantis BPO CRM";
        $data['users'] = User::doesnthave('employee_suspension')->has('employee')->where('status',1)->where('user_type', 'Employee')->orderBy('user_id', 'DESC')->get();
        if(isset($request->suspension_id)){
            $data['suspension'] = EmployeeSuspension::with('user')->where('suspension_id',$request->suspension_id)->first();
            $data['users'] = User::has('employee')->where('user_type', 'Employee')->orderBy('user_id', 'DESC')->get();
        }
        return view('employee_suspension.suspension_form',$data);
    }
    public function suspension_save(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'reason' => 'required',
        ]);
        if ($validator->passes()) {
            $suspension = EmployeeSuspension::where('suspension_id', $request->suspension_id)->first();
            $suspension_data = [
                'added_by' => Auth::user()->user_id,
                'user_id' => $request->user_id,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'reason' => $request->reason,
            ];
            if($suspension){
                EmployeeSuspension::where('suspension_id', $suspension->suspension_id)->update($suspension_data);
            } else {
                EmployeeSuspension::create($suspension_data);
            }
            // change user status to Suspended
            User::where('user_id', $request->user_id)->update(['status' => 4]);
            // change user employee record status to Suspended
            Employee::where('user_id', $request->user_id)->update(['status' => 4]);

            $response['status'] = 'Success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'Failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function suspension_view(Request $request){
        $data['page_title'] = "Employee Suspension Details - Atlantis BPO CRM";
        if(isset($request->suspension_id)) {
            $data['suspension'] = EmployeeSuspension::with('user')->where('suspension_id',$request->suspension_id)->first();
        }else{
            $data['suspension'] = false;
        }
        return view('employee_suspension.suspension_details_view', $data);
    }
    public function unsuspend_user_account(Request $request){
        User::where('user_id', $request->suspended_user_id)->update([
            'status' => 1,
        ]);
        EmployeeSuspension::where('user_id', $request->suspended_user_id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Un Suspended Successfully";
        return response()->json($response);
    }
}



