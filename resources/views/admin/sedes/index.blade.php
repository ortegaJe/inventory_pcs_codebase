@extends('layouts.backend')

@section('title', 'Sedes')

@section('content')
    {{--     <div class="row">
        <div class="col-md-3">
            <label for="regionalSelect">Selecciona una regional:</label>
            <select id="regionalSelect">
                <option value="todas">Todas</option>
                <option value="norte">Regional Norte</option>
                <option value="sur">Regional Sur</option>
                <option value="este">Regional Este</option>
                <!-- Agrega más opciones regionales según sea necesario -->
            </select>
        </div>
    </div> --}}
    <!-- Overview -->
    <div class="content-heading">
        <div class="d-flex justify-content-between align-items-center mb-20">
            <h2 class="h4 font-w300 mb-0">Sedes <small class="d-none d-sm-inline">VIVA 1A IPS</small></h2>
            <div class="col-md-10 col-lg-8 col-xl-6">
            </div>
            <button type="button" class="btn btn-hero btn-alt-primary min-width-125" data-toggle="click-ripple"
                onclick="Codebase.blocks('#cb-add-server', 'open');">
                <i class="fa fa-building-o mr-1"></i> Nueva sede
            </button>
        </div>
        <div id="cb-add-server" class="block bg-body-light animated fadeIn d-none">
            <div class="block-header">
                <h3 class="block-title">Agregar nueva sede</h3>
                <div class="block-options">
                    <button type="button" class="btn-sm btn-block-option" data-toggle="block-option" data-action="close">
                        <i class="si si-close"></i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <form action="{{ route('admin.inventory.campus.index') }}" method="POST">
                    @csrf
                    @method('POST')
                    <div class="form-group row gutters-tiny mb-0 items-push">
                        <div class="col-md-2">
                            <input type="text" class="js-maxlength form-control" id="abreviature" name="abreviature"
                                maxlength="4" placeholder="Abreviado sede" data-always-show="true" data-pre-text="Used "
                                data-separator=" of " data-post-text=" letters"
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                            @error('abreviature')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="name" name="name"
                                placeholder="Nombre de la sede" onkeyup="javascript:this.value=this.value.toUpperCase();">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <select class="form-control" id="regional" name="regional">
                                <option value="0">--Seleccione regional--</option>
                                @forelse ($regionals as $region)
                                    <option value="{{ $region->id }}">{{ $region->name }}
                                    </option>
                                @empty
                                    <option>REGIONALES NO DISPONIBLES</option>
                                @endforelse
                            </select>
                            @error('regional')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="address" name="address" placeholder="Dirección"
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                            @error('address')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefono"
                                onkeyup="javascript:this.value=this.value.toUpperCase();">
                            @error('phone')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-alt-success btn-block" data-toggle="click-ripple">
                                <i class="fa fa-save mr-1"></i> Guardar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <form class="push" onsubmit="return false;">
        <div class="input-group input-group-lg">
            <input type="text" class="js-icon-search form-control" placeholder="Buscar sede..">
            <div class="input-group-append">
                <span class="input-group-text">
                    <i class="fa fa-search"></i>
                </span>
            </div>
        </div>
    </form>
    <!-- END Overview -->
    <!-- Simple Line Icons -->
    <div class="block">
        <div class="block-header block-header-default">
            <div class="form-inline">
                <label for="regionalSelect">Regiones</label>
                <select class="form-control ml-5" id="regionalSelect" name="regionalSelect">
                    <option value="0">TODAS</option>
                    @forelse ($regionals as $region)
                        <option value="{{ $region->id }}">{{ $region->name }}
                        </option>
                    @empty
                        <option>REGIONALES NO DISPONIBLES</option>
                    @endforelse
                </select>
                <button type="button" class="btn btn-alt-success ml-5 downloadCampuByRegion" data-toggle="click-ripple">
                    <i class="fa fa-file-excel-o mr-1"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            <div class="js-icon-list row items-push-2x text-center" id="sedeList">
            </div>
        </div>
    </div>
    <!-- END Simple Line Icons -->
@endsection

@push('js')
    <!-- Page JS Code -->
    <script src="{{ asset('/js/pages/be_forms_plugins.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('/js/bootstrap3-typeahead.min.js') }}"></script>
    <script src="{{ asset('/js/pages/be_ui_icons.min.js') }}"></script>
    <script src="{{ asset('/js/list.campus.filter.js') }}"></script>
    <script>
        jQuery(function() {
            Codebase.helpers(['maxlength']);
        });
    </script>
    <script>
        let url_all_campus = <?php echo json_encode(route('all_campus')); ?>;
        let campu_by_regional = <?php echo json_encode(route('campus.regional')); ?>;
        let index_campus = <?php echo json_encode(route('admin.inventory.campus.index')); ?>;
        let export_campus_by_regional = <?php echo json_encode(route('export.campu_by_regional')); ?>;
        let export_all_campus_by_regional = <?php echo json_encode(route('export.all_campu_by_regional')); ?>;
    </script>

    @if (Session::has('success'))
        <script>
            Swal.fire(
                'Creado con Exito!',
                '{!! Session::get('success') !!}',
                'success'
            )
        </script>
    @endif

    <script>
        let route = "{{ route('admin.inventory.campus.search') }}";

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
@endpush
