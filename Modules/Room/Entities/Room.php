<?php

namespace Modules\Room\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cinema\Entities\Cinema;

class Room extends Model
{
    use HasFactory;

    protected $table = "rooms";

    protected $fillable = ['name', 'cinema_id'];

    public function cinema(){
        return $this->belongsTo(Cinema::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\Room\Database\factories\RoomFactory::new();
    }
}
