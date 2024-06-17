<?php

namespace Modules\Attribute\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
class Attribute extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'attributes';

    protected $fillable = [
        'id',	'movie_id',	'name',	'created_at',	'updated_at',	

    ];
    public $timestamp = true;
    protected static function newFactory()
    {
        return \Modules\Attribute\Database\factories\AttributeFactory::new();
    }
}
