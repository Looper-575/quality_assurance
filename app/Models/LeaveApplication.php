<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class LeaveApplication extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'leave_applications';
    protected $primaryKey = 'id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'from' , 'to', 'half_type' , 'attachement' , 'no_leaves' ,'reason' ,
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
        'added_on' => 'datetime',
        'modified_on' => 'datetime',
    ];

    public  function leaveType()
    {
        return $this->belongsTo(LeaveType::class , 'leave_type_id' , 'leave_type_id');
    }


}
