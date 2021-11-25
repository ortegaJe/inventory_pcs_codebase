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

    const DOMAIN_NAME = ['DOMAIN.LOCAL', 'TEMPORALES.LOCAL'];

    public function scopeSearchRemove($query, $data)
    {
        if (trim($data) != "") {
            return $query->where('devices.serial_number', 'LIKE', "%$data%")
                ->where('devices.statu_id', 5);
        }
    }

    public function scopeSearch($query, $data)
    {
        if (trim($data) != "") {
            return $query->where('devices.serial_number', 'LIKE', "%$data%")
                ->whereIn('devices.statu_id', [1, 2, 3, 5, 6, 7, 8]);
        }
    }
}
