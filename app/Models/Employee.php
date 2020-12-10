<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $fillable = ['name', 'mobile', 'nid_no', 'designation', 'per_address', 'pre_address', 'salary', 'photo'];
}
