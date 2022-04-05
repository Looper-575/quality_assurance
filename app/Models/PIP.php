<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PIP extends Model
{
    use HasFactory;
    protected $table = 'performance_improvement_plans';
    protected $primaryKey = 'pip_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'staff_id',
        'om_id',
        'pip_from',
        'pip_to',
        'review_date',
        'improvement_required',
        'action_required',
        'needed_resource',
        'target_date',
        'recommendations',
        'om_comments',
        'staff_comments',
        'staff_acknowledgement',
        'staff_acknowledgement_date',
        'om_approve',
        'om_approve_date',
        'hrm_approve',
        'hrm_approve_date'
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

    public function operation_manager()
    {
        return $this->belongsTo(User::class, 'om_id', 'user_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id', 'user_id');
    }
}
