<?php

namespace App\Http\Controllers;

use App\Models\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class HolidayController extends Controller
{
    public function index()
    {
        $data['page_title'] = "Holidays - Atlantis BPO CRM";
        $data['holidays'] = Holiday::orderBy('holiday_id', 'DESC')->get();
        return view('holiday.index' , $data);
    }
    public function save_holiday(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title'=> 'required',
            'type'=>'required',
            'date_from'=> 'required',
            'date_to'=> 'required',
        ]);
        if($validator->passes()) {
            Holiday::updateOrCreate([
                'holiday_id' => $request->holiday_id,
            ], [
                'title' => $request->title,
                'type' => $request->type,
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
}
