<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportDelivery extends Model
{
    use HasFactory;

    protected $fillable = [
        //'device-id',
        'custodian-name',
        'custodian-middle-name',
        'custodian-last-name',
        'custodian-second-last-name',
        'custodian-position',
        'wifi',
        'keyboard',
        'mouse',
        'webcam',
        'cover',
        'briefcase',
        'padlock',
        'power-adapter'
    ];

    public $timestamps = false;
}
