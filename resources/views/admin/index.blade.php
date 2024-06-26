@extends('layouts.backend')

@section('title', 'Admin Dashboard')

@section('css')
<link href="{{ asset('/css/datatables/datatable.inventory.pc.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.css') }}">

@section('content')
<!-- Page Content -->
<div class="row gutters-tiny mb-2">
  <!-- Total equipos de escritorios -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="si si-screen-desktop fa-2x text-info-light"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-info" data-toggle="countTo" data-to="{{ $globalDesktopCount }}">0
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">de escritorios</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Total equipos de escritorios -->

  <!-- All In One -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="fa fa-desktop fa-2x text-elegance-lighter"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-elegance-light" data-toggle="countTo"
            data-to="{{ $globalAllInOneCount }}">0</div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">all in one</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END All In One -->

  <!-- Portatiles -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="fa fa-laptop fa-2x text-flat-lighter"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-flat" data-toggle="countTo" data-to="{{ $globalLaptopCount }}">
            0
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">portátiles</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Portatiles -->

  <!-- Turnero -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="fa fa-ticket fa-2x text-danger-light"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-danger" data-toggle="countTo"
            data-to="{{ $globalTurneroCount }}">0</div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">Turneros</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Turnero -->

  <!-- Raspberry PI -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <img width="30px" src="{{ asset('media/various/raspberry-pi-0.svg') }}" alt="raspberry-pi.svg">
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0" style="color: #c51d4a" data-toggle="countTo"
            data-to="{{ $globalRaspberryCount }}">0
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">raspberry</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Raspberry PI -->

  <!-- Telefonos IP -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="fa fa-phone fa-2x text-warning-light"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-warning" data-toggle="countTo"
            data-to="{{ $globalIpPhoneCount }}">0
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">Telefonos IP</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Telefonos IP -->
</div>
<div class="col-md-14">
  <div class="block block-rounded block-bordered">
    <div class="block-header block-header-default border-b">
      <h3 class="block-title">
        Lista<small> | Equipos informaticos</small>
      </h3>
      <div class="block-options">
        <button type="button" class="btn btn-alt-danger" data-toggle="tooltip" data-placement="left"
          title="Descargar Mantenimientos" onclick="showMultiSelect()">
          <i class="fa fa-file-pdf-o"></i>
        </button>
        <button type="button" class="btn btn-alt-success" data-toggle="tooltip" data-placement="left"
          title="Descargar Inventario" onclick="window.location='{{ route('admin.inventory.export-all-computers') }}'">
          <i class="fa fa-file-excel-o"></i>
        </button>
        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle"
          data-action-mode="demo">
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
              <th>
                <img class="img-fluid" width="80px" src="https://go.anydesk.com/_static/img/logos/anydesk-logo.svg"
                  alt="anydesk">
              </th>
              <th>sede</th>
              <th>estado</th>
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
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('js')
<script src="{{ asset('/js/datatables/datatable.inventory.js') }}"></script>
<script src="{{ asset('/js/pages/be_tables_datatables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/js/download.admin.mto.js') }}"></script>

<script>
  let root_url_dashboard = <?php echo json_encode(route('admin.inventory.dash.index')) ?>;
</script>
@endpush