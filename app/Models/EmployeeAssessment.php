<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EmployeeAssessment extends Model
{
    use HasFactory;
    protected $table = 'employee_assessments';
    protected $primaryKey = 'id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'employee_id',
        'period',
        'total_service',
        'evaluation_date',
        'confirmation_status',
        'attendance',
        'tardiness',
        'written_warning',
        'verbal_warning',
        'hr_comments',
        'hr_sign',
        'manager_comments',
        'manager_additional_comments',
        'manager_sign',
        'esa_duties',
        'esa_achievements',
        'esa_future_aims',
        'employee_comments',
        'employee_sign',
        'employee_sign_date',
        'probation_extension',
        'probation_extension_to_date',
        'overall_rating',
        'increment',
        'added_by'
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
    public function employees()
    {
        return $this->belongsTo(Employee::class, 'user_id', 'user_id');
    }
    public function evaluation_standards()
    {
        return $this->hasMany(EvaluationStandards::class, 'assessment_id', 'id')->where('remarker_id', Auth::user()->user_id);
    }
}
