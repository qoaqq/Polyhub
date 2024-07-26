<?php

namespace Modules\TicketFoodCombo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketFoodCombo extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\TicketFoodCombo\Database\factories\TicketFoodComboFactory::new();
    }
}
