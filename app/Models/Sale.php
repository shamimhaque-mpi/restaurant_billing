<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'admin_id','customer_name','customer_mobile','given_money','total_price','total_product', 'discount', 'discount_2', 'vat', 'pickdate', 'is_order', 'total_price_after_discount', 'total_due', 'table_no'
    ];
}