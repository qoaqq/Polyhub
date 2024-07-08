<?php

namespace Modules\Category\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Movie\Entities\Movie;

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

    public function movies() {
        return $this->hasMany(Movie::class);
    }


    public function allMovies()
    {
        $categoryIds = $this->getDescendantIds($this->id);
        // Thêm category hiện tại vào danh sách các category
        $categoryIds[] = $this->id;
        // Lấy tất cả các movies thuộc các category này
        return Movie::whereIn('category_id', $categoryIds)->get();
    }
}
