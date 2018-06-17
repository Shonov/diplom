<?php

namespace ProfPlatforma\Orders\Models;

use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    public $timestamps = false;

    protected $table = 'budget_scale';
    protected $fillable = [
        'id',
        'interval'
    ];
    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
