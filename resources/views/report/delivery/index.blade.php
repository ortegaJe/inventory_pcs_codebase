@extends('layouts.backend')

@section('title', 'Reportes')

@section('content')
<nav class="breadcrumb bg-white push">
  <a class="breadcrumb-item" href="{{ route('inventory.report.index') }}">Reportes</a>
  <span class="breadcrumb-item active">Acta de entrega</span>
</nav>
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
    <form action="{{ route('inventory.report.delivery.index')}}" method="GET">
      <div class="form-group">
        <div class="input-group">
          <input type="text" class="form-control" id="search" name="search" placeholder="Buscar serial..">
          <div class="input-group-append">
            <button type="submit" class="btn btn-secondary">
              <i class="fa fa-search"></i>
            </button>
          </div>
          <button type="button" class="btn btn-sm btn-secondary ml-2" data-toggle="tooltip" data-placement="top"
            title="Actualizar lista" onclick="window.location='{{ route('inventory.report.delivery.index') }}'"><i
              class="si si-reload"></i></button>
        </div>
      </div>
    </form>
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
          <th class="d-none d-sm-table-cell text-center">ESTADO</th>
          <th class="d-none d-sm-table-cell text-center">ACCIONES</th>
        </tr>
      </thead>
      <tbody style="font-size: 14px">
        @if(count($devices) <= 0) <tr>
          <td colspan="7" class="text-center">SERIAL NO ENCONTRADO!
            <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="tooltip" data-placement="top"
              title="Nueva busqueda" onclick="window.location='{{ route('inventory.report.removes.index') }}'"><i
                class="fa fa-search"></i></button>
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
              @if($device->statu_id == 1)
              <span class="badge badge-success btn-block">{{ Str::title($device->estado) }}</span>
              @elseif($device->statu_id == 2)
              <span class="badge badge-warning btn-block">{{ Str::title($device->estado) }}</span>
              @elseif($device->statu_id == 3)
              <span class="badge badge-info btn-block">{{ Str::title($device->estado) }}</span>
              @elseif($device->statu_id == 5)
              <span class="badge badge-secondary btn-block">{{ Str::title($device->estado) }}</span>
              @elseif($device->statu_id == 6)
              <span class="badge badge-primary btn-block">{{ Str::title($device->estado) }}</span>
              @elseif($device->statu_id == 7)
              <span class="badge badge-primary btn-block">{{ Str::title($device->estado) }}</span>
              @elseif($device->statu_id == 8)
              <span class="badge badge-primary btn-block">{{ Str::title($device->estado) }}</span>
              @elseif($device->statu_id == 9)
              <span class="badge badge-primary btn-block">{{ Str::title($device->estado) }}</span>
              @elseif($device->statu_id == 10)
              <span class="badge badge-primary btn-block">{{ Str::title($device->estado) }}</span>
              @endif
            </td>
            <td class="d-none d-sm-table-cell text-center">
              <div class="btn-group">
                <a class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Generar Reporte"
                  href="{{ route('report.delivery.create', [$device->device_id, $device->rowguid]) }}">
                  <i class="fa fa-file-text-o"></i>
                </a>
              </div>
            </td>
          </tr>
          @endforeach
          @endif
      </tbody>
    </table>
    <nav aria-label="menu navigation">
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