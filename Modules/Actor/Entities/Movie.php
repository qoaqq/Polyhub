<?php

namespace Modules\Actor\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Movie extends Model
{
    use HasFactory;
    protected $table = 'movies';

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\Actor\Database\factories\MovieFactory::new();
    }
}
