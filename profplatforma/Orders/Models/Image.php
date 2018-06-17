<?php

namespace ProfPlatforma\Orders\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public $timestamps = false;
    protected $table = 'photos';
    protected $fillable = [
        'photo'
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'photo_id');
    }}
