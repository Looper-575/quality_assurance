<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeFinalSettlement extends Model
{
    use HasFactory;

    protected $table = 'employee_final_settlement';
    protected $primaryKey = 'final_settlement_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'separation_id',
        'last_working_day',
        'length_of_service',
        'salary_paid',
        'assets_not_returned',
        'asset_deduction_amount',
        'added_by',
        'modified_by'
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
    public function employee_separation()
    {
        return $this->belongsTo(EmployeeSeparation::class, 'separation_id', 'separation_id');
    }
}
