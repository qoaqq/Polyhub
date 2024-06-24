<?php

namespace Modules\Room\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cinema\Entities\Cinema;
use Modules\Seat\Entities\Seat;

class Room extends Model
{
    use HasFactory;

    protected $table = "rooms";

    protected $fillable = ['name', 'cinema_id'];

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\Room\Database\factories\RoomFactory::new();
    }
}
