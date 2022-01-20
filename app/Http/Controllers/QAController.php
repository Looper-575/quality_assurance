<?php
namespace App\Http\Controllers;
use App\Models\CallDisposition;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\QualityAssurance;
use App\Models\User;
use App\Models\CallType;
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
    public function form(){
        $data['page_title'] = "QA From - Atlantis BPO CRM";
        $data['agents'] = User::where([
            'role_id'=> 4,
            'status'=> 1,
            ])->get();
        $data['call_types'] = CallType::get();
        return view('qa.qa_form' , $data);
    }
    public function list()
    {
        $data['page_title'] = "QA List - Atlantis BPO CRM";
        $data['small_nav'] = true;
        $data['qa_lists'] = QualityAssurance::where([
            'status'=> 1,
            ])->with(['agent','call_type','qa_status'])->get();
           // dd($data);
        // $data['qa_single_data'] = QualityAssurance::find($id)->get();
        return view('qa.qa_list', $data);
    }
    public function show(Request $request)
    {
        $data['qa_data'] = QualityAssurance::where([
            'qa_id' => $request->qa_id,
        ])->with(['agent', 'call_type'])->get()[0];
        return view('qa.qa_single', $data);
    }
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(),[
                'rep_name'=> 'required',
                'call_type'=> 'required',
                'call_number'=> 'required',
                'greetings_correct' => 'required',
                'greetings_assurity_statement'=> 'required',
                'customer_name_call' => 'required',
                'listening_skills' => 'required',
                'courtesy_please' => 'required',
                'courtesy_thank_you' => 'required',
                'courtesy_interest' => 'required',
                'courtesy_empathy' => 'required',
                'courtesy_Apologized' => 'required',
                'equipment_system' => 'required',
                'soft_skills_energy' => 'required',
                'soft_skill_avoided_silence' => 'required',
                'soft_skill_polite' => 'required',
                'soft_skill_grammar' => 'required',
                'soft_skill_refrained_company' => 'required',
                'soft_skill_positive_words' => 'required',
                'using_hold_informed_customer' => 'required',
                'using_hold_touch' => 'required',
                'using_hold_thanked' => 'required',
                'connecting_calls_department' => 'required',
                'connecting_calls_customer' => 'required',
                'closing_recap' => 'required',
                'clossing_assistance' => 'required',
                'automatic_fail_misquoting' => 'required',
                'automatic_fail_disconnected' => 'required',
                'automatic_fail_answer' => 'required',
                'automatic_fail_repeating_details' => 'required',
                'automatic_fail_changing_details' => 'required',
                'automatic_fail_fabricating' => 'required',
                'additional_comment' => 'required',
        ]);
        if($validator->passes()) {
            $qa = new QualityAssurance;
            $qa->added_by = Auth::user()->user_id;
            $qa->agent_id	= $request->rep_name;
            $qa->call_date = $request->call_date;
            $qa->call_type_id = $request->call_type;
            $qa->call_number = $request->call_number;
            $qa->greetings_correct = $request->greetings_correct;
            $qa->greetings_assurity_statement  = $request->greetings_assurity_statement;
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
            $qa->soft_skill_avoided_silence  = $request-> soft_skill_avoided_silence;
            $qa->soft_skill_polite = $request->soft_skill_polite;
            $qa->soft_skill_grammar = $request->soft_skill_grammar;
            $qa->soft_skill_refrained_company= $request->soft_skill_refrained_company;
            $qa->soft_skill_positive_words = $request->soft_skill_positive_words;
            $qa->soft_skills_comment = $request->soft_skills_comment;
            $qa->using_hold_informed_customer = $request->using_hold_informed_customer;
            $qa->using_hold_touch = $request->using_hold_touch;
            $qa->using_hold_thanked = $request->using_hold_thanked;
            $qa->using_hold_comment = $request->using_hold_comment;
            $qa->connecting_calls_department = $request->connecting_calls_department;
            $qa->connecting_calls_customer = $request->connecting_calls_customer;
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
            $qa->yes_responses = $request->yes_responses;
            $qa->no_responses = $request->no_responses;
            $qa->automatic_fail_response = $request->automatic_fail_response;
            $qa->monitor_percentage = $request->monitor_percentage;
            $qa->call_id = $request->call_id;
            $call_id = QualityAssurance::select('call_id')->where([
                'call_id' => $request->call_id,
            ])->get();

            if(count($call_id)>0){
                $response['status'] = "Failure!";
                $response['result'] = "Quality Assessment for this call already exist";
            } else {
                $qa->save();
                $response['status'] = "Success";
                $response['result'] = "Added Successfully";
            }
        } else {
            $response['status'] = "Failure!";
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function edit($id)
    {
        $data['page_title'] = "QA Form - Atlantis BPO CRM";
        $data['qa_edit'] = QualityAssurance::where('qa_id' , $id)->with('agent' , 'call_type')->get()[0];
        return view('qa.qa_edit' , $data);
    }
    public function qa_queue(){
        $data['page_title'] = "QA Queue - Atlantis BPO CRM";
        $data['qa_queue'] = CallDisposition::where([
            'status' => 1,
            'disposition_type' => 1
        ])->with(['user','call_disposition_types','call_dispositions_services'])->doesntHave('qa_assessment')->whereRaw("date(added_on)>='2021-11-29 17:00:00'")->get();
        $data['qa_done'] = QualityAssurance::where([
            'status'=> 1,
            'call_type_id' => 1
        ])->with(['agent','call_type','qa_status','call_disposition','call_disposition.call_dispositions_services'])->whereRaw("date(added_on)>='2021-11-29 17:00:00'")->get();
        return view('qa.qa_list' , $data);
    }
    public function qa_add($id){
        $data['page_title'] = "QA Form - Atlantis BPO CRM";
        $data['qa_data'] = CallDisposition::where([
            'call_id'=> $id,
            'status'=> 1,
        ])->with(['call_disposition_types','user'])->get()[0];
        $data['agents'] = User::where([
            'role_id'=> 4,
            'status'=> 1,
        ])->get();
        $data['call_types'] = CallType::get();
        return view('qa.qa_form' , $data);
    }
    public function show_single_qa(Request $request)
    {
        $data['qa_data'] = QualityAssurance::where([
            'qa_id' => $request->qa_id,
        ])->with(['agent', 'call_type','call_disposition'])->get()[0];
        return view('qa.qa_single_report' , $data);
    }
}
