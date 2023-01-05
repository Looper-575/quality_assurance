<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class AttendanceLog extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'attendance_log';
    protected $primaryKey = 'attendance_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id' , 'time_in', 'time_out' , 'late', 'on_leave', 'applied_leave', 'half_leave', 'absent', 'attendance_date', 'added_by', 'modified_by',
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

    public function manager()
    {
        return $this->belongsTo(User::class , 'added_by' , 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'user_id');
    }

    public function leave()
    {
        return $this->belongsTo(LeaveApplication::class , 'user_id' , 'added_by');
    }

}
