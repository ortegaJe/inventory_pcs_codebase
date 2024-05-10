@extends('layouts.backend')

@section('title', 'Reportes')

@section('content')
<nav class="breadcrumb bg-white push">
  <a class="breadcrumb-item" href="{{ route('inventory.report.index') }}">Reportes</a>
  <span class="breadcrumb-item active">Mantenimientos</span>
</nav>
<div class="content-heading">
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
    <button type="button" class="btn btn-sm btn-secondary ml-2" onclick="showMultiSelect()">
      <i class="fa fa-download"></i>
    </button>
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
            <input type="hidden" name="campu_id" id="campu_id" value="{{ $device->campu_id }}">
            <div class="btn-group">
              @if($device->first_semester_month == now()->isoformat('M'))
              <a class="btn btn-sm btn-secondary btn-campu-id" id="{{ $device->campu_id }}" data-toggle="tooltip" title="Generar Reporte"
                href="{{ route('inventory.report.maintenance.create', [$device->device_id, $device->device_rowguid]) }}">
                <i class="fa fa-file-text-o"></i>
              </a>
              @elseif($device->second_semester_month == now()->isoformat('M'))
              <a class="btn btn-sm btn-secondary btn-campu-id" id="{{ $device->campu_id }}" data-toggle="tooltip" title="Generar Reporte"
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
@php
  $currenturl = url()->current();
  $user_id = Auth::id();
  $campu_id = $device->campu_id;
  $currentRoute = Route::currentRouteName()
@endphp
@endsection

@push('js')

<script src="{{ asset('/js/validate.sign.reports.js') }}"></script>
<script src="{{ asset('/js/validate.calendar.mto.js') }}"></script>
<script src="{{ asset('/js/list.user.campus.js') }}"></script>

<script>
    let validate_sign = <?php echo json_encode(route('validate_sign')) ?>;
    let route_sign_admin = <?php echo json_encode(route('sign.index')) ?>;
    let route_sign_user = <?php echo json_encode(route('admin.inventory.technicians.profiles')) ?>;
    let user_id = <?php echo json_encode($user_id) ?>;
    let campu_id = <?php echo json_encode($campu_id) ?>;
    let currentRoute = <?php echo json_encode($currentRoute) ?>;
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