<?php

namespace Modules\Bill\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function bill()
    {
        $this->belongsTo(Bill::class);
    }
    
    // protected static function newFactory()
    // {
    //     return \Modules\Bill\Database\factories\BillFactory::new();
    // }
}
