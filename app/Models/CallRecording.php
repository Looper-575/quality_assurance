<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CallRecording extends Model
{
    use HasFactory;

    protected $table = 'call_recordings';
    protected $primaryKey = 'rec_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';


    protected $fillable = [
        'from', 'to' , 'uid', 'agent_id','disposed'
    ];


    public function did_numbers(){
        return $this->hasOne(DidNumbers::class,'number_id','to_number');
    }
    public function user(){
        return $this->hasOne(User::class, 'vicidialer_id' , 'agent_id');
    }
}
