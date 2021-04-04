@extends('layouts.backend')

@section('title', 'Admin Dashboard')

@section('css')
<link href="{{ asset('/css/datatable.admin.css') }}" rel="stylesheet">

@section('content')
<!-- Page Content -->
<div class="content">
  <div class="row invisible" data-toggle="appear">
    <!-- Row #1 -->
    <div class="col-6 col-xl-3">
      <a class="block block-link-shadow text-right" href="javascript:void(0)">
        <div class="block-content block-content-full clearfix">
          <div class="float-left mt-10 d-none d-sm-block">
            <i class="si si-screen-desktop fa-3x text-body-bg-dark"></i>
          </div>
          <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{{ $global_pc_count }}">0
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">pc</div>
        </div>
      </a>
    </div>
    <div class="col-6 col-xl-3">
      <a class="block block-link-shadow text-right" href="javascript:void(0)">
        <div class="block-content block-content-full clearfix">
          <div class="float-left mt-10 d-none d-sm-block">
            <i class="si si-wallet fa-3x text-body-bg-dark"></i>
          </div>
          <div class="font-size-h3 font-w600">$<span data-toggle="countTo" data-speed="1000" data-to="780">0</span>
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">Earnings</div>
        </div>
      </a>
    </div>
    <div class="col-6 col-xl-3">
      <a class="block block-link-shadow text-right" href="javascript:void(0)">
        <div class="block-content block-content-full clearfix">
          <div class="float-left mt-10 d-none d-sm-block">
            <i class="si si-envelope-open fa-3x text-body-bg-dark"></i>
          </div>
          <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="15">0</div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">Messages</div>
        </div>
      </a>
    </div>
    <div class="col-6 col-xl-3">
      <a class="block block-link-shadow text-right" href="javascript:void(0)">
        <div class="block-content block-content-full clearfix">
          <div class="float-left mt-10 d-none d-sm-block">
            <i class="si si-users fa-3x text-body-bg-dark"></i>
          </div>
          <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="4252">0</div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">Online</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3">
      <a class="block block-link-shadow block-link-shadow" href="{{ route('admin.pcs.create') }}">
        <div class="block-content block-content-full block-sticky-options">
          <div class="block-options">
            <div class="block-options-item">
              <i class="si si-screen-desktop fa-2x text-success-light"></i>
            </div>
          </div>
          <div class="py-20 text-center">
            <div class="font-size-h2 font-w700 mb-0 text-success">
              <i class="fa fa-plus"></i>
            </div>
            <div class="font-size-sm font-w600 text-uppercase text-muted">Nuevo equipo</div>
          </div>
        </div>
      </a>
    </div>
    <!-- END Row #1 -->
  </div>
  <div class="col-md-14">
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
                <th>codigo</th>
                <th>serial</th>
                <th>ip</th>
                <th>mac</th>
                <th>
                  <img class="img-fluid" width="80px" src="https://go.anydesk.com/_static/img/logos/anydesk-logo.svg"
                    alt="anydesk">
                </th>
                <th>fecha de creación</th>
                <th>sede</th>
                <th>estado</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th></th>
                <th>CODIGO</th>
                <th>SERIAL</th>
                <th>IP</th>
                <th>MAC</th>
                <th>
                  <img class="img-fluid" width="80px" src="https://go.anydesk.com/_static/img/logos/anydesk-logo.svg"
                    alt="anydesk">
                </th>
                <th>FECHA DE CREACIÓN</th>
                <th>SEDE</th>
                <th>ESTADO</th>
                <th>ACTION</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Page Content -->

@endsection

@push('js')
<script>
  function format(d) {
    return '<div class="slider">'+
        '<table table-responsive style="font-size:13">'+
            '<tr>'+
                '<td>Marca: '+'<span class="badge badge-pill badge-success">'+d.Marca+'</span>'+
                '<td>Memoria RAM(ranura 01): '+d.Ram0+'</td>'+
                '<td>Memoria RAM(ranura 02): '+d.Ram1+'</td>'+
                '<td>Disco Duro: '+d.HddPeso+''+d.HddTipo+'</td>'+
                '<td>S/N monitor: '+d.SerialMonitor+'</td>'+
                '</td>'+
                '</tr>'+
            '<tr>'+
                '<td>Modelo: '+d.Modelo+''+
                '<td>'+'<i class="fa fa-microchip fa-1x"></i>'+' '+d.Cpu+'</td>'+
                '<td>'+'<img class="img-fluid" width="24px" src="https://cdn.svgporn.com/logos/microsoft-windows.svg" alt="windows">'+'</img>'+' '+d.Os+'</td>'+
                '<td>Ubicación: '+d.Ubicacion+'</td>'+
                '<td></td>'+
                '</td>'+
                '</tr>'+
            '<tr>'+
                '<td>Tipo: '+d.TipoMaquina+
                '<td>Dirección IP: '+d.Ip+'</td>'+
                '<td>Direccion MAC: '+d.Mac+'</td>'+
                '<td></td>'+
                '<td></td>'+
                '</td>'+
                '</tr>'+
            '<tr>'+
                '<td>Imagen: '+'<img class="img-fluid" width="160px" src="{{ asset('media/dashboard/photos/M710q.png') }}">'+'</img>'+'</td>'+
                '<td></td>'+
                '<td></td>'+
                '<td></td>'+
                '<td></td>'+
                '</tr>'+
            '</table>'+
        '</div>';
    }
</script>

<script>
  $(document).ready(function() {
    var dt = $('#dt').DataTable( {
    "processing": true,
    "serverSide": true,
    "ajax": "{{ route('admin.pcs.index') }}",
    "language": {
    "lengthMenu": "Display _MENU_ records per page",
    "zeroRecords": "Registro no encontrado",
    "info": "Showing page _PAGE_ of _PAGES_",
    "infoEmpty": "No records available",
    "infoFiltered": "(filtered from _MAX_ total records)",
    "search" : "Buscar"
    },
    "columns": [
    {
    "class": "details-control",
    "orderable": false,
    "data": null,
    "defaultContent": ""
    },
    { "data": "CodigoInventario" },
    { "data": "Serial" },
    { "data": "Ip" },
    { "data": "Mac" },
    { "data": "Anydesk" },
    { "data": "FechaCreacion" },
    { "data": "Sede" },
    { "data": "EstadoPC" },
    { "data": "action" }
    ],
    "order": [[1, 'asc']]
    } );
    
    // Array to track the ids of the details displayed rows
    $('#dt tbody').on('click', 'td.details-control', function () {
    var tr = $(this).closest('tr');
    var row = dt.row( tr );
    
    if ( row.child.isShown() ) {
    // This row is already open - close it
    $('div.slider', row.child()).slideUp( function () {
    row.child.hide();
    tr.removeClass('shown');
    } );
    }
    else {
    // Open this row
    row.child( format(row.data()), 'no-padding' ).show();
    tr.addClass('shown');
    
    $('div.slider', row.child()).slideDown();
    }
    } );
    } );
</script>
@endpush