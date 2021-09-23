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
                        <label  for="rep_name"><strong> Rep Name  </strong> </label>
                        <input class="form-control" type="text" name="rep_name" >
                    </div>
                    <div class="col-6">
                        <label  for="yes_responses"> Yes Responses </label>
                        <input class="form-control" type="text" name="yes_res" readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label for="call_date"><strong> Call Date  </strong> </label>
                        <input class="form-control" type="datetime" name="call_date" >
                    </div>
                    <div class="col-6">
                        <label for="no_responses"> No Responses </label>
                        <input class="form-control" type="text" name="no_res" readonly>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-6">
                        <label for="call_type"><strong> Call Type </strong></label>
                        <input class="form-control" type="text" name="call_type" >
                    </div>
                    <div class="col-6">
                        <label for="auto_fail"> Automatic Fail </label>
                        <input class="form-control" type="text" name="auto_fail" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="call_num"><strong> Call Number  </strong> </label>
                        <input class="form-control" type="number" name="call_num" >
                    </div>
                    <div class="col-6">
                        <label for="monitor_percent"> Monitor Percentage </label>
                        <input class="form-control" type="text" name="monitor_percent" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline">Greetings</strong>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="greetings_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="greetings_radio" id="greetings_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="greetings_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="greetings_radio" id="greetings_radio2" >
                        </div>
                        <p>Used Correct Greetings, Used Assurity Statement</p>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="greetings_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline">Customer Name</strong>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="customer_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="customer_radio" id="customer_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="customer_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="customer_radio" id="customer_radio2" >
                        </div>
                        <p>Used the customer's name at least once during the call</p>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="customer_name_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline">Listening</strong>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="listening_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="listening_radio" id="listening_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="listening_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="listening_radio" id="listening_radio2" >
                        </div>
                        <p>Used listening skills (doesn't interrupt, remembers info, etc)</p>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="listening_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Courtesy </strong>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="courtesy_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="courtesy_radio" id="courtesy_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="courtesy_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="courtesy_radio" id="courtesy_radio2" >
                        </div>
                        <p>  Used "please" when appropriate,  Used "thank you" when appropriate,
                             Showed interest and willingness to assist the customer,
                             Showed empathy when appropriate,  Apologized when appropriate </p><br>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="courtesy_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Equipment Use </strong>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="equipment_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="equipment_radio" id="equipment_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="equipment_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="equipment_radio"  id="equipment_radio2" >
                        </div>
                        <p>Prompt System Navigation </p><br>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="equipment_use_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Soft Skills </strong>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="soft_skills_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="soft_skills_radio" id="soft_skills_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="soft_skills_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="soft_skills_radio"  id="soft_skills_radio2" >
                        </div>
                        <p> Voice reflected energy and enthusiasm, Avoided long silence (more than 20 seconds),
                            Used polite/appropriate tone, Used proper grammar and business language,
                            Refrained from using company terms and jargon, Used positive words (I know, I'm certain,etc)
                        </p>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="soft_skills_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Using Hold  </strong>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="using_hold_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="using_hold_radio" id="using_hold_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="using_hold_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="using_hold_radio"  id="using_hold_radio2" >
                        </div>
                        <p> Informed the Customer before placing them on hold, Kept in touch during long hold,
                            Thanked the customer for holding
                        </p>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="using_hold_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Connecting Calls  </strong>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="connecting_calls_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="connecting_calls_radio" id="connecting_calls_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="connecting_calls_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="connecting_calls_radio"  id="connecting_calls_radio2" >
                        </div>
                        <p> Connected to the correct department/Queue, Informed customer where & why they were connected
                        </p>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="connecting_calls_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Closing </strong>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="closing_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="closing_radio" id="closing_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="closing_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="closing_radio"  id="closing_radio2" >
                        </div>

                        <p> Quick Recap of the Order, Used proper closing - and asked further assistance
                        </p>
                    </div>
                    <div class="col-6">
                        <textarea class="form-control" name="closing_comment" id="textarea" rows="2" placeholder="Comments"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <strong CLASS="form-check-inline"> Automatic Fail </strong>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="automatic_fail_radio1" > Yes </label>
                            <input class="form-check-input" type="radio" name="automatic_fail_radio" id="automatic_fail_radio1"  checked>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label" for="automatic_fail_radio2" > No </label>
                            <input class="form-check-input" type="radio" name="automatic_fail_radio"  id="automatic_fail_radio2" >
                        </div>
                        <p> Misquoting the price, Disconnected call without sufficient reason,
                            Failure to answer call, Repeating confidential details back to the customer like Credit Card and SSN,
                            Changing Customer details while reprocessing the order (name, number, email etc),
                            Fabricating information, Other 
                        </p>
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
                        <textarea class="form-control" id="textarea" rows="2" placeholder="Additional Comments"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <button type="submit">Save</button>
                        <button type="reset">Reset</button>
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

