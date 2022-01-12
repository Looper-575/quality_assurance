<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class Holiday extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $table = 'holidays';
    protected $primaryKey = 'holiday_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title' , 'type', 'date_from', 'date_to', 'added_by' ,'modified_by', 'deleted_by',
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

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($holiday) {
            $holiday->deleted_by = Auth::user()->user_id;
            $holiday->save();
        });
    }

    public function manager()
    {
        return $this->belongsTo(User::class , 'added_by' , 'user_id');
    }
}
