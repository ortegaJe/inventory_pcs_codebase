@extends('layouts.backend')

@section('title', 'Roles & Permisos')

@section('content')

@if(session('info'))
<div class="alert alert-success">
  <strong>{{ session('info') }}</strong>
</div>
@endif

<!-- Overview -->
<div class="content-heading">
  <div class="dropdown float-right">
    <button type="button" onclick="window.location='{{ route('admin.inventory.roles.create') }}'"
      class="btn btn-sm btn-alt-primary min-width-125" data-toggle="click-ripple">
      <i class="si si-badge"></i> Nuevo Rol
    </button>
  </div>
  Roles & Permisos
</div>
<!-- END Overview -->

<div class="row">
  @foreach($roles as $role)
  <div class="col-md-6 col-xl-3">
    <a class="block block-link-pop text-center" href="#">
      <div class="block-content text-center">
        <div class="item item-circle bg-primary-lighter text-primary mx-auto my-10">
          <i class="si si-badge"></i>
        </div>
        {{-- <divclass="font-size-smtext-muted">equipos --}}
      </div>
      <div class="block-content bg-body-light">
        <p class="font-w600">
          {{ Str::upper($role->name) }}
        </p>
      </div>
    </a>
  </div>
  @endforeach
</div>

@endsection