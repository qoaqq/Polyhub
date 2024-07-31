<?php

namespace Modules\Bill\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\TicketSeat\Entities\TicketSeat;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = ['grand_total'];

    public function ticketSeats()
    {
        return $this->hasMany(TicketSeat::class);
    }
    
    // protected static function newFactory()
    // {
    //     return \Modules\Bill\Database\factories\BillFactory::new();
    // }
}
