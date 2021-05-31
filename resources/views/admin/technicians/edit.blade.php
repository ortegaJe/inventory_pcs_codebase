@extends('layouts.backend')

@section('title', 'Actualizar técnico')

@section('css')
<link rel="stylesheet" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">

@section('content')

<div class="col-xl-12">
    <!-- Material (floating) Register -->
    <div class="block block-themed">
        <div class="block-header bg-corporative">
            <h3 class="block-title">Actualizar técnico</h3>
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle"
                    data-action-mode="demo">
                    <i class="si si-refresh"></i>
                </button>
                <button type="button" class="btn-block-option" data-toggle="block-option"
                    data-action="content_toggle"></button>
            </div>
        </div>
        <div class="block-content">
            <form action="{{ route('admin.inventory.technicians.update', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="form-group row">
                    <div class="col-3">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="tec-firstname" name="tec-firstname"
                                value="{{ $user->name }}">
                            <label for="tec-firstname">Primer nombre</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="tec-second-middlename"
                                name="tec-second-middlename">
                            <label for="tec-second-middlename">Segundo nombre</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="tec-lastname" name="tec-lastname">
                            <label for="tec-lastname">Primer apellido</label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="tec-second-lastname" name="tec-second-lastname">
                            <label for="tec-second-lastname">Segundo apellido</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="form-group col-md-2">
                        <div class="form-material">
                            <input type="text" class="js-flatpickr form-control" id="tec-age" name="tec-age"
                                placeholder="d-m-Y" data-allow-input="true" maxlength="10">
                            <label for="tec-age">Fecha de nacimiento</label>
                        </div>
                        @if($errors->has('tec-age'))
                        <small class="text-danger is-invalid">{{ $errors->first('tec-age') }}</small>
                        @endif
                    </div>
                    <div class="col-3">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="tec-phone" name="tec-phone">
                            <label for="tec-phone">Telefono</label>
                        </div>
                    </div>
                    <div class="col-md-3 mb-3">
                        <div class="form-group">
                            <div class="form-material">
                                <select class="js-select2 form-control" id="val-select2-profile"
                                    name="val-select2-profile" style="width: 100%;"
                                    data-placeholder="Seleccionar cargo..">
                                    <option></option>
                                    <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                    <option value=""></option>
                                    <option value="">NO SE ENTRARON ROLES REGISTRADOS</option>
                                </select>
                                <label for="val-select2-profile">Cargos de trabajo</label>
                            </div>
                            @if($errors->has('val-select2-profile'))
                            <small class="text-danger is-invalid">{{ $errors->first('val-select2-profile') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="col-2">
                        <label for="">Genero: </label>
                        <label class="css-control css-control-success css-radio">
                            <input type="radio" class="css-control-input" name="tec-gen[]" checked="" value="F">
                            <span class="css-control-indicator"></span> F
                        </label>
                        <label class="css-control css-control-success css-radio">
                            <input type="radio" class="css-control-input" name="tec-gen[]" value="M">
                            <span class="css-control-indicator"></span> M
                        </label>
                        <label class="css-control css-control-success css-radio">
                            <input type="radio" class="css-control-input" name="tec-gen[]" value="O">
                            <span class="css-control-indicator"></span> Otro
                        </label>
                    </div>
                    @foreach ($roles as $rol)
                    <div class="ml-2">
                        <label class="css-control css-control-success css-checkbox">
                            <input type="checkbox" class="css-control-input" name="rol[]" value="{{ $rol->id }}">
                            <span class="css-control-indicator"></span> {{ $rol->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="form-material input-group floating">
                            <input type="email" class="form-control" id="tec-email" name="tec-email">
                            <label for="tec-email">Email</label>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-envelope-o"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="form-material input-group floating">
                            <input type="password" class="form-control" id="tec-password" name="tec-password">
                            <label for="tec-password">Password</label>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-asterisk"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="form-material input-group floating">
                            <input type="password" class="form-control" id="tec-password2" name="tec-password2">
                            <label for="tec-password2">Confirm Password</label>
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <i class="fa fa-asterisk"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-alt-success">
                            <i class="fa fa-plus mr-5"></i> Registrar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Material (floating) Register -->
</div>

@endsection

@push('js')
<!-- Page JS Code -->
<script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

<!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins) -->
<script>
    jQuery(function(){ Codebase.helpers(['flatpickr', 'datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']); });
</script>

@endpush