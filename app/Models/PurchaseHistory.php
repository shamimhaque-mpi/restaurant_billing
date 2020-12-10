<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseHistory extends Model
{
	
	protected $fillable = [
		'purchase_item_id', 'price', 'quantity', 'unit', 'purchase_date', 'description', 'voucher', 'status'
	];

    public function purchase_item()
    {
        return $this->belongsTo(PurchaseItem::class);
    }
}