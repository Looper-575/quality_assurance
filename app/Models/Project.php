<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends  Model
{
    protected $table = 'projects';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';


    protected $fillable = [
        'title',
    ];
}
