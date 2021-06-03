<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
        $countCampus = DB::table('campu_users AS CP')->select('user_id')
            ->join('users AS U', 'U.id', 'CP.user_id')->count();

        //dd($countCampus);

        $users = DB::table('users AS U')
            ->select(
                'U.id AS UserID',
                DB::raw("CONCAT(U.name,' ',
                U.middle_name,' ',
                U.last_name,' ',
                U.second_last_name) AS NombreCompletoTecnico"),
                'U.nick_name AS NombreSesionTecnico',
                'P.name AS CargoUsuario',
                'C.description AS SedeTecnico',
                'U.email AS EmailTecnico',
                'U.avatar AS ImagenPerfil'
            )
            ->join('user_profiles AS UP', 'UP.id', 'U.id')
            ->join('profiles AS P', 'P.id', 'UP.profile_id')
            ->join('campu_users AS CP', 'CP.user_id', 'U.id')
            ->join('campus AS C', 'C.id', 'CP.campu_id')
            ->orderBy('U.id', 'ASC')
            //->leftJoin('model_has_roles AS MR', 'MR.model_id', 'U.id')
            //->leftJoin('roles AS R', 'R.id', 'MR.role_id')
            ->get();

        $data = [
            'users' => $users,
            'countCampus' => $countCampus,
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
        $user = new User();

        DB::insert(
            "EXEC SP_CreateUsers ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?",
            [
                //16
                $user->cc = e($request->input('tec-id')),
                $user->name = e($request->input('tec-firstname')),
                $user->middle_name = e($request->input('tec-middlename')),
                $user->last_name = e($request->input('tec-lastname')),
                $user->second_last_name = e($request->input('tec-second-lastname')),
                $user->nick_name = e($request->input('tec-nick-name')),
                $user->age = e($request->input('tec-age')),
                $user->sex = e($request->input('tec-gen')),
                $user->phone_number = e($request->input('tec-phone')),
                $user->avatar = null,
                $user->email = e($request->input('tec-email')),
                $user->password = Hash::make($request['tec-password']),
                //$user->password = e($request->input('tec-password2')),
                $user->created_at = now('America/Bogota'),
                true,
                e($request->input('val-select2-profile')),
                e($request->input('val-select2-campu')),
                //$request->all(),

            ]
        );
        return redirect()->route('admin.inventory.technicians.index')
            ->with('pc_created', 'Nuevo equipo añadido al inventario!');
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
