<?php

namespace Modules\SeatShowtimeStatus\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeatShowtimeStatus extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'seat_showtime_status';

    protected $fillable = [
        'seat_id',    'showtime_id',    'showtime_id',

    ];

    public $timestamp = true;
}
