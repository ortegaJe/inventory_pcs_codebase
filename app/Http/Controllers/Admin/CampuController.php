<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campu;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CampuController extends Controller
{
    public function index()
    {
        $campus = Campu::all();

        return view('admin.sedes.index', compact('campus'));
    }

    public function create()
    {
        return view('admin.sedes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'campu-abrev' => 'required',
            'description' => 'required',
        ]);

        $campu = new Campu();
        $campu->id = $request['campu-abrev'];
        $campu->description = $request['description'];
        $campu->created_at = now('America/Bogota');
        $campu->updated_at = null;
        //dd($campu);
        $campu->save();

        return redirect()->route('admin.inventory.campus.create', $campu)->with('info', 'Sede creada exitosamente!');
    }

    public function show($id)
    {
        $campus = Campu::findOrFail($id);

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
                'campusCount' => $campusCount,
                'campuAssigned' => $campuAssigned,
                'campuAssignedCount' => $campuAssignedCount,
            ];

        return view('admin.sedes.show')->with($data);
    }

    public function edit(Campu $campu)
    {
        return view('admin.sedes.edit', compact('campu'));
    }

    public function update(Request $request, Campu $campu)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
