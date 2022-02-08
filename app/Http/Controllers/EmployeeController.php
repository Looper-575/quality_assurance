<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\EmployeeCompanyReference;
use App\Models\EmployeeEducation;
use App\Models\EmployeeEmergencyContact;
use App\Models\EmployeeExperience;
use App\Models\EmployeeFamily;
use App\Models\EmployeeKin;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    public function index()
    {
        $data['page_title'] = "Employees List - Atlantis BPO CRM";
        if(Auth::user()->role_id == 1 or Auth::user()->role_id == 5){
            $data['employee_lists'] = Employee::where('status' , 1)->orderBy('added_on', 'desc')->get();
        } else {
            $data['employee_lists'] = Employee::where('user_id' , Auth::user()->user_id)->get();
        }
        return view('employees.employee_list', $data);
    }
    public function employee_form(Request $request)
    {
        $data['page_title'] = "Employee Form - Atlantis BPO CRM";
        $data['departments'] = Department::where('status',1)->orderBy('department_id', 'DESC')->get();
        $data['employee_ref_users'] = User::where('status',1)->get();
        $data['section_id'] = false;
        if(isset($request->employee_id)) {
            $find_user = Employee::where('employee_id', $request->employee_id)->pluck('user_id')->first();
            if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
                $data['employee'] = Employee::where('employee_id', $request->employee_id)->get()[0];
            } else if(Auth::user()->user_id  == $find_user){
                $data['employee'] = Employee::where('employee_id', $request->employee_id)->where('user_id', $find_user)->get()[0];
            } else {
                return redirect()->route('access_denied');
            }
            $data['users'] = User::where('status',1)->get();
            //$data['employee'] = Employee::where('employee_id', $request->employee_id)->get()[0];
            $data['employee_education'] = EmployeeEducation::where('employee_id', $request->employee_id)->get();
            $data['employee_experience'] = EmployeeExperience::where('employee_id', $request->employee_id)->get();
            $data['employee_family'] = EmployeeFamily::where('employee_id', $request->employee_id)->get();
            $count = EmployeeKin::where('employee_id', $request->employee_id)->get()->count();
            if ($count > 0){
                $data['employee_kin'] = EmployeeKin::where('employee_id', $request->employee_id)->get()[0];
            }else{
                $data['employee_kin'] = false;
            }
            $data['employee_emergency_contact'] = EmployeeEmergencyContact::where('employee_id',$request->employee_id)->get();
            $data['employee_company_reference'] = EmployeeCompanyReference::where('employee_id',$request->employee_id)->get();
        } else {
            if(Auth::user()->role_id != 1 && Auth::user()->role_id != 5){
                return redirect()->route('access_denied');
            }
            $data['users'] = User::doesnthave('employee')->where('status',1)->get();
            $data['employee'] = false;
            $data['employee_education'] = false;
            $data['employee_experience'] = false;
            $data['employee_family'] = false;
            $data['employee_kin'] = false;
            $data['employee_emergency_contact'] = false;
            $data['employee_company_reference'] = false;
        }
        return view('employees.employee_form_wizard',$data);
    }
    public function employee_info_save(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'full_name' => 'required',
            'surname' => 'required',
            'father_husband' => 'required',
            'email' => 'required',
            "image" => "image|mimes:png,gif,jpeg,jpg",
            'gender' => 'required',
            'contact_number' => 'required',
            'designation' => 'required',
            'marital_status' => 'required',
            'domicile_city' => 'required',
            'present_address' => 'required',
            'permanent_address' => 'required',
            'date_of_birth' => 'required',
            'nationality' => 'required',
            'cnic' => 'required',
            'father_cnic' => 'required',
            'religion' => 'required',
            'blood_group' => 'required',
            'native_lang' => 'required',
            'gross_salary' => 'required',
            'joining_date' => 'required',
            'department' => 'required'
        ]);
        if($validator->passes()){
            $employee = Employee::where('user_id', $request->user_id)->get();
            $employee_info_data = [
                'added_by' => Auth::user()->user_id,
                'user_id' => $request->user_id,
                'department' => $request->department,
                'full_name' => $request->full_name,
                'surname' => $request->surname,
                'father_husband' => $request->father_husband,
                'email' => $request->email,
                'gender' => $request->gender,
                'present_address' => $request->present_address,
                'contact_number' => $request->contact_number,
                'designation' => $request->designation,
                'marital_status' => $request->marital_status,
                'domicile_city' => $request->domicile_city,
                'permanent_address' => $request->permanent_address,
                'contact_number' => $request->contact_number,
                'designation' => $request->designation,
                'marital_status' => $request->marital_status,
                'domicile_city' => $request->domicile_city,
                'permanent_address' => $request->permanent_address,
                'date_of_birth' => $request->date_of_birth,
                'nationality' => $request->nationality,
                'cnic' => $request->cnic,
                'father_cnic' => $request->father_cnic,
                'religion' => $request->religion,
                'blood_group' => $request->blood_group,
                'native_lang' => $request->native_lang,
                'gross_salary' => $request->gross_salary,
                'joining_date' => $request->joining_date,
                'hobbies_interest' => $request->hobbies_interest,
            ];
            if($request->hasFile('image')) {
                $file = $request->file('image');
                $employee_image = time() . rand(1, 100) . '.' . $file->extension();
                $file->move(public_path('employee_images'), $employee_image);
                $employee_info_data['image'] = $employee_image;
            }
            if(count($employee)>0){
                Employee::where('employee_id', $employee[0]->employee_id)->update($employee_info_data);
            } else {
                Employee::create($employee_info_data);
            }
            $employee = Employee::where('user_id', $request->user_id)->get()[0];
            ?>
            <input data-response="Success" type="hidden" id="employee_id" value="<?=$employee->employee_id?>">
            <?php
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
            return response()->json($response);
        }
    }
    public function employee_education_save(Request $request){
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'education_degree' => 'required',
            'education_institute_name' => 'required',
            'education_division_grade' => 'required',
            'education_major_subjects' => 'required',
            'education_from_date' => 'required',
            'education_to_date' => 'required'
        ]);
        if($validator->passes()){
            // remove
            $employee_id = $request->employee_id;
            EmployeeEducation::where('employee_id', $employee_id)->delete();
            for($i=0, $i_max=count($request->education_degree); $i<$i_max; $i++) {
                EmployeeEducation::create(array(
                    'added_by' =>  Auth::user()->user_id,
                    'employee_id' => $employee_id,
                    'degree' => $request->education_degree[$i],
                    'institute_name' => $request->education_institute_name[$i],
                    'division_grade' => $request->education_division_grade[$i],
                    'major_subjects' => $request->education_major_subjects[$i],
                    'from_date' => parse_date_store($request->education_from_date[$i]),
                    'to_date' => parse_date_store($request->education_to_date[$i]),
                ));
            }
            $response['status'] = 'success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function employee_experience_save(Request $request){
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'experience_employer_name' => 'required',
            'experience_employer_contact_number' => 'required',
            'experience_position_held' => 'required',
            'experience_leave_reason' => 'required',
            'experience_gross_salary' => 'required',
            'experience_from_date' => 'required',
            'experience_to_date' => 'required',
            'approach_previous_employer' => 'required',
            'previous_employer_service_bond' => 'required'
        ]);
        if($validator->passes()){
            // remove
            $employee_id = $request->employee_id;
            EmployeeExperience::where('employee_id', $employee_id)->delete();
            for($i=0, $i_max=count($request->experience_employer_name); $i<$i_max; $i++) {
                EmployeeExperience::create(array(
                    'added_by' =>  Auth::user()->user_id,
                    'employee_id' => $employee_id,
                    'employer_name' => $request->experience_employer_name[$i],
                    'employer_contact_number' => $request->experience_employer_contact_number[$i],
                    'position_held' => $request->experience_position_held[$i],
                    'leave_reason' => $request->experience_leave_reason[$i],
                    'gross_salary' => $request->experience_gross_salary[$i],
                    'from_date' => $request->experience_from_date[$i],
                    'to_date' =>  $request->experience_to_date[$i],
                ));
            }
            Employee::where('employee_id', $employee_id)->update(array(
                'approach_previous_employer' => $request->approach_previous_employer,
                'previous_employer_service_bond' => $request->previous_employer_service_bond,
                'service_bond_reason' => $request->service_bond_reason
            ));
            $response['status'] = 'success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function employee_family_save(Request $request){
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'family_relationship' => 'required',
            'family_name' => 'required',
            'family_age' => 'required',
            'family_education' => 'required',
            'family_occupation' => 'required',
            'kin_relation'  => 'required',
            'kin_name'  => 'required',
            'kin_cnic'  => 'required',
            'kin_contact_number' => 'required',
            'kin_address' => 'required',
            'dependents' => 'required',
            'any_illness_record' => 'required'
        ]);
        if($validator->passes()){
            // remove already prersent data
            $employee_id = $request->employee_id;
            EmployeeFamily::where('employee_id', $employee_id)->delete();
            EmployeeKin::where('employee_id', $employee_id)->delete();

            for($i=0, $i_max=count($request->family_relationship); $i<$i_max; $i++) {
                EmployeeFamily::create(array(
                    'added_by' =>  Auth::user()->user_id,
                    'employee_id' => $employee_id,
                    'relationship' => $request->family_relationship[$i],
                    'name' => $request->family_name[$i],
                    'age' => $request->family_age[$i],
                    'education' => $request->family_education[$i],
                    'occupation' => $request->family_occupation[$i]
                ));
            }
            EmployeeKin::create(array(
                'added_by' =>  Auth::user()->user_id,
                'employee_id' => $employee_id,
                'kin_relation' => $request->kin_relation,
                'kin_name' => $request->kin_name,
                'kin_cnic' => $request->kin_cnic,
                'kin_contact_number' => $request->kin_contact_number,
                'kin_address' => $request->kin_address,
                'dependents' => $request->dependents,
                'any_illness_record' => $request->any_illness_record
            ));

            $response['status'] = 'success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function employee_emergency_contact_save(Request $request){
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'emergency_contact_relation' => 'required',
            'emergency_contact_name' => 'required',
            'emergency_contact_cnic' => 'required',
            'emergency_contact_number' => 'required',
            'emergency_contact_address' => 'required'
        ]);
        if($validator->passes()){
            $employee_id= $request->employee_id;
            EmployeeEmergencyContact::where('employee_id', $employee_id)->delete();
            for($i=0, $i_max=count($request->emergency_contact_relation); $i<$i_max; $i++) {
                EmployeeEmergencyContact::create(array(
                    'added_by' =>  Auth::user()->user_id,
                    'employee_id' => $employee_id,
                    'emergency_contact_relation' =>  $request->emergency_contact_relation[$i],
                    'emergency_contact_name' =>  $request->emergency_contact_name[$i],
                    'emergency_contact_cnic' =>  $request->emergency_contact_cnic[$i],
                    'emergency_contact_number' =>  $request->emergency_contact_number[$i],
                    'emergency_contact_address' =>  $request->emergency_contact_address[$i]
                ));
            }
            $response['status'] = 'success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    public function employee_company_reference_save(Request $request){
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'reference_relation' => 'required',
            'reference_id' => 'required',
            'correctness_certificate' => 'required'
        ]);
        if($validator->passes()){
            $employee_id= $request->employee_id;
            EmployeeCompanyReference::where('employee_id', $employee_id)->delete();
            for($i=0, $i_max=count($request->reference_relation); $i<$i_max; $i++) {
                EmployeeCompanyReference::create(array(
                    'added_by' =>  Auth::user()->user_id,
                    'employee_id' => $employee_id,
                    'relation' => $request->reference_relation[$i],
                    'reference_id' => $request->reference_id[$i],
                    'name'  => $request->reference_name[$i],
                    'email' => $request->reference_email[$i],
                    'company_name'  => $request->reference_company_name[$i],
                    'position'  => $request->reference_position[$i],
                    'contact_number'    => $request->reference_contact_number[$i]
                ));
            }
            $response['status'] = 'success';
            $response['result'] = 'Added Successfully';
        } else{
            $response['status']= 'failure';
            $response['result'] = $validator->errors()->toJson();
        }
        return response()->json($response);
    }
    // employee data view
    public function employee_data_view(Request $request)
    {
        $find_user = Employee::where('employee_id', $request->employee_id)->pluck('user_id')->first();
        $data['page_title'] = "Employee Data View - Atlantis BPO CRM";
        $data['section_id'] = true;
        $data['department'] = Department::where('status',1)->get();
        $data['users'] = User::where('status',1)->where('user_id', $find_user)->get();
        $data['employee_ref_users'] = User::where('status',1)->get();
        if(Auth::user()->role_id == 1 || Auth::user()->role_id == 5){
            $data['employee'] = Employee::with('employee_education', 'employee_family', 'employee_kin', 'employee_emergency_contact', 'employee_experience', 'employee_company_reference.user')->where('employee_id', $request->employee_id)->get()[0];
        } else if(Auth::user()->user_id  == $find_user){
            $data['employee'] = Employee::with('employee_education', 'employee_family', 'employee_kin', 'employee_emergency_contact', 'employee_experience', 'employee_company_reference.user')->where('employee_id', $request->employee_id)->where('user_id', $find_user)->get()[0];
        } else {
            return redirect()->route('access_denied');
        }
        return view('employees.employee_data_view', $data);
    }
    // section edits
    public function employees_personal_info_edit(Request $request){
        $data['page_title'] = "Employee Personal Data Update - Atlantis BPO CRM";
        $data['employee'] = Employee::where('employee_id', $request->employee_id)->get()[0];
        $data['departments'] = Department::where('status',1)->orderBy('department_id', 'DESC')->get();
        $data['users'] = User::where('status',1)->get();
        $data['section_id'] = 'personal_info_form';
        return view('employees.partials.personal_info_form', $data);
    }
    public function employees_education_info_edit(Request $request){
        $data['page_title'] = "Employee Education Data Update - Atlantis BPO CRM";
        $data['employee'] = Employee::where('employee_id', $request->employee_id)->get()[0];
        $data['employee_education'] = EmployeeEducation::where('employee_id', $request->employee_id)->get();
        $data['section_id'] = 'education_info_form';
        return view('employees.partials.education_info_form', $data);
    }
    public function employees_experience_info_edit(Request $request){
        $data['page_title'] = "Employee Education Data Update - Atlantis BPO CRM";
        $data['employee'] = Employee::where('employee_id', $request->employee_id)->get()[0];
        $data['employee_experience'] = EmployeeExperience::where('employee_id', $request->employee_id)->get();
        $data['section_id'] = 'experience_info_form';
        return view('employees.partials.experience_info_form', $data);
    }
    public function employees_family_info_edit(Request $request){
        $data['page_title'] = "Employee Education Data Update - Atlantis BPO CRM";
        $data['employee'] = Employee::where('employee_id', $request->employee_id)->get()[0];
        $data['employee_family'] = EmployeeFamily::where('employee_id', $request->employee_id)->get();
        $data['employee_kin'] = EmployeeKin::where('employee_id', $request->employee_id)->get()[0];
        $data['section_id'] = 'family_info_form';
        return view('employees.partials.family_info_form', $data);
    }
    public function employees_emergency_contact_info_edit(Request $request){
        $data['page_title'] = "Employee Education Data Update - Atlantis BPO CRM";
        $data['employee'] = Employee::where('employee_id', $request->employee_id)->get()[0];
        $data['employee_emergency_contact'] = EmployeeEmergencyContact::where('employee_id',$request->employee_id)->get();
        $data['section_id'] = 'emergency_contact_info_form';
        return view('employees.partials.emergency_contact_info_form', $data);
    }
    public function employees_company_reference_info_edit(Request $request){
        $data['page_title'] = "Employee Education Data Update - Atlantis BPO CRM";
        $data['employee'] = Employee::where('employee_id', $request->employee_id)->get()[0];
        $data['employee_company_reference'] = EmployeeCompanyReference::where('employee_id',$request->employee_id)->get();
        $data['employee_ref_users'] = User::where('status',1)->get();
        $data['section_id'] = 'reference_info_form';
        return view('employees.partials.reference_info_form', $data);
    }

    public function delete(Request $request)
    {
        Employee::where('employee_id', $request->employee_id)->update([
            'status' => 0,
        ]);
        $response['status'] = "Success";
        $response['result'] = "Deleted Successfully";
        return response()->json($response);
    }
    public function get_employee_data(Request $request)
    {
        $data = User::with('department')->where('user_id', $request->user_id)->first();
        return response()->json($data);
    }
}
