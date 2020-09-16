<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Work extends Base
{
    public $fillable = ['userid', 'work_start', 'work_end', 'work_time', 'work_extra', 'createDate'];

}
