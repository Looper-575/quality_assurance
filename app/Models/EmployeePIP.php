<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePIP extends Model
{
    use HasFactory;
    protected $table = 'employee_pip';
    protected $primaryKey = 'pip_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'manager_id',
        'pip_from',
        'pip_to',
        'review_date',
        'improvement_required',
        'action_required',
        'needed_resource',
        'target_date',
        'recommendations',
        'manager_comments',
        'employee_comments',
        'employee_acknowledgement',
        'employee_acknowledgement_date',
        'manager_approve',
        'manager_approve_date',
        'hr_approve',
        'hr_approve_date'
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

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'user_id');
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
