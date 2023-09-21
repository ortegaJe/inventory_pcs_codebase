<?php

namespace App\Http\Controllers\User\Inventory;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDevice;
use App\Models\Component;
use App\Models\Device;
use App\Models\TypeDevice;
use Faker\Provider\Uuid;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TabletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     private $generatorID;

     public function __construct()
     {
         $this->generatorID = Helper::IDGenerator(new Device(), 'inventory_code_number', 8, 'PC');
     }
     
     public function index(Request $request)
     {
         $globalDesktopCount     = TypeDevice::countTypeDeviceUser(TypeDevice::DESKTOP_PC_ID, Auth::id());
         $globalTurneroCount     = TypeDevice::countTypeDeviceUser(TypeDevice::TURNERO_PC_ID, Auth::id());
         $globalLaptopCount      = TypeDevice::countTypeDeviceUser(TypeDevice::LAPTOP_PC_ID, Auth::id());
         $globalRaspberryCount   = TypeDevice::countTypeDeviceUser(TypeDevice::RASPBERRY_PI_ID, Auth::id());
         $globalAllInOneCount    = TypeDevice::countTypeDeviceUser(TypeDevice::ALL_IN_ONE_PC_ID, Auth::id());
         $globalIpPhoneCount     = TypeDevice::countTypeDeviceUser(TypeDevice::IP_PHONE_ID, Auth::id());
         $globalMiniPcSatCount   = TypeDevice::countTypeDeviceUser(TypeDevice::MINIPC_SAT_ID, Auth::id());
         $globalTabletCount   = TypeDevice::countTypeDeviceUser(TypeDevice::TABLET_ID, Auth::id());
         $deviceType             = TypeDevice::select('name as type_name')->where('id', TypeDevice::TABLET_ID)->first();
 
         if ($request->ajax()) {
 
             $devices = DB::table('view_all_devices')
                 ->where('TipoPc', TypeDevice::EQUIPOS_TABLET)
                 ->where('TecnicoID', Auth::id())
                 ->get();
 
             $datatables = DataTables::of($devices);
             $datatables->addColumn('EstadoPC', function ($devices) {
                 //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($devices->EstadoPC, true));
                 return $devices->EstadoPc;
             });
 
             $datatables->addColumn('action', function ($devices) {
                 //error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($devices->DeviceID, true));
                 /*$btn = "<a type='button' class='btn btn-sm btn-secondary' id='btn-edit' 
                             href = '" . route('minipc.edit', $devices->DeviceID) . "'>
                                 <i class='fa fa-pencil'></i>
                         </a>";*/
                 $btn = "<button type='button' class='btn btn-sm btn-secondary' data-id='$devices->DeviceID' id='btn-delete'>
                                     <i class='fa fa-times'></i>";
                 return $btn;
             });
             $datatables->rawColumns(['action', 'EstadoPC']);
             return $datatables->make(true);
         }
 
         $data =
             [
                 'deviceType'            => $deviceType,
                 'globalDesktopCount'    => $globalDesktopCount,
                 'globalTurneroCount'    => $globalTurneroCount,
                 'globalLaptopCount'     => $globalLaptopCount,
                 'globalRaspberryCount'  => $globalRaspberryCount,
                 'globalAllInOneCount'   => $globalAllInOneCount,
                 'globalIpPhoneCount'    => $globalIpPhoneCount,
                 'globalMiniPcSatCount'  => $globalMiniPcSatCount,
                 'globalTabletCount'     => $globalTabletCount,
             ];
 
         return view('user.inventory.tablet.index')->with($data);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = DB::table('brands')
            ->select('id', 'name')
            ->whereIn('id',[8])
            ->get();

        $operatingSystems = DB::table('operating_systems')
            ->select('id', 'name', 'version', 'architecture')
            ->whereIn('id', [13])
            ->get();

        $memoryRams = DB::table('memory_rams')
            ->select('id','size','storage_unit','type')
            ->whereIn('id', [1,9])
            ->get();

        $storages = DB::table('storages')
        ->select('id', 'size','storage_unit')
        ->whereIn('id',[1,34])
        ->get();

        $processors = DB::table('processors')
            ->select('id', 'brand', 'generation', 'velocity')
            ->where('id', '=', 80)
            ->get();

        $campus = DB::table('campus as c')
            ->join('campu_users as cu', 'cu.campu_id', 'c.id')
            ->join('users as u', 'u.id', 'cu.user_id')
            ->where('cu.user_id', Auth::id())
            ->distinct('c.name')
            ->select('c.name', 'c.id')
            ->get();

        $status = DB::table('status')
            ->select('id', 'name')
            ->where('id', '<>', [4])
            ->where('id', '<>', [9])
            ->where('id', '<>', [10])
            ->where('id', '<>', [11])
            ->get();

        $statusAssignments = DB::table('status')
            ->select('id', 'name')
            ->whereIn('id', [9, 10])
            ->get();

        $domainNames = Device::DOMAIN_NAME;

        $data =
            [
                'operatingSystems'  => $operatingSystems,
                'memoryRams'        => $memoryRams,
                'storages'          => $storages,
                'brands'            => $brands,
                'processors'        => $processors,
                'campus'            => $campus,
                'status'            => $status,
                'domainNames'       => $domainNames,
                'statusAssignments' => $statusAssignments
            ];

        return view('user.inventory.tablet.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDevice $request)
    {
        $userId = Auth::id();

        $validator = Validator::make($request->all(),$rules = [], $messages = []);
        if ($validator->fails()) :
            return back()->withErrors($validator)
                ->withInput()
                ->with(
                    'message',
                    'Revisar campos! :-('
                )->with(
                    'modal',
                    'error'
                );
        else :
            Device::insert([            
                'inventory_code_number'     => $this->generatorID,
                'type_device_id'            => TypeDevice::TABLET_ID,
                'brand_id'                  => $request->brand,
                'model'                     =>  $request->model,
                'fixed_asset_number'        => $request->activo_fijo,
                'serial_number'             => $request->serial,
                'ip'                        => $request->ip,
                'mac'                       => $request->mac,
                'nat'                       => null,
                'domain_name'               => $request->domain_name,
                'device_name'               => $request->device_name,
                'anydesk'                   => null,
                'campu_id'                  => $request->campu,
                'location'                  => $request->location,
                'statu_id'                  => $request->statu,
                'custodian_assignment_date' => $request->custodian_date,
                'custodian_name'            => $request->custodian_name,
                'assignment_statu_id'       => $request->statu_assignment,
                'observation'               => $request->observation,
                'rowguid'                   => Uuid::uuid(),
                'created_at'                => now('America/Bogota'),
                'is_stock'                  => $request->has('stock'),
            ]);
        
            $lastIdDevice = Device::latest()->pluck('id')->first();
            Component::insert([            
                'device_id'         => $lastIdDevice,
                'os_id'             => $request->os,
                'slot_one_ram_id'   => $request->ram0,
                'slot_two_ram_id'   => $request->ram1,
                'first_storage_id'  => $request->hdd0,
                'second_storage_id' => $request->hdd1,
                'processor_id'      => $request->processor,
                'handset'           => null,
                'power_adapter'     => null,
            ]);

            $data = Device::select(
                'id',
                'custodian_name',
                'assignment_statu_id',
                'custodian_assignment_date',
                'statu_id',
                'location',
                'observation',
                'created_at'
                )
            ->where('id', $lastIdDevice)
            ->first();

            DB::table('statu_devices')->insert(
                array(
                    'device_id'   => $lastIdDevice,
                    'statu_id'    => $data->statu_id,
                    'date_log'    => $data->created_at, 
                )
            );

            DB::table('device_log')->insert(
                array(
                    'user_id'    => $userId,
                    'device_id'  => $lastIdDevice,
                    'created_at' => $data->created_at,
                )
            );

            DB::table('custodian_log')->insert(
                array(
                    'device_id'             => $lastIdDevice,
                    'custodian_name'        => $data->custodian_name,
                    'assignment_statu_id'   => $data->assignment_statu_id,
                    'assignment_date'       => $data->custodian_assignment_date,
                    'location'              => $data->location,
                    'observation'           => $data->observation, 
                )
            );

        endif;

        return redirect()->route('tablet.index')
            ->withErrors($validator)
    ->with('device_created', 'Nuevo equipo añadido al inventario! ','');
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
        $devices = null;
        $deviceTemp = [];
        //error_log(__LINE__ . __METHOD__ . ' pc --->' .$id);
        try {
            $devices = Device::findOrFail($id);

            $deviceTemp[] = DB::table('devices')->where('id', $id)->get();

            $ts = now('America/Bogota')->toDateTimeString();
            //$softDeletePc = array('deleted_at' => $ts, 'is_active' => false, 'statu_id' => 4);
            $softDeleteDevice = array('is_active' => false);
            $devices = DB::table('devices')->where('id', $id)->update($softDeleteDevice);
            error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($devices, true));

            $statu_id = DB::table('devices')->select('statu_id')->where('id', $id)->first();

            $deleteStatu = array('statu_id' => $statu_id->statu_id, 'device_id' => $id, 'date_log' => $ts);
            $devices = DB::table('statu_devices')->where('device_id', $id)->insert($deleteStatu);
            error_log(__LINE__ . __METHOD__ . ' pc --->' . var_export($devices, true));

            $deviceLogDelete = array('device_id' => $id, 'user_id' => Auth::id(), 'deleted_at' => $ts);
            $devices = DB::table('device_log')->where('device_id', $id)->insert($deviceLogDelete);
        } catch (ModelNotFoundException $e) {
            // Handle the error.
        }

        return response()->json([
            'message' => 'Equipo eliminado del inventario exitosamente!',
            'result' => $deviceTemp[0]
        ]);
    }
}
