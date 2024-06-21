@extends('layouts.backend')

@section('title', 'Actualizar equipo')

@section('css')
    <link rel="stylesheet" href="{{ asset('/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">

@section('content')
    <div class="row">
        <div class="col-md-12 mx-auto">
            <h2 class="content-heading">Actualizar Equipo Atril</h2>
            <!-- Progress Wizard 2 -->
            <div class="js-wizard-simple block">
                <!-- Wizard Progress Bar -->
                <div class="progress rounded-0" data-wizard="progress" style="height: 8px;">
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"
                        style="width: 34.3333%;" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
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
                        <a class="nav-link" href="#wizard-progress2-step4" data-toggle="tab">4. Ubicacion</a>
                    </li>
                </ul>
                <!-- END Step Tabs -->

                <!-- Form -->
                <form action="{{ route('user.inventory.turnero.update', $deviceComponents->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <!-- Steps Content -->
                    <div class="block-content block-content-full tab-content" style="min-height: 274px;">
                        <!-- Step 1 -->
                        <div class="tab-pane active" id="wizard-progress2-step1" role="tabpanel">
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <div class="form-material">
                                        <select class="js-select2 form-control" id="marca-pc-select2"
                                            name="marca-pc-select2" style="width: 100%;"
                                            data-placeholder="Seleccionar fabricante..">
                                            <option disabled selected></option>
                                            <!-- Empty value for demostrating material select box -->
                                            @forelse ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ $brand->id == $deviceComponents->brand_id ? 'selected' : '' }}>
                                                    {{ $brand->name }}</option>
                                            @empty
                                                <option>NO EXISTEN FABRICANTES REGISTRADOS</option>
                                            @endforelse
                                        </select>
                                        <label for="marca-pc-select2">Fabricantes</label>
                                    </div>
                                    @if ($errors->has('marca-pc-select2'))
                                        <small
                                            class="text-danger is-invalid">{{ $errors->first('marca-pc-select2') }}</small>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="form-material">
                                        <select class="js-select2 form-control" id="os-pc-select2" name="os-pc-select2"
                                            style="width: 100%;" data-placeholder="Seleccionar sistema operativo..">
                                            <option disabled selected></option>
                                            <!-- Empty value for demostrating material select box -->
                                            @forelse ($operatingSystems as $os)
                                                <option value="{{ $os->id }}"
                                                    {{ $os->id == $deviceComponents->os_id ? 'selected' : '' }}>
                                                    {{ $os->name }}
                                                    {{ $os->version }}
                                                    {{ $os->architecture }}</option>
                                            @empty
                                                <option>NO EXISTEN SISTEMAS OPERATIVOS REGISTRADOS</option>
                                            @endforelse
                                        </select>
                                        <label for="os-pc-select2">Sistema Operativo</label>
                                    </div>
                                    @if ($errors->has('os-pc-select2'))
                                        <small class="text-danger is-invalid">{{ $errors->first('os-pc-select2') }}</small>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="form-material floating input-group">
                                        <input type="text" class="form-control" id="modelo-pc" name="modelo-pc"
                                            value="{{ $deviceComponents->model }}" maxlength="100"
                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <label for="modelo-pc">Modelo</label>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-fw fa-paint-brush"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @if ($errors->has('modelo-pc'))
                                        <small class="text-danger is-invalid">{{ $errors->first('modelo-pc') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-material floating input-group">
                                        <input type="text" class="form-control" id="serial-pc" name="serial-pc"
                                            value="{{ $deviceComponents->serial_number }}" maxlength="24"
                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <label for="serial-pc">Numero Serial</label>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-fw fa-barcode"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @if ($errors->has('serial-pc'))
                                        <small class="text-danger is-invalid">{{ $errors->first('serial-pc') }}</small>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-material floating input-group">
                                        <input type="text" class="form-control" id="activo-fijo-pc" name="activo-fijo-pc"
                                            value="{{ $deviceComponents->inventory_active_code }}" maxlength="20"
                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <label for="activo-fijo-pc">Codigo de activo fijo</label>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                {{-- <iclass="fafa-fwfa-barcode"></i> --}}
                                            </span>
                                        </div>
                                    </div>
                                    @if ($errors->has('activo-fijo-pc'))
                                        <small
                                            class="text-danger is-invalid">{{ $errors->first('activo-fijo-pc') }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- END Step 1 -->

                        <!-- Step 2 -->
                        <div class="tab-pane" id="wizard-progress2-step2" role="tabpanel">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <div class="form-material">
                                        <select class="js-select2 form-control" id="val-select2-ram0"
                                            name="val-select2-ram0" style="width: 100%;"
                                            data-placeholder="Seleccionar RAM ranura 1">
                                            <option disabled selected></option>
                                            <!-- Empty value for demostrating material select box -->
                                            @forelse ($memoryRams as $ram)
                                                <option value="{{ $ram->id }}"
                                                    {{ $ram->id == $deviceComponents->slot_one_ram_id ? 'selected' : '' }}>
                                                    {{ $ram->size }}{{ $ram->storage_unit }}{{ $ram->type }}{{ $ram->format }}
                                                </option>
                                            @empty
                                                <option>NO EXISTEN MEMORIAS RAM REGISTRADAS</option>
                                            @endforelse
                                        </select>
                                        <label for="val-select2-ram0">Memorias RAM</label>
                                    </div>
                                    @if ($errors->has('val-select2-ram0'))
                                        <small
                                            class="text-danger is-invalid">{{ $errors->first('val-select2-ram0') }}</small>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="form-material">
                                        <select class="js-select2 form-control" id="val-select2-ram1"
                                            name="val-select2-ram1" value="{{ old('val-select2-ram1') }}"
                                            style="width: 100%;" data-placeholder="Seleccionar RAM ranura 2">
                                            <option disabled selected></option>
                                            <!-- Empty value for demostrating material select box -->
                                            @forelse ($memoryRams as $ram)
                                                <option value="{{ $ram->id }}"
                                                    {{ $ram->id == $deviceComponents->slot_two_ram_id ? 'selected' : '' }}>
                                                    {{ $ram->size }}{{ $ram->storage_unit }}{{ $ram->type }}{{ $ram->format }}
                                                </option>
                                            @empty
                                                <option>NO EXISTEN MEMORIAS RAM REGISTRADAS</option>
                                            @endforelse
                                        </select>
                                        <label for="val-select2-ram1">Memorias RAM <small>(Opcional)</small></label>
                                    </div>
                                    @if ($errors->has('val-select2-ram1'))
                                        <small
                                            class="text-danger is-invalid">{{ $errors->first('val-select2-ram1') }}</small>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="form-material">
                                        <select class="js-select2 form-control" id="val-select2-first-storage"
                                            name="val-select2-first-storage" style="width: 100%;"
                                            data-placeholder="Seleccionar primer almacenamiento..">
                                            <option disabled selected></option>
                                            <!-- Empty value for demostrating material select box -->
                                            @forelse ($storages as $storage)
                                                <option value="{{ $storage->id }}"
                                                    {{ $storage->id == $deviceComponents->first_storage_id ? 'selected' : '' }}>
                                                    {{ $storage->size }}
                                                    {{ $storage->storage_unit }}
                                                    {{ $storage->type }}
                                                </option>
                                            @empty
                                                <option>NO EXISTEN DISCO DUROS REGISTRADOS</option>
                                            @endforelse
                                        </select>
                                        <label for="val-select2-first-storage">Almacenamiento</label>
                                    </div>
                                    @if ($errors->has('val-select2-first-storage'))
                                        <small
                                            class="text-danger is-invalid">{{ $errors->first('val-select2-first-storage') }}</small>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="form-material">
                                        <select class="js-select2 form-control" id="val-select2-second-storage"
                                            name="val-select2-second-storage" style="width: 100%;"
                                            data-placeholder="Seleccionar segundo almacenamiento..">
                                            <option disabled selected></option>
                                            <!-- Empty value for demostrating material select box -->
                                            @forelse ($storages as $storage)
                                                <option value="{{ $storage->id }}"
                                                    {{ $storage->id == $deviceComponents->second_storage_id ? 'selected' : '' }}>
                                                    {{ $storage->size }}
                                                    {{ $storage->storage_unit }}
                                                    {{ $storage->type }}</option>
                                            @empty
                                                <option>NO EXISTEN DISCO DUROS REGISTRADOS</option>
                                            @endforelse
                                        </select>
                                        <label for="val-select2-second-storage">Almacenamiento
                                            <small>(Opcional)</small></label>
                                    </div>
                                    @if ($errors->has('val-select2-second-storage'))
                                        <small
                                            class="text-danger is-invalid">{{ $errors->first('val-select2-second-storage') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-material">
                                        <select class="js-select2 form-control" id="val-select2-cpu"
                                            name="val-select2-cpu" style="width: 100%;"
                                            data-placeholder="Seleccionar procesador..">
                                            <option disabled selected></option>
                                            <!-- Empty value for demostrating material select box -->
                                            @forelse ($processors as $cpu)
                                                <option value="{{ $cpu->id }}"
                                                    {{ $cpu->id == $deviceComponents->processor_id ? 'selected' : '' }}>
                                                    {{ $cpu->brand }}
                                                    {{ $cpu->generation }}
                                                    {{ $cpu->velocity }}
                                                </option>
                                            @empty
                                                <option>NO EXISTEN PROCESADORES REGISTRADOS</option>
                                            @endforelse
                                        </select>
                                        <label for="val-select2-cpu">Precesador</label>
                                    </div>
                                    @if ($errors->has('val-select2-cpu'))
                                        <small
                                            class="text-danger is-invalid">{{ $errors->first('val-select2-cpu') }}</small>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-material">
                                        <select class="js-select2 form-control" id="val-select2-status"
                                            name="val-select2-status" style="width: 100%;"
                                            data-placeholder="Seleccionar un estado..">
                                            <option disabled></option>
                                            <!-- Empty value for demostrating material select box -->
                                            @forelse ($status as $statu)
                                                <option value="{{ $statu->StatusID }}"
                                                    {{ $statu->StatusID == $deviceComponents->statu_id ? 'selected' : '' }}>
                                                    {{ Str::title($statu->NameStatus) }}
                                                </option>
                                            @empty
                                                <option>NO EXISTEN DISCO DUROS REGISTRADOS</option>
                                            @endforelse
                                        </select>
                                        <label for="val-select2-status">Estado del equipo</label>
                                    </div>
                                    @if ($errors->has('val-select2-status'))
                                        <small
                                            class="text-danger is-invalid">{{ $errors->first('val-select2-status') }}</small>
                                    @endif
                                </div>
                            </div>
                            @if (Auth::id() == 13)
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <label class="css-control css-control-primary css-switch css-switch-square">
                                            <input type="checkbox" class="css-control-input" id="stock"
                                                name="stock" {{ $statuStock->is_stock == 1 ? 'checked' : '' }}>
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
                                        <input type="text" class="form-control" id="ip" name="ip"
                                            maxlength="16" value="{{ $deviceComponents->ip }}"
                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <label for="ip">Dirección IP</label>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                {{-- <iclass="fafa-fwfa-barcode"></i> --}}
                                            </span>
                                        </div>
                                    </div>
                                    @if ($errors->has('ip'))
                                        <small class="text-danger is-invalid">{{ $errors->first('ip') }}</small>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-material floating input-group">
                                        <input type="text" class="form-control" id="mac" name="mac"
                                            maxlength="17" value="{{ $deviceComponents->mac }}"
                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <label for="mac">Dirección MAC</label>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                {{-- <iclass="fafa-fwfa-barcode"></i> --}}
                                            </span>
                                        </div>
                                    </div>
                                    @if ($errors->has('mac'))
                                        <small class="text-danger is-invalid">{{ $errors->first('mac') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <div class="form-material floating input-group">
                                        <input type="text" class="form-control" id="anydesk" name="anydesk"
                                            maxlength="24" value="{{ $deviceComponents->anydesk }}"
                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <label for="ip">Anydesk</label>
                                        <div class="input-group-append">
                                            <label for="anydesk"><img class="img-fluid" width="20px"
                                                    src="https://ubuntupit.com/wp-content/uploads/2019/03/AnyDesk-remote.png"
                                                    alt="anydesk">
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('anydesk'))
                                        <small class="text-danger is-invalid">{{ $errors->first('anydesk') }}</small>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="form-material">
                                            <select class="js-select2 form-control" id="pc-domain-name"
                                                name="pc-domain-name" style="width: 100%;"
                                                data-placeholder="Seleccionar dominio..">
                                                <option></option>
                                                <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                <option selected>{{ $deviceComponents->domain_name }}</option>
                                            </select>
                                            <label for="pc-domain-name"><i class="fa fa-sitemap"></i> Dominio</label>
                                        </div>
                                        @if ($errors->has('pc-domain-name'))
                                            <small
                                                class="text-danger is-invalid">{{ $errors->first('pc-domain-name') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-material floating">
                                        <input type="text" class="form-control" id="pc-name" name="pc-name"
                                            maxlength="20" value="{{ $deviceComponents->device_name }}"
                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <label for="pc-name">Nombre del equipo</label>
                                    </div>
                                    @if ($errors->has('pc-name'))
                                        <small class="text-danger is-invalid">{{ $errors->first('pc-name') }}</small>
                                    @endif
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
                                            <select class="js-select2 form-control" id="val-select2-campus"
                                                name="val-select2-campus" style="width: 100%;"
                                                data-placeholder="Seleccionar Sede..">
                                                <option></option>
                                                <!-- Required for data-placeholder attribute to work with Select2 plugin -->
                                                @forelse ($campus as $campu)
                                                    <option value="{{ $campu->id }}"
                                                        {{ $campu->id == $deviceComponents->campu_id ? 'selected' : '' }}>
                                                        {{ $campu->name }}
                                                    </option>
                                                @empty
                                                    <option>NO EXISTEN SEDES REGISTRADAS</option>
                                                @endforelse
                                            </select>
                                            <label for="val-select2-campus">Sede del equipo</label>
                                        </div>
                                        @if ($errors->has('val-select2-campus'))
                                            <small
                                                class="text-danger is-invalid">{{ $errors->first('val-select2-campus') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-material floating input-group">
                                        <input type="text" class="form-control" id="location" name="location"
                                            maxlength="56" value="{{ $deviceComponents->location }}"
                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <label for="location">Ubicacion</label>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-map-marker"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @if ($errors->has('location'))
                                        <small class="text-danger is-invalid">{{ $errors->first('location') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <div class="form-material">
                                        <input type="text" class="js-flatpickr form-control"
                                            id="custodian-assignment-date" name="custodian-assignment-date"
                                            placeholder="d-m-Y" data-allow-input="true" maxlength="10"
                                            value="{{ $deviceComponents->custodian_assignment_date }}">
                                        <label for="custodian-assignment-date">Fecha de asignación al custodio</label>
                                    </div>
                                    @if ($errors->has('custodian-assignment-date'))
                                        <small
                                            class="text-danger is-invalid">{{ $errors->first('custodian-assignment-date') }}</small>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="form-material floating input-group">
                                        <input type="text" class="form-control" id="custodian-name"
                                            name="custodian-name" maxlength="56"
                                            value="{{ $deviceComponents->custodian_name }}"
                                            onkeyup="javascript:this.value=this.value.toUpperCase();">
                                        <label for="custodian-name">Nombres y apellidos del custodio</label>
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-user"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @if ($errors->has('custodian-name'))
                                        <small
                                            class="text-danger is-invalid">{{ $errors->first('custodian-name') }}</small>
                                    @endif
                                </div>
                                <div class="col-md-3">
                                    <div class="form-material">
                                        <select class="js-select2 form-control" id="val-select2-status-assignment"
                                            name="val-select2-status-assignment" style="width: 100%;"
                                            data-placeholder="Seleccionar concepto..">
                                            <option disabled></option>
                                            <!-- Empty value for demostrating material select box -->
                                            @forelse ($statusAssignments as $statuAssignment)
                                                <option value="{{ $statuAssignment->id }}"
                                                    {{ $statuAssignment->id == $deviceComponents->assignment_statu_id ? 'selected' : '' }}>
                                                    {{ Str::title($statuAssignment->name) }}
                                                </option>
                                            @empty
                                                <option>NO EXISTEN ESTADOS REGISTRADOS</option>
                                            @endforelse
                                        </select>
                                        <label for="val-select2-status-assignment">Concepto</label>
                                    </div>
                                    @if ($errors->has('val-select2-status-assignment'))
                                        <small
                                            class="text-danger is-invalid">{{ $errors->first('val-select2-status-assignment') }}</small>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-md-12">
                                    <div class="form-material">
                                        <textarea class="js-maxlength form-control" id="observation" name="observation" rows="3" maxlength="255"
                                            placeholder="Escriba aqui una observación" data-always-show="true" data-warning-class="badge badge-primary"
                                            data-limit-reached-class="badge badge-warning" value=""
                                            onkeyup="javascript:this.value=this.value.toUpperCase();">{{ $deviceComponents->observation }}</textarea>
                                        <label for="observation">Observación</label>
                                    </div>
                                </div>
                                @if ($errors->has('observation'))
                                    <small class="text-danger is-invalid">{{ $errors->first('observation') }}</small>
                                @endif
                            </div>
                            @php
                                $count = count($files);
                                echo $count;
                            @endphp
                            <div class="block block-rounded">
                                <div class="block-content">
                                    <table class="table table-bordered table-vcenter">
                                        <thead>
                                            <tr>
                                                <th scope="row">Fecha</th>
                                                <th>Envidencias Fotográfica</th>
                                                <th class="text-center">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="files-tbody">
                                            @forelse ($files as $file)
                                                @include('user.inventory.turnero.partials.modal')
                                                <tr id="file-row-{{ $file->id }}">
                                                    <td><code class="text-muted">{{ $file->created_at }}</code></td>
                                                    <td><code class="text-muted">{{ $file->file_name }}</code></td>
                                                    <td class="text-center">
                                                        <div class="btn-group">
                                                            <button type="button"
                                                                class="btn btn-sm btn-alt-primary js-tooltip-enabled"
                                                                data-toggle="modal"
                                                                data-target="#viewImageModal-{{ $file->id }}"
                                                                title="Ver">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-sm btn-alt-danger js-tooltip-enabled delete-file"
                                                                data-id="{{ $file->id }}" title="Borrar">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <td colspan="3" class="text-center">Sin envidencias fotográfica
                                                </td>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="upload-input-container"
                                class="@if ($files->isNotEmpty()) d-none @endif form-row">
                                <div class="col-md-12">
                                    <div class="form-material">
                                        <label for=""><code>*Se deben subir dos evidencia fotográficas del
                                                atril
                                                instalado y etiqueta del serial.</code></label>
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Subir Evidencia Fotográficas</span>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="files[]"
                                                    name="files[]" accept="image/*" multiple>
                                                <label class="custom-file-label" for="inputGroupFile01">Seleccione los
                                                    archivos...</label>
                                            </div>
                                        </div>
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
    <script src="{{ asset('/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/es6-promise/es6-promise.auto.min.js') }}"></script>
    <script src="{{ asset('/js/pages/be_ui_activity.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('/js/pages/be_forms_plugins.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js ') }}"></script>
    <script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

    <!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins) -->
    <script>
        jQuery(function() {
            Codebase.helpers(['flatpickr', 'datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs',
                'rangeslider', 'tags-inputs'
            ]);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.delete-file').forEach(button => {
                button.addEventListener('click', function() {
                    const fileId = this.getAttribute('data-id');
                    const url = `/tecnico/dashboard/inventario/delete-atril-file/${fileId}`;
                    const token = '{{ csrf_token() }}';

                    fetch(url, {
                            method: 'DELETE',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                document.getElementById(`file-row-${fileId}`).remove();

                                const tbody = document.getElementById('files-tbody');
                                if (tbody.children.length === 0) {
                                    const tr = document.createElement('tr');

                                    const td = document.createElement('td');
                                    td.classList.add('text-center');
                                    td.textContent = 'Sin evidencias fotográficas';
                                    td.setAttribute('colspan', '3');

                                    tr.appendChild(td);

                                    tbody.appendChild(tr);

                                    document.getElementById('upload-input-container').classList
                                        .remove('d-none');
                                }
                                //alert('Archivo eliminado correctamente');
                            } else {
                                //alert('Error al eliminar el archivo');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>
@endpush
