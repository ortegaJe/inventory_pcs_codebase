<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class TechnicianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('model_has_roles AS MR')
            ->select(
                'U.id AS UserID',
                DB::raw("CONCAT(U.name,' ',
                U.middle_name,' ',
                U.last_name,' ',
                U.second_last_name) AS NombreCompletoTecnico"),
                'U.nick_name AS NombreSesionTecnico',
                'P.name AS CargoUsuario',
                'R.guard_name AS RolUsuario',
                'U.email AS EmailTecnico',
                'U.avatar AS ImagenPerfil'
            )
            ->leftJoin('users AS U', 'U.id', 'MR.model_id')
            ->leftJoin('roles AS R', 'R.id', 'MR.role_id')
            ->leftJoin('user_profiles AS UP', 'UP.user_id', 'MR.model_id')
            ->leftJoin('profiles AS P', 'P.id', 'MR.model_id')
            ->get();

        $data = [
            'users' => $users,
        ];

        return view('admin.technicians.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profiles = DB::table('profiles')->select('id', 'name')->get();
        $campus = DB::table('campus')->select('id', 'description')->get();


        $data = [
            'profiles' => $profiles,
            'campus' => $campus,
        ];

        return view('admin.technicians.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //$user = User::where('id', $id)->get();
        $user = User::findOrFail($id);
        //dd($id);

        $roles = Role::all();

        return view('admin.technicians.edit', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->roles()->sync($request['rol']);

        return redirect()->route('admin.inventory.technicians.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
