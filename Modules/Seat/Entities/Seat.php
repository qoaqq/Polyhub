<?php

namespace Modules\Seat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = ['row', 'column','status', 'type'];
    
    protected static function newFactory()
    {
        return \Modules\Seat\Database\factories\SeatFactory::new();
    }
}
