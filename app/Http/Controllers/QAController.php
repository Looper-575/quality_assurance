<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\QualityAssurance;

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

    public function save(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'rep_name'=> 'required',
            'call_date'=>'required|date',
            'call_type'=> 'required',
            'call_number'=> 'required',
            /*using_hold_comment
            connecting_calls_department
            connecting_calls_customer
            connecting_calls_comment
            closing_recap
            clossing_assistance
            closing_comment
            automatic_fail_misquoting
            automatic_fail_disconnected
            automatic_fail_answer
            automatic_fail_repeating_details
            automatic_fail_changing_details
            automatic_fail_fabricating
            automatic_fail_other
            automatic_fail_comment*/
        ]);

        if($validator->passes()) {
            $qa = new QualityAssurance;
            $qa->added_by = Auth::user()->user_id;
            $qa->rep_name	= $request->rep_name;
            $qa->call_date = $request->call_date;
            $qa->call_type = $request->call_type;
            $qa->call_number = $request->call_number;
            $qa->greetings_correct = $request->greetings_correct;
            $qa-> greetings_assurity_statement  = $request->greetings_assurity_statement;
            $qa->greetings_comment = $request->greetings_comment;
            $qa->customer_name_call = $request->customer_name_call;
            $qa->customer_comment = $request->customer_comment;
            $qa->listening_skills = $request->listening_skills;
            $qa->listening_comment= $request-> listening_comment;
            $qa->courtesy_please = $request->courtesy_please;
            $qa->courtesy_thank_you = $request->courtesy_thank_you;
            $qa->courtesy_interest = $request->courtesy_interest;
            $qa->courtesy_empathy = $request-> courtesy_empathy;
            $qa->courtesy_Apologized = $request->courtesy_Apologized;
            $qa->courtesy_comment = $request->courtesy_comment;
            $qa->equipment_system = $request-> equipment_system;
            $qa->equipment_comment = $request->equipment_comment;
            $qa->soft_skills_energy = $request->soft_skills_energy;
            $qa->soft_skill_avoided_silence   = $request-> soft_skill_avoided_silence;
            $qa->soft_skill_polite = $request->soft_skill_polite;
            $qa->soft_skill_grammar = $request->soft_skill_grammar;
            $qa-> soft_skill_refrained_company= $request->soft_skill_refrained_company;
            $qa-> soft_skill_positive_words = $request->soft_skill_positive_words;
            $qa-> soft_skills_comment = $request->soft_skills_comment;
            $qa-> using_hold_informed_customer = $request->using_hold_informed_customer;
            $qa->using_hold_touch = $request->using_hold_touch;
            $qa->using_hold_thanked = $request->using_hold_thanked;
            $qa->using_hold_comment = $request->using_hold_comment;
            $qa->connecting_calls_department = $request->using_hold_comment;
            $qa->connecting_calls_customer = $request->using_hold_comment;
            $qa->connecting_calls_comment = $request->connecting_calls_comment;
            $qa->closing_recap = $request->closing_recap;
            $qa->clossing_assistance = $request->clossing_assistance;
            $qa->closing_comment= $request->closing_comment;
            $qa->automatic_fail_misquoting= $request->automatic_fail_misquoting;
            $qa->automatic_fail_disconnected = $request->automatic_fail_disconnected;
            $qa->automatic_fail_answer = $request->automatic_fail_answer;
            $qa->automatic_fail_repeating_details = $request->automatic_fail_repeating_details;
            $qa->automatic_fail_changing_details = $request->automatic_fail_changing_details;
            $qa->automatic_fail_fabricating = $request->automatic_fail_fabricating;
            $qa->automatic_fail_other = $request->automatic_fail_other;
            $qa-> automatic_fail_comment = $request->automatic_fail_comment;
            $qa->additional_comment = $request->additional_comment;
            $qa->yes_responses = $request->yes_resp;
            $qa->no_responses = $request->no_resp;
            $qa->automatic_fail_response = $request->auto_fail_resp;
            $qa->monitor_percentage = $request->monitor_percent;
            $qa->save();
            $response['status'] = "Success";
            $response['result'] = "Added Successfully";
            return redirect()->back();
        }
        else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
}
