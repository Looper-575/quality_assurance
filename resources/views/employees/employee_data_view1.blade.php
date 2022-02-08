<button class="btn btn-primary" onclick="print_div('employee_record_print')" style="position: absolute; top: -58px; right: 70px;">Print</button>
<div id="employee_record_print" style="overflow-y: scroll; height: 500px; overflow-x: hidden;">
    <h3 CLASS="text-center">Employee Record</h3><br>
{{--    @dd($employee);--}}
    <h5 CLASS="text-left">Personal Details</h5><br>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Position Applied For</th>
            <th>Gross Salary</th>
            <th>Date of Joining</th>
            <th>Employee Full Name</th>
            <th>Employee Surname</th>
            <th>Father/ Husband Name</th>
        </tr>
        <tr>
            <td>{{$employee->designation}}</td>
            <td>{{$employee->gross_salary}}</td>
            <td>{{$employee->joining_date}}</td>
            <td>{{$employee->full_name}}</td>
            <td>{{$employee->surname}}</td>
            <td>{{$employee->father_husband}}</td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <th>Gender</th>
            <th>Marital Status</th>
            <th>Email</th>
            <th>Contact Number</th>
            <th>CNIC</th>
        </tr>
        <tr>
            <td>{{$employee->date_of_birth}}</td>
            <td>{{$employee->gender}}</td>
            <td>{{$employee->marital_status}}</td>
            <td>{{$employee->email}}</td>
            <td>{{$employee->contact_number}}</td>
            <td>{{$employee->cnic}}</td>
        </tr>
        <tr>
            <th>Father CNIC</th>
            <th>Religion</th>
            <th>Blood Group</th>
            <th>Native Language</th>
            <th>Nationality</th>
            <th>Domicile City</th>
        </tr>
        <tr>
            <td>{{$employee->father_cnic}}</td>
            <td>{{$employee->religion}}</td>
            <td>{{$employee->blood_group}}</td>
            <td>{{$employee->native_lang}}</td>
            <td>{{$employee->nationality}}</td>
            <td>{{$employee->domicile_city}}</td>
        </tr>
        <tr>
            <th colspan="3">Present Address</th>
            <th colspan="3">Permanent Address</th>
        </tr>
        <tr>
            <td colspan="3">{{$employee->present_address}}</td>
            <td colspan="3">{{$employee->permanent_address}}</td>
        </tr>
    </table>
    <br><h5 CLASS="text-left">Educational Details</h5><br>
    @if($employee->employee_education)
    <table class="table table-bordered table-striped">
        <tr>
            <th>Degree</th>
            <th>Institute</th>
            <th>Grades</th>
            <th>Major Subjects</th>
            <th>Duration</th>
        </tr>
        @foreach($employee->employee_education as $employee_education)
            <tr>
                <td>{{$employee_education->degree}}</td>
                <td>{{$employee_education->institute_name}}</td>
                <td>{{$employee_education->division_grade}}</td>
                <td>{{$employee_education->major_subjects}}</td>
                <td>{{$employee_education->from_date}} - {{$employee_education->to_date}}</td>
            </tr>
        @endforeach
    </table>
    @else
        <p>No record found</p>
    @endif
    <br><h5 CLASS="text-left">Family Record Details</h5><br>
    @if($employee->employee_family)
    <table class="table table-bordered table-striped">
        <tr>
            <th>Relation</th>
            <th>Name</th>
            <th>Age</th>
            <th>Education</th>
            <th>Occupation</th>
        </tr>
        @foreach($employee->employee_family as $employee_family)
        <tr>
            <td>{{$employee_family->relationship}}</td>
            <td>{{$employee_family->name}}</td>
            <td>{{$employee_family->age}}</td>
            <td>{{$employee_family->education}}</td>
            <td>{{$employee_family->occupation}}</td>
        </tr>
        @endforeach
    </table>
    @else
        <p>No record found</p>
    @endif
    <br><h6 CLASS="text-left">Next of KIN Details</h6><br>
    @if($employee->employee_kin)
    <table class="table table-bordered table-striped">
        <tr>
            <th>Relation</th>
            <th>Name</th>
            <th>CNIC</th>
            <th>Contact Number</th>
            <th>Address</th>
        </tr>
        <tr>
            <td>{{$employee->employee_kin->kin_relation}}</td>
            <td>{{$employee->employee_kin->kin_name}}</td>
            <td>{{$employee->employee_kin->kin_cnic}}</td>
            <td>{{$employee->employee_kin->kin_contact_number}}</td>
            <td>{{$employee->employee_kin->kin_address}}</td>
        </tr>
    </table>
    @else
        <p>No record found</p>
    @endif
    <br><h5 CLASS="text-left">Emergency Contact Details</h5><br>
    @if($employee->employee_emergency_contact)
    <table class="table table-bordered table-striped">
        <tr>
            <th>Relation</th>
            <th>Name</th>
            <th>CNIC</th>
            <th>Contact Number</th>
            <th>Address</th>
        </tr>
        @foreach($employee->employee_emergency_contact as $employee_emergency_contact)
        <tr>
            <td>{{$employee_emergency_contact->emergency_contact_relation}}</td>
            <td>{{$employee_emergency_contact->emergency_contact_name}}</td>
            <td>{{$employee_emergency_contact->emergency_contact_cnic}}</td>
            <td>{{$employee_emergency_contact->emergency_contact_number}}</td>
            <td>{{$employee_emergency_contact->emergency_contact_address}}</td>
        </tr>
        @endforeach
    </table>
    @else
        <p>No record found</p>
    @endif
    <br><h5 CLASS="text-left">Experience Details</h5><br>
    @if($employee->employee_experience)
        <table class="table table-bordered table-striped">
            <tr>
                <th>Position Held</th>
                <th>EmployerName</th>
                <th>Reason for Leave</th>
                <th>Gross Salary</th>
                <th>Duration</th>
            </tr>
            @foreach($employee->employee_experience as $employee_experience)
                <tr>
                    <td>{{$employee_experience->position_held}}</td>
                    <td>{{$employee_experience->employer_name}}</td>
                    <td>{{$employee_experience->leave_reason}}</td>
                    <td>{{$employee_experience->gross_salary}}</td>
                    <td>{{$employee_experience->from_date}} - {{$employee_experience->to_date}}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p>No record found</p>
    @endif
    <br><h5 CLASS="text-left">Atlantian References</h5><br>
    @if($employee->employee_company_reference)
        <table class="table table-bordered table-striped">
            <tr>
                <th>Name</th>
                <th>Relation</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Position</th>
                <th>Company Name</th>
            </tr>
            @foreach($employee->employee_company_reference as $employee_company_reference)
                <tr>
                    <td>{{$employee_company_reference->name}}</td>
                    <td>{{$employee_company_reference->relation}}</td>
                    <td>{{$employee_company_reference->email}}</td>
                    <td>{{$employee_company_reference->contact_number}}</td>
                    <td>{{$employee_company_reference->position}}</td>
                    <td>{{$employee_company_reference->company_name}}</td>
                </tr>
            @endforeach
        </table>
    @else
        <p>No record found</p>
    @endif
</div>
