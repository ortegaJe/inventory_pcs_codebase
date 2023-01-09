<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Campu;
use Illuminate\Support\Facades\DB;

class Device extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    const DOMAIN_NAME = ['DOMAIN.LOCAL', 'TEMPORALES.LOCAL'];

    public function scopeSearchRemove($query, $data)
    {
        if (trim($data) != "") {
            return $query->where('devices.serial_number', 'LIKE', "%$data%")
                ->whereIn('devices.statu_id', [2, 3, 5, 6, 7]);
        }
    }

    public function scopeSearch($query, $data)
    {
        if (trim($data) != "") {
            return $query->where('devices.serial_number', 'LIKE', "%$data%")
                ->whereIn('devices.statu_id', [1, 2, 3, 5, 6, 7, 8]);
        }
    }

    public function scopeRestoreDevice($query, $user_id)
    {
        return $query->select(
            'devices.id',
            'devices.serial_number',
            'c.name as campu',
            DB::raw("CASE WHEN devices.is_active=false THEN 'eliminado' END AS is_deleted"),
            DB::raw("CASE WHEN devices.is_active=false THEN 'badge-danger' END AS color"),
        )
            ->leftJoin('campus as c', 'c.id', 'devices.campu_id')
            ->leftJoin('campu_users as cu', 'cu.campu_id', 'c.id')
            ->leftJoin('users as u', 'u.id', 'cu.user_id')
            ->leftJoin('status as s', 's.id', 'devices.statu_id')
            ->where('u.id', $user_id)
            ->where('devices.is_active', false)
            ->get();
    }

    public function Component()
    {
        return $this->hasOne(Component::class);
    }
}
