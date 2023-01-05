<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Allowance extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'allowances';
    protected $primaryKey = 'allowance_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'department_id', 'role_id', 'type', 'bench_mark_type', 'provider', 'bench_mark_criteria', 'bench_mark_value', 'allowance_value', 'added_by' ,'modified_by', 'status'
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

    public function department()
    {
        return $this->belongsTo(Department::class , 'department_id' , 'department_id');
    }
}
