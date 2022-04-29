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
        $data['unread_notifications'] = Notifications::where('user_id', Auth::user()->user_id)
            ->where('status',1)->count();
        return view('notifications.notifications' , $data);
    }
    public function read_notification(Request $request)
    {
       if($request->notification_id == 0 && $request->type == 'all'){
           Notifications::where('user_id', Auth::user()->user_id)->update(['status' => 2]);
           return redirect('/');
       } else {
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
        $del_notification = Notifications::where('user_id', Auth::user()->user_id)->update(['status' => 0]);
        if($del_notification){
            return redirect('/');
        }
    }
    public function show_welcome_modal(){
        $data['notifications_count'] = Notifications::where('user_id', Auth::user()->user_id)
            ->where('status',1)->count();
        $data['user_birthday'] = $this->check_user_birthday();
        $data['other_user_birthday'] = $this->check_other_user_birthday();
        $data['unread_messages_count'] = $this->check_new_messages();
        return response()->json($data);
    }
    public function check_user_birthday()
    {
        $employee_birthday = false;
        $today_date = date('m-d', strtotime(get_date()));
        $employee_dob = DB::table('employees')->select('full_name','date_of_birth')
            ->where('user_id',Auth::user()->user_id)
            ->where(DB::raw("(DATE_FORMAT(date_of_birth,'%m-%d'))"),$today_date)
            ->count();
        if ($employee_dob > 0) {
            $employee_birthday = true;
        }
        return $employee_birthday;
    }
    public function check_other_user_birthday()
    {
        $today_date = date('m-d', strtotime(get_date()));
        $employee_dob_check = DB::table('employees')
            ->where('user_id','!=',Auth::user()->user_id)
            ->where(DB::raw("(DATE_FORMAT(date_of_birth,'%m-%d'))"),$today_date)
            ->whereStatus(1)->pluck('full_name')->toArray();
        return $employee_dob_check;
    }
    public function check_new_messages()
    {
        $unread_messages_count = \App\Models\UserChat::where('to_user', Auth::user()->user_id)
            ->where('msg_read',0)->count();
        return $unread_messages_count;
    }
}
