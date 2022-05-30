<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleComments extends Model
{
    protected $table = 'module_comments';
    protected $primaryKey = 'id';
    const CREATED_AT = 'added_on';
    const UPDATED_AT = 'modified_on';


}