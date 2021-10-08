@extends('layouts.backend')

@section('title', 'Reportes')

@section('css')
<link href="{{ asset('/css/datatables/datatable.inventory.pc.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.css') }}">

@section('content')
<!-- Orders -->
<div class="content-heading">
  {{--<div class="dropdown float-right">
        <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-drop"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
  Lista De Equipos Informaticos
</div>
<div class="block block-rounded">
  <div class="block-content bg-body-light">
    <!-- Search -->
    <form action="be_pages_ecom_orders.html" method="post" onsubmit="return false;">
      <div class="form-group">
        <div class="input-group">
          <input type="text" class="form-control" placeholder="Search orders..">
          <div class="input-group-append">
            <button type="submit" class="btn btn-secondary">
              <i class="fa fa-search"></i>
            </button>
          </div>
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
          <th style="width: 100px;">SERIAL</th>
          <th class="d-none d-sm-table-cell">IP</th>
          <th class="d-none d-sm-table-cell">MAC</th>
          <th class="d-none d-sm-table-cell">SEDE</th>
          <th class="d-none d-sm-table-cell text-center">ESTADO</th>
          <th class="d-none d-sm-table-cell text-center">ACCIONES</th>
        </tr>
      </thead>
      <tbody style="font-size: 14px">
        @foreach($devices as $device)
        <tr>
          <td class="d-none d-sm-table-cell">
            {{ $device->Serial }}
          </td>
          <td class="d-none d-sm-table-cell">
            {{ $device->Ip }}
          </td>
          <td class="d-none d-sm-table-cell">
            {{ $device->Mac }}
          </td>
          <td class="d-none d-sm-table-cell">
            {{ $device->Sede }}
          </td>
          <td class="d-none d-sm-table-cell text-center">
            <span class="badge {{ $device->ColorEstado }} btn-block">{{ Str::title($device->EstadoPc) }}</span>
          </td>
          <td class="d-none d-sm-table-cell text-center">
            <div class="btn-group">
              <a class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Generar Reporte"
                href="{{ route('inventory.report.removes.create', [$device->DeviceID, $device->rowguid, $device->Serial]) }}">
                <i class="fa fa-file-text-o"></i>
              </a>
            </div>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
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
<script src="{{ asset('/js/datatables/datatable.inventory.js') }}"></script>
<script src="{{ asset('/js/pages/be_tables_datatables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
  let root_url_dashboard = <?php echo json_encode(route('admin.inventory.dash.index')) ?>;
</script>
@endpush