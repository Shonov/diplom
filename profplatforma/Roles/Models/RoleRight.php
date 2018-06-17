<?php

namespace ProfPlatforma\Roles\Models;

use App\Module;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RoleRight extends Pivot
{
    public $incrementing = false;
    public $timestamps = false;
    protected $primaryKey = null;
    protected $table = 'role_rights';
    protected $with = [
        'module',
        'right',
    ];

    protected $fillable = [
        'module_id',
        'right_id',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function right()
    {
        return $this->belongsTo(Right::class);
    }

    public function role()
    {
        return $this->hasOne(Role::class);
    }
}
