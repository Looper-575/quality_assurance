@extends('layout.template')
@section('header_scripts')
    <link href="{{asset('assets/css/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        .modal-lg{
            max-width: 80% !important;
        }
        .modal-body{
            height: 500px;
            overflow: auto;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            border-radius: 40px;
        }
        th {
            text-align: left;
            padding: 15px 5px;
        }
        td {
            text-align: left;
            padding: 5px;
        }
        tr:nth-child(even) {background-color: #f2f2f2;}
        .training_and_hobbies_table  td {
            text-align: left;
            border-radius: 20px;
        }
        .bg-style{
            background-color: #f2f2f2;
            border-radius: 20px;
        }
        .profile_user_img_div{
            width: 100px;
            height: 100px;
            position: relative;
            margin: auto;
        }
        .profile_user_img{
            width: 100%;height: 100%;object-fit: cover;
        }
        .icon-upload{
            position: absolute;
            right: 0px;
            bottom: -3px;
            text-align: center;
            background-color: #581f1f;
        }
        .my-mb{
            margin-bottom: 25px;
        }
        .m-right{
            margin-right: 40px;
        }
        .spacer{
            display:block;
            height:30px;
            width:100%;
            margin: 0 auto;
            content:"";
        }
        .align_end{
            align-items: flex-end;
        }
        .box_shadow{
            padding-bottom: 30px;
            box-shadow: 0px 30px 26px -40px;
        }
        .btn_edit{
            font-size: 24px;
            color: red;
        }
        .training_and_hobbies_table{
            width:25%;
            margin-right:50px;
        }
        .personal_edit_btn_div{
            text-align:right;
            margin-bottom:-25px;z-index:2;
        }
        .height-170{
            height: 140px;
        }
        .p-12,span{
            font-weight: 600;
            font-size: 12px;
        }
        .c-gray{
            color: #848484
        }
    </style>
@endsection
@section('content')
    <input data-response="Success" type="hidden" id="employee_id" value="{{$employee->employee_id}}">
     <div class="card m-2">
        <div class="card-header">
            <h3><b>Employee Profile</b></h3>
        </div>
         {{-- personel info --}}
         <div class="row m-0 mb-5 box_shadow">
             <div class="col-12 personal_edit_btn_div">
                 @if($employee->locked == 0)
                     <button id="personal_info" onclick="edit_personal_info(this)" value="{{$employee->employee_id}}"  class="btn btn_edit"><i class="fa fa-edit"></i></button>
                 @endif
             </div>
             @if($employee && $employee->employee->image != '')
                 @php
                     $image_src = asset('user_images/'.$employee->employee->image);
                 @endphp
             @else
                 @php
                     $image_src = asset('user_images/user.png');
                 @endphp
             @endif
             <div class="col-12 col-sm-6 col-md-3 col-lg-3 py-3 text-center" >
                 <div class="rounded-circle profile_user_img_div mb-2" >
                     <img src="{{$image_src}}" alt="" class="rounded-circle profile_user_img">
{{--                     <span class="rounded-circle icon-upload">--}}
{{--                    <button class="btn p-2 pt-1 pb-1" style="color: white"><i class="fa fa-upload" ></i></button>--}}
                </span>
                 </div>
                 <div class="name_and_designation">
                     <span class="p-12 c-gray">{{$employee->full_name}}</span><br>
                     <span class="p-12"><b>{{$employee->designation}}</b></span>
                 </div>
             </div>
             <div class="col-12 col-sm-12 col-md-9 col-lg-9" style="padding-top: 34px;">
                 <div class="row m-0 mb-4" style="padding-right:50px;">
                     <div class="col-12 col-sm-6 col-md-4">
                         <div class="p-12 c-gray">Email</div>
                         <div class="p-12">{{$employee->email}}</div>
                     </div>
                     <div class="col-12 col-sm-6 col-md-4">
                         <div class="p-12 c-gray">Phone No#</div>
                         <div class="p-12">{{$employee->contact_number}}</div>
                     </div>
                     <div class="col-12 col-sm-12 col-md-4">
                         <div class="p-12 c-gray">Present Address </div>
                         <div class="p-12 ">{{$employee->present_address}}</div>
                     </div>
                 </div>
                 <div class="row m-0" style="padding-right:50px;">
                     <div class="col-12 col-sm-6 col-md-4">
                         <div class="d-flex">
                             <div class="py-2 m-right">
                                 <span class="p-12 c-gray">Gender</span><br>
                                 <span class="p-12">{{$employee->gender}}</span>
                             </div>
                             <div class="p-2">
                                 <span class="p-12 c-gray">CNIC</span><br>
                                 <span class="p-12">{{$employee->cnic}}</span>
                             </div>
                         </div>
                     </div>
                     <div class="col-12 col-sm-6 col-md-4">
                         <div class="d-flex">
                             <div class="py-2 m-right">
                                 <span class="p-12 c-gray">Nationality</span><br>
                                 <span class="p-12">{{$employee->nationality}}</span>
                             </div>
                             <div class="p-2">
                                 <span class="p-12 c-gray">Language</span><br>
                                 <span class="p-12 ">{{$employee->native_lang}}</span>
                             </div>
                         </div>
                     </div>
                     <div class="col-12 col-sm-6 col-md-4">
                         <div class="d-flex">
                             <div class="py-2 m-right">
                                 <span class="p-12 c-gray">Blood Group</span><br>
                                 <span class="p-12">{{$employee->blood_group}}</span>
                             </div>
                             <div class="p-2">
                                 <span class="p-12 c-gray">Date of Birth</span><br>
                                 <span class="p-12">{{$employee->date_of_birth}}</span>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
        {{-- education info --}}
         @if($employee->employee_education)
            <div class="row m-0 mb-5 box_shadow">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="" style="padding-left: 37px;"><b>Education Data</b></h4>
                @if($employee->locked == 0)
                    <button id="education_info" onclick="edit_education_info(this)" value="{{$employee->employee_id}}" value="{{$employee->employee_id}}" class="btn btn_edit"><i class="fa fa-edit"></i></button>
                @endif
            </div>
            <div class="col-12 px-5">
                <table class="" style="width:100%;">
                    <tr>
                        <th class="p-12 c-gray" scope="col">Degree</th>
                        <th class="p-12 c-gray" scope="col">Name of Institute</th>
                        <th class="p-12 c-gray" scope="col">Division/Grade</th>
                        <th class="p-12 c-gray" scope="col">Major Subjects</th>
                        <th class="p-12 c-gray" scope="col">From</th>
                        <th class="p-12 c-gray" scope="col">To</th>
                    </tr>
                        @foreach($employee->employee_education as $employee_education)
                    <tr>
                        <td class="px-4 p-12">{{$employee_education->degree}}</td>
                        <td class="p-12">{{$employee_education->institute_name}}</td>
                        <td class="p-12">{{$employee_education->division_grade}}</td>
                        <td class="p-12">{{$employee_education->major_subjects}}</td>
                        <td class="p-12">{{$employee_education->from_date}}</td>
                        <td class="p-12">{{$employee_education->to_date}}</td>
                    </tr>
                        @endforeach

                </table>
            </div>
        </div>
         @endif
        {{-- Experience info --}}
         @if($employee->employee_experience)
            <div class="row m-0 mb-5 box_shadow">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="" style="padding-left: 37px;"><b>Experience Details</b></h4>
                @if($employee->locked == 0)
                    <button id="experience_info" onclick="edit_experience_info(this)" value="{{$employee->employee_id}}" class="btn btn_edit"><i class="fa fa-edit"></i></button>
                @endif
            </div>
            <div class="col-12 px-5">
                <table class="w-100">
                    <tr>
                        <th class="p-12 c-gray" scope="col">Employer Name</th>
                        <th class="p-12 c-gray" scope="col">Employer Contact</th>
                        <th class="p-12 c-gray" scope="col">Position Held</th>
                        <th class="p-12 c-gray" scope="col">Reason for leaving</th>
                        <th class="p-12 c-gray" scope="col">Gross Salary</th>
                        <th class="p-12 c-gray" scope="col">From</th>
                        <th class="p-12 c-gray" scope="col">To</th>
                    </tr>
                        @foreach($employee->employee_experience as $employee_experience)
                    <tr>
                        <td class="px-4 p-12">{{$employee_experience->employer_name}}</td>
                        <td class="p-12">{{$employee_experience->employer_contact_number}}</td>
                        <td class="p-12">{{$employee_experience->position_held}}</td>
                        <td class="p-12">{{$employee_experience->leave_reason}}</td>
                        <td class="p-12">{{$employee_experience->gross_salary}}</td>
                        <td class="p-12">{{$employee_experience->from_date}}</td>
                        <td class="p-12">{{$employee_experience->to_date}}</td>
                    </tr>
                        @endforeach
                </table>
                <br>
                <div>
                    <span class="p-12 c-gray">May we approach your Previous Employer?</span><br>
                    <span class="p-12 bg-style px-4">{{$employee->approach_previous_employer}}</span>
                </div>
                <div>
                    <span class="p-12 c-gray">May we approach your Previous Employer?</span><br>
                    <span class="p-12 bg-style px-4">{{$employee->previous_employer_service_bond}}</span>
                </div>
                <div>
                    <span class="p-12 c-gray">If YES then give reason.</span><br>
                    <span class="p-12 bg-style px-4">{{$employee->service_bond_reason}}</span>
                </div>
            </div>
        </div>
         @endif
        {{-- Family info --}}
         @if($employee->employee_family)
            <div class="row m-0 mb-5 box_shadow">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="" style="padding-left: 37px;"><b>Family Details</b></h4>
                @if($employee->locked == 0)
                    <button id="family_info" onclick="edit_family_info(this)" value="{{$employee->employee_id}}" class="btn btn_edit"><i class="fa fa-edit"></i></button>
                @endif
            </div>
            <div class="col-12 px-5">
                <div>
                    <span class="p-12 c-gray">Number of Dependents:</span>
                    <span class="p-12">{{$employee->employee_kin ? $employee->employee_kin->dependents : ''}}</span>
                </div>
                <table class="" style="width:100%;">
                    <tr>
                        <th class="p-12 c-gray" scope="col">Relationship</th>
                        <th class="p-12 c-gray" scope="col">Name</th>
                        <th class="p-12 c-gray" scope="col">Age</th>
                        <th class="p-12 c-gray" scope="col">Education</th>
                        <th class="p-12 c-gray" scope="col">Occupation</th>
                    </tr>
                    @if(isset($employee->employee_family) && count($employee->employee_family) > 0 )
                        @foreach($employee->employee_family as $employee_family)
                        <tr>
                            <td class="px-4 p-12">{{$employee_family->relationship}}</td>
                            <td class="p-12">{{$employee_family->name}}</td>
                            <td class="p-12">{{$employee_family->age}}</td>
                            <td class="p-12">{{$employee_family->education}}</td>
                            <td class="p-12">{{$employee_family->occupation}}</td>
                        </tr>
                        @endforeach
                    @endif
                </table>
            </div>
            {{-- next of kin info --}}
            <div class="col-12 d-flex justify-content-between mt-5" style="align-items: center;">
                <h5 class="" style="padding-left: 37px;"><b>Next of Kin Details</b></h5>
            </div>
            <br>
            <div class="col-12 px-5">
                <table class="" style="width:100%;">
                    <tr>
                        <th class="p-12 c-gray" scope="col">Name</th>
                        <th class="p-12 c-gray" scope="col">Relationship</th>
                        <th class="p-12 c-gray" scope="col">CNIC</th>
                        <th class="p-12 c-gray" scope="col">Contact</th>
                        <th class="p-12 c-gray" scope="col">Address</th>
                    </tr>
                    <tr>
                        <td class="px-4 p-12">{{$employee->employee_kin ? $employee->employee_kin->kin_name  : ''}}</td>
                        <td class="p-12">{{$employee->employee_kin ? $employee->employee_kin->kin_relation  : ''}}</td>
                        <td class="p-12">{{$employee->employee_kin ?$employee->employee_kin->kin_cnic  : ''}}</td>
                        <td class="p-12">{{$employee->employee_kin ? $employee->employee_kin->kin_contact_number  : ''}}</td>
                        <td class="p-12">{{$employee->employee_kin ? $employee->employee_kin->kin_address  : ''}}</td>
                    </tr>
                </table>
                <br>
                <div>
                <span class="p-12 c-gray">Do you or any of your family member suffer or have suffered
                        from any serious contagious illness or disability?</span><br>
                    <span class="p-12 bg-style px-4">{{$employee->employee_kin ? $employee->employee_kin->any_illness_record : ''}}</span>
                </div>
                <div>
                    <span class="p-12 c-gray">If YES, please give particulars</span><br>
                    <span class="p-12 bg-style px-4">{{$employee->employee_kin ? $employee->employee_kin->illness_details : ''}}</span>
                </div>
            </div>
        </div>
         @endif
        {{-- Emergency info --}}
         @if($employee->employee_emergency_contact)
        <div class="row m-0 mb-5 box_shadow">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <h4 class="" style="padding-left: 37px;"><b>Emergency Details</b></h4>
                @if($employee->locked == 0)
                    <button id="emergency_contact_info" onclick="edit_emergency_contact_info(this)" value="{{$employee->employee_id}}" class="btn btn_edit"><i class="fa fa-edit"></i></button>
                @endif
            </div>
            <div class="col-12 px-5">
                <table class="w-100">
                    <tr>
                        <th class="p-12 c-gray" scope="col">Name</th>
                        <th class="p-12 c-gray" scope="col">Relationship</th>
                        <th class="p-12 c-gray" scope="col">CNIC</th>
                        <th class="p-12 c-gray" scope="col">Contact</th>
                        <th class="p-12 c-gray" scope="col">Address</th>
                    </tr>
                    @foreach($employee->employee_emergency_contact as $employee_emergency_contact)
                    <tr>
                        <td class="px-4 p-12">{{$employee_emergency_contact->emergency_contact_name}}</td>
                        <td class="p-12">{{$employee_emergency_contact->emergency_contact_relation}}</td>
                        <td class="p-12">{{$employee_emergency_contact->emergency_contact_cnic}}</td>
                        <td class="p-12">{{$employee_emergency_contact->emergency_contact_number}}</td>
                        <td class="p-12">{{$employee_emergency_contact->emergency_contact_address}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
         @endif
         {{-- Emergency info --}}
         @if($employee->employee_company_reference)
             <div class="row m-0 mb-5 box_shadow">
                 <div class="col-12 d-flex justify-content-between align-items-center">
                     <h4 class="" style="padding-left: 37px;"><b>Reference Details</b></h4>
                     @if($employee->locked == 0)
                         <button id="company_reference_info" onclick="edit_company_reference_info(this)" value="{{$employee->employee_id}}" class="btn btn_edit"><i class="fa fa-edit"></i></button>
                     @endif
                 </div>
                 <div class="col-12 px-5">
                     <table class="" style="width:100%;">
                         <tr>
                             <th class="p-12 c-gray" scope="col">Relationship</th>
                             <th class="p-12 c-gray" scope="col">Name</th>
                             <th class="p-12 c-gray" scope="col">Position</th>
                             <th class="p-12 c-gray" scope="col">Company Name</th>
                             <th class="p-12 c-gray" scope="col">Email</th>
                             <th class="p-12 c-gray" scope="col">Contact</th>
                         </tr>
                         @foreach($employee->employee_company_reference as $employee_company_reference)
                             <tr>
                                 <td class="px-4 p-12">{{$employee_company_reference->relation}}</td>
                                 <td class="p-12">{{$employee_company_reference->name}}</td>
                                 <td class="p-12">{{$employee_company_reference->position}}</td>
                                 <td class="p-12">{{$employee_company_reference->company_name}}</td>
                                 <td class="p-12">{{$employee_company_reference->email}}</td>
                                 <td class="p-12">{{$employee_company_reference->contact_number}}</td>
                             </tr>
                         @endforeach
                     </table>
                 </div>
             </div>
         @endif
{{--         Training and hiobbies details --}}
        <div class="row m-0 mb-5 box_shadow">
            <div class="col-12 d-flex justify-content-between" style="align-items: center;">
                <h4 class="" style="padding-left: 37px;"><b>Hobbies and Interests</b></h4>
                @if($employee->locked == 0)
                    <button id="personal_info" onclick="edit_personal_info(this)" value="{{$employee->employee_id}}" class="btn btn_edit"><i class="fa fa-edit"></i></button>
                @endif
            </div>
            <div class="col-12 px-5 d-flex">
                <table class="training_and_hobbies_table" style="width:25%;margin-right: 50px;">
                    <tr>
                        <th class="p-12 c-gray" scope="col">Hobbies and Interests</th>
                    </tr>
                    @if ($employee->hobbies_interest != "")
                        @foreach(explode(',', $employee->hobbies_interest) as $hobbies_interest)
                            <tr>
                                <td class="px-4 p-12">{{$hobbies_interest}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
{{--                <table class="training_and_hobbies_table" style="width:25%;margin-right: 50px;">--}}
{{--                    <tr>--}}
{{--                        <th scope="col">Hobbies & Interset</th>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td class="px-4">Mark</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td class="px-4">Mark</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td class="px-4">Mark</td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td class="px-4">Mark</td>--}}
{{--                    </tr>--}}
{{--                </table>--}}
            </div>
        </div>
         {{--  Uploaded Documents --}}
         @if($employee->employee_docs)
         <div class="row m-0 mb-5 box_shadow">
             <div class="col-12 d-flex justify-content-between" style="align-items: center;">
                 <h4 class="" style="padding-left: 37px;"><b>Uploaded Documents</b></h4>
                 <button id="upload_docs" onclick="edit_employee_docs(this)" value="{{$employee->employee_id}}" class="btn btn_edit"><i class="fa fa-edit"></i></button>
             </div>
             <div class="col-12 px-5">
                 <table class="training_and_hobbies_table" style="width:25%;margin-right: 50px;">
                     <tr>
                         <th class="p-6 c-gray" scope="col">Doc Title</th>
                         <th class="p-6 c-gray" scope="col">Doc File</th>
                     </tr>
                     @foreach($employee->employee_docs as $employee_docs)
                             <tr>
                                 <td class="px-4 p-6">{{$employee_docs->doc_title}}</td>
                                 <td class="px-4 p-6"><a href="{{asset('employee_documents/'.$employee_docs->doc_file)}}" target="_blank">
                                                        <span><i class="fa fa-file-pdf" style='color: red'></i><span></a>
                                 </td>
                             </tr>
                         @endforeach
                 </table>
             </div>
         </div>
         @endif
    </div>
@include('employees.partials.employee_js')
@endsection
@section('footer_scripts')
<script>
    function edit_personal_info(me) {
        let employee_id = me.value;
        let data = new FormData();
        data.append('employee_id', employee_id);
        data.append('_token', "{{csrf_token()}}");
        call_ajax_modal('POST', '{{route('employees_personal_info_edit')}}', data, 'Employee Personal Info Edit');
    }
    function edit_education_info(me){
        let employee_id = me.value;
        let data = new FormData();
        data.append('employee_id', employee_id);
        data.append('_token', "{{csrf_token()}}");
        call_ajax_modal('POST','{{route('employees_education_info_edit')}}', data, 'Employee Education Info Edit');
    }
    function edit_experience_info(me){
        let employee_id = me.value;
        let data = new FormData();
        data.append('employee_id', employee_id);
        data.append('_token', "{{csrf_token()}}");
        call_ajax_modal('POST','{{route('employees_experience_info_edit')}}', data, 'Employee Experience Info Edit');
    }
    function edit_family_info(me){
        let employee_id = me.value;
        let data = new FormData();
        data.append('employee_id', employee_id);
        data.append('_token', "{{csrf_token()}}");
        call_ajax_modal('POST','{{route('employees_family_info_edit')}}', data, 'Employee Family Info Edit');
    }
    function edit_emergency_contact_info(me){
        let employee_id = me.value;
        let data = new FormData();
        data.append('employee_id', employee_id);
        data.append('_token', "{{csrf_token()}}");
        call_ajax_modal('POST','{{route('employees_emergency_contact_info_edit')}}', data, 'Employee Emergency Contact Info Edit');
    }
    function edit_company_reference_info(me){
        let employee_id = me.value;
        let data = new FormData();
        data.append('employee_id', employee_id);
        data.append('_token', "{{csrf_token()}}");
        call_ajax_modal('POST','{{route('employees_company_reference_info_edit')}}', data, 'Employee Company Reference Info Edit');
    }
    function edit_employee_docs(me){
        let employee_id = me.value;
        let data = new FormData();
        data.append('employee_id', employee_id);
        data.append('_token', "{{csrf_token()}}");
        call_ajax_modal('POST','{{route('employees_docs_edit')}}', data, 'Employee Uploaded Docs Edit');
    }
</script>
@endsection
