<?php

namespace Modules\City\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Cinema\Entities\Cinema;

class City extends Model
{
    use HasFactory;


    protected $table = 'cities';
    protected $fillable = ['name'];

    public function cinemas(){
        return $this->hasMany(Cinema::class);
    }
    
    protected static function newFactory()
    {
        return \Modules\City\Database\factories\CityFactory::new();
    }
}
