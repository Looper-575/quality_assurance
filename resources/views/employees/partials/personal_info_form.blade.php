<div id="employee_id_response"></div>
<form action="javascript:save_employee()" enctype="multipart/form-data" class="m-form m-form--label-align-left- m-form--state-" id="employee_info_form">
    @csrf
    <!--begin: Form Wizard Step 1 Body -->
    <div class="row">
        <div class="col-xl-12">
            <div class="m-form__section m-form__section--first">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">
                        Personal Details
                    </h3>
                </div>
                <div class="row">
                    @if($employee && $employee->image != '')
                        @php
                            $image_src =  asset('employee_images/'.$employee->image);
                        @endphp
                    @else
                        @php
                            $image_src = asset('assets/img/users/user_avatar.jpg');
                        @endphp
                    @endif
                    <div class="col-4">
                        <div class="form-group m-form__group">
                            <label for="image">Profile Image</label>
                            <div class="p-3" style="text-align: center">
                                <img  id="profile_image" src="{{$image_src}}" class="m--img-rounded m--marginless" width="150" height="150">
                            </div>
                            <div class="avartar-picker">
                                <input onchange="setImage()" type="file" name="image" id="image" class="inputfile" style="display: none;">
                                <label for="image">
                                    <i class="fa fa-camera"></i>
                                    <span>Choose Picture</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group m-form__group">
                                    <label for="user_id">* Users</label>
                                    <?php $user_ddl_perm = ( (Auth::user()->role->role_id != '5' && Auth::user()->role->role_id != '1')  || (Auth::user()->role->role_id == '5' or Auth::user()->role->role_id == '1') && $employee );  ?>
                                    <select class="form-control" name="user_id" id="user_id" onchange="get_user_data(this)" required {{ $user_ddl_perm  ? 'disabled' : ''}} >
                                        <option value="">Select</option>
                                        @foreach($users as $user)
                                            <option {{ ($employee && $employee->user_id == $user->user_id)  ? 'selected' : ''}} value="{{$user->user_id}}">{{$user->full_name}}</option>
                                        @endforeach
                                    </select>
                                    @if( $user_ddl_perm )
                                        <input type="hidden" name="user_id" value="{{$employee->user_id}}">
{{--                                        (Auth::user()->role->role_id != '5' && Auth::user()->role->role_id != '1')  ? Auth::user()->user_id : $employee->user_id)--}}
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group m-form__group">
                                    <label for="full_name">* Full Name</label>
                                    <input name="full_name" value="{{$employee ? $employee->full_name : ''}}" readonly required type="text" id="full_name_id" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group m-form__group">
                                    <label for="department">* Department</label>
                                    <select class="form-control" name="department" id="department_id" required {{$user_ddl_perm ? 'disabled' : ''}} >
                                        <option value="">Select</option>
                                        @foreach($departments as $department)
                                            <option {{ (($employee && $employee->department == $department->department_id) or $department->department_id == Auth::user()->department_id) ? 'selected' : ''}} value="{{$department->department_id}}">{{$department->title}}</option>
                                        @endforeach
                                    </select>
                                    @if($user_ddl_perm)
                                        <input type="hidden" name="department" value="{{(Auth::user()->role->role_id != '5' && Auth::user()->role->role_id != '1')  ? Auth::user()->user_id : $employee->department}}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group m-form__group">
                                    <label for="designation">* Designation</label>
                                    <input name="designation" value="{{$employee ? $employee->designation : ''}}" required type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group m-form__group">
                                    <label for="gender">* Gender</label>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" name="gender" value="Male" {{($employee and $employee->gender == 'Male')? 'checked' : ''}} class="form-control">
                                            Male
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" name="gender" value="Female" {{($employee and $employee->gender == 'Female')? 'checked' : ''}} class="form-control">
                                            Female
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="form-group m-form__group">
                                    <label for="marital_status">* Maritial Status</label>
                                    <div class="m-radio-inline">
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" name="marital_status" value="Single" {{($employee and $employee->marital_status == 'Single')? 'checked' : ''}} class="form-control">
                                            Single
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" name="marital_status" value="Married" {{($employee and $employee->marital_status == 'Married')? 'checked' : ''}} class="form-control">
                                            Married
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" name="marital_status" value="Widowed" {{($employee and $employee->marital_status == 'Widowed')? 'checked' : ''}} class="form-control">
                                            Widowed
                                            <span></span>
                                        </label>
                                        <label class="m-radio m-radio--solid m-radio--brand">
                                            <input type="radio" name="marital_status" value="Divorced" {{($employee and $employee->marital_status == 'Divorced')? 'checked' : ''}}  class="form-control">
                                            Divorced
                                            <span></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group m-form__group">
                            <label  for="joining_date">* Joining Date</label>
                            <input name="joining_date" value="{{$employee ? $employee->joining_date : ''}}" required type="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group m-form__group">
                            <label  for="gross_salary">* Gross Salary</label>
                            <input name="gross_salary" value="{{$employee ? $employee->gross_salary : ''}}" required type="number" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group m-form__group">
                            <label for="email">* Email</label>
                            <input name="email" value="{{$employee ? $employee->email : ''}}" required type="email" id="email_id" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group m-form__group">
                            <label for="contact_number" for="contact_number">Contact Number</label>
                            <input name="contact_number" id="contact_number_id" value="{{$employee ? $employee->contact_number : ''}}" required type="tel" placeholder="03001234567" pattern="[0-9]{4}[0-9]{7}" class="form-control">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group m-form__group">
                            <label for="surname">* Surname</label>
                            <input name="surname" value="{{$employee ? $employee->surname : ''}}" required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group m-form__group">
                            <label for="father_husband">* Father/Husband's Name</label>
                            <input name="father_husband" value="{{$employee ? $employee->father_husband : ''}}" required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group m-form__group">
                            <label for="cnic">* CNIC</label>
                            <input name="cnic" value="{{$employee ? $employee->cnic : ''}}" required type="text" pattern="[0-9]{5}[0-9]{7}[0-9]{1}" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group m-form__group">
                            <label for="father_cnic">* Father CNIC</label>
                            <input name="father_cnic" value="{{$employee ? $employee->father_cnic : ''}}" id="father_cnic" required type="text" pattern="[0-9]{5}[0-9]{7}[0-9]{1}" class="form-control">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-3">
                        <div class="form-group m-form__group">
                            <label for="date_of_birth">* Date of Birth</label>
                            <input name="date_of_birth" value="{{$employee ? $employee->date_of_birth : ''}}" required type="date" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group m-form__group">
                            <label for="religion">* Religion</label>
                            <input name="religion" value="{{$employee ? $employee->religion : ''}}" required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group m-form__group">
                            <label for="blood_group">* Blood Group</label>
                            <input name="blood_group" value="{{$employee ? $employee->blood_group : ''}}" required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group m-form__group">
                            <label for="native_lang">* Native Language</label>
                            <input name="native_lang" value="{{$employee ? $employee->native_lang : ''}}" required type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-3">
                    <div class="form-group m-form__group">
                        <label for="hobbies_interest">* Hobbies Interest</label>
                        <input name="hobbies_interest" value="{{$employee ? $employee->hobbies_interest : ''}}"  type="text" class="form-control">
                    </div>
                </div>
            </div>
            <div class="m-separator m-separator--dashed m-separator--lg"></div>
            <div class="m-form__section">
                <div class="m-form__heading">
                    <h3 class="m-form__heading-title">
                        Mailing Address Details
                    </h3>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group m-form__group">
                            <label for="present_address" for="present_address">* Present Address</label>
                            <input name="present_address" value="{{$employee ? $employee->present_address : ''}}" required type="text" id="present_address_id" class="form-control">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group m-form__group">
                            <label for="permanent_address" for="permanent_address">* Permanent Address</label>
                            <input name="permanent_address" value="{{$employee ? $employee->permanent_address : ''}}" required type="text" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group m-form__group">
                            <label for="domicile_city">* Domicile City</label>
                            <input name="domicile_city" value="{{$employee ? $employee->domicile_city : ''}}" required type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group m-form__group">
                            <label for="nationality">* Nationality</label>
                            <input name="nationality" value="{{$employee ? $employee->nationality : ''}}" required type="text" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--end: Form Actions -->
    <!--begin: Form Actions -->
    <div class="m-portlet__foot m-portlet__foot--fit m--margin-top-40">
        <div class="m-form__actions">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-2 m--align-left"> </div>
                <div class="col-lg-6 m--align-right">
                    @if($section_id && $section_id == 'personal_info_form')
                        <button type="submit"  class="btn btn-warning m-btn m-btn--custom m-btn--icon" >
                            <span>Save</span>
                        </button>
                    @else
                        <button type="submit"  class="btn btn-warning m-btn m-btn--custom m-btn--icon" >
                            <span><span>Save & Continue</span><i class="la la-arrow-right"></i></span>
                        </button>
                        @if($employee && $employee->employee_id != '')
                            <a id="1" href="#" class="btn_skip btn btn-info m-btn m-btn--custom m-btn--icon" >
                                <span><i class="la la-arrow-right"></i><span>Skip</span></span>
                            </a>
                        @endif
                    @endif

                </div>
                <div class="col-lg-2"></div>
            </div>
        </div>
    </div>
    <!--end: Form Actions -->
</form>
