<?php

namespace Modules\Movie\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Director\Entities\Director;

class Movie extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['name', 'description', 'duration', 'premiere_date', 'director_id'];
    
    protected static function newFactory()
    {
        return \Modules\Movie\Database\Factories\MovieFactory::new();
    }

    public function director()
    {
        return $this->belongsTo(Director::class);
    }
}
