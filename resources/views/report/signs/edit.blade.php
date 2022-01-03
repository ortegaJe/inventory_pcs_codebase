@extends('layouts.backend')

@section('title', 'Firmas')

@section('css')
<link rel="stylesheet" href="{{ asset('/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">

@section('content')
<div class="col-md-12">
  <!-- Floating Labels -->
  <div class="block">
    <div class="block-header block-header-default">
      <h3 class="block-title">Editar administrador sede: {{ $campu_administrators->name }}</h3>
      {{-- <div class="block-options">
        <button type="button" class="btn-block-option">
          <i class="si si-wrench"></i>
        </button>
      </div> --}}
    </div>
    <div class="block-content">
      <form action="{{ route('sign.update', $campu_administrators->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group row @if($errors->has('admin_name')) is-invalid @endif">
          <div class="col-md-6">
            <div class="form-material floating">
              <input type="text" class="form-control" id="admin_name" name="admin_name"
                value="{{ $campu_administrators->admin_name }}">
              <label for="admin_name">Nombres</label>
            </div>
            @if($errors->has('admin_name'))
            <div class="invalid-feedback">{{ $errors->first('admin_name') }}</div>
            @endif
          </div>
          <div class="col-md-6">
            <div class="form-material floating">
              <input type=" text" class="form-control" id="admin_last_name" name="admin_last_name"
                value="{{ $campu_administrators->admin_last_name }}">
              <label for="admin_last_name">Apellidos</label>
            </div>
            @if($errors->has('admin_last_name'))
            <div class="invalid-feedback">{{ $errors->first('admin_last_name') }}</div>
            @endif
          </div>
        </div>
        <div class="form-group mt-4">
          <label for="sign">Cargar firmar</label>
          <div>
            <input type="file" id="sign" name="sign" accept="image/*">
          </div>
          @if($errors->has('sign'))
          <small class="text-danger is-invalid">{{ $errors->first('sign') }}</small>
          @endif
        </div>
        <h5 class="content-heading text-muted">Información Adicional</h5>
        <div class="form-group row">
          <div class="col-md-6">
            <div class="form-material floating">
              <input type="text" class="form-control" id="address" name="address"
                value="{{ $campu_administrators->address}}">
              <label for="address">Dirección sede</label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-material floating">
              <input type="text" class="form-control" id="phone" name="phone"
                value="{{ $campu_administrators->phone }}">
              <label for="phone">Telefonos sede</label>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-md-9">
            <button type="button" class="btn btn-alt-secondary"
              onclick="window.location='{{ route('sign.index') }}'">Atras</button>
            <button type="submit" class="btn btn-alt-success">Guardar</button>
          </div>
        </div>
      </form>
    </div>
  </div>
  <!-- END Floating Labels -->
</div>
@endsection

@push('js')

@if(Session::has('fail_upload_sign'))
<script>
  Swal.fire(
'La firma digital debe ser de tipo imagen',
'{!! Session::get('fail_upload_sign') !!}',
'error'
)
</script>
@endif

@endpush