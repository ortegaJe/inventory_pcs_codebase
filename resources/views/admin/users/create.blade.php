@extends('layouts.backend')

@section('title', 'Nuevo Usuario')

@section('css')
    <link rel="stylesheet" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">
    <style>
        .lower-txt {
            text-transform: lowercase;
        }
    </style>

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
                <form action="{{ route('admin.inventory.technicians.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="form-group row">
                        <div class="col-6">
                            <div class="form-material floating">
                                <input type="text" class="form-control" id="cc" name="cc"
                                    onkeypress="return /[0-9]/i.test(event.key)">
                                <label for="cc">Identificación</label>
                            </div>
                            @if ($errors->has('cc'))
                                <small class="text-danger is-invalid">{{ $errors->first('cc') }}</small>
                            @endif
                        </div>
                        <div class="col-6">
                            <div class="form-material floating">
                                <input type="text" class="form-control lower-txt" id="name" name="name"
                                    onkeyup="return forceLower(this);">
                                <label for="name">Primer Nombre</label>
                            </div>
                            @if ($errors->has('name'))
                                <small class="text-danger is-invalid">{{ $errors->first('name') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <div class="form-material floating">
                                <input type="text" class="form-control lower-txt" id="middle_name" name="middle_name">
                                <label for="middle_name">Segundo Nombre</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-material floating">
                                <input type="text" class="form-control lower-txt" id="last_name" name="last_name">
                                <label for="last_name">Primer Apellido</label>
                            </div>
                            @if ($errors->has('last_name'))
                                <small class="text-danger is-invalid">{{ $errors->first('last_name') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <div class="form-material floating">
                                <input type="text" class="form-control lower-txt" id="second_last_name"
                                    name="second_last_name">
                                <label for="second_last_name">Segundo Apellido</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-material floating">
                                <input type="text" class="form-control" id="phone_number" name="phone_number">
                                <label for="phone_number">Teléfono</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <div class="form-material">
                                <input type="text" class="js-flatpickr form-control" id="birthday" name="birthday"
                                    placeholder="Y-m-d" data-allow-input="true" maxlength="10">
                                <label for="birthday">Fecha de Nacimiento</label>
                            </div>
                            @if ($errors->has('birthday'))
                                <small class="text-danger is-invalid">{{ $errors->first('birthday') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-12">Género</label>
                        <div class="col-6">
                            <div class="custom-control custom-radio custom-control-inline mb-5">
                                <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio2"
                                    value="M">
                                <label class="custom-control-label" for="example-inline-radio2">M</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline mb-5">
                                <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio1"
                                    value="F">
                                <label class="custom-control-label" for="example-inline-radio1">F</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-6">
                            <div class="form-material">
                                <select class="js-select2 form-control" id="profile" name="profile" style="width: 100%;"
                                    data-placeholder="Seleccionar perfil..">
                                    <option></option>
                                    <!--  for data-placeholder attribute to work with Select2 plugin -->
                                    @forelse ($profiles as $profile)
                                        <option value="{{ $profile->id }}">{{ Str::upper($profile->name) }}</option>
                                    @empty
                                        <option>NO EXISTEN PERFILES REGISTRADOS</option>
                                    @endforelse
                                </select>
                                <label for="profile">Perfil</label>
                            </div>
                            @if ($errors->has('profile'))
                                <small class="text-danger is-invalid">{{ $errors->first('profile') }}</small>
                            @endif
                        </div>
                        <div class="col-6">
                            <div class="form-material">
                                <select class="js-select2 form-control" id="campu" name="campu"
                                    style="width: 100%;" data-placeholder="Seleccionar sede.." disabled>
                                    <option></option>
                                    <!--  for data-placeholder attribute to work with Select2 plugin -->
                                </select>
                                <label for="campu">Sede Principal</label>
                            </div>
                            @if ($errors->has('campu'))
                                <small class="text-danger is-invalid">{{ $errors->first('campu') }}</small>
                            @endif
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
                            @if ($errors->has('email'))
                                <small class="text-danger is-invalid">{{ $errors->first('email') }}</small>
                            @endif
                        </div>
                    </div>
                    <div class="d-flex justify-content-between w-100">
                        <button type="submit" class="btn btn btn-alt-success min-width-125 mt-4 mb-4"
                            data-toggle="click-ripple">
                            <i class="fa fa-save"></i> Guardar
                        </button>
                        <button type="button" class="btn btn btn-alt-secondary min-width-125 mt-4 mb-4"
                            data-toggle="click-ripple"
                            onclick="window.location='{{ route('admin.inventory.technicians.index') }}'">
                            Cancelar
                        </button>
                    </div>
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
        jQuery(function() {
            Codebase.helpers(['flatpickr', 'datepicker', 'select2']);
        });
    </script>

    <script>
        function forceLower(strInput) {
            strInput.value = strInput.value.toLowerCase();
        }
    </script>

    <script>
        $(document).ready(function() {

            /*------------------------------------------
            --------------------------------------------
            Campus Dropdown Change Event
            --------------------------------------------
            --------------------------------------------*/
            $('#profile').on('change', function() {
                const profileId = this.value;
                const campusSelect = document.getElementById('campu');
                campusSelect.innerHTML = '';
                $.ajax({
                    url: "{{ route('fetch.campus') }}",
                    type: "POST",
                    data: {
                        profile_id: profileId,
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(result) {
                        if (profileId == 2) {
                            campusSelect.disabled = false;
                            campusSelect.innerHTML =
                                '<option value="">Seleccionar Sede..</option>';

                            result.campus.forEach(({
                                id,
                                name
                            }) => {
                                const option = document.createElement('option');
                                option.value = id;
                                option.textContent = name;
                                campusSelect.appendChild(option);
                            });
                        } else {
                            campusSelect.disabled = true;
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error fetching campus data: ", textStatus, errorThrown);
                        Swal.fire({
                            title: "Error",
                            text: `Hubo un error al cargar las sedes. Por favor, intente nuevamente: ${errorThrown}`,
                            icon: "error",
                            confirmButtonText: "OK",
                        });
                    }
                });
            });

        });
    </script>
@endpush
