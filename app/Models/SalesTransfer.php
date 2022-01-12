<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalesTransfer extends Model
{
    use HasFactory;

    protected $table = 'sale_transfer';
    public $timestamps = false;

    public  function call_disposition()
    {
        return $this->belongsTo(CallDisposition::class , 'call_id' , 'call_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'added_by' , 'user_id');
    }
    public function transferTo(){
        return $this->belongsTo(User::class, 'transfer_to' , 'user_id');
    }

}


