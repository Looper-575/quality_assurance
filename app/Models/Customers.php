<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customers extends  Model{

    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';


    protected $fillable = [
        'disposition_id',
        'name',
        'email',
        'service_address',
        'primary_number',
        'alternate_numbers',
        'added_by'
    ];


    public function customer_notes(){
        return $this->hasMany(CustomerNotes::class, 'customer_id' , 'customer_id');
    }
}