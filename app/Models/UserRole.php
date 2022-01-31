<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserRole extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user_roles';
    protected $primaryKey = 'role_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'added_by',
        'modified_by',

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


    public function role()
    {
        return $this->hasMany(User::class, 'role_id', 'role_id');
    }

    public function added_by_user()
    {
        return $this->belongsTo(User::class, 'added_by', 'user_id');
    }

    public function modified_by_user()
    {
        return $this->belongsTo(User::class, 'modified_by', 'user_id');
    }

    public function role_permission()
    {
        return $this->hasMany(RolePermission::class, 'role_id', 'role_id');
    }
}
