<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Campu;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    const DOMAIN_NAME = ['DOMAIN.LOCAL', 'TEMPORALES.LOCAL'];
}
