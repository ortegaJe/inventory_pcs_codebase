<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AdminSignature extends Model
{
    use HasFactory;

    protected $fillable = ['imagen-firma'];

    public function getUrlPathAttribute()
    {
        return Storage::url($this->nombre_archivo);
    }
}
