<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = ['title', 'slug', 'category_id', 'status'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brands()
    {
        return $this->hasMany(Brand::class);
    }
}
