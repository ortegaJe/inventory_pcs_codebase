@extends('layouts.backend')

@section('title', 'Usuarios')

@section('content')

<!-- Overview -->
<div class="content-heading">
  <div class="dropdown float-right">
    <button type="button" onclick="window.location='{{ route('admin.inventory.technicians.create') }}'"
      class="btn btn-sm btn-alt-success min-width-125" data-toggle="click-ripple">
      <i class="si si-user"></i> Nuevo Usuario
    </button>
  </div>
  Usuarios <small class="d-none d-sm-inline">Técnicos</small>
</div>
<!-- END Overview -->

<div class="row">
  @foreach ($users as $user )
  <div class="col-md-6 col-xl-3">
    <a class="block block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full clearfix">
        <div class="float-right">
          <img class="img-avatar" src="{{ asset('/media/avatars/avatar8.jpg') }}" alt="">
        </div>
        <div class="float-left mt-10">
          <div class="font-w600 mb-5">{{ Str::title($user->NombreCompletoTecnico) }}</div>
          <div class="font-size-xs text-muted"><small>{{ Str::upper($user->SedeTecnico) }}</small></div>
        </div>
        <div class="float-left mt-30">
          <button type="button" class="btn btn-circle btn-alt-success mt-2" data-toggle="tooltip" title="Actualizar">
            <i class="fa fa-pencil"></i>
          </button>
          <button type="button"
            onclick="window.location='{{ route('admin.inventory.technicians.edit', $user->UserID) }}'"
            class="btn btn-circle btn-alt-warning mt-2" data-toggle="tooltip" title="Asignar Rol">
            <i class="si si-badge"></i>
          </button>
          <button type="button" class="btn btn-circle btn-alt-danger mt-2" data-toggle="tooltip" title="Eliminar">
            <i class="fa fa-times"></i>
          </button>
        </div>
      </div>
    </a>
  </div>
  @endforeach
</div>

{{--  <div class="col-md-6 col-xl-3">
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
              <i class="fa fa-fw fa-plus mr-5"></i>Add friend
            </a>
            <a class="dropdown-item" href="javascript:void(0)">
              <i class="fa fa-fw fa-user mr-5"></i>Check out profile
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="javascript:void(0)">
              <i class="fa fa-fw fa-envelope-o mr-5"></i>Send a message
            </a>
          </div>
        </div>
      </div>
      <img class="img-avatar" src="assets/media/avatars/avatar11.jpg" alt="">
    </div>
    <div class="block-content block-content-full block-content-sm bg-body-light">
      <div class="font-w600 mb-5">Jose Parker</div>
      <div class="font-size-sm text-muted">Web Developer</div>
    </div>
  </div>
</div>--}}
@endsection