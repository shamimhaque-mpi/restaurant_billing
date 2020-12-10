<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DueCollection extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $fillable = [
        'sale_id', 'date', 'payment'
    ];


    /*
    * relationship
    */
    public function sale()
    {
    	return $this->hasOne(Sale::class,'id','sale_id'); 
    }

}