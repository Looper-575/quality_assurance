<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class SideMenu extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'side_menus';
    protected $primaryKey = 'id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title' , 'url', 'icon', 'parent_id', 'sort_order', 'added_by' ,'modified_by',
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

    public function parent()
    {
        return $this->belongsTo(SideMenu::class ,  'parent_id');
    }

    public function children()
    {
        return $this->hasMany(SideMenu::class , 'parent_id');
    }

    public function menu_permission()
    {
        return $this->hasOne(RolePermission::class , 'menu_id', 'id');
    }
}
