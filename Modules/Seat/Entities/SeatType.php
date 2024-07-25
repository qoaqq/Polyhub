<?php

namespace Modules\Seat\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SeatType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price'];
}
