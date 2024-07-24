<?php

namespace Modules\BillDetail\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BillDetail extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function details()
    {
        $this->hasMany(BillDetail::class);
    }
    
    // protected static function newFactory()
    // {
    //     return \Modules\BillDetail\Database\factories\BillDetailFactory::new();
    // }
}
