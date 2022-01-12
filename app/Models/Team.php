<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Team extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'teams';
    protected $primaryKey = 'team_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'team_lead_id',
        'department_id',
        'shift_id',
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
    public function team_lead()
    {
        return $this->belongsTo(User::class, 'team_lead_id', 'user_id');
    }

    public function team_type()
    {
        return $this->belongsTo(Department::class, 'department_id', 'department_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id', 'shift_id');
    }

    public function team_member()
    {
        return $this->hasMany(TeamMember::class, 'team_id', 'team_id');
    }

    public function added_by_user()
    {
        return $this->belongsTo(User::class, 'added_by', 'user_id');
    }

    public function modified_by_user()
    {
        return $this->belongsTo(User::class, 'modified_by', 'user_id');
    }

}
