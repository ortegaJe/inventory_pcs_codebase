@extends('layouts.backend')

@section('title', 'Usuarios')

@section('content')

    <!-- Overview -->
    <div class="content-heading">
        <h2 class="h4 font-w300 mb-0">Usuarios<small class="d-none d-sm-inline"></small></h2>
    </div>
    <div class="row gutters-tiny">
        <!-- All Products -->
        <div class="col-md-6 col-xl-6">
            <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full block-sticky-options">
                    <div class="block-options">
                        <div class="block-options-item">
                            <i class="fa fa-users fa-4x text-primary-lighter"></i>
                        </div>
                    </div>
                    <div class="py-20 text-center">
                        <div class="font-size-h2 font-w700 mb-0 text-primary" data-toggle="countTo"
                            data-to="{{ $users }}">0
                        </div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">usuarios</div>
                    </div>
                </div>
            </a>
        </div>
        <!-- END All Products -->

        <!-- Add Product -->
        <div class="col-md-6 col-xl-6">
            <a class="block block-rounded block-link-shadow" href="{{ route('admin.inventory.technicians.create') }}">
                <div class="block-content block-content-full block-sticky-options">
                    <div class="block-options">
                        <div class="block-options-item">
                            <i class="fa fa-user fa-4x text-success-light"></i>
                        </div>
                    </div>
                    <div class="py-20 text-center">
                        <div class="font-size-h2 font-w700 mb-0 text-success">
                            <i class="fa fa-plus"></i>
                        </div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Nuevo Usuario</div>
                    </div>
                </div>
            </a>
        </div>
        <!-- END Add Product -->
    </div>
    <!-- END Overview -->

    {{--     <div class="content-heading">
        <div class="d-flex justify-content-between align-items-center mb-20">
            <h2 class="h4 font-w300 mb-0">Usuarios<small class="d-none d-sm-inline"></small></h2>
            <div class="col-md-10 col-lg-8 col-xl-6">
            </div>
        </div>
    </div> --}}
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
                    <span id="userCount" class="badge badge-pill badge-primary font-size-h5" style="display: none;">
                        0
                    </span>
                </div>
            </div>
        </div>
        <div class="block-content">
            <div class="js-icon-list row items-push-2x text-center" id="userList">
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
    <script src="{{ asset('/js/list.users.filter.js') }}"></script>
    <script>
        jQuery(function() {
            Codebase.helpers(['maxlength']);
        });
    </script>

    @if (Session::has('error'))
        <script>
            Swal.fire(
                'Error :/ )',
                '{!! Session::get('error') !!}',
                'error'
            )
        </script>
    @endif

    @if (Session::has('success'))
        <script>
            Swal.fire(
                'Usuario creado con Exito!',
                '{!! Session::get('success') !!}',
                'success'
            )
        </script>
    @endif

    <script>
        let route = "{{ route('search.users') }}";

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
