<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use App\Models\Computer;

class Campu extends Model
{
    use HasFactory; //Sluggable;

    /*public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'description'
            ]
        ];
    }*/

    protected $fillable = [
        'abreviature',
        'name',
        'address',
        'phone',
        'optional_phone',
        'slug',
    ];

    //Query Scope Sedes
    public function scopeName($query, $name)
    {
        if (trim($name) != "") {
            return $query->where('name', 'LIKE', "%$name%");
        }
    }

    //Relacion uno a muchos
    public function campuUsers()
    {
        return $this->hasMany(Profile::class);
    }
}
