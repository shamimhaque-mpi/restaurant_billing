<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class SaleResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'customer_mobile' => $this->customer_mobile,
            'total_price' => $this->total_price,
            'discount' => $this->discount,
            'total_price_after_discount' => $this->total_price_after_discount,
            'total_product' => $this->total_product,
            'given_money' => $this->given_money,
            'status' => $this->status,
            'admin' => $this->admin_id,
            'saler' => $this->saler_name,
            'order' => $this->is_order,
            'total_due' => $this->total_due,
            'table_no' => $this->table_no,
            'table_name' => $this->table_name,
            'created_at' => $this->created_at,
        ];
    }
}
