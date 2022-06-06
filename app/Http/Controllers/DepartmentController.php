<?php

namespace App\Http\Controllers;

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


class DepartmentController extends Controller
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
//        $this->middleware('check-permission:department,update');
    }

    public function index()
    {
        $data['page_title'] = "Atlantis BPO CRM - Team Type";
        $data['types'] = Department::with('added_by_user')->where('status',1)->with(['added_by_user'])->orderBy('department_id', 'DESC')->get();
        return view('department.department_list' , $data);
    }

    public function team_type_save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);
        if ($validator->passes()) {

            if($request->team_type_id != null){
                $check = Department::where('title', $request->title)->where('department_id', '!=', $request->team_type_id)->get();
            }
            else{
                $check = Department::where('title', $request->title)->get();
            }

            if(count($check)>0) {
                $response['status'] = "Failue";
                $response['result'] = "Record Already Exists";
            } else {
                Department::updateOrCreate([
                    'department_id' => $request->team_type_id,
                ], [
                    'title' => $request->title,
                    'added_by' => Auth::user()->user_id,
                ]);
                $response['status'] = "Success";
                $response['result'] = "Added Successfully";
            }
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }

    public function team_type_delete(Request $request)
    {
        Department::where('department_id', $request->team_type_id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }

}



