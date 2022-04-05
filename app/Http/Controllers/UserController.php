<?php
namespace App\Http\Controllers;
use App\Models\CallDispositionsDid;
use App\Models\Department;
use App\Models\ManagerialRole;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\UserRole;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    public function index()
    {
        if(Auth::user() && Auth::user()->user_id){
            $employee_id = get_employee_id(Auth::user()->user_id);
            if($employee_id == 0 && Auth::user()->user_type=='Employee'){
                return redirect('/employee_form_wizard');
            }else{
                return redirect('/');
            }
        }
        $data['page_title'] = "Login - Atlantis BPO CRM";
        return view('Auth.login_form',$data);
    }
    public function list()
    {
        $data['page_title'] = "Users List - Atlantis BPO CRM";
        $data['departments'] = Department::where('status', 1)->get();
        $data['user_lists'] = User::where([
            ['status', '=', 1],
            ['role_id', '!=', 13]
        ])->with(['role', 'manager'])->get();
        return view('users.user_list', $data);
    }
    public function user_form(Request $request)
    {
        $data['page_title'] = "User List - Atlantis BPO CRM";
        $data['departments'] = Department::where('status', 1)->get();
        $data['time_zones'] = DB::table('time_zones')->where('status', 1)->get();
        $data['user_roles'] = UserRole::where('status',1)->where('role_id', '!=', 13)->get();
        $manager_ids = ManagerialRole::whereIn('type', ['Manager'])->where('status', 1)->pluck('role_id')->toArray();
        $data['managers'] = User::where('status', 1)->whereIn('role_id', $manager_ids)->get();
        if(isset($request->user_id)){
            $data['user'] = User::where('user_id',$request->user_id)->get()[0];
        } else {
            $data['user'] = false;
        }
        return view('users.user_form',$data);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if ($validator->passes()) {
            $user = User::where([
                'email'=>$request->input('email'),
                'password'=>encrypt_password($request->input('password')),
                'status'=>1
            ])->first();
            if($user) {
                Auth::login($user);
                $response['status'] = "Success";
                $response['result'] = "Logged In";
            } else {
                $response['status'] = "Failure";
                $response['result'] = "Invalid email or password";
            }
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function save(Request $request){
        if($request->user_id){
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                "images" => "image|mimes:png,gif,jpeg,jpg|max:1024",
                'gender' => 'required',
                'postal_address' => 'required',
                'contact_number' => 'required',
                'role_id' => 'required',
                'time_zone' => 'required',
                'user_type' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'email' => 'required',
                "images" => "image|mimes:png,gif,jpeg,jpg|max:1024",
                'password' => 'required|unique:users,email',
                'gender' => 'required',
                'postal_address' => 'required',
                'contact_number' => 'required',
                'role_id' => 'required',
                'time_zone' => 'required',
                'user_type' => 'required',
            ]);
        }
        if($validator->passes()){
            if(isset($request->user_id)){
                User::where('user_id', $request->user_id)->update([
                    'full_name' => $request->full_name,
                    'role_id' => $request->role_id,
                    'department_id' => $request->department_id,
                    'vicidialer_id' => $request->vicidialer_id,
                    'manager_id' => $request->manager_id,
                    'gender' => $request->gender,
                    'contact_number' => $request->contact_number,
                    'postal_address' => $request->postal_address,
                    'time_zone' => $request->time_zone,
                    'user_type' => $request->user_type,
                ]);
            } else {
                $user = new User;
                $user->added_by = Auth::user()->user_id;
                $user->full_name = $request->full_name;
                $user->email = $request->email;
                $user->manager_id = $request->manager_id;
                $user->password = encrypt_password($request->input('password'));
                $user_image = "";
                if($request->file('image')) {
                    $file = $request->file('image');
                    $user_image = time() . rand(1, 100) . '.' . $file->extension();
                    $file->move(public_path('user_images'), $user_image);
                }
                $user->image = $user_image;
                $user->gender = $request->gender;
                $user->postal_address = $request->postal_address;
                $user->contact_number = $request->contact_number;
                $user->role_id = $request->role_id;
                $user->vicidialer_id = $request->vicidialer_id;
                $user->department_id = $request->department_id;
                $user->time_zone = $request->time_zone;
                $user->user_type = $request->user_type;
                $user->save();
            }
            $response['status'] = 'Success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    Public function delete(Request $request)
    {
        $role = User::where('user_id', $request->user_id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }
    public function logout()
    {
        Auth::logout();
        Session::put('permissions', false);
        return redirect('login');
    }
    public function change_password(Request $request)
    {
        User::where('user_id', $request->user_id)->update([
            'password' => encrypt_password($request->password)
        ]);
        $response['status'] = "Success";
        $response['result'] = "Password Updated Successfully";
        return response()->json($response);
    }
    public function edit_profile(Request $request){
        $data['page_title'] = "User Profile Edit - Atlantis BPO CRM";
        if(isset($request->user_id)){
            $data['user'] = User::where('user_id',$request->user_id)->first();
        } else {
            $data['user'] = false;
        }
        return view('Auth.edit_profile',$data);
    }
    public function save_profile_changes(Request $request){
     // dd($request->all());
        if($request->user_id){
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'postal_address' => 'required',
                'contact_number' => 'required',
                'current_password'=> 'required'
            ]);
            $check_curr_pass = User::where([
                'user_id'=>$request->user_id,
                'password'=>encrypt_password($request->current_password)])->count();
            if($validator->passes()){
                if($check_curr_pass > 0){
                    User::where('user_id', $request->user_id)->update([
                        'full_name' => $request->full_name,
                        'contact_number' => $request->contact_number,
                        'postal_address' => $request->postal_address
                    ]);
                    $response['status'] = "Success";
                    $response['result'] = "User Profile Updated Successfully";
                }else{
                    $response['status']= 'failure';
                    $response['result'] = "Current Password Provided Doesn't match with Database Stored Password";
                }
            }else{
                $response['status']= 'failure';
                $response['result'] = $validator->errors()->toJson();
            }
            if($request->password){ // password_confirmation
                $validator = Validator::make($request->all(), [
                    'full_name' => 'required',
                    'postal_address' => 'required',
                    'contact_number' => 'required',
                    'password' => 'required|confirmed',
                    'password_confirmation' => 'required',
                    'current_password'=> 'required'
                ]);
                if($validator->passes() && $request->password == $request->password_confirmation && $check_curr_pass > 0) {
                    User::where('user_id', $request->user_id)->update([
                        'full_name' => $request->full_name,
                        'contact_number' => $request->contact_number,
                        'postal_address' => $request->postal_address,
                        'password' => encrypt_password($request->password)
                    ]);
                    $response['status'] = "Success";
                    $response['result'] = "User Profile Updated Successfully";
                }else{
                    $response['status']= 'failure';
                    $response['result'] = $validator->errors()->toJson();
                }
            }
            if($request->file('user_image')) {
                $file = $request->file('user_image');
                $user_image = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('user_images'), $user_image);
                User::where('user_id', $request->user_id)->update(['image' => $user_image]);
            }
            return response()->json($response);
        }
    }
    public function change_pass(Request $request)
    {//dd($request->all());
        $check_curr_pass = User::where([ 'user_id'=>$request->user_id,
                                         'password'=>encrypt_password($request->curr_password)])->count();
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'curr_password' => 'required'
        ]);
        //dd($validator->passes());
        if($validator->passes()) {
            if($check_curr_pass > 0){
                User::where('user_id', $request->user_id)->update([
                    'password' => encrypt_password($request->password)
                ]);
                $response['status'] = "Success";
                $response['result'] = "Password Updated Successfully";
            }else{
                $response['status']= 'failure';
                $response['result'] = "Current Password doesn't Match";
            }
            return response()->json($response);
        }else{
            $response['status']= 'failure';
            $response['result'] = 'The password confirmation does not match.';
        }
        return response()->json($response);
    }
    /****** VENDORS *******/
    public function vendors_list()
    {
        $data['page_title'] = "Vendors List - Atlantis BPO CRM";
        $data['user_lists'] = User::where('status' , 1)->where('role_id', 13)->get();
        return view('vendors.vendor_list', $data);
    }
    public function vendor_form(Request $request)
    {
        $data['page_title'] = "Vendors List - Atlantis BPO CRM";
        $data['user_roles'] = UserRole::where('status',1)->where('role_id', 13)->get();
        $data['dids'] = CallDispositionsDid::where('status', 1)->get();
        DB::enableQueryLog();
        if(isset($request->user_id)){
            $data['user'] = User::where('user_id',$request->user_id)->get()[0];
        } else {
            $data['user'] = false;
        }
        return view('vendors.vendor_form',$data);
    }
    public function vendor_save(Request $request){
        if($request->user_id){
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                "images" => "image|mimes:png,gif,jpeg,jpg|max:1024",
                'gender' => 'required',
                'postal_address' => 'required',
                'contact_number' => 'required',
                'role_id' => 'required',
                'vendor_did_id' => 'required',
                'user_type' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'full_name' => 'required',
                'email' => 'required',
                "images" => "image|mimes:png,gif,jpeg,jpg|max:1024",
                'password' => 'required|unique:users,email',
                'gender' => 'required',
                'postal_address' => 'required',
                'contact_number' => 'required',
                'role_id' => 'required',
                'vendor_did_id' => 'required',
                'user_type' => 'required',
            ]);
        }
        if($validator->passes()){
            $vendor_did_id = implode(", ", $request->vendor_did_id);
            if(isset($request->user_id)){
                User::where('user_id', $request->user_id)->update([
                    'full_name' => $request->full_name,
                    'role_id' => $request->role_id,
                    'vendor_did_id' => $request->vendor_did_id,
                    'gender' => $request->gender,
                    'contact_number' => $request->contact_number,
                    'postal_address' => $request->postal_address,
                    'vendor_did_id' => $vendor_did_id,
                    'user_type' => $request->user_type,
                ]);
            } else {
                $user = new User;
                $user->added_by = Auth::user()->user_id;
                $user->full_name = $request->full_name;
                $user->email = $request->email;
                $user->vendor_did_id = $vendor_did_id;
                $user->password = encrypt_password($request->input('password'));
                $user_image = "";
                if($request->file('image')) {
                    $file = $request->file('image');
                    $user_image = time() . rand(1, 100) . '.' . $file->extension();
                    $file->move(public_path('user_images'), $user_image);
                }
                $user->image = $user_image;
                $user->gender = $request->gender;
                $user->postal_address = $request->postal_address;
                $user->contact_number = $request->contact_number;
                $user->role_id = $request->role_id;
                $user->user_type = $request->user_type;
                $user->save();
            }
            $response['status'] = 'Success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
}
