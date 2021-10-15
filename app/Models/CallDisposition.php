<?php

namespace App\Models;

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
        'was_mobile_pitched', 'fiscal_month', 'customer_name', 'service_address' , 'phone_number', 'email',
        'initial_bill', 'monthly_bill' , 'confirmation_number' , 'order_confirmation_number', 'order_number',
        'installation_date', 'installation', 'new_phone_number', 'mobile_lines'
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

    public function user(){
        return $this->belongsTo(User::class, 'added_by' , 'user_id');
    }

}
