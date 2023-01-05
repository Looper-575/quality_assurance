<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeSeparation extends Model
{
    use HasFactory;

    protected $table = 'employee_separation';
    protected $primaryKey = 'separation_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'effective_from',
        'reason',
        'general_comments',
        'resignation_date',
        'separation_date',
        'disable_user_account',
        'assets_list',
        'allowance_list',
        'bonus_deduction',
        'assets_returned',
        'added_by'
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
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
    public function employee_separation()
    {
        return $this->hasOne(EmployeeFinalSettlement::class, 'separation_id', 'separation_id');
    }
    public  function prepared_by()
    {
        return $this->belongsTo(User::class , 'added_by' , 'user_id');
    }
}
