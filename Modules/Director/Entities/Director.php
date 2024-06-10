<?php

namespace Modules\Director\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;


class Director extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'age',
        'date_of_birth',
    ];

    protected static function newFactory()
    {
        return \Modules\Director\Database\factories\DirectorFactory::new();
    }

    /**
     * Get the movie that the director is associated with.
     */
}
