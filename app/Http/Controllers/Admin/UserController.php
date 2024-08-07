<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Models\Campu;
use App\Models\CampuUser;
use App\Models\Computer;
use App\Models\Profile;
use App\Models\ProfileUser;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Faker\Factory as Faker;
use Faker\Provider\Uuid;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    protected $faker;
    protected $user;

    public function __construct()
    {
        $this->middleware('can:admin.inventory.tecnicos.index')->only('index');
        //$this->middleware('can:admin.inventory.tecnicos.index')->only('create', 'store');
        $this->middleware('can:admin.inventory.tecnicos.index')->only('edit', 'update');
        $this->user = new User();
        $this->campu_user = new CampuUser();
        $this->profile_user = new ProfileUser();
        $this->faker = Faker::create();
    }

    // Método privado para construir la consulta base de usuarios
    private function baseUserQuery()
    {
        return User::select(
            'users.id',
            'users.name',
            'users.last_name',
            'campus.name as sede',
            'regional.name as regional',
            DB::raw("CASE WHEN DATEDIFF(CURDATE(), users.created_at) <= 3 THEN 'Nuevo' ELSE 'Antiguo' END AS new_user")
        )
        ->leftJoin('campu_users', 'users.id', 'campu_users.user_id')
        ->leftJoin('campus', 'campu_users.campu_id', 'campus.id')
        ->leftJoin('regional', 'campus.regional_id', 'regional.id')
        ->where('campu_users.is_principal', 1)
        ->where('users.is_active', 1)
        ->orderBy('users.last_name');
    }

    public function index(Request $request)
    {
        $regionals = DB::table('regional')->orderBy('name')->get();
        $users = $this->baseUserQuery()->count();
        return view('admin.users.index', compact('regionals','users'));
    }

    // Método público para obtener todos los usuarios
    public function getUsers()
    {
        $users = $this->baseUserQuery()->get();
        return response()->json($users);
    }

    // Método público para obtener usuarios por regional
    public function userByRegional($id)
    {
        $users = $this->baseUserQuery()->where('regional.id', $id)->get();
        return response()->json($users);
    }

        public function autoCompleteUserSearch(Request $request)
    {
        $queryName = $request->get('search');

        $filterResult = User::select(DB::raw("UPPER(CONCAT(name,' ',last_name)) AS name"))->where('name', 'LIKE', '%' . $queryName . '%')->get();

        return response()->json($filterResult);
    }

    public function getAllUsers(Request $request)
    {
        if ($request->ajax()) {
            $users = User::select(
                'users.id as user_id',
                'campus.id as campu_id',
                'd.name as department',
                'd.town',
                'campus.name as campu',
                DB::raw("CONCAT(users.name, ' ', users.last_name) as user_name"),
                DB::raw("DATEDIFF(NOW(), users.created_at) as days"),
                DB::raw("CONCAT(CASE WHEN users.created_at BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE() THEN 'Nuevo' ELSE 'Antiguo' end) as new_user"),
                DB::raw("CASE WHEN users.is_active = 1 THEN 'Activo' WHEN users.is_active = 0 THEN 'Retirado' END AS status"),
                DB::raw("CASE WHEN users.is_active = 1 THEN 'badge-success' WHEN users.is_active = 0 THEN 'badge-danger' END AS color")
            )
                ->leftJoin('campu_users', 'users.id', 'campu_users.user_id')
                ->leftJoin('campus', 'campu_users.campu_id', 'campus.id')
                ->leftJoin('department_campu as dc', 'dc.campu_id', 'campus.id')
                ->leftJoin('departments as d', 'd.id', 'dc.department_id')
                ->where('campu_users.is_principal', 1)
                ->where('users.is_active', 1)
                ->whereNotIn('users.id', [1])
                ->orderByDesc('users.created_at');

            $datatables = DataTables::of($users);

            return $datatables->make(true);
        }

        return view('admin.users.history-user');
    }

    public function historyUser($user_id)
    {
        //$userId = User::findOrFail($user_id);

        $users = User::select([
            'users.id as user_id',
            'campus.id as campu_id',
            'd.name as department',
            'd.town',
            'campus.name as campu',
            DB::raw("CONCAT(users.name, ' ', users.last_name) as user_name"),
            DB::raw("DATEDIFF(NOW(), users.created_at) as days"),
            DB::raw("CONCAT(CASE WHEN users.created_at BETWEEN DATE_SUB(CURDATE(), INTERVAL 30 DAY) AND CURDATE() THEN 'Nuevo' ELSE 'Antiguo' end) as new_user"),
            DB::raw("CASE WHEN users.is_active = 1 THEN 'Activo' WHEN users.is_active = 0 THEN 'Retirado' END AS status"),
            DB::raw("CASE WHEN users.is_active = 1 THEN 'badge-success' WHEN users.is_active = 0 THEN 'badge-danger' END AS color"),
            DB::raw("CASE WHEN cu.is_principal = 1 THEN 'principal' WHEN cu.is_principal = 0 THEN 'secondary' END AS principal_campu")
        ])
            ->leftJoin('campu_users as cu', 'cu.user_id', 'users.id')
            ->leftJoin('campus', 'cu.campu_id', 'campus.id')
            ->leftJoin('department_campu as dc', 'dc.campu_id', 'campus.id')
            ->leftJoin('departments as d', 'd.id', 'dc.department_id')
            //->where('cu.is_principal', 1)
            ->where('users.is_active', 1)
            ->where('users.id', $user_id)
            //->whereNotIn('users.id', [1])
            //->orderByDesc('cu.is_principal')
            ->get();

        return $users;

        //return json_encode($users, JSON_PRETTY_PRINT);
    }

    public function create()
    {
        $profiles = DB::table('profiles')->select('name', 'id')->get();
        return view('admin.users.create', compact('profiles'));
    }

    public function fetchCampusDinamycDD(Request $request)
    {
        $data['campus'] = DB::table('campus')->where('profile_id', $request->profile_id)->where('is_active', true)->get(['name','id']);
        return response()->json($data);
    }

    public function store(UserFormRequest $request)
    {
        $name = substr($request->name, 0, 1);
        $lastName = $request->last_name;
        $baseNickName = Str::lower($name . $lastName);

        if (User::where('nick_name', $baseNickName)->exists()) {
            $name = substr($request->name, 0, 2);
            $lastName = $request->last_name;
            $nickName = Str::lower($name . $lastName);
            //return "The record ".$nickName. " does not exist";
        } else {
            $nickName = $baseNickName;
            //return "The record ".$baseNickName." exist";
        }

        $realPassword = $this->generateRandomPassword();

        $name = Str::lower($request->name);
        $middleName = Str::lower($request->middle_name);
        $lastName = Str::lower($request->last_name);
        $secondLastName = Str::lower($request->second_last_name);
        $email = Str::lower($request->email);

        try {
            $user = User::create([
            'cc' => $request->cc,
            'name' => $name,
            'middle_name' => $middleName,
            'last_name' => $lastName,
            'second_last_name' => $secondLastName,
            'nick_name' => $nickName,
            'birthday' => $request->birthday,
            'sex' => $request->sex,
            'phone_number' => $request->phone_number,
            'email' => $email,
            'password' => Hash::make($realPassword),
        ]);

        $profile = ProfileUser::create([
            'user_id' => $user->id,
            'profile_id' => $request->profile,
        ]);

        if($request->profile == 2)
        {
            $campu = CampuUser::create([
                'user_id' => $user->id,
                'campu_id' => $request->campu,
                'is_principal' => 1
            ]);
        }

        } catch (\Exception $e) {
            return response()->json(['message' => 'Error ' . $e->getMessage()]);
        }
        return redirect()->route('admin.inventory.technicians.index')
                            ->with('success',$user->name.' '.$user->last_name.'<br/> Usuario: '.$user->email.' <br/> Contraseña: '.$realPassword);
/*          return response()->json([
            'message' => 'Success',
            'user' => $user,
            'campu' => $campu,
            'profile' => $profile,
        ]); */
    }

    private function generateRandomPassword()
    {
        $upper = $this->faker->regexify('[A-Z]{2}');
        $lower = $this->faker->regexify('[a-z]{3}');
        $numbers = $this->faker->regexify('[0-9]{3}');
        $password = str_shuffle($upper . $lower . $numbers);
        return $password;
    }

    public function show($id)
    {
        $user = User::find($id);

        $roles = Role::all();
        $profiles = DB::table('profiles')->select('id', 'name')->get();
        $campus = DB::table('campus as a')
                        ->leftJoin('campu_users as b', 'b.campu_id', 'a.id')
                        ->select('a.id', 'a.name')
                        ->where('b.user_id', $user->id)
                        ->where('a.is_active', true)
                        ->where('b.is_active', true)
                        ->get();

        $principalCampuUser = DB::table('campus as c')
            ->join('campu_users as cp', 'cp.campu_id', 'c.id')
            ->join('users as u', 'u.id', 'cp.user_id')
            ->where('cp.is_principal', 1)
            ->where('u.id', $user->id)
            ->select('c.id as SedeID',)
            ->first();
        //return $principalCampuUser;

        $dataUsers = DB::table('users as u')
            ->select(
                'u.id as UserID',
                'c.id as SedeID',
                'p.name as CargoTecnico',
                'c.name as SedeTecnico',
                'cp.is_principal as SedePrincipal',
                'u.sign',
                'cp.is_active'
            )
            ->join('profile_users as pu', 'pu.user_id', 'u.id')
            ->join('profiles as p', 'p.id', 'pu.profile_id')
            ->join('campu_users as cp', 'cp.user_id', 'u.id')
            ->join('campus as c', 'c.id', 'cp.campu_id')
            ->where('u.id', $user->id)
            ->where('cp.is_active', true)
            ->get();
        //return $dataUsers;

        $rolesCollection = $user->roles->pluck('name');
        //return $rolesCollection;

        $data = [
            'users' => User::findOrFail($user->id),
            'dataUsers' => $dataUsers,
            'profiles' => $profiles,
            'roles' => $roles,
            'rolesCollection' => $rolesCollection,
            'campus' => $campus,
            'principalCampuUser' => $principalCampuUser,
        ];

        return view('admin.users.show')->with($data);
    }

    public function showProfileUser($id)
    {
        $users = User::findOrFail($id);

        $dataUsers = DB::table('users as u')
            ->select(
                'u.id as UserID',
                'c.id as SedeID',
                'p.name as CargoTecnico',
                'c.name as SedeTecnico',
                'cp.is_principal as SedePrincipal',
                'c.abreviature',
                'c.address',
                'c.phone'
            )
            ->join('profile_users as up', 'up.user_id', 'u.id')
            ->join('profiles as p', 'p.id', 'up.profile_id')
            ->join('campu_users as cp', 'cp.user_id', 'u.id')
            ->join('campus as c', 'c.id', 'cp.campu_id')
            ->where('u.id', $users->id)
            ->get();

            //return $dataUsers;

        $data = [
            'users' => $users,
            'dataUsers' => $dataUsers,
        ];

        //dd($data);

        return view('user.profiles.show')->with($data);
    }

    public function dropzoneUploadSignature(Request $request)
    {
        $user = Auth::user();
        //$image = $request->file('file');
        //$imageName = Uuid::uuid().'.'.$image->extension();
        $image = $request->file('file')->store('firma_tecnicos/' .$user->nick_name);

        $update = array('sign' => $image);
        User::where('id', $user->id)->update($update);
   
        return response()->json(['success'=> $image]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate(
            request(),
            ['cc' => ['required', 'unique:users,cc,' . $id]],
            ['lastname' => ['required', 'unique:users,last_name,' . $id]],
            ['nickname' => ['required', 'unique:users,nick_name,' . $id]],
            ['email' => ['required', 'email', 'unique:users,email,' . $id]]

        );

        DB::beginTransaction();

        DB::update(
            "CALL SP_updateUsers (?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [
                $this->user->cc = e($request->get('cc')),
                $this->user->name = e($request->get('firstname')),
                $this->user->middle_name = e($request->get('middlename')),
                $this->user->last_name = e($request->get('lastname')),
                $this->user->second_last_name = e($request->get('second-lastname')),
                $this->user->nick_name = e($request->get('nickname')),
                $this->user->birthday = e($request->get('birthday')),
                $this->user->sex = e($request->get('sex')),
                $this->user->phone_number = e($request->get('phone')),
                $this->user->avatar = null,
                $this->user->email = e($request->get('email')),
                $this->user->updated_at = now('America/Bogota'),
                $id,
            ]
        );
        DB::commit();
        return back()->with('updated-user-success', 'Usuario ' . Str::title($user->name) . " " . Str::title($user->last_name));
        try {
        } catch (\Throwable $e) {
            DB::rollback();
            return back()->with('info_error', '');
            throw $e;
        }
    }

/*     public function uploadUserSign(Request $request, $id)
    {
        $user_id = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'sign' => 'image'
        ]);


        if ($validator->fails()) {

            return back()->with('fail_upload_sign', '');
        } else if ($request->hasFile('sign')) {

            $user = Str::lower(Auth::user()->nick_name);
            $file_sign = $request->file('sign')->store('firma_tecnicos/' . $user);

            $update = array('sign' => $file_sign);
            User::where('id', $user_id->id)->update($update);
        }

        return back()->with('success_upload_sign', '');
    } */

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
                    ->with('updated-password-success', '');
            endif;
        endif;
    }

    public function updateCampu(Request $request, $id)
    {
        User::findOrFail($id);

        $campuId = $request->get('val-select2-change-campu');

        $update = array('is_principal' => false);

        $foundCampuId = DB::table('campu_users')
            ->select('campu_id', 'is_principal')
            ->where('campu_id', $campuId)
            ->first();

        if ($foundCampuId === null) {
            CampuUser::where('user_id', $id, 'is_principal' == true)->first(); //encuentra el usuario con sede principal
            DB::table('campu_users')->where('user_id', $id)->update($update); //actualiza la sede principal en false

            DB::table('campu_users') //inserta un nuevo registro con sede nueva y como sede principal
                ->insert(['user_id' => $id, 'campu_id' => $campuId, 'is_principal' => true]);
        } else {
            CampuUser::where('user_id', $id, 'is_principal' == true)->first(); //encuentra el usuario con sede principal
            DB::table('campu_users')->where('user_id', $id)->update($update); //actualiza la sede principal en false

            $updateNewCampu = array('campu_id' => $campuId, 'is_principal' => true); //actualiza el registro como sede principal
            DB::table('campu_users')->where('user_id', $id)->where('campu_id', $campuId)->update($updateNewCampu);
        }

        return back()->with('updated_campu_success', '');
    }

    public function updateProfile(Request $request, $id)
    {
        User::findOrFail($id);

        $profileId = $request->get('val-select2-change-profile');

        $update = array('profile_id' => $profileId);
        DB::table('profile_users')->where('user_id', $id)->update($update);

        $ts = now('America/Bogota')->toDateTimeString();
        $inactiveCampus = array('updated_at' => $ts,'is_active' => false);
        DB::table('campu_users')->where('user_id', $id)->update($inactiveCampus);

        return back()->with('updated_profile_success', '');
    }

    public function updateRol(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->roles()->sync($request['rol']);

        return back()->with('info-rol', 'Se asignarón los roles correctamente!');
    }

    public function destroy($id)
    {
        $users = null;
        $userTemp = [];
        $ts = now('America/Bogota')->toDateTimeString();
        $rand = Str::random(120);
        $passwordDisabled = bcrypt($rand);
        //error_log(__LINE__ . __METHOD__ . ' pc --->' .$id);
        try {

            $users = User::findOrFail($id);

            $userTemp[] = DB::table('users')->where('id', $id)->get();

            $softDelete = array(
                'password' => $passwordDisabled,
                'updated_at' => $ts,
                'deleted_at' => $ts,
                'is_active' => false
            );
            
            DB::table('users')->where('id', $id)->update($softDelete);

            $inactiveCampus = array(
                'updated_at' => $ts,
                'is_active' => false
            );
            
            DB::table('campu_users')->where('user_id', $id)->update($inactiveCampus);

            //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($users, true));
        } catch (ModelNotFoundException $e) {
            // Handle the error.
            return response()->json([
                'message' => $e,
            ]);
        }

        return response()->json([
            'message' => 'Usuario retirado exitosamente!',
            'result' => $userTemp[0]
        ]);
    }
}
