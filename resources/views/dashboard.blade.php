@extends('layouts.backend')

@section('title', 'Dashboard')

@section('css')
    <link href="{{ asset('/css/datatables/datatable.inventory.campus.less.devices.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.css') }}">
@endsection

@section('content')
    <div class="block block-rounded">
        <div class="block-content block-content-full bg-pattern">
            <div class="py-20 text-center">
                <h2 class="font-w700 text-muted mb-10">
                    Búsqueda Rápida de Equipos en el Inventario
                </h2>
                <h3 class="h5 text-muted">
                </h3>
                <div class="row justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-6">
                        <form class="push" onsubmit="return false;">
                            <div class="input-group input-group-lg">
                                <input type="text" class="js-icon-search form-control"
                                    name="search"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    placeholder="Escribe un número de serie..">
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-search"></i>
                                    </span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="js-icon-list row items-push-2x text-center" id="deviceList"></div>
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

    @php
        $user_id = Auth::id();
    @endphp
@endsection

@push('js')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        let root_url = <?php echo json_encode(route('get.campus.fewer.devices')); ?>;
        let root_url_show = <?php echo json_encode(route('admin.inventory.technicians.store')); ?>;
        let validate_sign = <?php echo json_encode(route('validate_sign')); ?>;
        let route_sign_admin = <?php echo json_encode(route('sign.index')); ?>;
        let route_sign_user = <?php echo json_encode(route('admin.inventory.technicians.profiles')); ?>;
        let user_id = <?php echo json_encode($user_id); ?>;
    </script>
    <script src="{{ asset('/js/datatables/datatable.inventory.campus.less.devices.js') }}"></script>
    <script src="{{ asset('/js/pages/be_tables_datatables.min.js') }}"></script>
    <script src="{{ asset('/js/validate.sign.js') }}"></script>
    <script src="{{ asset('/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('/js/search.devices.js') }}"></script>
    <script src="{{ asset('/js/bootstrap3-typeahead.min.js') }}"></script>
    <script>
        jQuery(function() {
            Codebase.helpers('slick');
        });
    </script>

    <script>
        let route = "{{ route('auto_complete_serial') }}";

        $('.js-icon-search').typeahead({
            source: function(query, process) {
                return $.get(route, {
                    query: query
                }, function(data) {
                    return process(data);
                });
            }
        });
    </script>

    <script>
        let name = <?php echo $name; ?>;
        let data = <?php echo $data; ?>;

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
        $(document).on("click", "#btn-refresh-dt", function(e) {
            $("#dt").DataTable().ajax.reload(null, true);
        });
    </script>
@endpush
