<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orderList extends Model
{
    protected $fillable = ['user_name','plan','price','cash_back','duration','order_code'];
}
