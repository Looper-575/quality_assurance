<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class CustomerNotes extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'customer_notes';
    protected $primaryKey = 'note_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'customer_id','description','added_by','status',
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

    public function user()
    {
        return $this->belongsTo(User::class , 'added_by' , 'user_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class , 'customer_id' , 'customer_id');
    }

}
