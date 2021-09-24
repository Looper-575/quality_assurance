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
    protected $primarykey = 'qa_id';
    const CREATED_AT ='added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

        protected $fillable = [
            'rep_name', 'call_date', 'call_type' , 'call_number', 'greetings', 'greetings_comment',
            'customer_name', 'customer_name_comment', 'listening', 'listening_comment', 'courtesy', 'courtesy_comment',
            'equipment_use',  'equipment_use_comment', 'soft_skills', ' soft_skills_comment', 'using_hold',	' using_hold_comment',
            'connecting_calls', 'connecting_calls_comment',  'closing', 'closing_comment',  'automatic_fail',' automatic_fail_comment', 
            'additional_comment', 'yes_responses', 'no_responses', 'automatic_fail_response', 'monitor_percentage',
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


}
