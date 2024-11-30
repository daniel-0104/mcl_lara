<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pricePlan extends Model
{
    protected $fillable = [
        'title',
        'price',
        'time',
        'project_permission',
        'cash_back',
        'description'
    ];
}
