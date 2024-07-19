<?php

namespace Modules\ShowingRelease\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\Seat\Entities\Seat;
use Modules\SeatShowtimeStatus\Entities\SeatShowtimeStatus;
use Modules\Ticket\Entities\Ticket;

class ShowingRelease extends Model
{
    use HasFactory;

    protected $fillable = ['movie_id',
    'room_id',
    'time_release',
    'date_release'];
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected static function newFactory()
    {
        return \Modules\ShowingRelease\Database\factories\ShowingReleaseFactory::new();
    }
    public function room(){
        return $this->belongsTo(Room::class,'room_id');
    }
    public function movie(){
        return $this->belongsTo(Movie::class,'movie_id');
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'showing_release_id');
    }

    public function seatShowtimeStatuses()
    {
        return $this->hasMany(SeatShowtimeStatus::class,'showtime_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($showingRelease) {
            $showingRelease->tickets()->each(function ($ticket) {
                $ticket->delete();
            });
        });
    }


    public function scopeSearch($query, $search)
    {
        if ($search) {
            // if (preg_match('/^\d{2}:\d{2}$/', $search)) {
            //     $query->whereTime('time_release', $search);
            // } elseif (preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $search)) {
            //     $formattedDate = \Carbon\Carbon::createFromFormat('d/m/Y', $search)->format('Y-m-d');
            //     $query->whereDate('date_release', $formattedDate);
            // }
            $search = '%' . $search . '%';
            $query->whereHas('movie', function ($query) use ($search) {
                $query->where('name', 'like', $search);
            })
            ->orWhereHas('room', function ($query) use ($search) {
                $query->where('name', 'like', $search);
            });       
        }
        return $query;
    }
}
