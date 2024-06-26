<?php

namespace Modules\Seat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Room\Entities\Room;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = ['row', 'column','status', 'type', 'room_id'];

    public function room(){
        return $this->belongsTo(Room::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\Seat\Database\factories\SeatFactory::new();
    }
}
