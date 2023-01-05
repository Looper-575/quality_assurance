<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class LeavesBucket extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'leaves_bucket';
    protected $primaryKey = 'bucket_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'start_date',
        'annual_leaves',
        'sick_leaves',
        'casual_leaves',
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
    protected $casts = [
        'added_on' => 'datetime',
        'modified_on' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
