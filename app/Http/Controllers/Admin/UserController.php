<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:admin.inventory.tecnicos.index')->only('index');
        //$this->middleware('can:admin.inventory.tecnicos.index')->only('create', 'store');
        $this->middleware('can:admin.inventory.tecnicos.index')->only('edit', 'update');
        $this->user = new User();
        $this->campu_user = new CampuUser();
        $this->profile_user = new ProfileUser();
    }

    public function index(Request $request)
    {
        $searchUsers = $request->get('search');

        $users = User::select('users.id', 'users.name', 'users.last_name')
            ->where('users.is_active', true)
            ->whereNotIn('users.id', [1])
            ->searchUser($searchUsers)
            ->withPrincipalCampu();

        return view('admin.users.index', compact('users'));
    }

    public function autoCompleteSearchUser(Request $request)
    {
        $queryName = $request->get('search');

        $filterResult = User::where('name', 'LIKE', '%' . $queryName . '%')->get();

        return response()->json($filterResult);
    }

    public function create()
    {
        $profiles = DB::table('profiles')->select('id', 'name')->get();
        $campus = DB::table('campus')->select('id', 'name')->get();

        return view('admin.users.create', compact('profiles', 'campus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cc' => 'required|unique:users,cc',
            'lastname' => 'required|unique:users,last_name',
            'nickname' => 'required|unique:users,nick_name',
            'birthday' => 'nullable|date',
            'campu' => 'required|numeric',
            'profile' => 'required|numeric',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'sign' => 'image'
        ]);

        $file_sign = $request->file('sign')->store('firma_tecnicos');
        $profile_user = $request->profile;
        $campu_user =  $request->campu;
        $is_principal = true;

        /*         try {
            $this->user->cc = $request->cc;
            $this->user->name = $request->firstname;
            $this->user->middle_name = $request->middlename;
            $this->user->last_name = $request->lastname;
            $this->user->second_last_name = $request->second_lastname;
            $this->user->nick_name = $request->nickname;
            $this->user->birthday = $request->birthday;
            $this->user->sex = $request->sex;
            $this->user->phone_number = $request->phone;
            $this->user->avatar = null;
            $this->user->sign = $url;
            $this->user->email = $request->email;
            $this->user->password = Hash::make($request['password']);
            $this->user->created_at = now('America/Bogota');
            $this->profile->profile_id = $profile_user;
            $this->campu->campu_id = $campu_user;
            $this->campu->is_principal = $is_principal;
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error' . $e]);
        }
        return response()->json([
            'message' => 'Success',
            'user' => $this->user,
            'campu' => $this->campu,
            'profile' => $this->profile
        ]); */

        DB::insert(
            "CALL SP_createUsers (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
            [
                $this->user->cc = $request->cc,
                $this->user->name = $request->firstname,
                $this->user->middle_name = $request->middlename,
                $this->user->last_name = $request->lastname,
                $this->user->second_last_name = $request->second_lastname,
                $this->user->nick_name = $request->nickname,
                $this->user->birthday = $request->birthday,
                $this->user->sex = $request->sex,
                $this->user->phone_number = $request->phone,
                $this->user->avatar = null,
                $this->user->sign = $file_sign,
                $this->user->email = $request->email,
                $this->user->password = Hash::make($request['password']),
                $this->user->created_at = now('America/Bogota'),
                $this->profile_user->profile_id = $profile_user,
                $this->campu_user->campu_id = $campu_user,
                $this->campu_user->is_principal = $is_principal,
            ]
        );

        return redirect()->route('admin.inventory.technicians.index')
            ->with('user_created', 'Usuario creado con éxito!');
    }

    public function show($id)
    {
        $roles = Role::all();
        $profiles = DB::table('profiles')->select('id', 'name')->get();
        $campus = DB::table('campus')->select('id', 'name')->get();

        $principalCampuUser = DB::table('campus as c')
            ->join('campu_users as cp', 'cp.campu_id', 'c.id')
            ->join('users as u', 'u.id', 'cp.user_id')
            ->where('cp.is_principal', 1)
            ->where('u.id', $id)
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
                'u.sign'
            )
            ->join('profile_users as pu', 'pu.user_id', 'u.id')
            ->join('profiles as p', 'p.id', 'pu.profile_id')
            ->join('campu_users as cp', 'cp.user_id', 'u.id')
            ->join('campus as c', 'c.id', 'cp.campu_id')
            ->where('u.id', $id)
            ->get();
        //return ($dataUsers);

        $data = [
            'users' => User::findOrFail($id),
            'dataUsers' => $dataUsers,
            'profiles' => $profiles,
            'roles' => $roles,
            'campus' => $campus,
            'principalCampuUser' => $principalCampuUser,
        ];

        return view('admin.users.show')->with($data);
    }

    public function showProfileUser($id)
    {
        $roles = Role::all();
        $profiles = DB::table('profiles')->select('id', 'name')->get();
        $campus = DB::table('campus')->select('id', 'name')->get();

        $principalCampuUser = DB::table('campus as c')
            ->join('campu_users as cp', 'cp.campu_id', 'c.id')
            ->join('users as u', 'u.id', 'cp.user_id')
            ->where('cp.is_principal', 1)
            ->where('u.id', $id)
            ->select('c.id as SedeID')
            ->first();

        $dataUsers = DB::table('users as u')
            ->select(
                'u.id as UserID',
                'c.id as SedeID',
                'p.name as CargoTecnico',
                'c.name as SedeTecnico',
                'cp.is_principal as SedePrincipal'
            )
            ->join('profile_users as up', 'up.id', 'u.id')
            ->join('profiles as p', 'p.id', 'up.profile_id')
            ->join('campu_users as cp', 'cp.user_id', 'u.id')
            ->join('campus as c', 'c.id', 'cp.campu_id')
            ->where('u.id', $id)
            ->get();

        $data = [
            'users' => User::findOrFail($id),
            'dataUsers' => $dataUsers,
            'profiles' => $profiles,
            'roles' => $roles,
            'campus' => $campus,
            'principalCampuUser' => $principalCampuUser,
        ];

        //dd($data);

        return view('user.profiles.show')->with($data);
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
            ->where('campu_id', '=', $campuId)
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
        $updatedProfile = DB::table('profile_users')->where('user_id', $id)->update($update);

        //$profileUsersTemp[] = DB::table('user_profiles')->where('user_id', $id)->get();

        //return response()->json($profileUsersTemp);

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

            $softDeletePc = array(
                'password' => $passwordDisabled,
                'updated_at' => $ts,
                'deleted_at' => $ts,
                'is_active' => false
            );
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
