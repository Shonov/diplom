<?php

namespace ProfPlatforma\Orders\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use ProfPlatforma\Users\Models\User;

class Order extends Model
{
    public $timestamps = false;

    protected $table = 'orders';
    protected $fillable = [
        'id',
        'title',
        'description',
        'address',
        'coordinates',
        'time_period',
        'start_date',
        'end_date',
        'budget_scale_id',
        'archive',
        'user_id',
        'id_request',
        'is_submited',
    ];

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function requests()
    {
        return $this->hasMany(OrderRequest::class);
    }

    public function images()
    {
        return $this->belongsTo(Image::class, 'order_id');
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class, 'budget_scale_id');

    }

    public function  getCoordinatesAttribute($value)
    {
        if (!$value) return;
        $coordinates = $pieces = explode(" ", $value);
        return [
                "lat" => $coordinates[0],
                "lng" => $coordinates[1]
        ];
    }
}