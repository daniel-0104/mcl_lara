<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class project extends Model
{
    protected $fillable = [
        'name',
        'type',
        'project_permission',
        'paragraph1',
        'paragraph2',
        'project_duration',
        'website_link',
        'price_letter',
        'tutorial_video',
        'images'
    ];

    protected $casts = ['images' => 'array'];
}
