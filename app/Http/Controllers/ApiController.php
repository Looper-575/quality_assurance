<?php

namespace App\Http\Controllers;
use App\Models\GroupChat;
use App\Models\UserChats;
use Illuminate\Support\Carbon;
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


    public function send_chat_msg(Request $request){
        $msg = new UserChats();
        $msg->to_user = $request->to_user;
        $msg->from_user = $request->from_user;
        $msg->msg = $request->msg;
        $current = Carbon::now()->format('YmdHms');
        $files = [];
        if($request->hasfile('chat_file'))
        {
            $i =1;
            foreach($request->file('chat_file') as $file)
            {
                $name= $current.'_'.$i.'.'.$file->getClientOriginalExtension();
                $file->move(public_path('chat_files'), $name);
                $files[] = $name;
                $i++;
            }
        }
        $msg->attachment = implode(',',$files);
        $msg->added_by = $request->from_user;
        $msg->save();



//        $response['chat_id'] = $msg->id;
//        $response['to_user'] = $request->to_user;
//        $response['from_user'] = $request->from_user;
//        $response['msg'] = $request->msg;
//        $response['attachment'] = implode(',',$files);
//        $response['status'] = 'Success';
//        $response['result'] = 'Sent Successfully';
        return $msg->chat_id;
    }


    public function send_group_msg(Request $request){
        $msg = new GroupChat();
        $msg->from_user = $request->from_user;
        $msg->group_id = $request->group_id;
        $msg->msg = $request->group_msg;
        $current = Carbon::now()->format('YmdHms');
        $files = [];
        if($request->hasfile('group_chat_file'))
        {
            $i =1;
            foreach($request->file('group_chat_file') as $file)
            {
                $name= $current.'_'.$i.'.'.$file->getClientOriginalExtension();
                $file->move(public_path('chat_files'), $name);
                $files[] = $name;
                $i++;
            }
        }
        $msg->attachment = implode(',',$files);
        $msg->save();

        return $msg->group_chat_id;
    }

}
