<?php

namespace Modules\Bill\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\TicketSeat\Entities\TicketSeat;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'checkin_id',
        'grand_total'
    ];

    public function ticketSeats()
    {
        return $this->hasMany(TicketSeat::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // protected static function newFactory()
    // {
    //     return \Modules\Bill\Database\factories\BillFactory::new();
    // }
}
