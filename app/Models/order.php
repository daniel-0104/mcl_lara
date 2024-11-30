<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    protected $fillable = ['user_name','order_code','qty','total_price','status','start_date','end_date'];
}
