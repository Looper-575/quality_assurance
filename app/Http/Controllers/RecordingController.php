<?php

namespace App\Http\Controllers;

use App\Models\CallDispositionsTypes;
use App\Models\CallRecording;
use Illuminate\Support\Facades\Auth;

class RecordingController extends Controller
{

    public function recordings()
    {
        $data['page_title'] = "Call Queue - Atlantis BPO CRM";
        if(Auth::user()->role_id == 2 || Auth::user()->role_id == 1  || Auth::user()->role_id == 3){
            $data['recording_list_outgoing'] = CallRecording::where('disposed' ,null)->has('did_numbers')->with('user')->orderBy('rec_id', 'desc')->limit(500)->get();
            $data['recording_list_incoming'] = CallRecording::where('disposed' ,null)->doesnthave('did_numbers')->with('user')->orderBy('rec_id', 'desc')->limit(500)->get();
        }
        if(Auth::user()->role_id == 2 || Auth::user()->role_id == 1 || Auth::user()->role_id ==4  || Auth::user()->role_id == 3){
            $data['recording_list_outgoing_own'] = CallRecording::where('disposed' ,null)->has('did_numbers')->with('user')->where('call_recordings.agent_id','=',Auth::user()->vicidialer_id)->orderBy('rec_id', 'desc')->limit(500)->get();
            $data['recording_list_incoming_own'] = CallRecording::where('disposed' ,null)->doesnthave('did_numbers')->with('user')->where([
                ['call_recordings.agent_id','=',Auth::user()->vicidialer_id],
                ['call_recordings.agent_id','<>',0],

            ])->orderBy('rec_id', 'desc')->limit(500)->get();
        }
        return view('call_dipositions.recording_list', $data);
    }

    public function dispose($id){
        $data['page_title'] = "Disposition Form - Atlantis BPO CRM";
        $current = CallRecording::where([
            'rec_id'=> $id,
        ])->first();
        if(is_numeric($current->to_number)){
            $data['call_data'] = CallRecording::where([
                'rec_id'=> $id,
            ])->with('did_numbers.disposition_did')->get();
        } else {
            $data['call_data'] = CallRecording::where([
                ['from_number','=', $current->from_number],
                ['to_number','>', 0]
            ])->with('did_numbers.disposition_did')->orderBy('rec_id', 'DESC')->limit(1)->get();
        }
        $data['disposition_types'] = CallDispositionsTypes::where([
            'status' => 1,
        ])->get();
        return view('call_dipositions.disposition_form',$data);
    }

}
