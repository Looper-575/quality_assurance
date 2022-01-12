<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Policy extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'policies';
    protected $primaryKey = 'policy_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'added_by' ,'modified_by', 'status',
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

    public function policy_files()
    {
        return $this->hasMany(PolicyFile::class, 'policy_id', 'policy_id');
    }
}
