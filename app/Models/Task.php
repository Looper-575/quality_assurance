<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Notifications\Notifiable;

class Task extends Model
{


    protected $table = 'tasks';
    protected $primaryKey = 'task_id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'title', 'added_by' , 'description' , 'start_date','end_date','assigned_to'
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

    public function  users(){
        return $this->belongsTo(User::class,'assigned_to','user_id');
    }
    public function  project(){
        return $this->belongsTo(Project::class,'project_id','id');
    }
    public function department(){
        return $this->belongsTo(Department::class,'department_id','department_id');
    }

}
