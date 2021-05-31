@extends('layouts.backend')

@section('title', 'Admin Dashboard')

@section('content')

<!-- Overview -->
<h2 class="content-heading">Técnicos</h2>
<div class="row gutters-tiny mb-4">
  <!-- In Orders -->
  <div class="col-md-6 col-xl-4">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="fa fa-shopping-basket fa-2x text-info-light"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-info" data-toggle="countTo" data-to="39">0</div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">In Orders</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END In Orders -->

  <!-- Stock -->
  <div class="col-md-6 col-xl-4">
    <a class="block block-rounded block-link-shadow" href="#">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="fa fa-check fa-2x text-success-light"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-success" data-toggle="countTo" data-to="85">0</div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">Stock</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Stock -->

  <!-- Delete Product -->
  <div class="col-xl-4">
    <a class="block block-rounded block-link-shadow" href="{{ route('admin.inventory.technicians.create') }}">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="fa fa-user fa-2x text-success-light"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-success">
            <i class="fa fa-plus"></i>
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">Agregar Nuevo</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Delete Product -->
</div>
<!-- END Overview -->
<div class="row">
  @foreach ($users as $user )
  <div class="col-md-3 col-xl-3">
    <div class="block block-themed text-center">
      <div class="block-content block-content-full block-sticky-options pt-30 bg-earth">
        <div class="block-options block-options-left">
          <div class="dropdown">
            <button type="button" class="btn-block-option" data-toggle="dropdown" aria-haspopup="true"
              aria-expanded="false">
              <i class="si si-wrench"></i>
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{ route('admin.inventory.technicians.edit', $user->UserID) }}">
                <i class="fa fa-fw fa-cog mr-5"></i>Asignar rol
              </a>
              {{--<a class="dropdown-item" href="javascript:void(0)">
                <i class="fa fa-fw fa-hand-stop-o mr-5"></i>Privacy
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="javascript:void(0)">
                <i class="fa fa-fw fa-envelope-o mr-5"></i>Messages
              </a>--}}
            </div>
          </div>
        </div>
        <img class="img-avatar img-avatar-thumb" src="{{ asset('/media/avatars/avatar7.jpg') }}" alt="">
      </div>
      <div class="block-content block-content-full block-content-sm bg-earth-dark">
        <div class="font-w600 text-white mb-5">{{ Str::title($user->NombreCompletoTecnico) }}</div>
        <div class="font-size-sm text-white-op">{{ Str::title($user->CargoUsuario) }} |
          {{ Str::title($user->RolUsuario) }}</div>
      </div>
      <div class="block-content">
        <div class="row items-push">
          <div class="col-6 text-center">
            <div class="mb-5"><i class="fa fa-building-o fa-2x"></i></div>
            <div class="font-size-sm text-muted"> Sedes</div>
          </div>
          {{--<div class="col-6">
            <div class="mb-5"><i class="si si-calendar fa-2x"></i></div>
            <div class="font-size-sm text-muted">2 Events</div>
          </div>--}}
        </div>
      </div>
    </div>
  </div>
  @endforeach
</div>

@endsection