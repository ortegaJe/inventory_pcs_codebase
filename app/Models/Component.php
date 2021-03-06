<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    //public $timestamps = false;

    protected $casts = [
        'handset' => 'boolean',
        'power_adapter' => 'boolean',
    ];
}
