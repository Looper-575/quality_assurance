<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'user_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name',
        'email',
        'password',
        'gender',
        'city',
        'contact_number',
        'remember_token',
        'vicidialer_id',
        'role_id',
        'postal_address',
        'vendor_did_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'added_on' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(UserRole::class, 'role_id', 'role_id');
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id', 'user_id');
    }

    public function manager_users()
    {
        return $this->hasMany(User::class, 'manager_id', 'user_id');
    }

    public function user_team()
    {
        return $this->hasOne(Team::class, 'team_lead_id', 'user_id')->where('status',1);
    }

    public function team_member()
    {
        return $this->hasOne(TeamMember::class, 'user_id', 'user_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'user_id');
    }
    public function LeavesBucket()
    {
        return $this->hasOne(LeavesBucket::class, 'user_id', 'user_id');
    }
}
