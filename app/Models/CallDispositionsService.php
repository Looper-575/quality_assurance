<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CallDispositionsService extends Authenticatable
{
    use HasFactory, Notifiable;

            protected $table = 'call_dispositions_services';
            protected $primaryKey = 'service_id';
            const CREATED_AT = 'added_on';
            const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

        protected $fillable = [

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
        'modified_on' => 'datetime',
        'added_on' => 'datetime',
    ];




    public function call_disposition(){
       return $this->belongsTo(CallDisposition::class, 'call_id', 'call_id' );
    }

}
