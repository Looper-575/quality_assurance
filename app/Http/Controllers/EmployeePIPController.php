<?php
namespace App\Http\Controllers;
use App\Models\ManagerialRole;
use App\Models\Notifications;
use App\Models\EmployeePIP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
class EmployeePIPController extends Controller
{
    public function __construct()
    {    }
    public function index()
    {
        $data['page_title'] = "Employees PIP List - Atlantis BPO CRM";
        $manager_ids = ManagerialRole::whereType('Manager')->whereStatus(1)->pluck('role_id')->toArray();
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['pip'] = EmployeePIP::orderBy('pip_id', 'DESC')->get();
            $data['is_hr'] = true;
            $data['is_manager'] = false;
            $data['is_employee'] = false;
        } else if(in_array(Auth::user()->role_id, $manager_ids)){
            $data['pip'] = EmployeePIP::where('manager_id', Auth::user()->user_id)->orderBy('pip_id', 'DESC')->get();
            $data['is_hr'] = false;
            $data['is_manager'] = true;
            $data['is_employee'] = false;
        }else{
            $data['pip'] = EmployeePIP::where('user_id', Auth::user()->user_id)->orderBy('pip_id', 'DESC')->get();
            $data['is_hr'] = false;
            $data['is_manager'] = false;
            $data['is_employee'] = true;
        }
        return view('employee_pip.pip_list' , $data);
    }
    public function pip_form(Request $request)
    {
        $data['page_title'] = "Employee PIP Form - Atlantis BPO CRM";
        $manager_ids = ManagerialRole::whereType('Manager')->whereStatus(1)->pluck('role_id')->toArray();
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['employee'] = User::whereStatus(1)->get();
            $data['is_manager'] = false;
        } else {
            $data['employee'] = User::whereStatus(1)->where('manager_id', Auth::user()->user_id)->get();
            $is_manager = User::where('status',1)->whereIn('role_id',$manager_ids)->where('user_id',Auth::user()->user_id)->get();
            $data['is_manager'] = $is_manager->count();
        }
        $data['om'] = User::where('status',1)->whereIn('role_id',$manager_ids)->get();
        if(isset($request->pip_id)) {
            $data['pip'] = EmployeePIP::where('pip_id', $request->pip_id)->first();
        }else{
            $data['pip'] = false;
        }
        return view('employee_pip.pip_form',$data);
    }
    public function pip_save(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'manager_id' => 'required',
            'pip_from' => 'required',
            'pip_to' => 'required',
            'review_date' => 'required',
            'improvement_required' => 'required',
            'action_required' => 'required',
            'needed_resource' => 'required',
            'target_date' => 'required',
            'recommendations' => 'required',
            'manager_comments' => 'required'
        ]);
        if($validator->passes()){
            $pip = EmployeePIP::where('pip_id', $request->pip_id)->get();
            $pip_data = [
                'added_by' => Auth::user()->user_id,
                'user_id' => $request->user_id,
                'manager_id' => $request->manager_id,
                'pip_from' => $request->pip_from,
                'pip_to' => $request->pip_to,
                'review_date' => $request->review_date,
                'improvement_required' => $request->improvement_required,
                'action_required' => $request->action_required,
                'needed_resource' => $request->needed_resource,
                'target_date' => $request->target_date,
                'recommendations' => $request->recommendations,
                'manager_comments' => $request->manager_comments,
                'manager_approve' => 1,
                'manager_approve_date' => get_date()
            ];
            if(count($pip)>0){
                EmployeePIP::where('pip_id', $pip[0]->pip_id)->update($pip_data);
                $pip_id = $pip[0]->pip_id;
                $user_id = $pip[0]->user_id;
            } else {
               $pip_created =  EmployeePIP::create($pip_data);
               $pip_created->fresh();
               $pip_id = $pip_created->pip_id;
               $user_id = $pip_created->user_id;
            }
                $send_email = false;
                add_notifications('employee_pip', 'employee_pip', $pip_id, $user_id, 'Pending PIP Ack.',$send_email);

            $response['status'] = 'success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function employee_ack_pip_with_comments(Request $request){
        $data['pip'] = EmployeePIP::where('pip_id', $request->pip_id)->first();
        return view('employee_pip.employee_ack_modal', $data);
    }
    public function employee_ack_pip(Request $request)
    {
        $employee_ack = EmployeePIP::where('pip_id', $request->pip_id)->update([
            'employee_comments' => $request->employee_comments,
            'employee_acknowledgement' => 1,
            'employee_acknowledgement_date' => get_date()
        ]);
        if($employee_ack){
            $hr_user_ids = User::where('role_id', 5)->get()->pluck('user_id')->toArray();
            if(count($hr_user_ids)>0){
                for($i=0; $i<count($hr_user_ids); $i++){
                    $send_email = false;
                    add_notifications('employee_pip','employee_pip',$request->pip_id,$hr_user_ids[$i],'Pending PIP HR Approval',$send_email);
                }
            }
            $response['status'] = "Success";
            $response['result'] = "Employee Acknowledged Successfully";
        }else{
            $response['status'] = "Failure";
            $response['result'] = "Some Error in Query";
        }
        return response()->json($response);
    }
    public function hr_approve_pip(Request $request)
    {
        EmployeePIP::where('pip_id', $request->pip_id)->update([
            'hr_approve' => 1,
            'hr_approve_date' => get_date()
        ]);
        $response['status'] = "Success";
        $response['result'] = "Approved by HR Successfully";
        return response()->json($response);
    }
    public function view_pip(Request $request)
    {
        $data['page_title'] = "View Employee's PIP Detail - Atlantis BPO CRM";
        if(isset($request->pip_id)) {
            $data['pip'] = EmployeePIP::where('pip_id', $request->pip_id)->first();
        }else{
            $data['pip'] = false;
        }
        return view('employee_pip.view_pip', $data);
    }
    public function get_manager_users_data(Request $request)
    {
        $data['employee'] = User::whereStatus(1)->where('manager_id', $request->manager_id)->get();
        return response()->json($data);
    }
}
