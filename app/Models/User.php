<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
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

    //Relacion uno a muchos
    public function profiles()
    {
        return $this->hasMany(Profile::class);
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
        return $query->leftJoin('campu_users', 'users.id', 'campu_users.user_id')
            ->leftJoin('campus', 'campu_users.campu_id', 'campus.id')
            //->leftJoin('department_campu as dc', 'dc.campu_id', 'campus.id')
            //->leftJoin('departments as d', 'd.id', 'dc.department_id')
            ->where('campu_users.is_principal', 1)
            ->where('users.is_active', 1)
            ->whereNotIn('users.id', [1])
            ->orderByDesc('users.created_at')
            ->paginate(8);
    }

    public function scopeCampuWithDeparment($query)
    {
    }
}
