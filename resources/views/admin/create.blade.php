@extends('layouts.backend')

@section('title', 'Registrar equipo')

@section('content')
<div class="row">
  <div class="col-md-12 mx-auto">
    <h2 class="content-heading">Registrar Nuevo Equipo De Escritorio</h2>
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
              <div class="col-md-4">
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
              <div class="col-md-4">
                <div class="form-material">
                  <select class="js-select2 form-control" id="os-pc-select2" name="os-pc-select2" style="width: 100%;"
                    data-placeholder="Seleccionar sistema operativo..">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($operatingSystems as $os)
                    <option value="{{ $os->id }}">{{ $os->name }} {{ $os->version }} {{ $os->architecture }}</option>
                    @empty
                    <option value="">NO EXISTEN SISTEMAS OPERATIVOS REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="os-pc-select2">Sistema Operativo</label>
                </div>
              </div>
              <div class="col-md-4">
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
            <div class="form-group row">
              <div class="col-md-6">
                <div class="form-material">
                  <select class="js-select2 form-control" id="val-select2-ram0" name="val-select2-ram0"
                    style="width: 100%;" data-placeholder="Seleccionar RAM ranura 1">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($SlotOneRams as $ram)
                    <option value="{{ $ram->id }}">{{ $ram->ram }}</option>
                    @empty
                    <option value="">NO EXISTEN MEMORIAS RAM REGISTRADAS</option>
                    @endforelse
                  </select>
                  <label for="val-select2-ram0">Memorias RAM</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-material">
                  <select class="js-select2 form-control" id="val-select2-ram1" name="val-select2-ram1"
                    style="width: 100%;" data-placeholder="Seleccionar RAM ranura 2">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($SlotTwoRams as $ram)
                    <option value="{{ $ram->id }}">{{ $ram->ram }}</option>
                    @empty
                    <option value="">NO EXISTEN MEMORIAS RAM REGISTRADAS</option>
                    @endforelse
                  </select>
                  <label for="val-select2-ram1">Memorias RAM</label>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <div class="form-material">
                  <select class="js-select2 form-control" id="val-select2-hdd" name="val-select2-hdd"
                    style="width: 100%;" data-placeholder="Seleccionar disco duro">
                    <option disabled selected></option><!-- Empty value for demostrating material select box -->
                    @forelse ($hdds as $hdd)
                    <option value="{{ $hdd->id }}">{{ $hdd->size }} | {{ $hdd->type }}</option>
                    @empty
                    <option value="">NO EXISTEN DISCO DUROS REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="val-select2-hdd">Discos duros</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="cpu" name="cpu"
                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="cpu">Procesador</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fa fa-microchip"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 mt-4">
                <!-- Status Checkboxes -->
                <div class="block">
                  <div class="block-header block-header-default">
                    <h3 class="block-title">Estado del equipo</h3>
                  </div>
                  <div class="block-content">
                    <div class="row no-gutters items-push">
                      <div class="col-6">
                        <label class="css-control css-control-success css-checkbox">
                          <input type="checkbox" class="css-control-input" name="estado-pc[]"
                            value="rendimiento optimo">
                          <span class="css-control-indicator"></span> Rendimiento Óptimo
                        </label>
                      </div>
                      <div class="col-6">
                        <label class="css-control css-control-warning css-checkbox">
                          <input type="checkbox" class="css-control-input" name="estado-pc[]" value="rendimiento bajo">
                          <span class="css-control-indicator"></span> Rendimiento bajo
                        </label>
                      </div>
                      <div class="col-6">
                        <label class="css-control css-control-info css-checkbox">
                          <input type="checkbox" class="css-control-input" name="estado-pc[]" value="hurtado">
                          <span class="css-control-indicator"></span> Hurtado
                        </label>
                      </div>
                      <div class="col-6">
                        <label class="css-control css-control-secondary css-checkbox">
                          <input type="checkbox" class="css-control-input" name="estado-pc[]" value="dado de baja">
                          <span class="css-control-indicator"></span> Dado de baja
                        </label>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- END Status Checkboxes -->
              </div>
            </div>
          </div>
          <!-- END Step 2 -->

          <!-- Step 3 -->
          <div class="tab-pane" id="wizard-progress2-step3" role="tabpanel">
            <div class="form-group row">
              <div class="col-md-6">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="ip" name="ip"
                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="ip">Dirección IP</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      {{-- <iclass="fafa-fwfa-barcode"></i> --}}
                    </span>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="mac" name="mac"
                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="mac">Dirección MAC</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      {{-- <iclass="fafa-fwfa-barcode"></i> --}}
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="anydesk" name="anydesk"
                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="ip">Anydesk</label>
                  <div class="input-group-append">
                    <label for="anydesk"><img class="img-fluid" width="20px"
                        src="https://ubuntupit.com/wp-content/uploads/2019/03/AnyDesk-remote.png" alt="anydesk">
                    </label>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-material floating">
                  <input type="text" class="form-control" id="pc-name" name="pc-name"
                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="pc-name">Nombre del equipo</label>
                  <div class="block-content block-content-full">
                    <button type="button" class="btn btn-alt-info ml-2 float-right" data-toggle="tooltip"
                      data-placement="bottom" title="Ver abreviados de las sedes">
                      <i class="fa fa-info-circle"></i>
                    </button>
                    <button type="button" class="btn btn-alt-info float-right" data-toggle="popover"
                      title="Nombre de equipos" data-placement="Right" data-content="Deberia ser: V1AMAC-CON21             
                      (V1A = VIVA 1A) (MAC = abreviado de la sede) (-CON21 = ubicación del equipo dentro de la sede).">
                      <i class="fa fa-info-circle"></i>
                      Como nombrar equipos?
                    </button>
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
                    <select class="js-select2 form-control" id="val-select2-campus" name="val-select2-campus"
                      style="width: 100%;" data-placeholder="Seleccionar Sede..">
                      <option></option>
                      <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                      @forelse ($campus as $campu)
                      <option value="{{ $campu->id }}">{{ $campu->description }}</option>
                      @empty
                      <option value="">NO EXISTEN SEDES REGISTRADAS</option>
                      @endforelse
                    </select>
                    <label for="val-select2-campus">Sede del equipo</label>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-material floating input-group">
                  <input type="text" class="form-control" id="location" name="location"
                    onkeyup="javascript:this.value=this.value.toUpperCase();">
                  <label for="location">Ubicacion</label>
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="fa fa-map-marker"></i>
                    </span>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-row">
              <div class="col-md-12">
                <div class="form-material floating">
                  <textarea class="form-control" id="observation" name="observation" rows="4"></textarea>
                  <label for="observation">Oberservación</label>
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