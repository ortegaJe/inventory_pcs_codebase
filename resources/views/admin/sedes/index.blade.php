@extends('layouts.backend')

@section('title', 'Sedes')

@section('content')

    <!-- Overview -->
    <div class="content-heading">
        <h2 class="h4 font-w300 mb-0">Sedes<small class="d-none d-sm-inline"> VIVA 1A IPS</small></h2>
    </div>
    <div class="row gutters-tiny">
        <!-- All Products -->
        <div class="col-md-6 col-xl-6">
            <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full block-sticky-options">
                    <div class="block-options">
                        <div class="block-options-item">
                            <i class="fa fa-building-o fa-4x text-primary-lighter"></i>
                        </div>
                    </div>
                    <div class="py-20 text-center">
                        <div class="font-size-h2 font-w700 mb-0 text-primary" data-toggle="countTo"
                            data-to="{{ $campus }}">0
                        </div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">sedes</div>
                    </div>
                </div>
            </a>
        </div>
        <!-- END All Products -->

        <!-- Add Product -->
        <div class="col-md-6 col-xl-6">
            <a class="block block-rounded block-link-shadow" onclick="Codebase.blocks('#cb-add-server', 'open');">
                <div class="block-content block-content-full block-sticky-options">
                    <div class="block-options">
                        <div class="block-options-item">
                            <i class="fa fa-building-o fa-4x text-success-light"></i>
                        </div>
                    </div>
                    <div class="py-20 text-center">
                        <div class="font-size-h2 font-w700 mb-0 text-success">
                            <i class="fa fa-plus"></i>
                        </div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">nueva sede</div>
                    </div>
                </div>
            </a>
        </div>
        <!-- END Add Product -->
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
    <form class="push mt-20" onsubmit="return false;">
        <div class="input-group input-group-lg">
            <input type="text" class="js-icon-search form-control" placeholder="Buscar..">
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
            <div class="form-inline d-flex justify-content-between w-100">
                <div class="d-flex align-items-center">
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
                </div>
                <div>
                    <span id="campuCount" class="badge badge-pill badge-primary font-size-h5" style="display: none;">
                        0
                    </span>
                </div>
            </div>
            <div class="block-options">
                <button type="button" class="btn btn-small btn-alt-success downloadCampuByRegion" data-toggle="tooltip" data-placement="top" data-original-title="Descargar Informe Sedes">
                    <i class="fa fa-file-excel-o"></i>
                </button>
              </div>
        </div>
        <div class="block-content">
            <div class="js-icon-list row items-push-2x text-center" id="campuList">
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
