@extends('layouts.backend')

@section('title', 'Perfil ' .Str::lower($users->nick_name))

@section('content')
<!-- Hero -->
<div class="bg-gray-lighter">
    <div class="bg-black-op-12">
        <div class="content content-top text-center">
            <div class="mb-20">
                <i class="si si-user fa-4x text-muted"></i>
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
<h2 class="h4 font-w300 mt-50">Asignado a:</h2>
<div class="row">
    @foreach ($dataUsers as $dataUser)
    @if ($dataUser->SedePrincipal == true)
    <div class="col-md-6 col-xl-4">
        <a class="block block-link-pop text-center">
            <div class="block-content text-center">
                <div class="item item-circle bg-primary-lighter text-primary mx-auto my-10">
                    <i class="fa fa-building-o"></i>
                </div>
                {{-- <divclass="font-size-smtext-muted">equipos --}}
            </div>
            <div class="block-content bg-body-light">
                <p class="font-w600">
                    <i class="fa fa-star text-primary"></i> {{ Str::upper($dataUser->SedeTecnico) }}
                </p>
            </div>
        </a>
    </div>
    @elseif($dataUser->SedePrincipal == false)
    <div class="col-md-6 col-xl-4">
        <a class="block block-link-pop text-center">
            <div class="block-content text-center">
                <div class="item item-circle bg-primary-lighter text-primary mx-auto my-10">
                    <i class="fa fa-building-o"></i>
                </div>
                {{-- <divclass="font-size-smtext-muted">equipos --}}
            </div>
            <div class="block-content bg-body-light">
                <p class="font-w600">
                    {{ Str::upper($dataUser->SedeTecnico) }}
                </p>
            </div>
        </a>
    </div>
    @endif
    @endforeach
</div>
<!-- END Overview -->

<!-- Settings -->
<h2 class="h4 font-w300 mt-50">Mis Datos</h2>
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">
            {{--<i class="si si-user fa-fw mr-5 text-muted"></i> Actualizar datos--}}
        </h3>
    </div>
    <div class="block-content">
        <div class="col-lg-12">
            <div class="form-group row">
                <div class="col-6">
                    <div class="form-material floating">
                        <input type="text" class="form-control" id="cc" name="cc" value="{{ $users->cc }}" readonly>
                        <label for="cc">Identificación</label>
                    </div>
                    @if($errors->has('cc'))
                    <small class="text-danger is-invalid">{{ $errors->first('cc') }}</small>
                    @endif
                </div>
                <div class="col-6">
                    <div class="form-material floating">
                        <input type="text" class="form-control" id="firstname" name="firstname"
                            value="{{ $users->name }}" readonly>
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
                        <input type="text" class="form-control" id="middlename" name="middlename"
                            value="{{ $users->middle_name }}" readonly>
                        <label for="middlename">Segundo nombre</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-material floating">
                        <input type="text" class="form-control" id="lastname" name="lastname"
                            value="{{ $users->last_name }}" readonly>
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
                        <input type="text" class="form-control" id="second-lastname" name="second-lastname"
                            value="{{ $users->second_last_name }}" readonly>
                        <label for="second-lastname">Segundo apellido</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-material floating">
                        <input type="text" class="form-control" id="nickname" name="nickname"
                            value="{{ $users->nick_name }}" readonly>
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
                        <input type="text" class="form-control" id="phone" name="phone"
                            value="{{ $users->phone_number }}" readonly>
                        <label for="phone">Telefono</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-material">
                        <input type="text" class="js-flatpickr form-control" id="birthday" name="birthday"
                            placeholder="Y-dd-mm" data-allow-input="true" maxlength="10" value="{{ $users->birthday }}"
                            readonly>
                        <label for="birthday">Fecha de nacimiento</label>
                    </div>
                    @if($errors->has('birthday'))
                    <small class="text-danger is-invalid">{{ $errors->first('birthday') }}</small>
                    @endif
                </div>
            </div>
            <div class="form-group row">
                @foreach ($dataUsers as $dataUser)
                @if($dataUser->SedePrincipal == 1)
                <div class="col-6">
                    <div class="form-material">
                        <input type="text" class="form-control" id="material-disabled-campu"
                            name="material-disabled-campu" value="{{ Str::upper($dataUser->SedeTecnico) }}" readonly>
                        <label for="material-disabled-campu">Sede principal</label>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-material">
                        <input type="text" class="form-control" id="material-disabled-profile"
                            name="material-disabled-profile" value="{{ Str::upper($dataUser->CargoTecnico) }}" readonly>
                        <label for="material-disabled-profile">Cargo</label>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
            <div class="form-group row">
                <label class="col-12">Genero</label>
                <div class="col-6">
                    <div class="custom-control custom-radio custom-control-inline mb-5">
                        <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio1" disabled
                            {{$users->sex == 'F' ? 'checked' : ''}}>
                        <label class="custom-control-label" for="example-inline-radio1">F</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline mb-5">
                        <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio2" disabled
                            {{$users->sex == 'M' ? 'checked' : ''}}>
                        <label class="custom-control-label" for="example-inline-radio2">M</label>
                    </div>
                    <div class="custom-control custom-radio custom-control-inline mb-5">
                        <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio3" disabled
                            {{$users->sex == 'O' ? 'checked' : ''}}>
                        <label class="custom-control-label" for="example-inline-radio3">Otro</label>
                    </div>
                </div>
            </div>
            @if ($users->sign == '')
            <form action="{{ route('upload.sign.user', $users->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="sign">Cargar firma</label>
                    <div>
                        <input type="file" id="sign" name="sign" accept="image/*">
                        <button type="submit" class="btn btn-circle btn-alt-primary mr-5 mb-5">
                            <i class="fa fa-upload"></i>
                        </button>
                    </div>
                    @if($errors->has('sign'))
                    <small class="text-danger is-invalid">{{ $errors->first('sign') }}</small>
                    @endif
                </div>
            </form>
            @elseif($users->sign != null)
            @include('user.profiles.partials.modal')
            <label>Firma:</label>
            <div class="row gutters-tiny items-push">
                <div class="col-sm-6 col-xl-4">
                    <div class="options-container">
                        <img class="img-fluid options-item" src="{{ Storage::url($users->sign) }}" alt="">
                        <div class="options-overlay bg-black-op">
                            <div class="options-overlay-content">
                                <button type="button" class="btn btn-sm btn-rounded btn-alt-success min-width-75"
                                    data-toggle="modal" data-target="#modal-sign">
                                    <i class="fa fa-edit"></i> Editar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{--<div class="form-group row">
                <div class="col-12">
                    <div class="form-material">
                        <span class="badge badge-pill badge-warning"><i class="si si-badge mr-5"></i>Attention</span>
                        <label for="example-tags3">Roles</label>
                    </div>
                </div>
            </div>--}}
            <div class="form-group row mb-4">
                <div class="col-12">
                    <div class="form-material input-group floating">
                        <input type="email" class="form-control" id="email" name="email" value="{{ $users->email }}"
                            readonly>
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
        </div>
    </div>
</div>
<!-- END Settings -->

@endsection

@push('js')

@if(Session::has('success_upload_sign'))
<script>
    Swal.fire(
'Firma cargada con éxito!',
'{!! Session::get('success_upload_sign') !!}',
'success'
)
</script>
@endif

@if(Session::has('fail_upload_sign'))
<script>
    Swal.fire(
'La firma digital debe ser de tipo imagen',
'{!! Session::get('fail_upload_sign') !!}',
'error'
)
</script>
@endif

@if(Session::has('empty_upload_sign'))
<script>
    Swal.fire(
'No has seleccionado un archivo imagen para la firma digital',
'{!! Session::get('empty_upload_sign') !!}',
'warning'
)
</script>
@endif

<!-- Page JS Code -->
<script src="{{ asset('/js/pages/be_forms_plugins.min.js') }}"></script>

@endpush