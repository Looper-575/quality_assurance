<?php

namespace App\Http\Controllers;

use App\Models\Notifications;
use App\Models\NotificationTypes;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\UserRole;
use Mockery\Exception;

class NotificationsController extends Controller
{
    /**
     *
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() { }

    /* **********  notification types methods ************ */
    public function index()
    {
        $data['page_title'] = "Notification Types List - Atlantis BPO CRM";
        $data['notification_types'] = NotificationTypes::orderBy('notification_type_id', 'DESC')->get();
        $data['is_admin'] = false;
        if(Auth::user()->role_id == 1){
            $data['is_admin'] = true;
        }
        return view('notification_types.index' , $data);
    }
    public function notification_type_form(Request $request){
        $data['page_title'] = "notification Types Form - Atlantis BPO CRM";
        if(isset($request->notification_type_id)) {
            $data['notification_type'] = NotificationTypes::where('notification_type_id', $request->notification_type_id)->get()[0];
        }else{
            $data['notification_type'] = false;
        }
        return view('notification_types.notification_type_form',$data);

    }
    public function notification_type_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'type' => 'required'
        ]);
        if ($validator->passes()) {
            $notification_type = NotificationTypes::where('notification_type_id', $request->notification_type_id)->get();
            $notification_type_data = [
                'added_by' => Auth::user()->user_id,
                'type' => $request->type
            ];
            if(count($notification_type)>0){
                NotificationTypes::where('notification_type_id', $notification_type[0]->notification_type_id)->update($notification_type_data);
            } else {
                NotificationTypes::create($notification_type_data);
            }
            $response['status'] = 'success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function view_notification_type(Request $request)
    {
        $data['page_title'] = "Notification Type Details - Atlantis BPO CRM";
        if(isset($request->notification_type_id)) {
            $data['notification_type'] = NotificationTypes::where('notification_type_id', $request->notification_type_id)->get()[0];
        }else{
            $data['notification_type'] = false;
        }
        return view('notification_types.view_notification_type', $data);
    }
    /* **************************** */

    public function get_pending_notifications(){
        $data['notifications'] = Notifications::where('user_id', Auth::user()->user_id)
            ->where('status','!=',0)->orderby('status','ASC')->get();
        return view('notifications.notifications' , $data);
    }
    public function read_notification(Request $request)
    {
       if($request->notification_id == 0 && $request->type == 'all'){
           Notifications::where('user_id', Auth::user()->user_id)->update(['status' => 2]);
           return redirect('/');
       }else{
           Notifications::where('notification_id', $request->notification_id)->update(['status' => 2]);
           if($request->type == 'Leaves'){
               return redirect('/leave_list');
           }
           if($request->type == 'PIP'){
               return redirect('/performance_improvement_plan');
           }
           if($request->type == 'Evaluation'){
               return redirect('/employee_assessment');
           }
       }
    }
    public function clear_all_notifications(Request $request)
    {
        //$del_notification = Notifications::where('user_id', Auth::user()->user_id)->delete();
        $del_notification = Notifications::where('user_id', Auth::user()->user_id)->update(['status' => 0]);
        if($del_notification){
            return redirect('/');
        }
    }
}