<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeKin extends Model
{
    use HasFactory;
    protected $table = 'employee_kin';
    protected $primaryKey = 'id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'kin_relation',
        'kin_name',
        'kin_cnic',
        'kin_contact_number',
        'kin_address',
        'dependents',
        'any_illness_record',
        'illness_details'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'added_on' => 'datetime',
    ];
    public function employees(){
        return $this->belongsTo(EmployeeKin::class, 'employee_id' , 'employee_id');
    }
}
