<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';

    protected $categories;

    protected $fillable = ['name', 'category_id'];

    public function children() {
        return $this->hasMany(Category::class, 'category_id');
    }

public function parent() {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // protected static function newFactory()
    // {
    //     return \Modules\Category\Database\factories\CategoryFactory::new();
    // }
}
