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
  <div class="row gutters-tiny mb-2">
    <div class="col-md-6 col-xl-2">
      <a class="block block-rounded block-link-shadow" href="{{ route('user.inventory.allinone.create') }}">
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
  </div>
  <!-- END Add Product -->
  <!-- Partial Table -->
  <div class="block block-rounded block-bordered">
    <div class="block-header block-header-default border-b">
      <h3 class="block-title">
        Lista<small> | Equipos informaticos</small>
      </h3>
      <div class="block-options">
        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle"
          data-action-mode="demo">
          <i class="si si-refresh"></i>
        </button>
        <button type="button" class="btn-block-option">
          <i class="si si-wrench"></i>
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
              <th>
                <img class="img-fluid" width="80px" src="https://go.anydesk.com/_static/img/logos/anydesk-logo.svg"
                  alt="anydesk">
              </th>
              <th>sede</th>
              <th>estado</th>
              <th>acciones</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th></th>
              <th>FECHA DE CREACIÓN</th>
              <th>nombre de equipo</th>
              <th>ubicacion</th>
              <th>SERIAL</th>
              <th>ACTIVO FIJO</th>
              <th>IP</th>
              <th>MAC</th>
              <th>
                <img class="img-fluid" width="80px" src="https://go.anydesk.com/_static/img/logos/anydesk-logo.svg"
                  alt="anydesk">
              </th>
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
<script src="{{ asset('/js/datatables/datatable.inventory.aio.js') }}"></script>
<script src="{{ asset('/js/pages/be_tables_datatables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

@if(Session::has('pc_created'))
<script>
  Swal.fire(
'Creado con Exito!',
'{!! Session::get('pc_created') !!}',
'success'
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

<script>
  let root_url_allinone = <?php echo json_encode(route('user.inventory.allinone.index')) ?>;
  let root_url_allinone_store = <?php echo json_encode(route('user.inventory.allinone.store')) ?>;
</script>
@endpush