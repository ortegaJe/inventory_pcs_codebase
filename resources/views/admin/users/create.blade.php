@extends('layouts.backend')

@section('title', 'Nuevo tecnico')

@section('css')
<link rel="stylesheet" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">

@section('content')

<!-- Material (floating) Register -->
<div class="col-xl-12">
  <div class="block pull-r-l">
    <div class="block-header bg-gray-light">
      <h3 class="block-title">
        <i class="si si-user fa-2x font-size-default mr-5"></i>Crear Usuario
      </h3>
      <div class="block-options">
      </div>
    </div>
    <div class="block-content">
      <form action="{{ route('admin.inventory.technicians.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group row">
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control" id="cc" name="cc">
              <label for="cc">Identificación</label>
            </div>
            @if($errors->has('cc'))
            <small class="text-danger is-invalid">{{ $errors->first('cc') }}</small>
            @endif
          </div>
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control" id="firstname" name="firstname">
              <label for="firstname">Primer nombre</label>
            </div>
            @if($errors->has('firstname'))
            <small class="text-danger is-invalid">{{ $errors->first('firstname') }}</small>
            @endif
          </div>
        </div>
        <div class="form-group row">
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control" id="middlename" name="middlename">
              <label for="middlename">Segundo nombre</label>
            </div>
          </div>
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control" id="lastname" name="lastname">
              <label for="lastname">Primer apellido</label>
            </div>
            @if($errors->has('lastname'))
            <small class="text-danger is-invalid">{{ $errors->first('lastname') }}</small>
            @endif
          </div>
        </div>
        <div class="form-group row">
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control" id="second-lastname" name="second-lastname">
              <label for="second-lastname">Segundo apellido</label>
            </div>
          </div>
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control" id="nickname" name="nickname">
              <label for="nickname">Nombre de usuario</label>
            </div>
            @if($errors->has('nickname'))
            <small class="text-danger is-invalid">{{ $errors->first('nickname') }}</small>
            @endif
          </div>
        </div>
        <div class="form-group row">
          <div class="col-6">
            <div class="form-material floating">
              <input type="text" class="form-control" id="phone" name="phone">
              <label for="phone">Telefono</label>
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
              <select class="js-select2 form-control" id="val-select2-campu" name="val-select2-campu"
                style="width: 100%;" data-placeholder="Seleccionar sede..">
                <option></option>
                <!--  for data-placeholder attribute to work with Select2 plugin -->
                @forelse ($campus as $campu)
                <option value="{{ $campu->id }}">{{ Str::upper($campu->name) }}</option>
                @empty
                <option>NO EXISTEN SEDES REGISTRADAS</option>
                @endforelse
              </select>
              <label for="val-select2-campu">Sede principal</label>
            </div>
            @if($errors->has('val-select2-campu'))
            <small class="text-danger is-invalid">{{ $errors->first('val-select2-campu') }}</small>
            @endif
          </div>
          <div class="col-6">
            <div class="form-material">
              <select class="js-select2 form-control" id="val-select2-profile" name="val-select2-profile"
                style="width: 100%;" data-placeholder="Seleccionar cargo..">
                <option></option>
                <!--  for data-placeholder attribute to work with Select2 plugin -->
                @forelse ($profiles as $profile)
                <option value="{{ $profile->id }}">{{ Str::upper($profile->name) }}</option>
                @empty
                <option>NO EXISTEN CARGOS REGISTRADOS</option>
                @endforelse
              </select>
              <label for="val-select2-profile">Cargos de trabajo</label>
            </div>
            @if($errors->has('val-select2-profile'))
            <small class="text-danger is-invalid">{{ $errors->first('val-select2-profile') }}</small>
            @endif
          </div>
        </div>
        <div class="form-group row">
          <label class="col-12">Genero</label>
          <div class="col-6">
            <div class="custom-control custom-radio custom-control-inline mb-5">
              <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio1" value="F">
              <label class="custom-control-label" for="example-inline-radio1">F</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline mb-5">
              <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio2" value="M">
              <label class="custom-control-label" for="example-inline-radio2">M</label>
            </div>
            <div class="custom-control custom-radio custom-control-inline mb-5">
              <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio3" value="O">
              <label class="custom-control-label" for="example-inline-radio3">Otro</label>
            </div>
          </div>
        </div>
        <div class="form-group row">
          <div class="col-12">
            <div class="form-material input-group floating">
              <input type="email" class="form-control" id="email" name="email">
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
              <label for="password">Password</label>
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
              <label for="password2">Confirm Password</label>
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

@endpush