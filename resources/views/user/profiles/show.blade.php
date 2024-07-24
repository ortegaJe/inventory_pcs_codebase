@extends('layouts.backend')

@section('title', 'Perfil ' . Str::lower($users->nick_name))

@section('css')
    <style>
        .upper-txt {
            text-transform: uppercase;
        }
    </style>

    <link rel="stylesheet" href="{{ asset('/js/plugins/dropzonejs/dist/min/dropzone.min.css') }}">
@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-gray-lighter">
        <div class="bg-black-op-12">
            <div class="content content-top text-center">
                <div class="mb-20">
                    <i class="fa fa-user fa-4x text-muted"></i>
                    <h1 class="h3 text-primary-light font-w700 mb-10">
                        {{ Str::title($users->name) }}
                        {{ Str::title($users->middle_name) }}
                        {{ Str::title($users->last_name) }}
                        {{ Str::title($users->second_last_name) }}
                    </h1>
                    <h2 class="h5 text-black-op">
                        <a class="text-primary-light link-effect" href="javascript:void(0)">
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Breadcrumb -->
    <div class="bg-body-light border-b">
        <div class="content py-5 text-center">
            <nav class="breadcrumb bg-body-light mb-0">
                <a class="breadcrumb-item" href="{{ route('dashboard') }}">Home</a>
                <span class="breadcrumb-item active">
                    {{ Str::title($users->name) }}
                    {{ Str::title($users->last_name) }}
                </span>
            </nav>
        </div>
    </div>
    <!-- END Breadcrumb -->

    <!-- Overview -->
    <h2 class="content-heading font-w300">Asignado a:</h2>
    <div class="row">
        @foreach ($dataUsers as $dataUser)
            <div class="col-md-6 col-xl-4">
                <a class="block block-link-pop text-center" href="javascript:void(0)">
                    <div class="block-content text-center">
                        <div class="item item-circle bg-primary-lighter text-primary mx-auto my-10">
                            <i class="fa fa-building-o"></i>
                        </div>
                    </div>
                    <div class="block-content bg-body-light">
                        <p class="font-w600">
                            @if ($dataUser->SedePrincipal == true)
                                <i class="fa fa-star text-primary"></i>
                            @endif
                            {{ Str::upper($dataUser->SedeTecnico) }}
                        </p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    <!-- END Overview -->

    <!-- Settings -->
    <h2 class="content-heading font-w300">Mis Datos</h2>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title"></h3>
        </div>
        <div class="block-content">
            <div class="col-lg-12">
                <div class="form-group row">
                    <div class="col-6">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="cc" name="cc"
                                value="{{ $users->cc }}" readonly>
                            <label for="cc">Identificación</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-material floating">
                            <input type="text" class="form-control upper-txt" id="firstname" name="firstname"
                                value="{{ $users->name }}" readonly>
                            <label for="firstname">Primer Nombre</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="form-material floating">
                            <input type="text" class="form-control upper-txt" id="middlename" name="middlename"
                                value="{{ $users->middle_name }}" readonly>
                            <label for="middlename">Segundo Nombre</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-material floating">
                            <input type="text" class="form-control upper-txt" id="lastname" name="lastname"
                                value="{{ $users->last_name }}" readonly>
                            <label for="lastname">Primer Apellido</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="form-material floating">
                            <input type="text" class="form-control upper-txt" id="second-lastname" name="second-lastname"
                                value="{{ $users->second_last_name }}" readonly>
                            <label for="second-lastname">Segundo Apellido</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-material floating">
                            <input type="text" class="form-control upper-txt" id="nickname" name="nickname"
                                value="{{ $users->nick_name }}" readonly>
                            <label for="nickname">Nombre de Usuario</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ $users->phone_number }}" readonly>
                            <label for="phone">Télefono</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-material">
                            <input type="text" class="js-flatpickr form-control" id="birthday" name="birthday"
                                placeholder="Y-dd-mm" data-allow-input="true" maxlength="10"
                                value="{{ $users->birthday }}" readonly>
                            <label for="birthday">Fecha de Nacimiento</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    @foreach ($dataUsers as $dataUser)
                        @if ($dataUser->SedePrincipal == 1)
                            <div class="col-6">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="material-disabled-campu"
                                        name="material-disabled-campu" value="{{ Str::upper($dataUser->SedeTecnico) }}"
                                        readonly>
                                    <label for="material-disabled-campu">Sede Principal</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-material">
                                    <input type="text" class="form-control" id="material-disabled-profile"
                                        name="material-disabled-profile"
                                        value="{{ Str::upper($dataUser->CargoTecnico) }}" readonly>
                                    <label for="material-disabled-profile">Cargo</label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="form-group row">
                    <label class="col-12">Género</label>
                    <div class="col-6">
                        <div class="custom-control custom-radio custom-control-inline mb-5">
                            <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio1"
                                disabled {{ $users->sex == 'F' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="example-inline-radio1">F</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline mb-5">
                            <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio2"
                                disabled {{ $users->sex == 'M' ? 'checked' : '' }}>
                            <label class="custom-control-label" for="example-inline-radio2">M</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="form-material input-group floating">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $users->email }}" readonly>
                            <label for="email">Email</label>
                        </div>
                    </div>
                </div>
                <div class="row gutters-tiny items-push">
                    <div class="col-sm-2 col-xl-2">
                        <div class="options-container">
                            <label for="sign">Firma</label>
                            <img class="img-fluid options-item" width="128"
                            @if ($users->sign != null)
                            src="{{ Storage::url($users->sign) }}" 
                            @else
                            src="{{ asset('/media/firmas/no_signature.png') }}" 
                            @endif
                            alt="">
                        </div>
                    </div>
                </div>
                <div class="block">
                    <div class="block-content block-content-full">
                        <!-- DropzoneJS Container -->
                        <form class="dropzone" action="{{ route('dropzone.upload.signature') }}" method="post"
                            enctype="multipart/form-data" id="image-upload" name="image-upload">
                            @csrf
                            @method('POST')
                            <div class="dz-default dz-message"><span>Subir Firma</span></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Settings -->
@endsection

@push('js')
    <!-- Page JS Code -->
    <script src="{{ asset('/js/pages/be_ui_activity.min.js') }}"></script>
    <script src="{{ asset('/js/pages/be_forms_plugins.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/dropzonejs/dropzone.min.js') }}"></script>

    <script>
        Dropzone.options.imageUpload = {
            method: "post",
            maxFilesize: 4,
            maxFiles: 1,
            acceptedFiles: ".jpeg,.jpg,.png"
        };
    </script>
@endpush
