@extends('layouts.backend')

@section('title', 'Usuarios')

@section('content')

<form action="{{ route('admin.inventory.technicians.index') }}" method="GET">
  <div class="input-group input-group-lg">
    <input type="text" class="form-control" id="search" name="search" placeholder="Buscar (Cedula, Nombre, Apellido)">
    <div class="input-group-append">
      <button type="submit" class="btn btn-secondary">
        <i class="fa fa-search"></i>
      </button>
    </div>
    <div class="input-group-append">
      <button type="button" class="btn btn-secondary"
        onclick="window.location='{{ route('admin.inventory.technicians.index') }}'">
        <i class="si si-reload"></i>
      </button>
    </div>
  </div>
</form>

<!-- Overview -->
<div class="content-heading">
  <div class="dropdown float-right">
    <button type="button" onclick="window.location='{{ route('admin.inventory.technicians.create') }}'"
      class="btn btn-sm btn-alt-primary min-width-125" data-toggle="click-ripple">
      <i class="si si-user"></i> Nuevo técnico
    </button>
  </div>
  Usuarios <small class="d-none d-sm-inline">Técnicos</small>
</div>
<!-- END Overview -->

<div class="row">
  @if(count($users) <= 0) <!-- Animation Classes -->
    <div class="col-sm-4 mx-auto">
      <div class="block block-bordered block-rounded invisible" data-toggle="appear" data-class="animated bounceIn">
        <div class="block-content block-content-full">
          <div class="py-30 text-center">
            <div class="item item-2x item-circle bg-gray text-white mx-auto">
              <i class="si si-user"></i>
            </div>
            <div class="h4 pt-20 mb-0">Usuario No Encontrado</div>
          </div>
        </div>
      </div>
    </div>
    <!-- END Animation Classes -->
    @else
    @foreach ($users as $user ) <div class="col-md-6 col-xl-3">
      <a class="block block-link-pop text-center" href="{{ route('admin.inventory.technicians.show', $user->id) }}">
        <div class="block-content text-center">
          <div class="item item-circle bg-primary-lighter text-primary mx-auto my-10">
            <i class="si si-user"></i>
          </div>
          {{-- <divclass="font-size-smtext-muted">equipos --}}
        </div>
        <div class="block-content bg-body-light">
          <p class="font-w600">
            {{ Str::title($user->name) }}
            {{ Str::title($user->last_name) }}
          </p>
        </div>
      </a>
    </div>
    @endforeach
    @endif
</div>
<div class="d-flex float-right mb-4">
  {!! $users->links("pagination::bootstrap-4") !!}
</div>

{{--<div class="col-md-6 col-xl-3">
  <div class="block text-center">
    <div class="block-content block-content-full block-sticky-options pt-30">
      <div class="block-options">
        <div class="dropdown">
          <button type="button" class="btn-block-option" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <i class="fa fa-fw fa-ellipsis-v"></i>
          </button>
          <div class="dropdown-menu dropdown-menu-right" style="">
            <a class="dropdown-item" href="javascript:void(0)">
              <i class="fa fa-cog mr-5"></i>Configuraciones
            </a>
            {{-- <a class="dropdown-item" href="javascript:void(0)">
              <i class="fa fa-fw fa-user mr-5"></i>Check out profile
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:void(0)">
              <i class="fa fa-cog mr-5"></i>Send a message
            </a>
          </div>
        </div>
      </div>
      <div class="item item-circle bg-primary-lighter text-primary mx-auto my-10">
        <i class="si si-user"></i>
      </div>
    </div>
    <div class="block-content block-content-full block-content-sm bg-body-light">
      <div class="font-w600 mb-5">Jose Parker</div>
      <div class="font-size-sm text-muted">VIVA 1A IPS SURA SAN JOSE</div>
    </div>
  </div>
</div>--}}
@endsection

@push('js')
<script src="{{ asset('/js/bootstrap3-typeahead.min.js') }}"></script>

@if(Session::has('not_found_user'))
<script>
  Swal.fire(
'Upps! Ha ocurrido un error',
'{!! Session::get('not_found_user') !!}',
'error'
)
</script>
@endif

{{-- <script>
  let route = "{{ route('admin.inventory.users.search') }}";

$('#search').typeahead({
source: function (query, process) {
return $.get(route, {
query: query
}, function (data) {
return process(data);
});
}
});
</script> --}}

@endpush