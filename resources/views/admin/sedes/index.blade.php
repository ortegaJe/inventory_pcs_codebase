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
    <a class="block block-link-pop text-center" href="{{ route('admin.inventory.campus.show', [trim($campu->slug)]) }}">
      <div class="block-content text-center">
        <div class="item item-circle bg-success-light text-success mx-auto my-10">
          <i class="fa fa-building-o"></i>
        </div>
        {{-- <divclass="font-size-smtext-muted">equipos --}}
      </div>
      <div class="block-content bg-body-light">
        <p class="font-w600">
          {{ Str::upper($campu->description) }}
        </p>
      </div>
    </a>
  </div>
  @endforeach
</div>
@endsection