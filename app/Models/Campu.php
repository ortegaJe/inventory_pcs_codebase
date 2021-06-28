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
        'slug',
    ];
}
