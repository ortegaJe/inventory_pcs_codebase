@extends('layouts.backend')

@section('title', 'Registrar telefono IP')

@section('css')
<link rel="stylesheet" href="{{ asset('/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">

@section('content')
<div class="row">
  <div class="col-md-12 mx-auto">
    <h2 class="content-heading">Registrar Nuevo Telefono IP</h2>
    <!-- Progress Wizard 2 -->
    <div class="js-wizard-simple block">
      <!-- Wizard Progress Bar -->
      <div class="progress rounded-0" data-wizard="progress" style="height: 8px;">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 34.3333%;"
          aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
      </div>
      <!-- END Wizard Progress Bar -->

      <!-- Step Tabs -->
      <ul class="nav nav-tabs nav-tabs-alt nav-fill" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" href="#wizard-progress2-step1" data-toggle="tab">1. Equipo</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#wizard-progress2-step2" data-toggle="tab">2. Accesorios</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#wizard-progress2-step3" data-toggle="tab">3. Red</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#wizard-progress2-step4" data-toggle="tab">3. Ubicacion</a>
        </li>
      </ul>
      <!-- END Step Tabs -->

      <!-- Form -->
      <form action="{{ route('user.inventory.phones.store') }}" method="POST">
        @csrf
        @method('POST')
        <!-- Steps Content -->
        <div class="block-content block-content-full tab-content" style="min-height: 274px;">
          <!-- Step 1 -->
          <div class="tab-pane active" id="wizard-progress2-step1" role="tabpanel">
            @if (Session::has('message'))
            <div data-notify="container"
              class="col-xs-11 col-sm-4 alert-message alert alert-{{ Session::get('typealert') }} animated fadeIn"
              role="alert" data-notify-position="top-right"
              style="display: inline-block; margin: 0px auto; position: fixed; transition: all 0.5s ease-in-out 0s; z-index: 1033; top: 20px; right: 20px; animation-iteration-count: 1;">
              <button type="button" aria-hidden="true" class="close" data-notify="dismiss"
                style="position: absolute; right: 10px; top: 5px; z-index: 1035;">×</button><span data-notify="icon"
                class="fa fa-times"></span> <span data-notify="title"></span> <span data-notify="message">{{
                Session::get('message') }}
              </span><a href="#" target="_blank" data-notify="url"></a>
            </div>
            @endif
            {{-- @if (Session::has('message'))
            <div class="alert alert-{{ Session::get('typealert') }} alert-dismissible fade show" style="d-none">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5><i class="icon fas fa-ban"></i> Upsss!</h5>
              {{ Session::get('message') }}
              @if ($errors->any())
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
              @endif --}}
              <div class="form-group row">
                <div class="col-md-6">
                  <div class="form-material">
                    <select class="js-select2 form-control" id="marca-pc-select2" name="marca-pc-select2"
                      style="width: 100%;" data-placeholder="Seleccionar fabricante..">
                      <option disabled selected></option>
                      <!-- Empty value for demostrating material select box -->
                      @forelse ($brands as $brand)
                      <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                      @empty
                      <option>NO EXISTEN FABRICANTES REGISTRADOS</option>
                      @endforelse
                    </select>
                    <label for="marca-pc-select2">Fabricantes</label>
                  </div>
                  @if($errors->has('marca-pc-select2'))
                  <small class="text-danger is-invalid">{{ $errors->first('marca-pc-select2') }}</small>
                  @endif
                </div>
                <div class="col-md-6">
                  <div class="form-material floating input-group">
                    <input type="text" class="form-control" id="modelo-pc" name="modelo-pc"
                      value="{{ old('modelo-pc') }}" maxlength="100"
                      onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <label for="modelo-pc">Modelo</label>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fa fa-fw fa-paint-brush"></i>
                      </span>
                    </div>
                  </div>
                  @if($errors->has('modelo-pc'))
                  <small class="text-danger is-invalid">{{ $errors->first('modelo-pc') }}</small>
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                  <div class="form-material floating input-group">
                    <input type="text" class="form-control" id="serial-pc" name="serial-pc"
                      value="{{ old('serial-pc') }}" maxlength="24"
                      onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <label for="serial-pc">Numero Serial</label>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fa fa-fw fa-barcode"></i>
                      </span>
                    </div>
                  </div>
                  @if($errors->has('serial-pc'))
                  <small class="text-danger is-invalid">{{ $errors->first('serial-pc') }}</small>
                  @endif
                </div>
                <div class="col-md-6">
                  <div class="form-material floating input-group">
                    <input type="text" class="form-control" id="activo-fijo-pc" name="activo-fijo-pc"
                      value="{{ old('activo-fijo-pc') }}" maxlength="20"
                      onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <label for="activo-fijo-pc">Codigo de activo fijo</label>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        {{-- <iclass="fafa-fwfa-barcode"></i> --}}
                      </span>
                    </div>
                  </div>
                  @if($errors->has('activo-fijo-pc'))
                  <small class="text-danger is-invalid">{{ $errors->first('activo-fijo-pc') }}</small>
                  @endif
                </div>
              </div>
            </div>
            <!-- END Step 1 -->

            <!-- Step 2 -->
            <input type="hidden" name="handset" value="0">
            <input type="hidden" name="power-adapter" value="0">
            <div class="tab-pane" id="wizard-progress2-step2" role="tabpanel">
              <div class="form-group row text-center">
                <div class="col-md-6">
                  <div class="mb-2"><i class="fa fa-phone fa-4x text-muted"></i></div>
                  <label class="css-control css-control-primary css-checkbox" for="handset">
                    <input type="checkbox" class="css-control-input" id="handset" name="handset" value="1">
                    <span class="css-control-indicator"></span> Tiene bocina?
                  </label>
                </div>
                <div class="col-md-6">
                  <div class="mb-2"><i class="fa fa-plug fa-4x text-muted"></i></div>
                  <label class="css-control css-control-primary css-checkbox" for="power-adapter">
                    <input type="checkbox" class="css-control-input" id="power-adapter" name="power-adapter" value="1">
                    <span class="css-control-indicator"></span> tiene adaptador de energia?
                  </label>
                </div>
              </div>
              {{--<div class="col-md-6">
                <label class="css-control css-control-sm css-control-success css-switch">
                  <div class="mb-2 text-center"><i class="fa fa-phone fa-4x text-muted"></i></div>
                  <input type="hidden" name="handset" value="0">
                  <input type="checkbox" class="css-control-input" id="handset" name="handset" value="1">
                  <span class="css-control-indicator"></span> Tiene bocina?
                </label>
              </div>
              <div class="col-md-6">
                <label class="css-control css-control-sm css-control-success css-switch">
                  <div class="mb-2 text-center"><i class="fa fa-plug fa-4x text-muted"></i></div>
                  <input type="hidden" name="power-adpater" value="0">
                  <input type="checkbox" class="css-control-input" id="power-adapter" name="power-adapter" value="1">
                  <span class="css-control-indicator"></span> Tiene adaptador de corriente?
                </label>
              </div>--}}
              <div class="form-group row">
                <div class="col-md-6">
                  <div class="form-material">
                    <select class="js-select2 form-control" id="val-select2-status" name="val-select2-status"
                      style="width: 100%;" data-placeholder="Seleccionar un estado..">
                      <option disabled selected></option>
                      <!-- Empty value for demostrating material select box -->
                      @forelse ($status as $statu)
                      <option value="{{ $statu->id }}">{{ Str::title($statu->name) }}
                      </option>
                      @empty
                      <option>NO EXISTEN ESTADOS REGISTRADOS</option>
                      @endforelse
                    </select>
                    <label for="val-select2-status">Estado del equipo</label>
                  </div>
                  @if($errors->has('val-select2-status'))
                  <small class="text-danger is-invalid">{{ $errors->first('val-select2-status') }}</small>
                  @endif
                </div>
              </div>
              @if (Auth::id() == 13)
              <div class="form-group row">
                <div class="col-md-3">
                  <label class="css-control css-control-primary css-switch css-switch-square">
                    <input type="checkbox" class="css-control-input" id="stock" name="stock">
                    <span class="css-control-indicator"></span> EN STOCK
                  </label>
                </div>
              </div>
              @endif
            </div>
            <!-- END Step 2 -->
            <!-- Step 3 -->
            <div class="tab-pane" id="wizard-progress2-step3" role="tabpanel">
              <div class="form-group row">
                <div class="col-md-6">
                  <div class="form-material floating input-group">
                    <input type="text" class="form-control" id="ip" name="ip" maxlength="16" value="{{ old('ip') }}"
                      onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <label for="ip">Dirección IP</label>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fa fa-sitemap"></i>
                      </span>
                    </div>
                  </div>
                  @if($errors->has('ip'))
                  <small class="text-danger is-invalid">{{ $errors->first('ip') }}</small>
                  @endif
                </div>
                <div class="col-md-6">
                  <div class="form-material floating input-group">
                    <input type="text" class="form-control" id="mac" name="mac" maxlength="17" value="{{ old('mac') }}"
                      onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <label for="mac">Dirección MAC</label>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fa fa-sitemap"></i>
                      </span>
                    </div>
                  </div>
                  @if($errors->has('mac'))
                  <small class="text-danger is-invalid">{{ $errors->first('mac') }}</small>
                  @endif
                </div>
              </div>
              <div class="form-group row">
                <div class="col-md-6">
                  <div class="form-group">
                    <div class="form-material">
                      <select class="js-select2 form-control" id="pc-domain-name" name="pc-domain-name"
                        style="width: 100%;" data-placeholder="Seleccionar dominio..">
                        <option></option>
                        <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                        @forelse ($domainNames as $domainName)
                        <option>{{ $domainName }}</option>
                        @empty
                        <option>NO EXISTEN DOMINIOS REGISTRADAS</option>
                        @endforelse
                      </select>
                      <label for="pc-domain-name"><i class="fa fa-sitemap"></i> Dominio</label>
                    </div>
                    @if($errors->has('pc-domain-name'))
                    <small class="text-danger is-invalid">{{ $errors->first('pc-domain-name') }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-material floating">
                    <input type="text" class="form-control" id="pc-name" name="pc-name" maxlength="20"
                      value="{{ old('pc-name') }}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <label for="pc-name">Nombre del equipo</label>
                  </div>
                  @if($errors->has('pc-name'))
                  <small class="text-danger is-invalid">{{ $errors->first('pc-name') }}</small>
                  @endif
                  <div class="block-content block-content-full">
                    {{-- <button type="button" class="btn btn-alt-info ml-2 float-right" data-toggle="tooltip"
                      data-placement="bottom" title="Ver abreviados de las sedes">
                      <i class="fa fa-info-circle"></i>
                    </button>
                    <button type="button" class="btn btn-alt-info float-right" data-toggle="popover"
                      title=" Nombre de equipos" data-placement="Right"
                      data-content="Deberia ser: V1AMAC-CON21 (V1A = VIVA 1A) (MAC = abreviado de la sede) (-CON21 = ubicación del equipo dentro de la sede).">
                      <i class="fa fa-info-circle"></i>
                      Como nombrar equipos?
                    </button>--}}
                  </div>
                </div>
              </div>
              <!-- END Step 3 -->
            </div>
            <!-- Step 4 -->
            <div class="tab-pane" id="wizard-progress2-step4" role="tabpanel">
              <div class="form-row">
                <div class="col-md-6 mb-3">
                  <div class="form-group">
                    <div class="form-material">
                      <select class="js-select2 form-control" id="val-select2-campus" name="val-select2-campus"
                        style="width: 100%;" data-placeholder="Seleccionar Sede..">
                        <option></option>
                        <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                        @forelse ($campus as $campu)
                        <option value="{{ $campu->id }}">{{ $campu->name }}</option>
                        @empty
                        <option>NO EXISTEN SEDES REGISTRADAS</option>
                        @endforelse
                      </select>
                      <label for="val-select2-campus"><i class="fa fa-building"></i> Sede del
                        equipo</label>
                    </div>
                    @if($errors->has('val-select2-campus'))
                    <small class="text-danger is-invalid">{{ $errors->first('val-select2-campus') }}</small>
                    @endif
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-material floating input-group">
                    <input type="text" class="form-control" id="location" name="location" maxlength="56"
                      value="{{ old('location') }}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <label for="location">Ubicación en la sede</label>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fa fa-map-marker"></i>
                      </span>
                    </div>
                  </div>
                  @if($errors->has('location'))
                  <small class="text-danger is-invalid">{{ $errors->first('location') }}</small>
                  @endif
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-3">
                  <div class="form-material">
                    <input type="text" class="js-flatpickr form-control" id="custodian-assignment-date"
                      name="custodian-assignment-date" placeholder="d-m-Y" data-allow-input="true" maxlength="10">
                    <label for="custodian-assignment-date">Fecha de asignación al custodio</label>
                  </div>
                  @if($errors->has('custodian-assignment-date'))
                  <small class="text-danger is-invalid">{{ $errors->first('custodian-assignment-date') }}</small>
                  @endif
                </div>
                <div class="col-md-6">
                  <div class="form-material floating input-group">
                    <input type="text" class="form-control" id="custodian-name" name="custodian-name" maxlength="56"
                      value="{{ old('custodian-name') }}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <label for="custodian-name">Nombres y apellidos del custodio</label>
                    <div class="input-group-append">
                      <span class="input-group-text">
                        <i class="fa fa-user"></i>
                      </span>
                    </div>
                  </div>
                  @if($errors->has('custodian-name'))
                  <small class="text-danger is-invalid">{{ $errors->first('custodian-name') }}</small>
                  @endif
                </div>
                <div class="col-md-3">
                  <div class="form-material">
                    <select class="js-select2 form-control" id="val-select2-status-assignment"
                      name="val-select2-status-assignment" style="width: 100%;"
                      data-placeholder="Seleccionar concepto..">
                      <option disabled selected></option>
                      <!-- Empty value for demostrating material select box -->
                      @forelse ($statusAssignments as $statuAssignment)
                      <option value="{{ $statuAssignment->id }}">
                        {{ Str::title($statuAssignment->name) }}
                      </option>
                      @empty
                      <option>NO EXISTEN ESTADOS REGISTRADOS</option>
                      @endforelse
                    </select>
                    <label for="val-select2-status-assignment">Concepto</label>
                  </div>
                  @if($errors->has('val-select2-status-assignment'))
                  <small class="text-danger is-invalid">{{ $errors->first('val-select2-status-assignment') }}</small>
                  @endif
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-12">
                  <div class="form-material">
                    <textarea class="js-maxlength form-control" id="observation" name="observation" rows="3"
                      maxlength="255" placeholder="Escriba aqui una observación" data-always-show="true"
                      data-warning-class="badge badge-primary" data-limit-reached-class="badge badge-warning"
                      value="{{ old('observation') }}"
                      onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                    <label for="observation">Observación</label>
                  </div>
                </div>
                @if($errors->has('observation'))
                <small class="text-danger is-invalid">{{ $errors->first('observation') }}</small>
                @endif
              </div>
              <!-- END Step 4 -->
            </div>
          </div>
          <!-- END Steps Content -->

          <!-- Steps Navigation -->
          <div class="block-content block-content-sm block-content-full bg-body-light">
            <div class="row">
              <div class="col-6">
                <button type="button" class="btn btn-alt-secondary disabled" data-wizard="prev">
                  <i class="fa fa-angle-left mr-5"></i> Atras
                </button>
              </div>
              <div class="col-6 text-right">
                <button type="button" class="btn btn-alt-secondary" data-wizard="next">
                  Siguiente <i class="fa fa-angle-right ml-5"></i>
                </button>
                <button type="submit" class="btn btn-alt-primary d-none" data-wizard="finish">
                  <i class="fa fa-check mr-5"></i> Guardar
                </button>
              </div>
            </div>
          </div>
          <!-- END Steps Navigation -->
      </form>
      <!-- END Form -->
    </div>
    <!-- END Progress Wizard 2 -->
  </div>
</div>
@endsection

@push('js')
<script src="{{ asset('/js/pages/be_ui_activity.min.js') }}"></script>
<script src="{{ asset('/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

<!-- Page JS Code -->
<script src="{{ asset('/js/pages/be_forms_plugins.min.js') }}"></script>
<script src="{{ asset('/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js ')}}"></script>
<script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

<!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins) -->
<script>
  jQuery(function(){ Codebase.helpers(['flatpickr', 'datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider', 'tags-inputs']); });
</script>

<script>
  $('.text-danger').slideDown();
  setTimeout(function(){ $('.text-danger').slideUp(); }, 50000);
</script>

<script>
  $('.alert-message').fadeIn();
  setTimeout(function(){ $('.alert-message').slideUp(); }, 10000);
</script>
@endpush