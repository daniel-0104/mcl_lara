<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class info extends Model
{
    protected $fillable = [
        'home_letter',
        'service_letter',
        'service_price',
        'about_letter',
        'contact_letter',
        'contact_phone',
        'contact_email',
        'logo_image'
    ];
}
