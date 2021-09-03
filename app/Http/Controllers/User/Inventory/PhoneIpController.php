<?php

namespace App\Http\Controllers\User\Inventory;

use App\Http\Controllers\Controller;
use App\Models\Computer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PhoneIpController extends Controller
{

    public function index()
    {
        return view('user.inventory.ip-phone.index');
    }

    public function create()
    {
        $brands = DB::table('brands')
            ->select('id', 'name')
            ->whereIn('id', [6])
            ->get();

        $campus = DB::select('SELECT DISTINCT(C.name),C.id FROM campus C
                                INNER JOIN campu_users CU ON CU.campu_id = C.id
                                INNER JOIN users U ON U.id = CU.user_id
                                WHERE U.id=' . Auth::id() . '', [1]);

        $status = DB::table('status')
            ->select('id', 'name')
            ->where('id', '<>', [4])
            ->where('id', '<>', [9])
            ->where('id', '<>', [10])
            ->get();

        $statusAssignments = DB::table('status')
            ->select('id', 'name')
            ->whereIn('id', [9, 10])
            ->get();

        $domainNames = Computer::DOMAIN_NAME;

        $data =
            [
                'brands' => $brands,
                'campus' => $campus,
                'status' => $status,
                'domainNames' => $domainNames,
                'statusAssignments' => $statusAssignments
            ];

        return view('user.inventory.ip-phone.create')->with($data);
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
