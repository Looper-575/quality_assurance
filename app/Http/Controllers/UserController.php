<?php
namespace App\Http\Controllers;
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
            return redirect('/');
        }
        $data['page_title'] = "Login - Atlantis BPO CRM";
        return view('Auth.login_form',$data);
    }
    public function list()
    {
        $data['page_title'] = "Users List - Atlantis BPO CRM";
        $data['user_lists'] = User::where('status' , 1)->with(['role', 'manager'])->get();
        return view('users.user_list', $data);
    }
    public function user_form(Request $request)
    {
        $data['page_title'] = "User List - Atlantis BPO CRM";
        $data['user_roles'] = UserRole::where('status',1)->get();
        DB::enableQueryLog();
        $data['managers'] = User::where([
            'status' => 1,
        ])->Where([
            'role_id' => 3,
        ])->orWhere([
            'role_id' => 2,
        ])->orWhere([
            'role_id' => 1,
        ])->get();
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
            ])->with(['role'])->first();
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
            ]);
        }
        if($validator->passes()){
            if(isset($request->user_id)){
                User::where('user_id', $request->user_id)->update([
                    'full_name' => $request->full_name,
                    'role_id' => $request->role_id,
                    'manager_id' => $request->manager_id,
                    'gender' => $request->gender,
                    'contact_number' => $request->contact_number,
                    'postal_address' => $request->postal_address,
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
}
