<?php

namespace Modules\Cinema\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cinema extends Model
{
    use HasFactory;

    protected $fillable = ['name',
    'rate_point',
   'city_id'];
    
    protected static function newFactory()
    {
        return \Modules\Cinema\Database\factories\CinemaFactory::new();
    }
}
