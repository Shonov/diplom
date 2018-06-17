<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ProfPlatforma\Users\Models\User;

class Category extends Model
{
    protected $table = 'work_categories';
    protected $fillable = [
        'ic',
        'title'
        ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'users_work_categories');
    }
}
