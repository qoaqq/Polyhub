<?php

namespace Modules\Checkin\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Checkin extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'checkin_code',
        'type'
    ];
    
    // protected static function newFactory()
    // {
    //     return \Modules\Checkin\Database\factories\CheckinFactory::new();
    // }
}
