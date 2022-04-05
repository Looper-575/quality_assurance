<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectModule extends  Model
{
    protected $table = 'project_modules';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';


    protected $fillable = [
        'project', 'module_name' ,'description', 'dependencies','controllers','models','views','module_usage'
    ];

    public function  projects(){
        return $this->hasOne(Project::class,'id','project');
    }
    public function  users(){
        return $this->belongsTo(User::class,'added_by','user_id');
    }
}
