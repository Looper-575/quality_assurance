<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeCompanyReference extends Model
{
    use HasFactory;
    protected $table = 'employee_company_reference';
    protected $primaryKey = 'id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id',
        'reference_id',
        'relation',
        'name',
        'email',
        'company_name',
        'position',
        'contact_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [ ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'added_on' => 'datetime',
    ];
    public function employees(){
        return $this->belongsTo(EmployeeCompanyReference::class, 'employee_id' , 'employee_id');
    }
    public function user(){
        return $this->belongsTo(User::class, 'reference_id' , 'user_id');
    }
}
