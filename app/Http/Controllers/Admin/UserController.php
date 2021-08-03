<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.inventory.tecnicos.index')->only('index');
        //$this->middleware('can:admin.inventory.tecnicos.index')->only('create', 'store');
        $this->middleware('can:admin.inventory.tecnicos.index')->only('edit', 'update');
    }
    public function index()
    {
        $countCampus = DB::table('campu_users AS CP')->select('user_id')
            ->join('users AS U', 'U.id', 'CP.user_id')->count();

        /*$users = User::all();

        dd($users);*/

        $users = DB::table('users AS U')
            ->select(
                'U.id AS UserID',
                DB::raw("CONCAT(U.name,' ',
                U.last_name) AS NombreCompletoTecnico"),
                'U.nick_name AS NombreSesionTecnico',
                'P.name AS CargoUsuario',
                'C.name AS SedeTecnico',
                'U.email AS EmailTecnico',
                'U.avatar AS ImagenPerfil'
            )
            ->join('user_profiles AS UP', 'UP.id', 'U.id')
            ->join('profiles AS P', 'P.id', 'UP.profile_id')
            ->join('campu_users AS CP', 'CP.user_id', 'U.id')
            ->join('campus AS C', 'C.id', 'CP.campu_id')
            ->where('CP.is_principal', 1)
            ->where('U.is_active', 1)
            ->orderBy('U.id', 'ASC')
            //->leftJoin('model_has_roles AS MR', 'MR.model_id', 'U.id')
            //->leftJoin('roles AS R', 'R.id', 'MR.role_id')
            ->get();

        $data = [
            'users' => $users,
            'countCampus' => $countCampus,
        ];

        return view('admin.users.index')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profiles = DB::table('profiles')->select('id', 'name')->get();
        $campus = DB::table('campus')->select('id', 'name')->get();


        $data = [
            'profiles' => $profiles,
            'campus' => $campus,
        ];

        return view('admin.users.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cc' => 'required|unique:users,cc',
            'firstname' => 'required|unique:users,name',
            'lastname' => 'required|unique:users,last_name',
            'nickname' => 'required|unique:users,nick_name',
            'birthday' => 'nullable|date',
            'val-select2-campu' => 'required|numeric',
            'val-select2-profile' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'password' => 'required'
        ]);

        $user = new User();
        $isActive = true;
        $profileUser = e($request->input('val-select2-profile'));
        $campuUser =  e($request->input('val-select2-campu'));
        $is_principal = true;

        DB::insert(
            "CALL SP_createUsers (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [
                //16
                $user->cc = e($request->input('cc')),
                $user->name = e($request->input('firstname')),
                $user->middle_name = e($request->input('middlename')),
                $user->last_name = e($request->input('lastname')),
                $user->second_last_name = e($request->input('second-lastname')),
                $user->nick_name = e($request->input('nickname')),
                $user->birthday = e($request->input('birthday')),
                $user->sex = e($request->input('sex')),
                $user->phone_number = e(trim($request->input('phone'))),
                $user->avatar = null,
                $user->email = e($request->input('email')),
                $user->password = Hash::make($request['password']),
                $user->created_at = now('America/Bogota'),
                $isActive,
                $profileUser,
                $campuUser,
                $is_principal,

            ]
        );

        //dd($user);

        return redirect()->route('admin.inventory.technicians.index')
            ->with('pc_created', 'Nuevo equipo añadido al inventario!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $profiles = DB::table('profiles')->select('id', 'name')->get();

        $principalCampuUser = DB::table('campus as c')
            ->join('campu_users as cp', 'cp.campu_id', 'c.id')
            ->join('users as u', 'u.id', 'cp.user_id')
            ->where('cp.is_principal', 1)
            ->where('u.id', $id)
            ->select('c.id as SedeID')
            ->first();

        $campus = DB::table('campus')->select('id', 'name')->get();


        $dataUsers = DB::table('users as u')
            ->select(
                'u.id as UserID',
                'c.id as SedeID',
                'p.name as CargoUsuario',
                'c.name as SedeTecnico',
                'cp.is_principal as SedePrincipal'
            )
            ->join('user_profiles as up', 'up.id', 'u.id')
            ->join('profiles as p', 'p.id', 'up.profile_id')
            ->join('campu_users as cp', 'cp.user_id', 'u.id')
            ->join('campus as c', 'c.id', 'cp.campu_id')
            ->where('u.id', $id)
            //->orderBy('u.id', 'asc')
            //->leftJoin('model_has_roles AS MR', 'MR.model_id', 'U.id')
            //->leftJoin('roles AS R', 'R.id', 'MR.role_id')
            ->get();


        $data = [
            'users' => User::findOrFail($id),
            'dataUsers' => $dataUsers,
            'profiles' => $profiles,
            'campus' => $campus,
            'principalCampuUser' => $principalCampuUser,
        ];

        //dd($data);

        return view('admin.users.show')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $profileUser = e($request->get('val-select2-profile'));

        $campuUser =  e($request->get('val-select2-campu'));

        $request->validate([
            'val-select2-campu' => 'required|numeric',
            'val-select2-profile' => 'required|numeric',
        ]);

        $this->validate(
            request(),
            ['cc' => ['required', 'unique:users,cc,' . $id]],
            ['firstname' => ['required', 'unique:users,name,' . $id]],
            ['lastname' => ['required', 'unique:users,last_name,' . $id]],
            ['nickname' => ['required', 'unique:users,nick_name,' . $id]],
            ['email' => ['required', 'unique:users,email,' . $id]],
            ['password' => ['required,' . $id]]

        );

        DB::beginTransaction();

        try {
            DB::insert(
                "CALL SP_updateUsers (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                [
                    //14
                    $user->cc = e($request->get('cc')),
                    $user->name = e($request->get('firstname')),
                    $user->middle_name = e($request->get('middlename')),
                    $user->last_name = e($request->get('lastname')),
                    $user->second_last_name = e($request->get('second-lastname')),
                    $user->nick_name = e($request->get('nick-name')),
                    $user->birthday = e($request->get('birthday')),
                    $user->sex = e($request->get('sex')),
                    $user->phone_number = e($request->get('phone')),
                    $user->avatar = null,
                    $user->email = e($request->get('email')),
                    //$user->password = Hash::make($request['password']),
                    $user->updated_at = now('America/Bogota'),
                    $profileUser,
                    $campuUser,
                    $id,
                ]
            );

            DB::commit();
            return back()->with('info_success', 'Usuario ' . Str::upper($user->name) . " " . Str::upper($user->last_name) .
                ' actualizado con exito!');
        } catch (\Throwable $e) {
            DB::rollback();
            //return back()->with('info_error', 'Upss! se ha producido un error');
            throw $e;
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'password' => 'required|confirmed'
        ];

        $message = [
            'password.required' => 'Por favor escriba una contraseña.',
            'password.confirmed' => 'Las contraseñas no coinciden.'
        ];

        $validator = Validator::make($request->all(), $rules, $message);
        if ($validator->fails()) :
            return back()->withErrors($validator)->with(
                'message',
                'Se ha producido un error:'
            )->with(
                'typealert',
                'danger'
            );
        else :
            $pass = $request->get('password');
            if ($pass != null) {
                $user->password = Hash::make($request->get('password'));
            } else {
                unset($user->password);
            }

            if ($user->save()) :
                return back()->withErrors($validator)
                    ->with('update-message', 'Contraseña actualizada');
            endif;
        endif;
    }

    public function editRol($id)
    {
        //$user = User::where('id', $id)->get();
        $user = User::findOrFail($id);
        //dd($id);

        $roles = Role::all();
        //dd($roles);

        return view('admin.users.edit', ['user' => $user, 'roles' => $roles]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateRol(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->roles()->sync($request['rol']);

        return back()->with('info', 'Se asignarón los roles correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $users = null;
        $userTemp = [];
        $ts = now('America/Bogota')->toDateTimeString();
        //error_log(__LINE__ . __METHOD__ . ' pc --->' .$id);
        try {

            $users = User::findOrFail($id);

            $userTemp[] = DB::table('users')->where('id', $id)->get();

            $softDeletePc = array('deleted_at' => $ts, 'is_active' => false);
            $users = DB::table('users')->where('id', $id)->update($softDeletePc);

            error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($users, true));
        } catch (ModelNotFoundException $e) {
            // Handle the error.
        }

        return response()->json([
            'message' => 'Usuario removido exitosamente!',
            'result' => $userTemp[0]
        ]);
    }
}
