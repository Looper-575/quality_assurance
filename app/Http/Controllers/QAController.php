<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\QualityAssurance ;

class QAController extends Controller
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
    public function list(){

        $data['page_title'] = "Atlantis BPO CRM - Roles";
        return view('qa.qa_form' , $data);
    }

    public function store(Request $request)
    {  
        dd($request->yes_res);

            $validator = Validator::make($request->all, [
                'rep_name'=> 'required',
                'call_date'=>'required|date',
                'call_type'=> 'required',
                'call_number'=> 'required',
                'greetings' => 'required',
                'customer_name' => 'required',
                'listening' => 'required',
                'courtesy' => 'required',
                'equipment_use'=> 'required',
                'soft_skills' => 'required',
                'using_hold' => 'required',
                'connecting_calls' => 'required',
                'closing' => 'required',
                'automatic_fail' => 'required',
                'yes_responses' => 'required',
                'no_responses' => 'required',
                'automatic_fail_response' => 'required',
                'monitor_percentage'=> 'required',
            ]);

            if($validator->passes()){
                
                $qa = new QualityAssurance; 
                 $qa->rep_name	= $request->rep_name;
                 $qa->call_date = $request->call_date;
                 $qa->call_type = $request->call_type;
                 $qa->call_number = $request-> call_num;
                 $qa->greetings = $request->greetings_radio;
                 $qa->greetings_comment = $request->greetings_comment;
                 $qa->customer_name = $request->customer_radio;
                 $qa->customer_name_comment = $request->customer_name_comment;
                 $qa->listening = $request->listening_radio;        
                 $qa->listening_comment = $request->listening_comment;
                 $qa->courtesy = $request->courtesy_radio;
                 $qa->courtesy_comment = $request->courtesy_comment;
                 $qa->equipment_use = $request->equipment_radio;
                 $qa->equipment_use_comment = $request->equipment_use_comment;
                 $qa->soft_skills = $request->soft_skills_radio;
                 $qa->soft_skills_comment = $request->soft_skills_comment;
                 $qa->using_hold = $request->using_hold_radio;
                 $qa->using_hold_comment = $request->using_hold_comment;
                 $qa->connecting_calls  = $request->connecting_calls_radio;
                 $qa->connecting_calls_comment = $request->connecting_calls_comment;
                 $qa->closing = $request->closing_radio;
                 $qa->closing_comment = $request->closing_comment;
                 $qa->automatic_fail = $request->automatic_fail_radio;
                 $qa->automatic_fail_comment  = $request->automatic_fail_comment;
                 $qa->additional_comment = $request->
                 $qa->yes_responses = $request->
                 $qa->no_responses = $request->
                 $qa->automatic_fail_response = $request->
                 $qa->monitor_percentage = $request->
                 
                }

    }
}