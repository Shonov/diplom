<?php

namespace ProfPlatforma\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use ProfPlatforma\Users\Models\User;

class OrderRequest extends Model
{
    protected $table = "order_requests";
    public $timestamps  = false;
    protected $fillable = [
        'user_id',
        'order_id',
        'status'
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}


