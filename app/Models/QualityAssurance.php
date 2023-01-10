<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class QualityAssurance extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'quality_assessment';
    protected $primaryKey = 'qa_id';
    const CREATED_AT ='added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
        protected $fillable = [
            'rep_name', 'agent_id', 'call_date', 'call_type_id' , 'call_number','recording',
            'greetings_correct', 'greetings_assurity_statement', 'greetings_comment',
            'customer_name_call', 'customer_comment',
            'listening_skills', 'listening_comment',
            'courtesy_please', 'courtesy_thank_you','courtesy_interest', 'courtesy_empathy', 'courtesy_Apologized' , 'courtesy_comment',
            'equipment_system',  'equipment_comment',
            'soft_skills_energy', 'soft_skill_avoided_silence', 'soft_skill_polite', 'soft_skill_grammar', 'soft_skill_refrained_company', 'soft_skill_positive_words', 'soft_skills_comment',
            'using_hold_informed_customer', 'using_hold_touch' ,'using_hold_thanked', 'using_hold_comment',
            'connecting_calls_department', 'connecting_calls_customer', 'connecting_calls_comment',
            'closing_recap', 'clossing_assistance', 'closing_comment',
            'automatic_fail_misquoting','automatic_fail_disconnected', 'automatic_fail_answer', 'automatic_fail_repeating_details', 'automatic_fail_changing_details','automatic_fail_fabricating', 'automatic_fail_other', 'automatic_fail_comment',
            'additional_comment', 'yes_responses', 'no_responses', 'automatic_fail_response', 'monitor_percentage','call_id','added_by', 'modified_by'
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'modified_on' => 'datetime',
        'added_on' => 'datetime',
    ];



    public function agent()
    {
        return $this->belongsTo(User::class, 'agent_id', 'user_id');
    }

    public function call_type()
    {
        return $this->belongsTo(CallType::class, 'call_type_id' , 'call_type_id');
    }

    public function qa_status(){
        return $this->hasOne(QAWithColorBadge::class, 'qa_id' , 'qa_id');
    }

    public function call_disposition(){
        return $this->belongsTo(CallDisposition::class,'call_id','call_id');
    }

    public function qa_done_by(){
        return $this->belongsTo(User::class,'added_by','user_id');
    }

}
