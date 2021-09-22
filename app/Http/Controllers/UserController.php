<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
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
    


    public function index()
    {
        if(Auth::user() && Auth::user()->user_id){
            return redirect('home');
        }
        $data['page_title'] = "Atlantis BPO Quality Assurance";
        //$data['qa'] = Product::where('status', '!=', 0)->get();
        return view('auth.login_form',$data);
    }


    public function list()
    {
        $data['page_title'] = "Atlantis BPO CRM - Users List";
        //$data['qa'] = Product::where('status', '!=', 0)->get();      
        return view('users.user_list',$data);
    }

    public function user_form()
    {
        $data['page_title'] = "Atlantis BPO CRM - Users Form";
        //$data['qa'] = Product::where('status', '!=', 0)->get();
        return view('users.user_form',$data);
    }


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\JsonResponse
     */
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
            ])->get();
            if(count($user)>0) {
                Auth::login($user[0]);
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

    public function verify_account($verification_token)
    {
        $data['page_title'] = "Marcha Marlo - Account Verification";
        $data['meta_keywords'] = "";
        $data['meta_description'] = "";
        $data['meta_title'] = "";
        $data['categories'] = Category::where('status', 1)->get();
        $user = User::where([
            'remember_token' => $verification_token
        ])->get();
        if(count($user)>0) {
            User::where([
                'remember_token' => $verification_token
            ])->update([
                'status' => 1,
                //'remember_token' => '',
            ]);
            $data['status'] = true;
        } else {
            $data['status'] = false;
        }
        return view('public_pages.verify_account', $data);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
