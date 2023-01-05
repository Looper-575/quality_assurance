<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CallDispositionsTypes extends Authenticatable
{
    use HasFactory, Notifiable;

            protected $table = 'call_dispositions_types';
            protected $primaryKey = 'disposition_type_id';
            const CREATED_AT = 'added_on';
            const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

        protected $fillable = [
            'title', 'added_by' , 'modified_by',
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

    public function call_disposition()
    {
        return $this->hasMany(CallDisposition::class , 'disposition_type','disposition_type_id');
    }
    public function added_by_user()
    {
        return $this->belongsTo(User::class, 'added_by', 'user_id');
    }
}
