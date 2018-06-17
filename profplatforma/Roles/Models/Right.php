<?php

namespace ProfPlatforma\Roles\Models;

use Illuminate\Database\Eloquent\Model;

class Right extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title'
    ];
}