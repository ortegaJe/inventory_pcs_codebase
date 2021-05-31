<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Computer extends Model
{
    use HasFactory, SoftDeletes;

    const DESKTOP_PC_ID = 1;
    const TURNERO_PC_ID = 2;
    const LAPTOP_PC_ID = 3;
    const RASPBERRY_PI_ID = 4;
    const ALL_IN_ONE_PC_ID = 5;

    public function scopeCountPc($query, $id)
    {
        return $query->select('type_device_id')
            ->where('type_device_id', $id)
            ->where('is_active', [1])
            ->where('deleted_at', null)
            ->count();
    }

    public $timestamps = false;
}
