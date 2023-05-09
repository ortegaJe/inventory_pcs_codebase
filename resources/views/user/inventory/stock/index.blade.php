@extends('layouts.backend')

@section('title', 'Equipos en Stock')

@section('css')
<link href="{{ asset('/css/datatables/datatable.inventory.pc.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.css') }}">

@section('content')
<!-- Page Content -->
<!-- Partial Table -->
<div class="col-md-12">
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default border-b">
            <h3 class="block-title">
                Equipos informáticos<small> | En Stock</small>
            </h3>
            <div class="block-options">
                <button type="button" id="btn-refresh1" class="btn-block-option" data-toggle="block-option"
                    data-action="state_toggle" data-action-mode="demo">
                    <i class="si si-refresh"></i>
                </button>
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table id="dt" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>fecha de creación</th>
                            <th>nombre de equipo</th>
                            <th>ubicacion</th>
                            <th>serial</th>
                            <th>activo fijo</th>
                            <th>ip</th>
                            <th>mac</th>
                            <th>anydesk</th>
                            <th>sede</th>
                            <th>estado</th>
                            <th>acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>FECHA DE CREACIÓN</th>
                            <th>NOMBRE DE EQUIPO</th>
                            <th>UBICACIÓN</th>
                            <th>SERIAL</th>
                            <th>ACTIVO FIJO</th>
                            <th>IP</th>
                            <th>MAC</th>
                            <th>ANYDESK</th>
                            <th>SEDE</th>
                            <th>ESTADO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<script src="{{ asset('/js/datatables/datatable.inventory.stock.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    let root_url_stock = <?php echo json_encode(route('get.stock')) ?>;
  let root_url_desktop_store = <?php echo json_encode(route('user.inventory.desktop.store')) ?>;    
</script>
@endpush