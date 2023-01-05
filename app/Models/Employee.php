<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'department_id',
        'full_name',
        'father_husband',
        'surname',
        'email',
        'gender',
        'marital_status',
        'domicile_city',
        'contact_number',
        'present_address',
        'permanent_address',
        'date_of_birth',
        'nationality',
        'cnic',
        'father_cnic',
        'religion',
        'blood_group',
        'native_lang',
        'designation',
        'net_salary',
        'joining_date',
        'hobbies_interest',
        'approach_previous_employer',
        'previous_employer_service_bond',
        'service_bond_reason',
        'locked',
        'conveyance_allowance',
        'employment_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'added_on' => 'datetime',
    ];

    public function employee_education(){
        return $this->hasMany(EmployeeEducation::class, 'employee_id' , 'employee_id');
    }
    public function employee_family(){
        return $this->hasMany(EmployeeFamily::class, 'employee_id' , 'employee_id');
    }
    public function employee_kin(){
        return $this->hasOne(EmployeeKin::class, 'employee_id' , 'employee_id');
    }
    public function employee_emergency_contact(){
        return $this->hasMany(EmployeeEmergencyContact::class, 'employee_id' , 'employee_id');
    }
    public function employee_experience(){
        return $this->hasMany(EmployeeExperience::class, 'employee_id' , 'employee_id');
    }
    public function employee_company_reference(){
        return $this->hasMany(EmployeeCompanyReference::class, 'employee_id' , 'employee_id');
    }
    public function employee_docs(){
        return $this->hasMany(EmployeeDocs::class, 'employee_id' , 'employee_id');
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
}
