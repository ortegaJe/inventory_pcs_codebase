<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDevice extends Model
{
    use HasFactory;

    const DESKTOP_PC_ID = 1;
    const TURNERO_PC_ID = 2;
    const LAPTOP_PC_ID = 3;
    const RASPBERRY_PI_ID = 4;
    const ALL_IN_ONE_PC_ID = 5;
    const IP_PHONE_ID = 6;
    const MINIPC_SAT_ID = 9;
    const TABLET_ID = 10;

    const EQUIPOS_ESCRITORIOS = 'DE ESCRITORIO';
    const EQUIPOS_TURNEROS = 'TURNERO';
    const EQUIPOS_PORTATILES = 'PORTATIL';
    const EQUIPOS_RASPBERRY = 'RASPBERRY';
    const EQUIPOS_ALL_IN_ONES = 'ALL IN ONE';
    const EQUIPOS_TELEFONOS_IP = 'TELEFONO IP';
    const EQUIPOS_MINIPC_SAT = 'MINI PC SAT';
    const EQUIPOS_TABLET = 'TABLET';

    public function scopeCountTypeDevice($query, $type_device_id)
    {
        return $query->select('d.type_device_id', 'd.id')
            ->leftJoin('devices as d', 'd.type_device_id', 'type_devices.id')
            ->where('d.type_device_id', $type_device_id)
            ->whereIn('d.statu_id', [1, 2, 3, 5, 6, 7, 8])
            ->count();
    }

    public function scopeCountTypeDeviceUser($query, $type_id, $user_id)
    {
        return $query->select('d.type_device_id', 'cu.user_id', 'cu.campu_id')
            ->leftJoin('devices as d', 'd.type_device_id', 'type_devices.id')
            ->leftJoin('campus as c', 'c.id', 'd.campu_id')
            ->leftJoin('campu_users as cu', 'cu.campu_id', 'c.id')
            ->leftJoin('users as u', 'u.id', 'cu.user_id')
            ->where('d.type_device_id', $type_id)
            ->where('cu.user_id', $user_id)
            //->where('cu.campu_id', $campu_id)
            ->whereIn('d.statu_id', [1, 2, 3, 5, 6, 7, 8])
            ->where('d.is_active', [1])
            ->where('d.deleted_at', null)
            ->count();
    }
}
