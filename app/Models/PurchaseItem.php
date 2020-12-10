<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
	
	protected $fillable = [
		'title', 'regular_price', 'description', 'r_m_cat_id', 'status'
	];

	public function raw_material_category()
	{
		return $this->hasOne(RawMaterialCategory::class,'id','r_m_cat_id');
	}

}