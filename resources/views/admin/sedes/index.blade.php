@extends('layouts.backend')

@section('title', 'Sedes')

@section('content')

<!-- Overview -->
<div class="content-heading">
  <div class="dropdown float-right">
    <button type="button" onclick="window.location='{{ route('admin.inventory.campus.create') }}'"
      class="btn btn-sm btn-alt-success min-width-125" data-toggle="click-ripple">
      <i class="fa fa-building-o"></i> Nueva Sede
    </button>
  </div>
  Sedes <small class="d-none d-sm-inline">Viva 1A IPS</small>
</div>
<!-- END Overview -->

<div class="row">
  @foreach ($campus as $campu )
  <div class="col-md-6 col-xl-3">
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
                <i class="fa fa-fw fa-eye mr-5"></i>Ver inventario
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="javascript:void(0)">
                <i class="fa fa-fw fa-pencil mr-5"></i>Actualizar
              </a>
              <a class="dropdown-item" href="javascript:void(0)">
                <i class="fa fa-fw fa-times mr-5"></i>Borrar
              </a>
            </div>
          </div>
        </div>
        <i class="fa fa-building-o fa-3x"></i>
      </div>
      <div class="block-content block-content-full block-content-sm bg-body-light">
        <div class="font-w400 mb-5">
          {{ Str::upper($campu->description) }}
        </div>
        {{--  <div class="font-size-sm text-muted">Web Developer</div>--}}
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection