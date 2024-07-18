<?php

namespace Modules\SeatShowtimeStatus\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Seat\Entities\Seat;

class SeatShowtimeStatus extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'seat_showtime_status';

    protected $fillable = [
        'seat_id',    'showtime_id',    'status',

    ];

    public function seat(){
        return $this->belongsTo(Seat::class);
    }

    public $timestamp = true;
}
