<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\UserRole;


class RolesController extends Controller
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

    public function list()
    {
        $data['page_title'] = "Atlantis BPO CRM - Roles";
        $data['roles'] = UserRole::where('status',1)->with(['added_by_user'])->get();
        return view('users.user_role' , $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if ($validator->passes()) {
            $check = UserRole::where('title', $request->title)->where('status', 1)->get();
            if(count($check)>0) {
                $response['status'] = "Failue";
                $response['result'] = "Record Already Exists";
            } else {
                $role = new UserRole;
                $role->added_by = Auth::user()->user_id;
                $role->title = $request->title;
                $role->slug = slugify($request->title);
                $role->save();
                $response['status'] = "Success";
                $response['result'] = "Added Successfully";
            }
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required',
            'title' => 'required',
        ]);
        if ($validator->passes()) {
            $check = UserRole::where('title', $request->title)->where('role_id', '!=', $request->role_id)->get();
            if(count($check)>0) {
                $response['status'] = "Failue";
                $response['result'] = "Record Already Exists";
            } else {
                UserRole::where('role_id', $request->role_id)->update([
                    'modified_by' => Auth::user()->user_id,
                    'title' => $request->title,
                    'slug' => slugify($request->title),

                ]);
                $response['status'] = "Success";
                $response['result'] = "Updated Successfully";
            }
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    Public function delete(Request $request)
    {
        $role = UserRole::where('role_id', $request->role_id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }

}



                        