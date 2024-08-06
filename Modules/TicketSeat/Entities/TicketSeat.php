<?php

namespace Modules\TicketSeat\Entities;

use Modules\Bill\Entities\Bill;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketSeat extends Model
{
    use HasFactory;

    protected $fillable = [
        'seat_id',
        'bill_id',
        'movie_id',
        'room_id',
        'cinema_id',
        'showing_release_id',
        'time_start',
        'price',
        'seat_showtime_status_id'];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function seat_show_time()
    {
        
    }
    
    // protected static function newFactory()
    // {
    //     return \Modules\TicketSeat\Database\factories\TicketSeatFactory::new();
    // }
}
