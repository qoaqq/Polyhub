<?php

namespace Modules\TicketFoodCombo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketFoodCombo extends Model
{
    use HasFactory;

    protected $fillable = [
        'food_combo_id',
        'bill_id',
        'price',
        'quantity',
    ];
    
    // protected static function newFactory()
    // {
    //     return \Modules\TicketFoodCombo\Database\factories\TicketFoodComboFactory::new();
    // }
}
