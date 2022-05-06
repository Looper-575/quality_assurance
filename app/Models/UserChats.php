<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserChats extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'chats';
    protected $primaryKey = 'chat_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = null;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'to_user',
        'from_user',
        'msg',
        'attachment',
        'added_by',
        'msg_read',
        'status',
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
    ];
}
