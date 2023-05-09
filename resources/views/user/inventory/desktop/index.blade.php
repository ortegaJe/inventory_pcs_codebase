@extends('layouts.backend')

@section('title', 'Equipos ' .Str::title($deviceType->type_name))

@section('css')
<link href="{{ asset('/css/datatables/datatable.inventory.pc.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.css') }}">

@section('content')
<!-- Page Content -->
<div class="col-md-12">
  @include('user.partials.cards')
  <!-- Add Product -->
{{--   <div class="row gutters-tiny mb-2">
    <div class="col-md-6 col-xl-2">
      <a class="block block-rounded block-link-shadow" href="{{ route('user.inventory.desktop.create') }}">
        <div class="block-content block-content-full block-sticky-options">
          <div class="block-options">
            <div class="block-options-item">
            </div>
          </div>
          <div class="py-20 text-center">
            <div class="font-size-h2 font-w700 mb-3 text-success">
              <i class="fa fa-plus"></i>
            </div>
            <div class="font-size-sm font-w600 text-uppercase text-muted">Nuevo equipo</div>
          </div>
        </div>
      </a>
    </div>
  </div> --}}
  <!-- End Add Product -->
  <!-- Partial Table -->
  <div class="block block-rounded block-bordered">
    <div class="block-header block-header-default border-b">
      <h3 class="block-title">
        Equipos informáticos<small> | Lista</small>
      </h3>
      <div class="block-options">
        <button type="button" class="btn btn-alt-success" data-toggle="tooltip" data-placement="top" title="Nuevo equipo {{ Str::lower($deviceType->type_name) }}"
          onclick="window.location='{{ route('user.inventory.desktop.create') }}'">
          <i class="fa fa-plus"></i>
        </button>
        <button type="button" class="btn btn-alt-primary" id="btn-refresh1" data-toggle="tooltip" data-placement="top" title="Actualizar lista">
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
              <th>UBICACION</th>
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
<!-- End Partial Table -->
@include('user.partials.table_deleted')
<!-- End Page Content -->
@endsection

@push('js')
<script src="{{ asset('/js/datatables/datatable.inventory.pc.js') }}"></script>
<script src="{{ asset('/js/pages/be_tables_datatables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
  let root_url_desktop = <?php echo json_encode(route('user.inventory.desktop.index')) ?>;
  let root_url_desktop_store = <?php echo json_encode(route('user.inventory.desktop.store')) ?>;    
</script>

@if(Session::has('pc_created'))
<script>
  Swal.fire(
            'Creado con Exito!',
            '{!! Session::get('pc_created') !!}',
            'success'
            )
</script>
@endif

@if(Session::has('info_error'))
<script>
  Swal.fire(
            'Ha Ocurrido Un Error Al Crear El Equipo!',
            '{!! Session::get('info_error') !!}',
            'warning'
            )
</script>
@endif

@if(Session::has('pc_updated'))
<script>
  Swal.fire(
            'Actualizado con Exito!',
            '{!! Session::get('pc_updated') !!}',
            'success'
            )
</script>
@endif
@endpush