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
/* <script>
  Highcharts.chart('container', {
  chart: {
  plotBackgroundColor: null,
  plotBorderWidth: null,
  plotShadow: false,
  type: 'pie',
  height: 331,
  style: {
      fontFamily: 'Nunito Sans'
    }
  },
  title: {
  text: null
  },
  tooltip: {
  pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
  },
  accessibility: {
  point: {
  valueSuffix: '%'
  }
  },
  plotOptions: {
  pie: {
  allowPointSelect: true,
  cursor: 'pointer',
  dataLabels: {
  enabled: true,
  format: '<b>{point.name}</b>: {point.percentage:.1f} %'
  }
  }
  },
  series: [{
  name: 'Total',
  colorByPoint: true,
  data: <?= $chart_data ?>
  }],
  exporting: {
    filename: 'sistemas-operativos-instalados-viva1a'
  }
  }); 

  $('#update').bind('click', function() {
    var chart = $('#container').highcharts();
    
    chart.series[0].update({
    data: [{
    name: 'windows 7',
    y: 87.99
    }]
    }, false);
    
    chart.redraw();
    });
</script> */

<script>
  Highcharts.chart('container', {
chart: {
type: 'bar'
},
title: {
text: 'Historic World Population by Region',
align: 'left'
},
xAxis: {
categories: <?= $chart_data ?>,
title: {
text: null
}
},
yAxis: {
min: 0,
title: {
text: 'Population (millions)',
align: 'high'
},
labels: {
overflow: 'justify'
}
},
tooltip: {
valueSuffix: ' millions'
},
plotOptions: {
bar: {
dataLabels: {
enabled: true
}
}
},
legend: {
layout: 'vertical',
align: 'right',
verticalAlign: 'top',
x: -40,
y: 80,
floating: true,
borderWidth: 1,
backgroundColor:
Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
shadow: true
},
credits: {
enabled: false
},
series: [{
name: 'Year 1990',
data: <?= $chart_data ?>,
}]
});
</script>

<script>
  $(document).on("click", "#btn-refresh-dt", function (e) {
    $("#dt").DataTable().ajax.reload(null, true);
    });
</script>
@endpush