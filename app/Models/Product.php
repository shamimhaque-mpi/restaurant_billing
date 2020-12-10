<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	
	protected $fillable = [
		'title', 'slug', 'category_id', 'description', 'image', 'purchase_price', 'regular_sale_price', 'discount', 'total_sale', 'status'
	];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
