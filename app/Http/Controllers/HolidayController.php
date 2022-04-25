<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Holiday;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class HolidayController extends Controller
{
    public function __construct()
    {
    }
    public function index()
    {
        $data['page_title'] = "Holidays - Atlantis BPO CRM";
        $holidays = Holiday::with('department')->orderBy('holiday_id', 'DESC')->get();
        for ($i=0; $i<count($holidays); $i++){
            $start = strtotime($holidays[$i]->date_from);
            $end = strtotime($holidays[$i]->date_to);
            $holiday_count = 1;
            while(date('Y-m-d', $start) < date('Y-m-d', $end)){
                $holiday_count += date('N', $start) < 6 ? 1 : 0;
                $start = strtotime("+1 day", $start);
            }
            $holidays[$i]->holiday_count = $holiday_count;
        }
        $data['holidays'] = $holidays;
        $data['departments'] = Department::where('status', 1)->get();
        return view('holiday.index' , $data);
    }
    public function save_holiday(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'=> 'required',
            'department_id'=>'required',
            'date_from'=> 'required',
            'date_to'=> 'required',
        ]);
        if($validator->passes()) {
            if($request->role_id[0] == 0){
                $role_id = 0;
            } else {
                $role_id = implode(',',$request->role_id);
            }
            if($request->user_id[0] == 0){
                $user_id = 0;
            } else {
                $user_id = implode(',', $request->user_id);
            }
            Holiday::updateOrCreate([
                'holiday_id' => $request->holiday_id,
            ], [
                'title' => $request->title,
                'department_id' => $request->department_id,
                'role_id' => $role_id,
                'user_id' => $user_id,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to,
                'added_by' => Auth::user()->user_id,
            ]);
            $response['status'] = "Success";
            $response['result'] = "Saved Successfully";
        }
        else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function holiday_delete(Request $request)
    {
        Holiday::destroy($request->id);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }
    public function get_selected_role_users(Request $request)
    {
        if($request->department_id == 0 && $request->role_id[0] == 0){
            $model =  User::with('role')->where('user_type', 'Employee')->get();
        } else if($request->department_id != 0 && $request->role_id[0] == 0) {
            $model =  User::with('role')->where('department_id', $request->department_id)->where('user_type', 'Employee')->get();
        } else {
            $model =  User::with('role')->whereIn('role_id', $request->role_id)->where('user_type', 'Employee')->get();

        }
        return response()->json($model);
    }
}
