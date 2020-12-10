<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['title', 'slug', 'category_id', 'sub_category_id', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
