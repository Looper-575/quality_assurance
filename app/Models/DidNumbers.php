<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DidNumbers extends Model
{
    use HasFactory;

    protected $table = 'call_dispostions_did_numbers';
    protected $primaryKey = 'id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';


    public function disposition_did(){

        return $this->hasOne(CallDispositionsDid::class,'did_id','did_id');
    }
}
