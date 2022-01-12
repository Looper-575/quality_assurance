<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\CallRecording;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function call_connect(Request $request){
        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'from_number' => 'required',
            'to_number' => 'required',
            'agent_id' => 'required',
        ]);
        if ($validator->passes()) {
            try {
                $call_rec = new CallRecording;
                $call_rec->uid = $request->uid;
                $call_rec->from_number = $request->from_number;
                $call_rec->to_number = $request->to_number;
                $call_rec->agent_id = $request->agent_id;
                $call_rec->save();
                $response['status'] = 'success';
                $response['result'] = "Added Successfully";
            } catch (Exception $ex) {
                $response['status'] = 'failure';
                $response['result'] = "Unexpected Db Error";
            }
        }
        else{
            $response['status'] = 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return $response;
    }

    public function call_end(Request $request){
        $validator = Validator::make($request->all(), [
            'uid' => 'required',
            'call_length' => 'required',
            'recording_file_name' => 'required',
        ]);
        if ($validator->passes()) {
            try {

                CallRecording::where('uid', $request->uid)->update([
                    "call_length" => $request->call_length,
                    "recording_file_name" => $request->recording_file_name,
                ]);
                $response['status'] = 'success';
                $response['result'] = "Updated Successfully";
            } catch (Exception $ex) {
                $response['status'] = 'failure';
                $response['result'] = "Unexpected Db Error";
            }
        }
        else{
            $response['status'] = 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return $response;
    }
}
