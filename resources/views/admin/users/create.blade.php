@extends('layouts.backend')

@section('title', 'Nuevo técnico')

@section('css')
<link rel="stylesheet" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">

@section('content')

<!-- Material (floating) Register -->
<div class="col-xl-12">
  <div class="block pull-r-l">
    <div class="block-header bg-gray-light">
      <h3 class="block-title">
        <i class="si si-user fa-2x font-size-default mr-5"></i>Crear técnico
      </h3>
      <div class="block-options">
      </div>
    </div>
    <div class="block-content">
      <form action="{{ route('admin.inventory.technicians.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')
        <div class="form-group row">
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control" id="cc" name="cc" onkeypress="return isNumber(event)">
              <label for="cc">Identificación</label>
            </div>
            @if($errors->has('cc'))
            <small class="text-danger is-invalid">{{ $errors->first('cc') }}</small>
            @endif
          </div>
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control lower-txt" id="name" name="name"
                onkeyup="return forceUpper(this);">
              <label for="name">Primer nombre</label>
            </div>
            @if($errors->has('name'))
            <small class="text-danger is-invalid">{{ $errors->first('name') }}</small>
            @endif
          </div>
        </div>
        <div class="form-group row">
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control lower-txt" id="middle_name" name="middle_name"
                onkeyup="return forceUpper(this);">
              <label for="middle_name">Segundo nombre</label>
            </div>
          </div>
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control lower-txt" id="last_name" name="last_name"
                onkeyup="return forceUpper(this);">
              <label for="last_name">Primer apellido</label>
            </div>
            @if($errors->has('last_name'))
            <small class="text-danger is-invalid">{{ $errors->first('last_name') }}</small>
            @endif
          </div>
        </div>
        <div class="form-group row">
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control lower-txt" id="second_last_name" name="second_last_name"
                onkeyup="return forceUpper(this);">
              <label for="second_last_name">Segundo apellido</label>
            </div>
          </div>
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control lower-txt" id="nick_name" name="nick_name"
                onkeyup="return forceUpper(this);" maxlength="12">
              <label for="nick_name">Nombre de usuario</label>
            </div>
            @if($errors->has('nick_name'))
            <small class="text-danger is-invalid">{{ $errors->first('nick_name') }}</small>
            @endif
          </div>
        </div>
        <div class="form-group row">
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control" id="phone_number" name="phone_number"
                onkeypress="return isNumber(event)" maxlength="10">
              <label for="phone_number">Telefono</label>
            </div>
          </div>
          <div class="col-6">
            <div class="form-material">
              <input type="text" class="js-flatpickr form-control" id="birthday" name="birthday" placeholder="Y-m-d"
                data-allow-input="true" maxlength="10">
              <label for="birthday">Fecha de nacimiento</label>
            </div>
            @if($errors->has('birthday'))
            <small class="text-danger is-invalid">{{ $errors->first('birthday') }}</small>
            @endif
          </div>
        </div>
        <div class="form-group row">
          <div class="col-6">
            <div class="form-material">
              <select class="js-select2 form-control" id="campu" name="campu" style="width: 100%;"
                data-placeholder="Seleccionar sede..">
                <option></option>
                <!--  for data-placeholder attribute to work with Select2 plugin -->
                @forelse ($campus as $campu)
                <option value="{{ $campu->id }}">{{ $campu->name }}</option>
                @empty
                <option>NO EXISTEN SEDES REGISTRADAS</option>
                @endforelse
              </select>
              <label for="campu">Sede principal</label>
            </div>
            @if($errors->has('campu'))
            <small class="text-danger is-invalid">{{ $errors->first('campu') }}</small>
            @endif
          </div>
          <div class="col-6">
            <div class="form-material">
              <select class="js-select2 form-control" id="profile" name="profile" style="width: 100%;"
                data-placeholder="Seleccionar perfil..">
                <option></option>
                <!--  for data-placeholder attribute to work with Select2 plugin -->
                @forelse ($profiles as $profile)
                <option value="{{ $profile->id }}">{{ $profile->name }}</option>
                @empty
                <option>NO EXISTEN PERFIL REGISTRADOS</option>
                @endforelse
              </select>
              <label for="profile">Perfil</label>
            </div>
            @if($errors->has('profile'))
            <small class="text-danger is-invalid">{{ $errors->first('profile') }}</small>
            @endif
          </div>
        </div>
        <div class="form-group row">
          <label class="col-12">Genero</label>
          <div class="col-6">
            <div class="custom-control custom-radio custom-control-inline mb-5">
              <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio1" value="f">
              <label class="custom-control-label" for="example-inline-radio1">F</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline mb-5">
              <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio2" value="m">
              <label class="custom-control-label" for="example-inline-radio2">M</label>
            </div>
            {{-- <div class="custom-control custom-radio custom-control-inline mb-5">
              <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio3" value="O">
              <label class="custom-control-label" for="example-inline-radio3">Otro</label>
            </div> --}}
          </div>
        </div>
        <div class="form-group row">
          <label class="col-12" for="sign">Firma</label>
          <div class="col-6">
            <input type="file" id="sign" name="sign" accept="image/*">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-12">
            <div class="form-material input-group floating">
              <input type="email" class="form-control lower-txt" id="email" name="email">
              <label for="email">Email</label>
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="fa fa-envelope-o"></i>
                </span>
              </div>
            </div>
            @if($errors->has('email'))
            <small class="text-danger is-invalid">{{ $errors->first('email') }}</small>
            @endif
          </div>
        </div>
        <div class="form-group row">
          <div class="col-12">
            <div class="form-material input-group floating">
              <input type="password" class="form-control" id="password" name="password">
              <label for="password">Contraseña</label>
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="fa fa-asterisk"></i>
                </span>
              </div>
            </div>
            @if($errors->has('password'))
            <small class="text-danger is-invalid">{{ $errors->first('password') }}</small>
            @endif
          </div>
        </div>
        <div class="form-group row">
          <div class="col-12">
            <div class="form-material input-group floating">
              <input type="password" class="form-control" id="password2" name="password2">
              <label for="password2">Confirmar contraseña</label>
              <div class="input-group-append">
                <span class="input-group-text">
                  <i class="fa fa-asterisk"></i>
                </span>
              </div>
            </div>
          </div>
        </div>
        <button type="submit" class="btn btn-sm btn-alt-success min-width-125 mt-4 mb-4" data-toggle="click-ripple">
          <i class="fa fa-save"></i> Guardar
        </button>
      </form>
    </div>
  </div>
</div>
<!-- END Material (floating) Register -->

@endsection

@push('js')
<!-- Page JS Code -->
<script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

<!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins) -->
<script>
  jQuery(function(){ Codebase.helpers(['flatpickr', 'datepicker', 'select2']); });
</script>

<script>
  function forceUpper(strInput) {
    strInput.value=strInput.value.toUpperCase();
  }
</script>

<script>
  function isNumber(evt) {
  evt = (evt) ? evt : window.event;
  var charCode = (evt.which) ? evt.which : evt.keyCode;
  if (charCode > 31 && (charCode < 48 || charCode> 57)) {
    return false;
    }
    return true;
    }
</script>
@endpush