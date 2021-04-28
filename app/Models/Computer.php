<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Computer extends Model
{
    use HasFactory, SoftDeletes;

    const DESKTOP_PC_ID = 1;
    const ALL_IN_ONE_PC_ID = 3;

    public $timestamps = false;
}
