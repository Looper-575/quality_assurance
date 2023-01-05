@extends('layout.template')
@section('header_scripts')
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
    <style>
        .avartar-picker {
            text-align: center;
        }
        .avartar-picker .inputfile {
            display: none;
        }
        .avartar-picker label {
            display: block;
            cursor: pointer;
            display: inline-block;
            color: #333;
            font-size: 12px;
            text-transform: uppercase;
            font-weight: 800;
        }
        .avartar-picker label i {
             margin-right: 3px;
         }
        .form-group, .m-form__group{
            padding: 5px !important;
        }
    </style>
@endsection
@section('content')
    <!--Begin::Main Portlet-->
    <div class="m-portlet m-portlet--mobile">
        <!--begin: Portlet Head-->
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        Employee Registration
                        <small>
                            Form
                        </small>
                        @if(isset($message))
                            {{$message}}
                        @endif
                    </h3>
                </div>
            </div>
        </div>
        <!--end: Portlet Head-->
        <!--begin: Form Wizard-->
        <div class="m-wizard m-wizard--2 m-wizard--success" id="m_wizard">
            <!--begin: Message container -->
            <div class="m-portlet__padding-x">
                <!-- Here you can put a message or alert -->
            </div>
            <!--end: Message container -->
            <!--begin: Form Wizard Head -->
            <div class="m-wizard__head m-portlet__padding-x">
                <!--begin: Form Wizard Progress -->
                <div class="m-wizard__progress">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar"  aria-valuemin="0" aria-valuemax="100" ></div>
                    </div>
                </div>
                <!--end: Form Wizard Progress -->
                <!--begin: Form Wizard Nav -->
                <div class="m-wizard__nav">
                    <div class="m-wizard__steps">
                        <div id="step_1" class="m-wizard__step m-wizard__step--current">
                            <a href="#"  class="m-wizard__step-number">
                            <span><i class="fa fa-info-circle"></i> </span>
                            </a>
                            <div class="m-wizard__step-info">
                                <h6 >Employee Information</h6>
{{--                                <div class="m-wizard__step-desc">--}}
{{--                                    All feilds are mandatory. And the information--}}
{{--                                    of this form is strictly confidential.--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div id="step_2" class="m-wizard__step">
                            <a href="#" class="m-wizard__step-number">
                                <span>
                                    <i class="fa fa-mortar-board"></i>
                                </span>
                            </a>
                            <div class="m-wizard__step-info">
                                <h6>Educational Details</h6>
                            </div>
                        </div>
                        <div id="step_3" class="m-wizard__step">
                            <a href="javascript:;" class="m-wizard__step-number">
                              <span> <i class="fa fa-history"></i></span>
                            </a>
                            <div class="m-wizard__step-info">
                                <h6>Experience Details </h6>
                            </div>
                        </div>
                        <div id="step_4" class="m-wizard__step">
                            <a href="#" class="m-wizard__step-number">
                             <span><i class="fa fa-group"></i></span>
                            </a>
                            <div class="m-wizard__step-info">
                                <h6>Family Details</h6>
                            </div>
                        </div>
                        <div id="step_5" class="m-wizard__step" >
                            <a href="#" class="m-wizard__step-number">
                             <span><i class="fa flaticon-information"></i></span>
                            </a>
                            <div class="m-wizard__step-info">
                                <h6>Emergency Contact Details</h6>
                            </div>
                        </div>
                        <div id="step_6" class="m-wizard__step" >
                            <a href="#" class="m-wizard__step-number">
                              <span><i class="fa flaticon-user-ok"></i> </span>
                            </a>
                            <div class="m-wizard__step-info">
                                <h6>Reference Details</h6>
                            </div>
                        </div>
                        <div id="step_7" class="m-wizard__step" >
                            <a href="#" class="m-wizard__step-number">
                             <span><i class="fa fa-file-text"></i></span>
                            </a>
                            <div class="m-wizard__step-info">
                                <h6>Upload Documents</h6>
{{--                                <div class="m-wizard__step-desc">--}}
{{--                                    please upload your educational and experience certificates.--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <!--end: Form Wizard Nav -->
            </div>
            <!--end: Form Wizard Head -->
        <!--begin: Form Wizard Form-->
            <div class="m-wizard__form">
                <div class="m-portlet__body">
                    <div id="employee_id_response">
                        <input data-response="Success" type="hidden" id="employee_id" value="{{$employee->employee_id ?? 0 }}">
                    </div>
                    <!--begin: Form Wizard Step 1-->
                    <div id="m_wizard_form_step_1" class="m-wizard__form-step m-wizard__form-step--current" >
                        @include('employees.partials.personal_info_form');
                    </div>
                    <!--end: Form Wizard Step 1-->
                    <!--begin: Form Wizard Step 2-->
                    <div id="m_wizard_form_step_2" class="m-wizard__form-step" >
                        @include('employees.partials.education_info_form');
                    </div>
                    <!--end: Form Wizard Step 2-->
                    <!--begin: Form Wizard Step 3-->
                    <div id="m_wizard_form_step_3" class="m-wizard__form-step">
                        @include('employees.partials.experience_info_form');
                    </div>
                    <!--end: Form Wizard Step 3-->
                    <!--begin: Form Wizard Step 4-->
                    <div id="m_wizard_form_step_4" class="m-wizard__form-step">
                        @include('employees.partials.family_info_form');
                    </div>
                    <!--end: Form Wizard Step 4-->
                    <!--begin: Form Wizard Step 5-->
                    <div id="m_wizard_form_step_5" class="m-wizard__form-step">
                        @include('employees.partials.emergency_contact_info_form');
                    </div>
                    <!--end: Form Wizard Step 5-->
                    <!--begin: Form Wizard Step 6-->
                    <div id="m_wizard_form_step_6" class="m-wizard__form-step">
                        @include('employees.partials.reference_info_form');
                    </div>
                    <!--end: Form Wizard Step 6-->
                    <!--begin: Form Wizard Step 7-->
                    <div id="m_wizard_form_step_7" class="m-wizard__form-step">
                        @include('employees.partials.upload_docs_form');
                    </div>
                    <!--end: Form Wizard Step 7-->
                </div>
                <!--end: Form Body -->
            </div>
            {{--                    <!--end: Form Wizard Form--> --}}
            {{--                </form>--}}
        </div>
        <!--end: Form Wizard-->
    </div>
    <!--End::Main Portlet-->
    @include('employees.partials.employee_js')
@endsection
@section('footer_scripts')
    <script src="{{asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
    <script src="{{asset('assets/js/datatables.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/js/datatables_init.js')}}" type="text/javascript"></script>

    <script>
        function change_progress_bar_width(i,r){
            if(r == 'remove'){
                i = i - 2;
            }
            i = i * (120/7);
            let wid = i +'%';
            $(".progress-bar").css('width',wid);
        }
        $(document).ready(function() {
            if($('#employee_id').val() != 0){
                $(document).on('click', '.m-wizard__step', function(){
                    let button_id = $(this).attr("id");
                    button_id = button_id.substring(5);
                    $('#m_wizard_form_step_'+button_id+'').addClass("m-wizard__form-step--current");
                    $('#step_'+button_id+'').addClass("m-wizard__step--current");
                    change_progress_bar_width(button_id,'add');
                    let previous = parseInt(button_id) - 1;
                    if(previous > 1){
                        while(previous >= 1){
                            $('#step_'+previous+'').addClass("m-wizard__step--done");
                            $('#step_'+previous+'').removeClass("m-wizard__step--current");
                            $('#m_wizard_form_step_'+previous+'').removeClass("m-wizard__form-step--current");
                            previous--;
                        }
                    }else{
                        $('#step_'+previous+'').addClass("m-wizard__step--done");
                        $('#step_'+previous+'').removeClass("m-wizard__step--current");
                        $('#m_wizard_form_step_'+previous+'').removeClass("m-wizard__form-step--current");
                    }
                    let next = parseInt(button_id) + 1;
                    change_progress_bar_width(next, 'remove');
                    while(next <= 7) {
                        $('#step_' + next + '').removeClass("m-wizard__step--done");
                        $('#step_' + next + '').removeClass("m-wizard__step--current");
                        $('#m_wizard_form_step_' + next + '').removeClass("m-wizard__form-step--current");
                        next++;
                    }
                });
            }
            if($('#employee_id').val() == 0){
                let user = $('#user_id').val();
                    if(user != ''){
                        get_user_data(user);
                    }
            }
            $(document).on('click', '.btn_skip', function(){
                let button_id = $(this).attr("id");
                change_progress_bar_width(button_id,'add');
                $('#m_wizard_form_step_'+button_id+'').removeClass("m-wizard__form-step--current");
                $('#step_'+button_id+'').removeClass("m-wizard__step--current");
                $('#step_'+button_id+'').addClass("m-wizard__step--done");
                let previous = parseInt(button_id) - 1;
                $('#step_'+previous+'').addClass("m-wizard__step--done");
                let next = parseInt(button_id) + 1;
                $('#step_'+next+'').removeClass("m-wizard__step--done");
                $('#step_'+next+'').addClass("m-wizard__step--current");
                $('#m_wizard_form_step_'+next+'').addClass("m-wizard__form-step--current");
            });
            $(document).on('click', '.btn_back', function(){
                let button_id = $(this).attr("id");
                change_progress_bar_width(button_id,'remove');
                $('#m_wizard_form_step_'+button_id+'').removeClass("m-wizard__form-step--current");
                $('#step_'+button_id+'').removeClass("m-wizard__step--current");
                let previous = parseInt(button_id) - 1;
                $('#step_'+previous+'').removeClass("m-wizard__step--done");
                $('#step_'+previous+'').addClass("m-wizard__step--current");
                $('#m_wizard_form_step_'+previous+'').addClass("m-wizard__form-step--current");
            });
        });
    </script>
    <style>
        .progress {
            -webkit-box-shadow: 0 0.04rem 0.5rem rgb(0 0 0 / 8%) !important;
            box-shadow: 0 0.04rem 0.5rem rgb(0 0 0 / 8%) !important;
        }
    </style>
@endsection
