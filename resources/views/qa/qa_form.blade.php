@extends('layout.template')
@section('header_scripts')
{{--    <link rel="stylesheet" href="{{ asset('assets/bundles/select2/dist/css/select2.min.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">--}}
@endsection
@section('content')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">Quality Assurance Form</h3>
                </div>
            </div>
        </div>
        <div class="m-portlet__body">
            <form class="m-form m-form--fit m-form--label-align-right" method="post" id="qa_form" action="" enctype="multipart/form-data">
                @csrf
                <div class="row mb-2">
                    <div class="col-6 mb-1">
                        <label for="call_type"><strong> Call Type </strong></label>
                        <select class="form-control" name="call_type" id="call_type">
                            <option value="" class="fomr-control" {{isset($qa_data)?'disabled':''}} >Please Select</option>
                            @if(isset($qa_data))
                                <option selected value="{{$qa_data->call_disposition_types->disposition_type_id}}"> {{ $qa_data->call_disposition_types->title }} </option>
                            @else
                                @foreach ($call_types as $call_type)

                                    <option value="{{ $call_type->call_type_id }}" > {{ $call_type->title }} </option>
                                @endforeach
                            @endif

                        </select>
                    </div>

                    @if(!isset($qa_data))

                        <div class="col-6 mb-2">
                            <label for="call_date"><strong> Call Date  </strong> </label>
                            <input class="form-control" type="date" name="call_date" id="call_date" >
                        </div>
                     @endif


                    @if(isset($qa_data))
                        <input id="h_call_id" type="hidden" name="call_id" value="{{$qa_data->call_id}}">
                        <div class="col-6 mb-1" id="filtered_numbers">
                            <div>
                                <label for="num_type"><strong> Order No / Order Confirmation Number / Account Number </strong></label>
                                <input disabled class="form-control" type="text" value="{{$qa_data->order_number}}  /  {{$qa_data->order_confirmation_number}}  /  {{$qa_data->account_number}} ">
                            </div>

                        </div>

                    @else
                        <div class="col-6 mb-1" id="filtered_numbers">
                            <div>
                                <label for="num_type"><strong> Select </strong></label>
                                <select class="form-control select2" name="call_id" id="num_type">
                                </select>
                            </div>

                        </div>
                     @endif

                    <div class="col-6 mb-2">
                            <label  for="agent_id"><strong> Rep Name  </strong> </label>
                            <select class="form-control" name="rep_name" id="rep_name" required readonly>
                                <option class="form-control" value="" selected {{isset($qa_data)?'disabled':''}}>Plese Select</option>
                                @if(isset($qa_data))
                                    <option selected value="{{$qa_data->user->user_id}}"> {{ $qa_data->user->full_name }} </option>
                                @else
                                    @foreach($agents as $agent)
                                        <option value="{{$agent->user_id}}">{{$agent->full_name}}</option>
                                    @endforeach
                                 @endif

                            </select>

                    </div>
                    <div class="col-6 mb-1" id="call_num_div">
                        <label for="call_num"><strong> Call Number  </strong> </label>
                        @if(isset($qa_data))
                            <input readonly class="form-control" type="text" name="call_number" value="{{$qa_data->phone_number}}" readonly>
                        @else
                            <input class="form-control" type="text" name="call_number" id="call_number" readonly>

                        @endif
                    </div>
                    <div class="col-6 mb-1">
                        <label for="recording"><strong> Recording File  </strong> </label>
                        <input class="form-control" type="file" name="recording[]" id="recording" multiple accept="audio/*">
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline">Greetings</strong><br>

                        <div class="row">
                            <div class="col-6">
                                <p class=" form-check form-check-inline">Used Correct Greetings</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="greetings_radio1"> Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" id="greetings_radio1" name="greetings_correct" value="1" >
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="greetings_radio2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" id="greetings_radio2" name="greetings_correct" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="greetings_radio3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" id="greetings_radio3" name="greetings_correct" value="2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline"> Used Assurity Statement</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="greetings_assurity_statement1"> Yes </label>
                                    <input class="form-check-input yes_radio" id="greetings_assurity_statement1" type="radio" name="greetings_assurity_statement" value="1" >
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="greetings_assurity_statement2"> No </label>
                                    <input class="form-check-input no_radio" id="greetings_assurity_statement2" type="radio" name="greetings_assurity_statement" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="greetings_assurity_statement3"> N/A </label>
                                    <input class="form-check-input na_radio" type="radio" id="greetings_assurity_statement3" name="greetings_assurity_statement" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="greetings_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline">Customer Name</strong><br>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Used the customer's name at least once during the call</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="customer_name_call1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="customer_name_call" id="customer_name_call1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="customer_name_call2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="customer_name_call"  id="customer_name_call2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="customer_name_call3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="customer_name_call" id="customer_name_call3" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="customer_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline">Listening</strong><br>
                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Used listening skills (doesn't interrupt, remembers info, etc)</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="listening_skills1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="listening_skills" id="listening_skills1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="listening_skills2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="listening_skills" id="listening_skills2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="listening_skills3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="listening_skills" id="listening_skills3" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="listening_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Courtesy </strong><br>
                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline" >Used "please" when appropriate </p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_please1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="courtesy_please" id="courtesy_please1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_please2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="courtesy_please" id="courtesy_please2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_please3" > NA </label>
                                    <input class="form-check-input na_radio" type="radio" name="courtesy_please" id="courtesy_please3" value="2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline"> Used "thank you" when appropriate</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_thank_you1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="courtesy_thank_you" id="courtesy_thank_you1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_thank_you2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="courtesy_thank_you" id="courtesy_thank_you2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_thank_you3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="courtesy_thank_you" id="courtesy_thank_you3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline" >Showed interest and willingness to assist the customer</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_interest1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="courtesy_interest" id="courtesy_interest1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_interest2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="courtesy_interest" id="courtesy_interest2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_interest3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="courtesy_interest" id="courtesy_interest3" value="2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Showed empathy when appropriate</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_empathy1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="courtesy_empathy" id="courtesy_empathy1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_empathy2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="courtesy_empathy" id="courtesy_empathy2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_empathy3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="courtesy_empathy" id="courtesy_empathy3" value="2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline"> Apologized when appropriate </p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_Apologized1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="courtesy_Apologized" id="courtesy_Apologized1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_Apologized2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="courtesy_Apologized" id="courtesy_Apologized2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="courtesy_Apologized3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="courtesy_Apologized" id="courtesy_Apologized3" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="courtesy_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Equipment Use </strong><br>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Prompt System Navigation </p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="equipment_system1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="equipment_system" id="equipment_system1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="equipment_system2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="equipment_system" id="equipment_system2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="equipment_system3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="equipment_system" id="equipment_system3"  value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="equipment_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Soft Skills </strong><br>
                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Voice reflected energy and enthusiasm</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_energy1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="soft_skills_energy" id="soft_skills_energy1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_energy2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="soft_skills_energy" id="soft_skills_energy2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skills_energy3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="soft_skills_energy" id="soft_skills_energy3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Avoided long silence (more than 20 seconds)</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_avoided_silence1"> Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="soft_skill_avoided_silence" id="soft_skill_avoided_silence1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_avoided_silence2"> No </label>
                                    <input class="form-check-input no_radio" type="radio" name="soft_skill_avoided_silence"  id="soft_skill_avoided_silence2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_avoided_silence3"> N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="soft_skill_avoided_silence" id="soft_skill_avoided_silence3" value="2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Used polite/appropriate tone</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_polite1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="soft_skill_polite" id="soft_skill_polite1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_polite2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="soft_skill_polite" id="soft_skill_polite2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_polite3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="soft_skill_polite" id="soft_skill_polite3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Used proper grammar and business language</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_grammar1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="soft_skill_grammar" id="soft_skill_grammar1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_grammar2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="soft_skill_grammar" id="soft_skill_grammar2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_grammar3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="soft_skill_grammar" id="soft_skill_grammar3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline"> Refrained from using company terms and jargon</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_refrained_company1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="soft_skill_refrained_company" id="soft_skill_refrained_company1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_refrained_company2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="soft_skill_refrained_company" id="soft_skill_refrained_company2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_refrained_company3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="soft_skill_refrained_company" id="soft_skill_refrained_company3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline"> Used positive words (I know, I'm certain,etc)</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_positive_words1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="soft_skill_positive_words" id="soft_skill_positive_words1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_positive_words2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="soft_skill_positive_words" id="soft_skill_positive_words2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="soft_skill_positive_words3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="soft_skill_positive_words" id="soft_skill_positive_words3" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="soft_skills_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong class="form-check-inline"> Using Hold </strong><br>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Informed the Customer before placing them on hold</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="using_hold_informed_customer1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="using_hold_informed_customer" id="using_hold_informed_customer1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="using_hold_informed_customer2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="using_hold_informed_customer" id="using_hold_informed_customer2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="using_hold_informed_customer3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="using_hold_informed_customer" id="using_hold_informed_customer3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Kept in touch during long hold</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="using_hold_touch1"> Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="using_hold_touch" id="using_hold_touch1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="using_hold_touch2"> No </label>
                                    <input class="form-check-input no_radio" type="radio" name="using_hold_touch" id="using_hold_touch2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="using_hold_touch3"> N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="using_hold_touch" id="using_hold_touch3" value="2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline"> Thanked the customer for holding</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="using_hold_thanked1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="using_hold_thanked" id="using_hold_thanked1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="using_hold_thanked2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="using_hold_thanked" id="using_hold_thanked2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="using_hold_thanked3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="using_hold_thanked" id="using_hold_thanked3" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="Closing" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Connecting Calls  </strong><br>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">  Connected to the correct department/Queue</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="connecting_calls_department1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="connecting_calls_department" id="connecting_calls_department1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="connecting_calls_department2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="connecting_calls_department" id="connecting_calls_department2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="connecting_calls_department3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="connecting_calls_department" id="connecting_calls_department3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Informed customer where & why they were connected</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="connecting_calls_customer1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="connecting_calls_customer" id="connecting_calls_customer1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="connecting_calls_customer2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="connecting_calls_customer" id="connecting_calls_customer2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="connecting_calls_customer3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="connecting_calls_customer" id="connecting_calls_customer3" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="connecting_calls_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Closing </strong><br>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Quick Recap of the Order</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="closing_recap1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="closing_recap" id="closing_recap1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="closing_recap2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="closing_recap" id="closing_recap2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="closing_recap3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="closing_recap" id="closing_recap3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Used proper closing - and asked further assistance</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="clossing_assistance1" > Yes </label>
                                    <input class="form-check-input yes_radio" type="radio" name="clossing_assistance" id="clossing_assistance1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="clossing_assistance2" > No </label>
                                    <input class="form-check-input no_radio" type="radio" name="clossing_assistance" id="clossing_assistance2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="clossing_assistance3" > N/A </label>
                                    <input class="form-check-input na_radio" type="radio" name="clossing_assistance" id="clossing_assistance3" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="closing_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Automatic Fail </strong><br>
                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Misquoting the price</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_misquoting1" > Yes </label>
                                    <input class="form-check-input auto_yes_radio" type="radio" name="automatic_fail_misquoting" id="automatic_fail_misquoting1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_misquoting2" > No </label>
                                    <input class="form-check-input auto_no_radio" type="radio" name="automatic_fail_misquoting" id="automatic_fail_misquoting2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_misquoting3" > N/A </label>
                                    <input class="form-check-input auto_na_radio" type="radio" name="automatic_fail_misquoting" id="automatic_fail_misquoting3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Disconnected call without sufficient reason</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_disconnected1" > Yes </label>
                                    <input class="form-check-input auto_yes_radio" type="radio" name="automatic_fail_disconnected" id="automatic_fail_disconnected1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_disconnected2" > No </label>
                                    <input class="form-check-input auto_no_radio" type="radio" name="automatic_fail_disconnected" id="automatic_fail_disconnected2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_disconnected3" > N/A </label>
                                    <input class="form-check-input auto_na_radio" type="radio" name="automatic_fail_disconnected" id="automatic_fail_disconnected3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Failure to answer call</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_answer1" > Yes </label>
                                    <input class="form-check-input auto_yes_radio" type="radio" name="automatic_fail_answer" id="automatic_fail_answer1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_answer2"> No </label>
                                    <input class="form-check-input auto_no_radio" type="radio" name="automatic_fail_answer" id="automatic_fail_answer2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_answer3" > N/A </label>
                                    <input class="form-check-input auto_na_radio" type="radio" name="automatic_fail_answer"  id="automatic_fail_answer3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline"> Repeating confidential details back to the customer like Credit Card and SSN</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_repeating_details1" > Yes </label>
                                    <input class="form-check-input auto_yes_radio" type="radio" name="automatic_fail_repeating_details" id="automatic_fail_repeating_details1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_repeating_details2" > No </label>
                                    <input class="form-check-input auto_no_radio" type="radio" name="automatic_fail_repeating_details" id="automatic_fail_repeating_details2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_repeating_details3" > N/A </label>
                                    <input class="form-check-input auto_na_radio" type="radio" name="automatic_fail_repeating_details" id="automatic_fail_repeating_details3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Changing Customer details while reprocessing the order (name, number, email etc)</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_changing_details1" > Yes </label>
                                    <input class="form-check-input auto_yes_radio" type="radio" name="automatic_fail_changing_details" id="automatic_fail_changing_details1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_changing_details2" > No </label>
                                    <input class="form-check-input auto_no_radio" type="radio" name="automatic_fail_changing_details" id="automatic_fail_changing_details2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_changing_details3" > N/A </label>
                                    <input class="form-check-input auto_na_radio" type="radio" name="automatic_fail_changing_details" id="automatic_fail_changing_details3" value="2">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">Fabricating information</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_fabricating1" > Yes </label>
                                    <input class="form-check-input auto_yes_radio" type="radio" name="automatic_fail_fabricating" id="automatic_fail_fabricating1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_fabricating2" > No </label>
                                    <input class="form-check-input auto_no_radio" type="radio" name="automatic_fail_fabricating" id="automatic_fail_fabricating2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_fabricating3" > N/A </label>
                                    <input class="form-check-input auto_na_radio" type="radio" name="automatic_fail_fabricating" id="automatic_fail_fabricating3" value="2">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p class="form-check form-check-inline">other</p>
                            </div>
                            <div class="col-6">
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other1" > Yes </label>
                                    <input class="form-check-input auto_yes_radio" type="radio" name="automatic_fail_other" id="automatic_fail_other1" value="1">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other2" > No </label>
                                    <input class="form-check-input auto_no_radio" type="radio" name="automatic_fail_other" id="automatic_fail_other2" value="0">
                                </div>
                                <div class="form-check form-check-inline">
                                    <label class="form-check-label" for="automatic_fail_other3" > N/A </label>
                                    <input class="form-check-input auto_na_radio" type="radio" name="automatic_fail_other" id="automatic_fail_other3" value="2">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="automatic_fail_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>
                <hr>
                <div class="row mb-2">
                    <div class="col-3">
                        <label  for="yes_responses"> Yes Responses </label>
                        <input class="form-control" id="yes_responses" type="text" name="yes_responses" readonly>
                    </div>
                    <div class="col-3">
                        <label for="no_responses"> No Responses </label>
                        <input class="form-control" id="no_responses" type="text" name="no_responses" readonly>
                    </div>
                    <div class="col-3">
                        <label for="auto_fails"> Automatic Fail </label>
                        <input class="form-control" id="auto_fails" type="text" name="automatic_fail_response" readonly>
                    </div>
                    <div class="col-3">
                        <label for="monitor_percent"> Monitor Percentage: <span id="grade_color"><strong class="text-white font-18 p-4" id="grade"></strong></span></label>
                        <input class="form-control" id="monitor_percent" type="text" name="monitor_percentage" readonly>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-12">
                        <textarea class="form-control" id="textarea" name="additional_comment" rows="2" placeholder="Additional Comments"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Monitor By {{Auth::user()->full_name}}</strong>
                    </div>
                    <div class="col-6">
                        <button class="btn btn-danger float-right ml-3" type="reset">Reset</button>
                        <button class="btn btn-primary float-right" type="submit">Save</button>
                    </div>
                    {{--                </div>--}}
                    {{--            </div>--}}
                </div>
            </form>
        </div>
    </div>
        @endsection
        @section('footer_scripts')
            <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
            <script>
                function get_calls() {
                    $('#call_number').val("");
                    $('#rep_name').val("");
                    if($('#call_type').val() == 1){
                        $('#filtered_numbers').fadeIn();
                        let date = $('#call_date').val();
                        let data = new FormData();
                        data.append('_token', "{{csrf_token()}}");
                        data.append('type', 1);
                        data.append('date', date);
                        call_ajax('num_type', '{{ route('filter_nums') }}', data);

                    }
                    else if($('#call_type').val() == 2){
                        let date = $('#call_date').val();
                        let data = new FormData();
                        data.append('_token', "{{csrf_token()}}");
                        data.append('date', date);
                        data.append('type', 2);
                        call_ajax('num_type', '{{ route('filter_nums') }}', data);
                    }
                    else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please select Call Type!',
                        })
                    }
                }
                $( document ).ready(function() {
                    $('#call_date').change(function (){
                        get_calls();
                    });
                    $('#call_type').change(function () {
                        if($('#call_type').val() == 1){
                            $('#call_num_div').fadeIn();
                        } else if($('#call_type').val() == 2){
                            $('#call_num_div').fadeOut();
                        }

                        if($('#call_date').val() != ''){
                            get_calls();
                        } else {
                            $('#call_date').focus();
                        }
                    });

                    $('#num_type').change(function(){
                        let rep_id = this.options[this.selectedIndex].getAttribute('data-id');
                        let call_num = this.options[this.selectedIndex].getAttribute('data-id22');
                        $('#rep_name').val(rep_id);
                        $('#call_number').val(call_num);
                       // alert(rep_id);
                    });

                    if (jQuery().select2) {
                        $(".select2").select2();
                    }
                    //form submission;
                    $('#qa_form').submit(function (e) {
                        e.preventDefault();
                        let data = new FormData(this);
                        let h_call_id = $('#h_call_id');
                        if($('#h_call_id').length == 0){
                            var a = function(){ window.location.reload(); };
                        }
                        else{
                            var a = function(){ window.location.href="{{route('qa_queue')}}"; };
                        }
                        let arr = [a];
                        call_ajax_with_functions('','{{route('qa_save')}}',data,arr);
                    });
                    $('.yes_radio').click(function (){
                        calculate_score();
                    });
                    $('.no_radio').click(function (){
                        calculate_score();
                    });
                    $('.na_radio').click(function (){
                        calculate_score();
                    });
                    $('.auto_yes_radio').click(function (){
                        calculate_score();
                    });
                    $('.auto_no_radio').click(function (){
                        calculate_score();
                    });
                    $('.auto_na_radio').click(function (){
                        calculate_score();
                    });
                    function calculate_score() {
                        let yes_boxes = document.getElementsByClassName('yes_radio');
                        let no_boxes = document.getElementsByClassName('no_radio');
                        let na_boxes = document.getElementsByClassName('na_radio');
                        let yes_count = 0;
                        let no_count = 0;
                        // Main Counts
                        for(let i=0; i < yes_boxes.length; i++){
                            if(yes_boxes[i].checked){
                                yes_count++;
                            }
                        }
                        for(let i=0; i < no_boxes.length; i++){
                            if(no_boxes[i].checked){
                                no_count++;
                            }
                        }
                        for(let i=0; i < na_boxes.length; i++){
                            if(na_boxes[i].checked){
                                yes_count++;
                            }
                        }
                        // Auto Fail Counts
                        let auto_yes_boxes =  document.getElementsByClassName('auto_yes_radio');
                        let auto_no_boxes  =  document.getElementsByClassName('auto_no_radio');
                        let auto_na_boxes  =  document.getElementsByClassName('auto_na_radio');
                        let auto_yes_count =  0;
                        let auto_no_count  =  0;
                        for(let i=0; i < auto_yes_boxes.length; i++){
                            if(auto_yes_boxes[i].checked){
                                auto_yes_count++;
                            }
                        }
                        for(let i=0; i < auto_no_boxes.length; i++){
                            if(auto_no_boxes[i].checked){
                                auto_no_count++;
                            }
                        }
                        for(let i=0; i < auto_na_boxes.length; i++){
                            if(auto_na_boxes[i].checked){
                                auto_no_count++;
                            }
                        }
                        // calculating percentage
                        let percentage = (yes_count/yes_boxes.length) * 100;
                        // applying values
                        document.getElementById('yes_responses').value = yes_count;
                        document.getElementById('no_responses').value = no_count;
                        document.getElementById('auto_fails').value = auto_yes_count;
                        if(auto_yes_count > 0){
                            percentage = 0;
                        }
                        document.getElementById('monitor_percent').value = percentage.toFixed(2);
                        if(percentage >= 90) {
                            document.getElementById('grade').innerText = "Outstanding";
                            document.getElementById('grade_color').style.backgroundColor = "#2e7d32";
                        } else if(percentage >= 80 && percentage < 90) {
                            document.getElementById('grade').innerText = "Excellent";
                            document.getElementById('grade_color').style.backgroundColor = "#50f450";
                        } else if(percentage >= 75 && percentage < 80) {
                            document.getElementById('grade').innerText = "Good";
                            document.getElementById('grade_color').style.backgroundColor = "#cfff95";
                        } else if(percentage >= 70 && percentage < 75) {
                            document.getElementById('grade').innerText = "Average";
                            document.getElementById('grade_color').style.backgroundColor = "#ffb04c";
                        } else if(percentage >= 60 && percentage < 70) {
                            document.getElementById('grade').innerText = "Needs Improvement";
                            document.getElementById('grade_color').style.backgroundColor = "#ffff6b";
                        } else {
                            document.getElementById('grade').innerText = "Poor";
                            document.getElementById('grade_color').style.backgroundColor = "#d32f2f";
                        }
                    }
                });
            </script>
@endsection

