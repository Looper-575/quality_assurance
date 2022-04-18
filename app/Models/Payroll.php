<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Payroll extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'payrolls';
    protected $primaryKey = 'payroll_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'salary_month', 'attendance_marked','attendance_not_marked', 'leaves', 'half_leaves','leaves_of_half','leaves_of_late', 'lates', 'absents', 'presents', 'basic_salary', 'gross_salary', 'status', 'hr_approved', 'added_by' ,'modified_by',
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

    public function added()
    {
        return $this->belongsTo(User::class , 'added_by' , 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'user_id');
    }

    public function payroll_deduction()
    {
        return $this->hasMany(PayrollDeductionDetail::class , 'payroll_id' , 'payroll_id');
    }

    public function payroll_allowance()
    {
        return $this->hasMany(PayrollAllowanceDetail::class , 'payroll_id' , 'payroll_id');
    }
}
