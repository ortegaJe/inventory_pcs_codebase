<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Campu;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    const DESKTOP_PC_ID = 1;
    const TURNERO_PC_ID = 2;
    const LAPTOP_PC_ID = 3;
    const RASPBERRY_PI_ID = 4;
    const ALL_IN_ONE_PC_ID = 5;

    const EQUIPOS_ESCRITORIOS = 'DE ESCRITORIO';
    const EQUIPOS_TURNEROS = 'TURNERO';
    const EQUIPOS_PORTATILES = 'PORTATIL';
    const EQUIPOS_RASPBERRY = 'RASPBERRY';
    const EQUIPOS_ALL_IN_ONES = 'ALL IN ONE';

    const DOMAIN_NAME = ['DOMAIN.LOCAL', 'TEMPORALES.LOCAL'];

    public function scopeCountPc($query, $id)
    {
        return $query->select('type_device_id')
            ->where('type_device_id', $id)
            ->where('is_active', [1])
            ->where('deleted_at', null)
            ->count();
    }

    //public $timestamps = false;
}
