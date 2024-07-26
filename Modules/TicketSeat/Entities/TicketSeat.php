<?php

namespace Modules\TicketSeat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketSeat extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\TicketSeat\Database\factories\TicketSeatFactory::new();
    }
}
