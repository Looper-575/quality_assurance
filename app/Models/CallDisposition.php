<?php

namespace App\Models;

use App\Http\Controllers\QAController;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CallDisposition extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'call_dispositions';
    protected $primaryKey = 'call_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
         'did_id' , 'recording_id' , 'disposition_type' ,'was_mobile_pitched',
         'customer_name', 'service_address' , 'phone_number', 'email',
         'installation_date', 'installation_type', 'order_confirmation_number', 'order_number', 'pre_payment',
         'account_number', 'services_sold' , 'new_phone_number', 'mobile_lines', 'comments',
         'added_by' , '	modified_by', 'mobile_work_order_number',
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

    public function call_dispositions_services(){
        return $this->hasMany(CallDispositionsService::class, 'call_id' , 'call_id');
    }

    public function call_disposition_did()
    {
        return $this->belongsTo(CallDispositionsDid::class , 'did_id' , 'did_id');
    }

    public function call_disposition_types()
    {
        return $this->belongsTo(CallDispositionsTypes::class ,  'disposition_type', 'disposition_type_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'added_by' , 'user_id');
    }

    public function qa_status(){
        return $this->hasOne(QAWithColorBadge::class, 'call_id' , 'call_id');
    }
    public function qa_assessment(){
        return $this->belongsTo(QualityAssurance::class, 'call_id' , 'call_id');
    }
}
