@extends('admin_layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
@endsection
@section('content')
    <form method="post" action="{{route('qa_save')}}">
        @csrf
        <div class="card">
            <div class="card-header" style="justify-content: space-between;">
                <h4>Quality Assurance Form</h4>
            </div>
            <div class="card-body">

                <div class=" row mb-2">
                    <div class="col-6">
                        <label  for="agent_id"><strong> Rep Name  </strong> </label>
                        <input class="form-control" type="text" name="rep_name" >
                    </div>
               

                    <div class="col-6">
                        <label  for="yes_responses"> Yes Responses </label>
                        <input class="form-control" type="text" name="yes_responses" readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label for="call_date"><strong> Call Date  </strong> </label>
                        <input class="form-control" type="date" name="call_date" >
                    </div>
                    <div class="col-6">
                        <label for="no_responses"> No Responses </label>
                        <input class="form-control" type="text" name="no_responses" readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label for="call_type"><strong> Call Type </strong></label>
                        <input class="form-control" type="text" name="call_type" >
                    </div>
                    <div class="col-6">
                        <label for="auto_fail"> Automatic Fail </label>
                        <input class="form-control" type="text" name="automatic_fail_response" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="call_num"><strong> Call Number  </strong> </label>
                        <input class="form-control" type="text" name="call_number" >
                    </div>
                    <div class="col-6">
                        <label for="monitor_percent"> Monitor Percentage </label>
                        <input class="form-control" type="text" name="monitor_percentage" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline">Greetings</strong><br>
                        <p class="form-check form-check-inline">Used Correct Greetings</p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="greetings_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="greetings" value="1" id="greetings_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="greetings_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="greetings" value="0" id="greetings_radio2" >
                        </div><br>
                        <p class="form-check form-check-inline"> Used Assurity Statement</p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="greetings_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="greetings" value="1" id="greetings_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="greetings_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="greetings" value="0" id="greetings_radio2" >
                        </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="greetings_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline">Customer Name</strong><br>
                        <p class="form-check form-check-inline">Used the customer's name at least once during the call</p> 
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="customer_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="customer_name" value="1" id="customer_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="customer_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="customer_name" value="0" id="customer_radio2" >
                        </div>
                       
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="customer_name_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline">Listening</strong><br>
                        <div class="row">
                            <div class="col-7">
                                <p class="form-check form-check-inline">Used listening skills (doesn't interrupt, remembers info, etc)</p>    
                            </div>
                            <div class="col-5">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="listening_radio1" > Yes </label>
                                    <input class="form-check-input" type="radio" name="listening" value="1" id="listening_radio1"  checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="listening_radio2" > No </label>
                                    <input class="form-check-input" type="radio" name="listening" value="0" id="listening_radio2" >
                                </div>
                            </div>    
                        </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="listening_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Courtesy </strong><br>
                        <p class="form-check form-check-inline" >Used "please" when appropriate </p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="courtesy_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="courtesy" value="1" id="courtesy_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="courtesy_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="courtesy" value="0" id="courtesy_radio2" >
                        </div>

                         <p class="form-check form-check-inline"> Used "thank you" when appropriate</p>
                         <div class="form-check form-check-inline">
                            <label class="form-check-label" for="courtesy_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="courtesy" value="1" id="courtesy_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="courtesy_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="courtesy" value="0" id="courtesy_radio2" >
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline" >Showed interest and willingness to assist the customer</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_radio1" > Yes </label>
                                    <input class="form-check-input" type="radio" name="courtesy" value="1" id="courtesy_radio1"  checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_radio2" > No </label>
                                    <input class="form-check-input" type="radio" name="courtesy" value="0" id="courtesy_radio2" >
                                </div>
                            </div>
                        </div>
                                <p class="form-check form-check-inline">Showed empathy when appropriate</p>
                                
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_radio1" > Yes </label>
                                    <input class="form-check-input" type="radio" name="courtesy" value="1" id="courtesy_radio1"  checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_radio2" > No </label>
                                    <input class="form-check-input" type="radio" name="courtesy" value="0" id="courtesy_radio2" >
                                </div>
                                
                                <p class="form-check form-check-inline"> Apologized when appropriate </p>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_radio1" > Yes </label>
                                    <input class="form-check-input" type="radio" name="courtesy" value="1" id="courtesy_radio1"  checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_radio2" > No </label>
                                    <input class="form-check-input" type="radio" name="courtesy" value="0" id="courtesy_radio2" >
                                </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="courtesy_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Equipment Use </strong><br>

                        <p class="form-check form-check-inline">Prompt System Navigation </p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="equipment_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="equipment_use" value="1" id="equipment_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="equipment_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="equipment_use"  value="0" id="equipment_radio2" >
                        </div>

                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="equipment_use_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                                <strong CLASS="form-check-inline"> Soft Skills </strong><br>

                                <p class="form-check form-check-inline">Voice reflected energy and enthusiasm</p>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_radio1" > Yes </label>
                                    <input class="form-check-input" type="radio" name="soft_skills" value="1" id="soft_skills_radio1"  checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_radio2" > No </label>
                                    <input class="form-check-input" type="radio" name="soft_skills" value="0"  id="soft_skills_radio2" >
                                </div>

                                    <p class="form-check form-check-inline">Avoided long silence (more than 20 seconds)</p>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_radio1" > Yes </label>
                                    <input class="form-check-input" type="radio" name="soft_skills" value="1" id="soft_skills_radio1"  checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_radio2" > No </label>
                                    <input class="form-check-input" type="radio" name="soft_skills" value="0"  id="soft_skills_radio2" >
                                </div>
                                <p class="form-check form-check-inline">Used polite/appropriate tone</p>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_radio1" > Yes </label>
                                    <input class="form-check-input" type="radio" name="soft_skills" value="1" id="soft_skills_radio1"  checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_radio2" > No </label>
                                    <input class="form-check-input" type="radio" name="soft_skills" value="0"  id="soft_skills_radio2" >
                                </div>

                                <p class="form-check form-check-inline">Used proper grammar and business language</p>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_radio1" > Yes </label>
                                    <input class="form-check-input" type="radio" name="soft_skills" value="1" id="soft_skills_radio1"  checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_radio2" > No </label>
                                    <input class="form-check-input" type="radio" name="soft_skills" value="0"  id="soft_skills_radio2" >
                                </div>
                                
                                <p class="form-check form-check-inline"> Refrained from using company terms and jargon</p>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_radio1" > Yes </label>
                                    <input class="form-check-input" type="radio" name="soft_skills" value="1" id="soft_skills_radio1"  checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_radio2" > No </label>
                                    <input class="form-check-input" type="radio" name="soft_skills" value="0"  id="soft_skills_radio2" >
                                </div>
                                
                                <p class="form-check form-check-inline"> Used positive words (I know, I'm certain,etc)</p>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_radio1" > Yes </label>
                                    <input class="form-check-input" type="radio" name="soft_skills" value="1" id="soft_skills_radio1"  checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_radio2" > No </label>
                                    <input class="form-check-input" type="radio" name="soft_skills" value="0"  id="soft_skills_radio2" >
                                </div>
                    </div>
                     <div class="col-6">
                        <textarea class="form-control" name="soft_skills_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Using Hold  </strong><br>
                        <p class="form-check form-check-inline">Informed the Customer before placing them on hold</p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="using_hold_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="using_hold" value="1" id="using_hold_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="using_hold_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="using_hold" value="0"  id="using_hold_radio2" >
                        </div>

                        <p class="form-check form-check-inline">Kept in touch during long hold</p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="using_hold_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="using_hold" value="1" id="using_hold_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="using_hold_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="using_hold" value="0"  id="using_hold_radio2" >
                        </div>

                        <p class="form-check form-check-inline"> Thanked the customer for holding</p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="using_hold_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="using_hold" value="1" id="using_hold_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="using_hold_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="using_hold" value="0"  id="using_hold_radio2" >
                        </div>

                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="using_hold_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Connecting Calls  </strong><br>

                        <p class="form-check form-check-inline">  Connected to the correct department/Queue,</p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="using_hold_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="using_hold" value="1" id="using_hold_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="using_hold_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="using_hold" value="0"  id="using_hold_radio2" >
                        </div>

                        <p class="form-check form-check-inline">Informed customer where & why they were connected</p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="connecting_calls_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="connecting_calls" value="1" id="connecting_calls_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="connecting_calls_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="connecting_calls" value="0"  id="connecting_calls_radio2" >
                        </div>
                        
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="connecting_calls_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Closing </strong><br>

                        <p class="form-check form-check-inline">Quick Recap of the Order</p>   
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="closing_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="closing" value="1" id="closing_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="closing_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="closing" value="0" id="closing_radio2" >
                        </div>

                        <p class="form-check form-check-inline">Used proper closing - and asked further assistance</p>   
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="closing_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="closing" value="1" id="closing_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="closing_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="closing" value="0" id="closing_radio2" >
                        </div>

                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="closing_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Automatic Fail </strong><br>
                        
                        <p class="form-check form-check-inline">Misquoting the price</p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="automatic_fail_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="automatic_fail" value="1" id="automatic_fail_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="automatic_fail_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="automatic_fail" value="0"  id="automatic_fail_radio2" >
                        </div>

                        <p class="form-check form-check-inline">Disconnected call without sufficient reason</p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="automatic_fail_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="automatic_fail" value="1" id="automatic_fail_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="automatic_fail_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="automatic_fail" value="0"  id="automatic_fail_radio2" >
                        </div>

                        <p class="form-check form-check-inline">Failure to answer call</p>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="automatic_fail_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="automatic_fail" value="1" id="automatic_fail_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="automatic_fail_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="automatic_fail" value="0"  id="automatic_fail_radio2" >
                        </div>

                        <div class="row">
                            <div class="col-7">
                                <p class="form-check form-check-inline"> Repeating confidential details back to the customer like Credit Card and SSN</p>
                            </div>
                            <div class="col-5">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_radio1" > Yes </label>
                                    <input class="form-check-input" type="radio" name="automatic_fail" value="1" id="automatic_fail_radio1"  checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_radio2" > No </label>
                                    <input class="form-check-input" type="radio" name="automatic_fail" value="0"  id="automatic_fail_radio2" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-7">
                                <p class="form-check form-check-inline">Changing Customer details while reprocessing the order (name, number, email etc)</p>
                            </div>
                            <div class="col-5">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_radio1" > Yes </label>
                                    <input class="form-check-input" type="radio" name="automatic_fail" value="1" id="automatic_fail_radio1"  checked>
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_radio2" > No </label>
                                    <input class="form-check-input" type="radio" name="automatic_fail" value="0"  id="automatic_fail_radio2" >
                                </div>
                            </div>
                        </div>

                                    <p class="form-check form-check-inline">Fabricating information</p>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="automatic_fail_radio1" > Yes </label>
                                        <input class="form-check-input" type="radio" name="automatic_fail" value="1" id="automatic_fail_radio1"  checked>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="automatic_fail_radio2" > No </label>
                                        <input class="form-check-input" type="radio" name="automatic_fail" value="0"  id="automatic_fail_radio2" >
                                    </div><br>

                                    <p class="form-check form-check-inline">other</p>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="automatic_fail_radio1" > Yes </label>
                                        <input class="form-check-input" type="radio" name="automatic_fail" value="1" id="automatic_fail_radio1"  checked>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label" for="automatic_fail_radio2" > No </label>
                                        <input class="form-check-input" type="radio" name="automatic_fail" value="0"  id="automatic_fail_radio2" >
                                    </div>
                        
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="automatic_fail_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Monitor By </strong>
                    </div>
                        <div class="col-6">
                        <textarea class="form-control" id="textarea" name="monitor_by" rows="2" placeholder="Additional Comments"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button class="btn btn-primary" type="submit">Save</button>
                        <button class="btn btn-primary" type="reset">Reset</button>
                    </div>
                </div>

            </div>
        </div>
    </form>






@endsection
@section('footer_scripts')
    {{-- <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script>
        $( document ).ready(function() {
            if (jQuery().select2) {
                $(".select2").select2();
            }
            //form submission;
            $('#product_form').submit(function (e) {
                e.preventDefault();
                let data = new FormData(this);
                let a = function(){ /*window.location.href = '{{ route('') }}';*/ };
                let arr = [a];
                call_ajax_with_functions('','{{ isset($product) ? route('qa.update', $product->product_id) : route('qa.store') }}',data,arr);
            });
            // Cancel action
            $('#cancel_action').click(function (){
                window.location.href="{{route('qa.index')}}";
            });
        });
    </script> --}}
@endsection

