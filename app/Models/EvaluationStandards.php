<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationStandards extends Model
{
    use HasFactory;
    protected $table = 'employee_evaluation_standards';
    protected $primaryKey = 'eval_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'added_by',
        'assessment_id',
        'user_id',
        'remarker_id',
        'discipline',
        'punctuality',
        'work_dedication',
        'performance',
        'peer_behaviour',
        'customer_handling',
        'customer_service',
        'job_knowledge',
        'technical_application',
        'efficiency',
        'dependability',
        'communication',
        'team_work',
        'decision_making',
        'problem_solving',
        'adaptability',
        'independence',
        'initiative',
        'supervision',
        'quality_of_work',
        'quantity_of_work',
        'organization_planning',
        'productivity',
        'reliability',
        'attitude',
        'coaching',
        'leadership',
        'WOW',
        'last_eval_objectives_achieved'
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
    public function evaluation_standards()
    {
        return $this->belongsTo(EvaluationStandards::class, 'assessment_id', 'id');
    }
}
