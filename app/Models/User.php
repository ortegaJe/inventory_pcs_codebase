<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNameAttribute()
    {
        return ucwords($this->attributes['name']);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = strtolower($value);
    }

    public function setMiddleNameAttribute($value)
    {
        $this->attributes['middle_name'] = strtolower($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = strtolower($value);
    }

    public function setSecondLastNameAttribute($value)
    {
        $this->attributes['second_last_name'] = strtolower($value);
    }

    public function setNickNameAttribute($value)
    {
        $this->attributes['nick_name'] = strtolower($value);
    }

    public function setSexAttribute($value)
    {
        $this->attributes['sex'] = strtolower($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    protected function setPasswordAttribute($password)
    {
        $this->attributes['password'] = hash::make($password);
    }

    //Relacion uno a uno
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    //Relacion uno a muchos
    public function campus()
    {
        return $this->hasMany(CampuUser::class);
    }

    public function scopeSearchUser($query, $data)
    {
        if (trim($data) != "") {
            return $query->where((DB::raw("CONCAT(users.name,' ',users.last_name)")), 'LIKE', "%$data%")
                ->orWhere((DB::raw("CONCAT(users.name,users.last_name)")), 'LIKE', "%$data%")
                ->orWhere((DB::raw("CONCAT(users.last_name,' ',users.name)")), 'LIKE', "%$data%")
                ->orWhere((DB::raw("CONCAT(users.last_name,users.name)")), 'LIKE', "%$data%")
                ->orWhere('users.last_name', 'LIKE', "%$data%")
                ->orWhere('users.cc', 'LIKE', "%$data%");
        }
    }

    public function scopeWithPrincipalCampu($query)
    {
        return $query->join('campu_users', 'users.id', '=', 'campu_users.user_id')
            ->join('campus', 'campu_users.campu_id', '=', 'campus.id')
            ->where('campu_users.is_principal', true)
            ->orderBy('users.id', 'desc')
            ->paginate(8);
    }
}
