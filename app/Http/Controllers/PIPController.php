<?php

namespace App\Http\Controllers;

use App\Models\ManagerialRole;
use App\Models\Notifications;
use App\Models\PIP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class PIPController extends Controller
{
    public function __construct()
    {    }
    public function index()
    {
        $data['page_title'] = "Performance Improvement Plans List - Atlantis BPO CRM";
        $manager_ids = ManagerialRole::whereType('Manager')->whereStatus(1)->pluck('role_id')->toArray();
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['pip'] = PIP::orderBy('pip_id', 'DESC')->get();
            $data['is_hrm'] = true;
            $data['is_om'] = false;
            $data['is_staff'] = false;
        } else if(in_array(Auth::user()->role_id, $manager_ids)){
            $data['pip'] = PIP::where('om_id', Auth::user()->user_id)->orderBy('pip_id', 'DESC')->get();
            $data['is_hrm'] = false;
            $data['is_om'] = true;
            $data['is_staff'] = false;
        }else{
            $data['pip'] = PIP::where('staff_id', Auth::user()->user_id)->orderBy('pip_id', 'DESC')->get();
            $data['is_hrm'] = false;
            $data['is_om'] = false;
            $data['is_staff'] = true;
        }
        return view('performance_improvement_plan.index' , $data);
    }
    public function pip_form(Request $request)
    {
        $data['page_title'] = "Performance Improvement Plan Form - Atlantis BPO CRM";
        $manager_ids = ManagerialRole::whereType('Manager')->whereStatus(1)->pluck('role_id')->toArray();
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['staff'] = User::whereStatus(1)->get();
            $data['is_om'] = false;
        } else {
            $data['staff'] = User::whereStatus(1)->where('manager_id', Auth::user()->user_id)->get();
            $is_om = User::where('status',1)->whereIn('role_id',$manager_ids)->where('user_id',Auth::user()->user_id)->get();
            $data['is_om'] = $is_om->count();
        }
        $data['om'] = User::where('status',1)->whereIn('role_id',$manager_ids)->get();
        if(isset($request->pip_id)) {
            $data['pip'] = PIP::where('pip_id', $request->pip_id)->first();
        }else{
            $data['pip'] = false;
        }
        return view('performance_improvement_plan.pip_form',$data);
    }
    public function pip_save(Request $request){
        $validator = Validator::make($request->all(), [
            'staff_id' => 'required',
            'om_id' => 'required',
            'pip_from' => 'required',
            'pip_to' => 'required',
            'review_date' => 'required',
            'improvement_required' => 'required',
            'action_required' => 'required',
            'needed_resource' => 'required',
            'target_date' => 'required',
            'recommendations' => 'required',
            'om_comments' => 'required'
        ]);
        if($validator->passes()){
            $pip = PIP::where('pip_id', $request->pip_id)->get();
            $pip_data = [
                'added_by' => Auth::user()->user_id,
                'staff_id' => $request->staff_id,
                'om_id' => $request->om_id,
                'pip_from' => $request->pip_from,
                'pip_to' => $request->pip_to,
                'review_date' => $request->review_date,
                'improvement_required' => $request->improvement_required,
                'action_required' => $request->action_required,
                'needed_resource' => $request->needed_resource,
                'target_date' => $request->target_date,
                'recommendations' => $request->recommendations,
                'om_comments' => $request->om_comments,
                'om_approve' => 1,
                'om_approve_date' => get_date()
            ];
            if(count($pip)>0){
                PIP::where('pip_id', $pip[0]->pip_id)->update($pip_data);
                $pip_id = $pip[0]->pip_id;
                $staff_id = $pip[0]->staff_id;
            } else {
               $pip_created =  PIP::create($pip_data);
               $pip_created->fresh();
               $pip_id = $pip_created->pip_id;
               $staff_id = $pip_created->staff_id;
            }
            $Notification_data = Notifications::where([
                'reference_table' => 'performance_improvement_plans',
                'type' => 'PIP',
                'reference_id' => $pip_id,
                'user_id' => $staff_id,
            ])->first();
            if(!$Notification_data ) {
                add_notifications('performance_improvement_plans', 'PIP', $pip_id, $staff_id, 'Pending PIP Ack.');
            }
            $response['status'] = 'success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function staff_ack_pip_with_comments(Request $request){
        $data['pip'] = PIP::where('pip_id', $request->pip_id)->first();
        return view('performance_improvement_plan.staff_ack_modal', $data);
    }
    public function staff_ack_pip(Request $request)
    {
        $staff_ack = PIP::where('pip_id', $request->pip_id)->update([
            'staff_comments' => $request->staff_comments,
            'staff_acknowledgement' => 1,
            'staff_acknowledgement_date' => get_date()
        ]);
        if($staff_ack){
            $hr_user_id = User::where('role_id', 5)->pluck('user_id')->first();
            add_notifications('performance_improvement_plans','PIP',$request->pip_id,$hr_user_id,'Pending PIP HR Approval');

            $response['status'] = "Success";
            $response['result'] = "Staff Acknowledged Successfully";
        }else{
            $response['status'] = "Failure";
            $response['result'] = "Some Error in Query";
        }
        return response()->json($response);
    }
    public function hrm_approve_pip(Request $request)
    {
        PIP::where('pip_id', $request->pip_id)->update([
            'hrm_approve' => 1,
            'hrm_approve_date' => get_date()
        ]);
        $response['status'] = "Success";
        $response['result'] = "Approved by HRM Successfully";
        return response()->json($response);
    }

    public function view_pip(Request $request)
    {
        $data['page_title'] = "View Performance Improvement Plan Details - Atlantis BPO CRM";
        if(isset($request->pip_id)) {
            $data['pip'] = PIP::where('pip_id', $request->pip_id)->get()[0];
        }else{
            $data['pip'] = false;
        }
        return view('performance_improvement_plan.view_pip', $data);
    }

    public function get_om_users_data(Request $request)
    {
        $data['staff'] = User::whereStatus(1)->where('manager_id', $request->om_id)->get();
        return response()->json($data);
    }

}
