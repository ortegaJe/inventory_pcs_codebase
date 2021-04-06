@extends('layouts.backend')

@section('title', 'Registrar equipo')

@section('content')
<div class="row">
  <div class="col-md-12 mx-auto">
    <h2 class="content-heading">Registro de equipos</h2>
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
          <a class="nav-link" href="#wizard-progress2-step4" data-toggle="tab">3. Ubicacion</a>
        </li>
      </ul>
      <!-- END Step Tabs -->

      <!-- Form -->
      <form action="{{ route('admin.pcs.store') }}" method="POST">
        @csrf
        @method('POST')
        <!-- Steps Content -->
        <div class="block-content block-content-full tab-content" style="min-height: 274px;">
          <!-- Step 1 -->
          <div class="tab-pane active" id="wizard-progress2-step1" role="tabpanel">
            <div class="form-group row">
              <div class="col-md-3">
                <div class="form-material floating">
                  <select class="form-control" id="tipos-pc-select2" name="tipos-pc-select2">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($types as $type)
                    <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @empty
                    <option value="tipos-pc-select2">NO EXISTEN TIPOS DE EQUIPOS REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="tipos-pc-select2">Tipo de equipo</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-material floating">
                  <select class="form-control" id="marca-pc-select2" name="marca-pc-select2">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                    @empty
                    <option value="">NO EXISTEN FABRICANTES REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="marca-pc-select2">Seleccionar fabricante</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-material">
                  <select class="js-select2 form-control" id="os-pc-select2" name="os-pc-select2" style="width: 100%;"
                    data-placeholder="Seleccione sistema operativo..">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($operating_systems as $os)
                    <option value="{{ $os->id }}">{{ $os->name }} {{ $os->version }} {{ $os->architecture }}</option>
                    @empty
                    <option value="">NO EXISTEN SISTEMAS OPERATIVOS REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="os-pc-select2">Sistema operativo</label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="modelo-pc" name="modelo-pc"
                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="modelo-pc">Modelo</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fa fa-fw fa-paint-brush"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="serial-pc" name="serial-pc"
                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="serial-pc">Serial</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fa fa-fw fa-barcode"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="serial-monitor-pc" name="serial-monitor-pc"
                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="serial-monitor-pc">Serial monitor</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fa fa-fw fa-barcode"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <!-- END Step 1 -->

          <!-- Step 2 -->
          <div class="tab-pane" id="wizard-progress2-step2" role="tabpanel">
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <div class="form-material">
                    <select class="js-select2 form-control" name="val-select2-ram0" style="width: 100%;"
                      data-placeholder="Seleccionar RAM Slot #1..">
                      <option></option>
                      <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                      @forelse ($rams as $ram)
                      <option value="{{ $ram->id }}">{{ $ram->ram }}</option>
                      @empty
                      <option value="">NO EXISTEN RAM REGISTRADAS</option>
                      @endforelse
                    </select>
                    <label for="val-select2">Memoria</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <div class="form-material">
                    <select class="js-select2 form-control" name="val-select2-ram1" style="width: 100%;"
                      data-placeholder="Seleccionar RAM Slot #2..">
                      <option></option>
                      <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                      @forelse ($rams as $ram)
                      <option value="{{ $ram->id }}">{{ $ram->ram }}</option>
                      @empty
                      <option value="">NO EXISTEN RAM REGISTRADAS</option>
                      @endforelse
                    </select>
                    <label for="val-select2">Memoria</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <div class="form-material">
                    <select class="js-select2 form-control" name="val-select2-hdd" style="width: 100%;"
                      data-placeholder="Seleccionar Disco duro..">
                      <option></option>
                      <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                      @forelse ($hdds as $hdd)
                      <option value="{{ $hdd->id }}">{{ $hdd->size }} | {{ $hdd->type }}</option>
                      @empty
                      <option value="">NO EXISTEN DISCOS DUROS REGISTRADOS</option>
                      @endforelse
                    </select>
                    <label for="val-select2">Disco Duro</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <div class="form-material floating">
                    <input class="form-control" type="text" name="cpu"
                      onkeyup="javascript:this.value=this.value.toUpperCase();">
                    <label for="">Procesador</label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- END Step 2 -->

          <!-- Step 3 -->
          <div class="tab-pane" id="wizard-progress2-step3" role="tabpanel">
            <div class="form-row">
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <div class="form-material floating">
                    <input class="form-control" type="text" name="ip">
                    <label for="wizard-simple2-ip">Dirección IP</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <div class="form-material floating">
                    <input class="form-control" type="text" name="mac">
                    <label for="wizard-simple2-mac">Dirección MAC</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <div class="form-material floating">
                    <input class="form-control" type="text" name="anydesk">
                    <label for="wizard-simple2-mac"><img class="img-fluid" width="80px"
                        src="https://go.anydesk.com/_static/img/logos/anydesk-logo.svg" alt="anydesk"></label>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <div class="form-material floating">
                    <input class="form-control" type="text" name="pc-name">
                    <label for="wizard-simple2-mac">Nombre del equipo</label>
                  </div>
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
                    <select class="js-select2 form-control" name="val-select2-campus" style="width: 100%;"
                      data-placeholder="Seleccionar Sede..">
                      <option></option>
                      <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                      @forelse ($campus as $campu)
                      <option value="{{ $campu->id }}">{{ $campu->description }}</option>
                      @empty
                      <option value="">NO EXISTEN SEDES REGISTRADAS</option>
                      @endforelse
                    </select>
                    <label for="val-select2">Sede del equipo</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <div class="form-group">
                  <div class="form-material floating">
                    <input class="form-control" type="text" name="location">
                    <label for="wizard-simple2-mac">Ubicación</label>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <div class="form-material floating">
                <textarea class="form-control" name="observation" rows="4"></textarea>
                <label for="material-textarea-large2">Oberservación</label>
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
                <i class="fa fa-angle-left mr-5"></i> Previous
              </button>
            </div>
            <div class="col-6 text-right">
              <button type="button" class="btn btn-alt-secondary" data-wizard="next">
                Next <i class="fa fa-angle-right ml-5"></i>
              </button>
              <button type="submit" class="btn btn-alt-primary d-none" data-wizard="finish">
                <i class="fa fa-check mr-5"></i> Submit
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