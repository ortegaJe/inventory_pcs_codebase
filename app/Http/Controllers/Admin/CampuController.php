<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campu;
use App\Models\Computer;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Facades\DB;

class CampuController extends Controller
{
    public function index()
    {
        $campus = Campu::select(['description', 'slug'])
            ->orderByDesc('created_at')
            ->get();

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

    public function show(Campu $campu)
    {

        $campus = Campu::findOrFail($campu)->dd();

        return view('admin.sedes.show', compact('campus'));
    }

    public function edit(Campu $campu)
    {
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
