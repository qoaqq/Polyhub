<?php

namespace Modules\RankMember\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class RankMember extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'rank',
        'min_points',
    ];
    
    protected static function newFactory()
    {
        // return \Modules\RankMember\Database\factories\RankMemberFactory::new();
    }
}
