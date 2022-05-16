<?php
namespace App\Http\Controllers;
use App\Models\Notifications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
    public function get_pending_notifications(){
        $data['notifications'] = Notifications::where('user_id', Auth::user()->user_id)
            ->where('status','!=',0)->orderby('status','ASC')->get();
        $data['unread_notifications'] = Notifications::where('user_id', Auth::user()->user_id)
            ->where('status',1)->count();
        return view('layout.partials.notifications' , $data);
    }
    public function read_notification(Request $request)
    {
       if($request->notification_id == 0 && $request->route_name == 'all'){
           Notifications::where('user_id', Auth::user()->user_id)->update(['status' => 2]);
           return redirect('/');
       } else {
           Notifications::where('notification_id', $request->notification_id)->update(['status' => 2]);
           return redirect('/'.$request->route_name);
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
    // testing email
    public function send_laravel_email()
    {
        $user = User::where('user_id',26)->first();
        $user_email = $user->email;
        $user_name = $user->full_name;
        $email_body = 'You have a pending leave approval Request.';
        $email_subject = 'Pending Leave Approval Request!';
        $email_view = 'email_templates.notification_email';
        $email_data = ['name' => $user_name,
            'email_body' => $email_body];
        // Sending Email
        try {
            \Mail::send($email_view, ['data' => $email_data],
                function ($message) use ($user_name, $user_email, $email_subject) {
                    $message->from('crm-bot@atlantisbposolutions.com','Atlantis CRM Bot');
                    $message->to($user_email, $user_name)
                        ->cc('danish.sheraz575@gmail.com');
                    $message->subject($email_subject);
                });
            return back()->with(['message' => 'Email was successfully sent']);
        } catch (Exception $e) {
            return back()->withErrors(['invalid email address']);
        }
    }
}
