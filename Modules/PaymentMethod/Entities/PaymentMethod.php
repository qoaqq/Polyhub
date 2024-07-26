<?php

namespace Modules\PaymentMethod\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\PaymentMethod\Database\factories\PaymentMethodFactory::new();
    }
}