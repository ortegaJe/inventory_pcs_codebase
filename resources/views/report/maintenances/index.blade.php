@extends('layouts.backend')

@section('title', 'Reportes')

@section('content')
<nav class="breadcrumb bg-white push">
  <a class="breadcrumb-item" href="{{ route('inventory.report.index') }}">Reportes</a>
  <span class="breadcrumb-item active">Mantenimientos</span>
</nav>
{{-- <div class="row gutters-tiny">
  <!-- Row #1 -->
  <div class="col-md-3 col-xl-2">
    <a style="cursor:default" class="block" href="javascript:void(0)">
      <div class="block-content block-content-full">
        <div class="py-20 text-center">
          <div class="js-pie-chart pie-chart mb-20" data-percent="45" data-line-width="6" data-size="100"
            data-bar-color="#9ccc65" data-track-color="#e9e9e9">
            <span>
              <img class="img-avatar" src="assets/media/avatars/avatar15.jpg" alt="">
            </span>
          </div>
          <div class="font-size-h3 font-w600">45 Realizados</div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">/100</div>
        </div>
      </div>
    </a>
  </div>
  <div class="col-md-3 col-xl-2">
    <a style="cursor:default" class="block" href="javascript:void(0)">
      <div class="block-content block-content-full">
        <div class="py-20 text-center">
          <div class="js-pie-chart pie-chart mb-20" data-percent="75" data-line-width="6" data-size="100"
            data-bar-color="#ffca28" data-track-color="#e9e9e9">
            <span>
              <img class="img-avatar" src="assets/media/avatars/avatar8.jpg" alt="">
            </span>
          </div>
          <div class="font-size-h3 font-w600">64 Pendientes</div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">/36</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Row #1 -->
</div> --}}
<!-- Orders -->
<div class="content-heading">
  {{--<div class="dropdown float-right">
    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-drop" data-toggle="dropdown"
      aria-haspopup="true" aria-expanded="false">
      Today
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-drop">
      <a class="dropdown-item active" href="javascript:void(0)">
        <i class="fa fa-fw fa-calendar mr-5"></i>Today
      </a>
      <a class="dropdown-item" href="javascript:void(0)">
        <i class="fa fa-fw fa-calendar mr-5"></i>This Week
      </a>
      <a class="dropdown-item" href="javascript:void(0)">
        <i class="fa fa-fw fa-calendar mr-5"></i>This Month
      </a>
      <a class="dropdown-item" href="javascript:void(0)">
        <i class="fa fa-fw fa-calendar mr-5"></i>This Year
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item" href="javascript:void(0)">
        <i class="fa fa-fw fa-circle-o mr-5"></i>All Time
      </a>
    </div>
  </div>
  <div class="dropdown float-right mr-5">
    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-filter-drop"
      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      All
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-filter-drop">
      <a class="dropdown-item" href="javascript:void(0)">
        <i class="fa fa-fw fa-spinner fa-spin text-warning mr-5"></i>Pending
      </a>
      <a class="dropdown-item" href="javascript:void(0)">
        <i class="fa fa-fw fa-refresh fa-spin text-info mr-5"></i>Processing
      </a>
      <a class="dropdown-item" href="javascript:void(0)">
        <i class="fa fa-fw fa-times text-danger mr-5"></i>Canceled
      </a>
      <a class="dropdown-item" href="javascript:void(0)">
        <i class="fa fa-fw fa-check text-success mr-5"></i>Completed
      </a>
      <div class="dropdown-divider"></div>
      <a class="dropdown-item active" href="javascript:void(0)">
        <i class="fa fa-fw fa-circle-o mr-5"></i>All
      </a>
    </div>
  </div>--}}
  Lista De Equipos
</div>
<div class="block block-rounded">
  <div class="block-content bg-body-light">
    <!-- Search -->
    <form action="{{ route('inventory.report.maintenance.index')}}" method="GET">
      <div class="form-group">
        <div class="input-group">
          <input type="text" class="form-control" id="search" name="search" placeholder="Buscar serial..">
          <div class="input-group-append">
            <button type="submit" class="btn btn-secondary">
              <i class="fa fa-search"></i>
            </button>
          </div>
    </form>
    <button type="button" class="btn btn-sm btn-secondary ml-2" data-toggle="tooltip" data-placement="top"
      title="Actualizar lista" onclick="window.location='{{ route('inventory.report.maintenance.index') }}'">
      <i class="si si-reload"></i>
    </button>
    {{-- @include('report.maintenances.partials.modal_download_mto')
    <button type="button" class="btn btn-sm btn-secondary ml-2" data-toggle="modal" data-target="#modal-download-all"
      title="">
      <i class="fa fa-download"></i>
    </button> --}}
  </div>
</div>
<!-- END Search -->
</div>
<div class="block-content">
  <!-- Device Table -->
  <table class="table table-borderless table-striped">
    <thead>
      <tr>
        <th style="width: 100px;">CODIGO</th>
        <th style="width: 100px;">SERIAL</th>
        <th class="d-none d-sm-table-cell">IP</th>
        <th class="d-none d-sm-table-cell">MAC</th>
        <th class="d-none d-sm-table-cell">SEDE</th>
        <th class="d-none d-sm-table-cell text-center">ESTADO DE MANTENIMIENTO</th>
        <th class="d-none d-sm-table-cell text-center">ACCIONES</th>
      </tr>
    </thead>
    <tbody style="font-size: 14px">
      @if(count($devices) <= 0) <tr>
        <td colspan="7" class="text-center">SERIAL NO ENCONTRADO!
          <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="tooltip" data-placement="top"
            title="Nueva busqueda" onclick="window.location='{{ route('inventory.report.maintenance.index') }}'">
            <i class="fa fa-search"></i>
          </button>
        </td>
        </tr>
        @else
        @foreach($devices as $device)
        <tr>
          <td class="d-none d-sm-table-cell">
            {{ $device->inventory_code_number }}
          </td>
          <td class="d-none d-sm-table-cell">
            {{ $device->serial_number }}
          </td>
          <td class="d-none d-sm-table-cell">
            {{ $device->ip }}
          </td>
          <td class="d-none d-sm-table-cell">
            {{ $device->mac }}
          </td>
          <td class="d-none d-sm-table-cell">
            {{ $device->sede }}
          </td>
          <td class="d-none d-sm-table-cell text-center">
            {{-- <span class="badge badge-success btn-block">
              {{Str::title(\Carbon\Carbon::parse($device->MesPrimerSemestre)->formatLocalized('%B')) }}
            </span> --}}
            @if($device->mto_flag === 0)
            <span class="badge badge-warning">
              <i class="fa fa-exclamation-circle"></i>
              {{ $device->mto_statu }}
            </span>
            @elseif($device->mto_flag === 1)
            <span class="badge badge-success">
              <i class="fa fa-check"></i>
              {{ $device->mto_statu }}
            </span>
            @endif
          </td>
          <td class="d-none d-sm-table-cell text-center">
            <div class="btn-group">
              @if($device->first_semester_month == now()->isoformat('M'))
              <a class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Generar Reporte"
                href="{{ route('inventory.report.maintenance.create', [$device->device_id, $device->device_rowguid]) }}">
                <i class="fa fa-file-text-o"></i>
              </a>
              @elseif($device->second_semester_month == now()->isoformat('M'))
              <a class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Generar Reporte"
                @if($device->maintenance_01_date == null)
                id="btn-notify"
                @endif
                href="{{route('inventory.report.maintenance.create', [$device->device_id, $device->device_rowguid])}}">
                <i class="fa fa-file-text-o"></i>
              </a>
              @else
              <button type="button" class="btn btn-sm btn-alt-secondary" disabled>
                <i class="fa fa-file-text-o"></i>
              </button>
              @endif
            </div>
          </td>
        </tr>
        @endforeach
        @endif
    </tbody>
  </table>
  <nav aria-label="navigation">
    <ul class="pagination justify-content-end">
      {!! $devices->links("pagination::bootstrap-4") !!}
    </ul>
  </nav>
  <!-- END Orders Table -->

  <!-- Navigation 
        <nav aria-label="Orders navigation">
            <ul class="pagination justify-content-end">
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                        <span aria-hidden="true">
                            <i class="fa fa-angle-left"></i>
                        </span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="javascript:void(0)">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)">2</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0)">...</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)">8</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)">9</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" aria-label="Next">
                        <span aria-hidden="true">
                            <i class="fa fa-angle-right"></i>
                        </span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
         END Navigation -->
</div>
</div>
<!-- END Device -->
@endsection

@push('js')
<!-- Page JS Plugins -->
<script src="{{ asset('/js/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('/js/plugins/easy-pie-chart/jquery.easypiechart.min.js') }}"></script>
<script src="{{ asset('/js/plugins/chartjs/Chart.bundle.min.js') }}"></script>

<!-- Page JS Code -->
<script src="{{ asset('/js/pages/be_widgets_stats.min.js') }}"></script>

<!-- Page JS Helpers (Easy Pie Chart Plugin) -->
<script>
  jQuery(function(){ Codebase.helpers('easy-pie-chart'); });
</script>

@if(Session::has('report_created'))
<script>
  Swal.fire(
      'Reporte creado con Exito!',
      '{!! Session::get('report_created') !!}',
      'success'
    )
</script>
@endif

<script>
  $(document).on("click", "#btn-notify", function (e) {
        Swal.fire(
          "Mantenimiento del primer semestre no realizado",
          `Informe al administrador de la aplicacíon.`,
          "info"
        );
          console.log("Mantenimiento del primer semestre no realizado");
            event.preventDefault();
      });
</script>

@endpush