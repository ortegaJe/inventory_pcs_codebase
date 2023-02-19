@extends('layouts.backend')

@section('title', 'Dashboard')

@section('css')
<link href="{{ asset('/css/datatables/datatable.inventory.campus.less.devices.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('/js/plugins/slick/slick.css') }}">
<link rel="stylesheet" href="{{ asset('/js/plugins/slick/slick-theme.css') }}">

@section('content')
{{--<div class="block block-rounded">
  <div class="block-content block-content-full bg-pattern"
    style="background-image: url('{{ asset('/media/various/bg-pattern-inverse.png') }}');">
    <div class="py-20 text-center">
      <h2 class="font-w700 text-black mb-10">
        Busqueda por Serial
      </h2>
      <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-6">
          <form action="be_pages_hosting_support.html" method="POST">
            <div class="input-group input-group-lg">
              <input type="text" class="form-control" placeholder="Serial equipo..">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary">
                  <i class="fa fa-search"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>--}}
@hasrole('super_admin|admin_view')
<div class="row">
  <div class="col-md-6">
    <div class="block block-themed">
      <div class="block-header bg-primary">
        <h3 class="block-title">
          <i class="fa fa-building text-white-op"></i>
          Número de equipos por sede registrados
        </h3>
        <div class="block-options">
          <button type="button" class="btn-block-option" id="btn-refresh-dt" data-toggle="block-option"
            data-action="state_toggle" data-action-mode="demo">
            <i class="si si-refresh"></i>
          </button>
        </div>
      </div>
      <div class="block-content">
        <table id="dt" class="table table-hover" style="width:100%">
          <thead>
            <tr>
              <th><i class="si si-user fa-2x"></i></th>
              <th><i class="si si-screen-smartphone fa-2x"></i></th>
              <th><i class="fa fa-building-o fa-2x"></i></th>
              <th><i class="si si-screen-desktop fa-2x"></i></th>
            </tr>
          </thead>
        </table>
      </div>
      <div class="block-content block-content-full block-content-sm font-size-sm">
      </div>
    </div>
  </div>
  <div class="col-md-6">
    <div class="block block-themed">
      <div class="block-header bg-primary">
        <h3 class="block-title">
          <i class="fa fa-windows text-white-op"></i>
          Sistemas Operativos
        </h3>
        <div class="block-options">
        </div>
      </div>
      <div class="block-content">
        <figure class="highcharts-figure">
          <div id="container"></div>
          <p class="highcharts-description">
          </p>
        </figure>
      </div>
    </div>
  </div>
</div>
@endhasrole

<!-- Avatar Sliders -->
{{-- <div class="row items-push" style="height: 6%">
  <div class="col-md-6">
    @include('partials.modal')
    <!-- Slider with Multiple Slides/Avatars -->
    <div class="block">
      <div class="block-header block-header-default">
        <h3 class="block-title">Equipos en prestamo</h3>
      </div>
      <div class="block-content">
        <div class="js-slider text-center" data-autoplay="true" data-dots="true" data-arrows="true"
          data-slides-to-show="3">
          @foreach($deviceBorrowed as $devices)
          <div class="py-20">
            <i class="si si-screen-desktop fa-4x text-primary"></i>
            <div class="mt-10 font-w600">
              {{ $devices->brand }}
            </div>
            <div class="font-w600">
              {{ $devices->serial_number }}
            </div>
            <div class="font-size-sm text-muted">{{ Str::title($devices->custodian) }}</div>
            <button type="button" class="btn btn-sm btn-alt-primary" data-toggle="modal" data-target="#modal-popout">
              <i class="si si-eye"></i>
            </button>
          </div>
          @endforeach
        </div>
      </div>
    </div>
    <!-- END Slider with Multiple Slides/Avatars -->
  </div>
</div> --}}
<!-- END Avatar Sliders -->
@endsection

@push('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
  let root_url = <?php echo json_encode(route('get.campus.fewer.devices')) ?>;
	let root_url_show = <?php echo json_encode(route('admin.inventory.technicians.store')) ?>;
</script>
<script src="{{ asset('/js/datatables/datatable.inventory.campus.less.devices.js') }}"></script>
<script src="{{ asset('/js/pages/be_tables_datatables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/js/plugins/slick/slick.min.js') }}"></script>
<script>
  jQuery(function(){ Codebase.helpers('slick'); });
</script>
<script>
let name =  <?php echo $name ?>;
let data =  <?php echo $data ?>; 

Highcharts.chart('container', {
    chart: {
        type: 'column',
           height: 331,
    style: {
        fontFamily: 'Nunito Sans'
      }
    },
    title: {
        text: 'Número de Sistemas Operativos Instalados'
    },
    credits: {
      enabled: false
    },
    xAxis: {
        categories: name,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Sistemas Operativos'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                      '<td style="padding:0"><b>{point.y:.0f} total</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    series: [{
      name: '<i class="fa fa-windows"></i>',
      showInLegend: false,
      data
    }],
    exporting: {
      filename: 'numero-sistemas-operativos-instalados-viva1a'
    }
});
</script>

<script>
  $(document).on("click", "#btn-refresh-dt", function (e) {
    $("#dt").DataTable().ajax.reload(null, true);
    });
</script>
@endpush