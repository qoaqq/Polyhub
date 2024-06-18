<?php

namespace Modules\Ticket\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cinema\Entities\Cinema;
use Modules\Movie\Entities\Movie;
use Modules\Room\Entities\Room;
use Modules\Seat\Entities\Seat;
use Modules\ShowingRelease\Entities\ShowingRelease;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id','seat_id','room_id','cinema_id','showing_release_id','time_start'
    ];
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    public function seat(){
        return $this->belongsTo(Seat::class,'seat_id');
    }
    public function room(){
        return $this->belongsTo(Room::class,'room_id');
    }
    public function movie(){
        return $this->belongsTo(Movie::class,'movie_id');
    }
    public function cinema(){
        return $this->belongsTo(Cinema::class,'cinema_id');
    }
    public function showingrelease(){
        return $this->belongsTo(ShowingRelease::class,'showing_release_id');
    }
    protected static function newFactory()
    {
        return \Modules\Ticket\Database\factories\TicketFactory::new();
    }
    // tìm kiếm
    public function scopeSearchByTimeStart($query, $term)
    {
        // if (preg_match('/^\d{2}:\d{2}$/', $search)) {
        //     return $query->whereTime('time_start', $search);
        // }
        // return $query;
        if ($term) {
            $term = '%' . $term . '%';
            $query->whereHas('movie', function ($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('seat', function ($query) use ($term) {
                $query->where('column', 'like', $term);
            })
            ->orWhereHas('room', function ($query) use ($term) {
                $query->where('name', 'like', $term);
            })
            ->orWhereHas('cinema', function ($query) use ($term) {
                $query->where('name', 'like', $term);
            });
        }
    }
    
    // lọc
    public function scopeFilterByShowingRelease($query, $showingReleaseId)
    {
        if ($showingReleaseId) {
            return $query->where('showing_release_id', $showingReleaseId);
        }
        return $query;
    }
}
