<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampuUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'campu_id',
        'is_principal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
