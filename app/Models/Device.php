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

    public function scopeSearch($query, $data)
    {
        if (trim($data) != "") {
            return $query->where('serial_number', 'LIKE', "%$data%")
                ->where('statu_id', 5);
        }
    }

    //Relacion uno a muchos inversa
    public function campu()
    {
        return $this->belongsTo(Campu::class);
    }

    //Relacion uno a uno
    public function component()
    {
        return $this->hasOne(Component::class);
    }
}
