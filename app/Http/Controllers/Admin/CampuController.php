<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCampuRequest;
use App\Models\Campu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampuController extends Controller
{
    public function index()
    {
        $campus = Campu::all();
        $users = User::get(['id', 'name', 'last_name']);
        //dd($users);

        return view('admin.sedes.index', compact('campus', 'users'));
    }

    public function create()
    {
        return view('admin.sedes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'abreviature' => 'required',
            'name' => 'required',
        ]);

        $campu = Campu::create($request->all());

        return redirect()->route('admin.inventory.campus.index', $campu)->with('info', 'Sede creada exitosamente! ' . $campu->name);
    }

    public function show($id)
    {
        $campus = Campu::findOrFail($id);

        $typeDevices = DB::table('computers as pc')
            ->leftJoin('type_devices as td', 'td.id', 'pc.type_device_id')
            ->select(
                DB::raw("COUNT(pc.type_device_id) AS numberTypeDevice"),
                'td.name as nameTypeDevice',
                'pc.campu_id as SedeId'
            )
            ->where('pc.campu_id', $id)
            ->groupBy('pc.type_device_id', 'td.name', 'pc.campu_id')
            ->get();
        //dd($typeDevices);

        $campusCount = DB::table('computers')
            ->select('campu_id')
            ->where('campu_id', $id)
            ->count();

        $campusCount = DB::table('computers')
            ->select('campu_id')
            ->where('campu_id', $id)
            ->count();

        $getIdUserByCampus = DB::table('campu_users')
            ->select('user_id')
            ->where('campu_id', $id)
            ->first();

        $campuAssignedCount = DB::table('campu_users')
            ->select(DB::raw("campu_id,user_id,COUNT(user_id) AS NumberCampus"))
            ->where('campu_id', $id)
            ->orWhere('user_id', ($getIdUserByCampus) ? $getIdUserByCampus->user_id : 0)
            ->count();

        //dd($campuAssignedCount);

        $campuAssigned = DB::table('campus AS C')
            ->select(
                'C.id AS SedeID',
                'C.name AS NombreSede',
                DB::raw("CONCAT(U.name,' ',
                U.last_name) AS NombreCompletoTecnico"),
                'P.name AS CargoTecnico',
                'U.email AS EmailTecnico'
            )
            ->leftJoin('campu_users AS CU', 'CU.campu_id', 'C.id')
            ->leftJoin('users AS U', 'U.id', 'CU.user_id')
            ->join('user_profiles AS UP', 'UP.id', 'U.id')
            ->join('profiles AS P', 'P.id', 'UP.profile_id')
            ->where('CU.campu_id', $id)
            ->get();

        $data =
            [
                'campus' => $campus,
                'typeDevices' => $typeDevices,
                'campusCount' => $campusCount,
                'campuAssigned' => $campuAssigned,
                'campuAssignedCount' => $campuAssignedCount,
            ];

        return view('admin.sedes.show')->with($data);
    }

    public function edit($id)
    {
        return view('admin.sedes.edit', compact('campu'));
    }

    public function update(Request $request, Campu $campu)
    {
        //$campu = Campu::findOrFail($id);

        $campu->update($request->all());

        return redirect()->route(
            'admin.inventory.campus.show'
            //$campu->name
        )->with('info', 'Sede actualizada con exito!');
    }

    public function destroy($id)
    {
        //
    }
}
