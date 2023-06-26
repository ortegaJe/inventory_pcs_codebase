@extends('layouts.backend')

@section('title', 'Registrar equipo')

@section('css')
<link rel="stylesheet" href="{{ asset('/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">

@section('content')
<div class="row">
  <div class="col-md-12 mx-auto">
    <h2 class="content-heading">Registrar Nuevo Equipo De Escritorio</h2>
    @if ($errors->any())
    <div class="alert alert-danger">
      <strong>Whoops!</strong> There were some problems with your input.<br><br>
      <ul>
        @foreach ($errors->all() as $error)
        <li style="list-style:none;"><i class="fa fa-times text-pulse mr-5"></i>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
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
          <a class="nav-link" href="#wizard-progress2-step2" data-toggle="tab">2. Hardware</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#wizard-progress2-step3" data-toggle="tab">3. Red</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#wizard-progress2-step4" data-toggle="tab">4. Ubicación</a>
        </li>
      </ul>
      <!-- END Step Tabs -->

      <!-- Form -->
      <form action="{{ route('user.inventory.desktop.store') }}" method="POST">
        @csrf
        @method('POST')
        <!-- Steps Content -->
        <div class="block-content block-content-full tab-content" style="min-height: 274px;">
          <!-- Step 1 -->
          <div class="tab-pane active" id="wizard-progress2-step1" role="tabpanel">
            <div class="form-group row">
              <div class="col-md-4">
                <div class="form-material">
                  <select class="js-select2 form-control" id="brand" name="brand" style="width: 100%;"
                    data-placeholder="Seleccionar fabricante..">
                    <option disabled selected></option>
                    <!-- Empty value for demostrating material select box -->
                    @forelse ($brands as $brand)
                    @if(old('brand') == $brand->id)
                    <option value="{{ $brand->id }}" selected>
                      {{ $brand->name }}
                    </option>
                    @else
                    <option value="{{ $brand->id }}">
                      {{ $brand->name }}
                    </option>
                    @endif
                    @empty
                    <option>NO EXISTEN FABRICANTES REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="brand_id">Fabricantes</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-material">
                  <select class="js-select2 form-control" id="os" name="os" style="width: 100%;"
                    data-placeholder="Seleccionar sistema operativo..">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($operatingSystems as $os)
                    @if(old('os') == $os->id)
                    <option value="{{ $os->id }}" selected>{{ $os->name }} {{ $os->version }} {{ $os->architecture }}
                    </option>
                    @else
                    <option value="{{ $os->id }}">{{ $os->name }} {{ $os->version }} {{ $os->architecture }}</option>
                    @endif
                    @empty
                    <option>NO EXISTEN SISTEMAS OPERATIVOS REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="os">Sistema Operativo</label>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}"
                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                    onkeypress="return /[0-9a-zA-Z-(), ]/i.test(event.key)">
                  <label for="model">Modelo</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fa fa-fw fa-paint-brush"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-4">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="serial" name="serial"
                    value="{{ old('serial') }}" onkeyup="javascript:this.value=this.value.toUpperCase();"
                    onkeypress="return /[0-9a-zA-Z]/i.test(event.key)">
                  <label for="serial">Número Serial</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fa fa-fw fa-barcode"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="monitor_serial" name="monitor_serial"
                    value="{{ old('monitor_serial') }}" onkeyup="javascript:this.value=this.value.toUpperCase();"
                    onkeypress="return /[0-9a-zA-Z]/i.test(event.key)">
                  <label for="monitor_serial">Número Serial de monitor</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fa fa-fw fa-barcode"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="fixed_asset_number" name="fixed_asset_number"
                    value="{{ old('fixed_asset_number') }}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="fixed_asset_number">Codigo de activo fijo</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fa fa-fwfa-barcode"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END Step 1 -->

          <!-- Step 2 -->
          <div class="tab-pane" id="wizard-progress2-step2" role="tabpanel">
            <div class="form-group row">
              <div class="col-md-3">
                <div class="form-material">
                  <select class="js-select2 form-control" id="ram0" name="ram0"
                    style="width: 100%;" data-placeholder="Seleccionar RAM ranura 1">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($memoryRams as $ram)
                    @if(old('ram0') == $ram->id)
                    <option value="{{ $ram->id }}" selected> {{ $ram->size }}{{ $ram->storage_unit }}{{ $ram->type }}
                      {{ $ram->format }}
                    </option>
                    @else
                    <option value="{{ $ram->id }}"> {{ $ram->size }}{{ $ram->storage_unit }}{{ $ram->type }}
                      {{ $ram->format }}
                    </option>
                    @endif
                    @empty
                    <option>NO EXISTEN MEMORIAS RAM REGISTRADAS</option>
                    @endforelse
                  </select>
                  <label for="ram0">Memorias RAM</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-material">
                  <select class="js-select2 form-control" id="ram1" name="ram1"
                    value="{{ old('ram1') }}" style="width: 100%;"
                    data-placeholder="Seleccionar RAM ranura 2">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($memoryRams as $ram)
                    @if(old('ram1') == $ram->id)
                    <option value="{{ $ram->id }}" selected> {{ $ram->size }}{{ $ram->storage_unit }}{{ $ram->type }}
                      {{ $ram->format }}
                    </option>
                    @else
                    <option value="{{ $ram->id }}"> {{ $ram->size }}{{ $ram->storage_unit }}{{ $ram->type }}
                      {{ $ram->format }}
                    </option>
                    @endif
                    @empty
                    <option>NO EXISTEN MEMORIAS RAM REGISTRADAS</option>
                    @endforelse
                  </select>
                  <label for="ram1">Memorias RAM</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-material">
                  <select class="js-select2 form-control" id="hdd0" name="hdd0"
                    style="width: 100%;" data-placeholder="Seleccionar primer almacenamiento..">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($storages as $storage)
                    @if(old('hdd0') == $storage->id)
                    <option value="{{ $storage->id }}" selected>{{ $storage->size }} {{ $storage->storage_unit }}
                      {{ $storage->type }}
                    </option>
                    @else
                    <option value="{{ $storage->id }}">{{ $storage->size }} {{ $storage->storage_unit }}
                      {{ $storage->type }}
                    </option>
                    @endif
                    @empty
                    <option>NO EXISTEN DISCO DUROS REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="hdd0">Almacenamiento</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-material">
                  <select class="js-select2 form-control" id="hdd1" name="hdd1"
                    style="width: 100%;" data-placeholder="Seleccionar segundo almacenamiento..">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($storages as $storage)
                    @if(old('hdd1') == $storage->id)
                    <option value="{{ $storage->id }}" selected>{{ $storage->size }} {{ $storage->storage_unit }}
                      {{ $storage->type }}
                    </option>
                    @else
                    <option value="{{ $storage->id }}">{{ $storage->size }} {{ $storage->storage_unit }}
                      {{ $storage->type }}
                    </option>
                    @endif
                    @empty
                    <option>NO EXISTEN DISCO DUROS REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="hdd1">Almacenamiento</label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <div class="form-material">
                  <select class="js-select2 form-control" id="processor" name="processor" style="width: 100%;"
                    data-placeholder="Seleccionar procesador..">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($processors as $cpu)
                    @if(old('processor') == $cpu->id)
                    <option value="{{ $cpu->id }}" selected>{{ $cpu->brand }} {{ $cpu->generation }}
                      {{ $cpu->velocity }}
                    </option>
                    @else
                    <option value="{{ $cpu->id }}">{{ $cpu->brand }} {{ $cpu->generation }}
                      {{ $cpu->velocity }}
                    </option>
                    @endif
                    @empty
                    <option>NO EXISTEN PROCESADORES REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="processor">Procesador</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-material">
                  <select class="js-select2 form-control" id="statu" name="statu" style="width: 100%;"
                    data-placeholder="Seleccionar un estado..">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($status as $statu)
                    @if(old('statu') == $statu->id)
                    <option value="{{ $statu->id }}" selected>{{ Str::title($statu->name) }}</option>
                    @else
                    <option value="{{ $statu->id }}">{{ Str::title($statu->name) }}</option>
                    @endif
                    @empty
                    <option>NO EXISTEN ESTADOS REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="statu">Estado del equipo</label>
                </div>
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
                  <input type="text" class="form-control" id="ip" name="ip" maxlength="15" value="{{ old('ip') }}"
                    onkeypress="return /[0-9-.]/i.test(event.key)"
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
                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                    onkeypress="return /[0-9a-zA-Z:-]/i.test(event.key)">
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
              <div class="col-md-4">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="anydesk" name="anydesk" maxlength="24"
                    value="{{ old('anydesk') }}" onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="ip">Anydesk</label>
                  <div class="input-group-append">
                    <label for="anydesk"><img class="img-fluid" width="20px"
                        src="https://ubuntupit.com/wp-content/uploads/2019/03/AnyDesk-remote.png" alt="anydesk">
                    </label>
                  </div>
                </div>
                @if($errors->has('anydesk'))
                <small class="text-danger is-invalid">{{ $errors->first('anydesk') }}</small>
                @endif
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <div class="form-material">
                    <select class="js-select2 form-control" id="domain_name" name="domain_name" style="width: 100%;"
                      data-placeholder="Seleccionar dominio..">
                      <option disabled selected></option>
                      <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                      @forelse ($domainNames as $domainName)
                      @if(old('domain_name') == $domainName)
                      <option selected>{{ $domainName }}</option>
                      @else
                      <option>{{ $domainName }}</option>
                      @endif
                      @empty
                      <option>NO EXISTEN DOMINIOS REGISTRADAS</option>
                      @endforelse
                    </select>
                    <label for="domain_name"><i class="fa fa-sitemap"></i> Dominio</label>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-material floating">
                  <input type="text" class="form-control" id="device_name" name="device_name" maxlength="20"
                    onkeypress="return /[0-9a-zA-Z-]/i.test(event.key)" value="{{ old('device_name') }}"
                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="device_name">Nombre del equipo</label>
                </div>
                <div class="block-content block-content-full">
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
                    <select class="js-select2 form-control" id="campu" name="campu" style="width: 100%;"
                      data-placeholder="Seleccionar Sede..">
                      <option></option>
                      <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                      @forelse ($campus as $campu)
                      @if(old('campu') == $campu->id)
                      <option value="{{ $campu->id }}" selected>{{ $campu->name }}</option>
                      @else
                      <option value="{{ $campu->id }}">{{ $campu->name }}</option>
                      @endif
                      @empty
                      <option>NO EXISTEN SEDES REGISTRADAS</option>
                      @endforelse
                    </select>
                    <label for="campu"><i class="fa fa-building"></i> Sede del equipo</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="location" name="location" value="{{ old('location') }}"
                    onkeypress="return /[0-9a-zA-ZñÑóÓíÍ ]/i.test(event.key)"
                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="location">Ubicación en la sede</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fa fa-map-marker"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-3">
                <div class="form-material">
                  <input type="text" class="js-flatpickr form-control" id="custodian_date"
                    name="custodian_date" value="{{ old('custodian_date') }}" placeholder="d-m-Y"
                    data-allow-input="true" maxlength="10">
                  <label for="custodian_date">Fecha de asignación al custodio</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="custodian_name" name="custodian_name" maxlength="56"
                    value="{{ old('custodian_name') }}" onkeypress="return /[0-9a-zA-ZñÑóÓíÍ. ]/i.test(event.key)"
                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="custodian_name">Nombres y apellidos del custodio</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fa fa-user"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-material">
                  <select class="js-select2 form-control" id="statu_assignment" name="statu_assignment"
                    style="width: 100%;" data-placeholder="Seleccionar concepto..">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($statusAssignments as $statuAssignment)
                    @if(old('statu_assignment') == $statuAssignment->id)
                    <option value="{{ $statuAssignment->id }}" selected>
                      {{ Str::title($statuAssignment->name) }}
                    </option> @else
                    <option value="{{ $statuAssignment->id }}">
                      {{ Str::title($statuAssignment->name) }}
                    </option> @endif
                    @empty
                    <option>NO EXISTEN ESTADOS REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="statu_assignment">Concepto</label>
                </div>
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
<script src="{{ asset('/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

<!-- Page JS Code -->
<script src="{{ asset('/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js ')}}"></script>
<script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

<!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins) -->
<script>
  jQuery(function(){ Codebase.helpers(['flatpickr', 'datepicker','maxlength', 'select2']); });
</script>

{{-- @if(Session::has('message'))
<script>
  Swal.fire(
  '{!! Session::get('message') !!}',
  '{{ $error }}',
  '{{ Session::get('modal') }}'
  )
</script>
@endif

@if(Session::has('info_error'))
<script>
  Swal.fire(
  '{!! Session::get('info_error') !!}',
  '{{ Session::get('modal') }}'
  )
</script>
@endif --}}
@endpush
{{-- https://dev.to/jeromew90/how-use-sweetalert2-in-laravel-8-using-composer-jki --}}
{{-- https://stackoverflow.com/questions/65172778/how-to-use-sweetalert-messages-for-validation-in-laravel-8 --}}