<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campu;
use Illuminate\Http\Request;
use Cviebrock\EloquentSluggable\Services\SlugService;

class CampuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campus = Campu::all();

        return view('admin.sedes.index', compact('campus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.sedes.create');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Campu::class, 'slug', $request->description);

        return response()->json(['slug' => $slug]);
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

        return redirect()->route('admin.inventory.campus.create', $campu)->with('info', 'Sede creada exsitosamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
        //
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
        //
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
