@extends('layouts.backend')

@section('title', 'Usuario ' .Str::lower($users->nick_name))

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
            <a class="breadcrumb-item" href="{{ route('admin.inventory.technicians.index') }}">Usuario</a>
            <span class="breadcrumb-item active">{{ $users->name }} {{ $users->last_name }}</span>
        </nav>
    </div>
</div>
<!-- END Breadcrumb -->

<!-- Overview -->
<h2 class="h4 font-w300 mt-50">Asignado a:</h2>
<div class="row">
    @foreach ($dataUsers as $dataUser)
    @if ($dataUser->SedePrincipal == 1)
    <div class="col-md-6 col-xl-3">
        <a class="block block-link-pop text-center"
            href="{{ route('admin.inventory.campus.show', $dataUser->SedeID) }}">
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
    @continue
    @endif
    <div class="col-md-6 col-xl-3">
        <a class="block block-link-pop text-center"
            href="{{ route('admin.inventory.campus.show', $dataUser->SedeID) }}">
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
    @endforeach
</div>
<!-- END Overview -->

<!-- Settings -->
<h2 class="h4 font-w300 mt-50">Configuraciones</h2>
@include('admin.users.partials.modals')
<div class="row">
    <div class="col-xl-3">
        <a class="block p-10 block-rounded block-link-shadow" data-toggle="modal" data-target="#modal-popin">
            <div class="block-content block-content-full block-sticky-options">
                <div class="block-options">
                    <div class="block-options-item">
                        <i class="si si-user fa-2x text-success-light"></i>
                    </div>
                </div>
                <div class="py-20 text-center">
                    <div class="font-size-h2 font-w700 mb-0 text-success">
                        <i class="si si-key"></i>
                    </div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">change password</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3">
        <a class="block p-10 block-rounded block-link-shadow" data-id="{{ $users->id }}" id="btn-delete"
            href="javascript:void(0)">
            <div class="block-content block-content-full block-sticky-options">
                <div class="block-options">
                    <div class="block-options-item">
                        <i class="si si-user fa-2x text-primary-lighter"></i>
                    </div>
                </div>
                <div class="py-20 text-center">
                    <div class="font-size-h2 font-w700 mb-0 text-primary">
                        <i class="fa fa-building-o"></i>
                    </div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">change campu</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3">
        <a class="block p-10 block-rounded block-link-shadow" data-id="{{ $users->id }}" id="btn-delete"
            href="javascript:void(0)">
            <div class="block-content block-content-full block-sticky-options">
                <div class="block-options">
                    <div class="block-options-item">
                        <i class="si si-user fa-2x text-warning-light"></i>
                    </div>
                </div>
                <div class="py-20 text-center">
                    <div class="font-size-h2 font-w700 mb-0 text-warning">
                        <i class="si si-briefcase"></i>
                    </div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">change profile</div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3">
        <a class="block p-10 block-rounded block-link-shadow" data-id="{{ $users->id }}" id="btn-delete"
            href="javascript:void(0)">
            <div class="block-content block-content-full block-sticky-options">
                <div class="block-options">
                    <div class="block-options-item">
                        <i class="fa fa-archive fa-2x text-danger-light"></i>
                    </div>
                </div>
                <div class="py-20 text-center">
                    <div class="font-size-h2 font-w700 mb-0 text-danger">
                        <i class="fa fa-times"></i>
                    </div>
                    <div class="font-size-sm font-w600 text-uppercase text-muted">remove user</div>
                </div>
            </div>
        </a>
    </div>
</div>
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">
            <i class="si si-user fa-fw mr-5 text-muted"></i> Actualizar datos
        </h3>
    </div>
    <div class="block-content">
        <form action="{{ route('admin.inventory.technicians.update', $users) }}" method="POST">
            @csrf
            @method('PATCH')
            <div class="col-lg-12">
                <div class="form-group row">
                    <div class="col-6">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="cc" name="cc" value="{{ $users->cc }}">
                            <label for="cc">Identificación</label>
                        </div>
                        @if($errors->has('cc'))
                        <small class="text-danger is-invalid">{{ $errors->first('cc') }}</small>
                        @endif
                    </div>
                    <div class="col-6">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="firstname" name="firstname"
                                value="{{ $users->name }}">
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
                                value="{{ $users->middle_name }}">
                            <label for="middlename">Segundo nombre</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="lastname" name="lastname"
                                value="{{ $users->last_name }}">
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
                                value="{{ $users->second_last_name }}">
                            <label for="second-lastname">Segundo apellido</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="nick-name" name="nick-name"
                                value="{{ $users->nick_name }}">
                            <label for="nick-name">Nombre de usuario</label>
                        </div>
                        @if($errors->has('nick-name'))
                        <small class="text-danger is-invalid">{{ $errors->first('nick-name') }}</small>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="phone" name="phone"
                                value="{{ $users->phone_number }}">
                            <label for="phone">Telefono</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-material">
                            <input type="text" class="js-flatpickr form-control" id="birthday" name="birthday"
                                placeholder="Y-dd-mm" data-allow-input="true" maxlength="10"
                                value="{{ $users->birthday }}">
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
                                <option value="{{ $campu->id }}">
                                    {{ Str::upper($campu->name) }}
                                </option>
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
                                {@forelse ($profiles as $profile)
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
                            <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio1"
                                value="M" checked="">
                            <label class="custom-control-label" for="example-inline-radio1">F</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline mb-5">
                            <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio2"
                                value="F">
                            <label class="custom-control-label" for="example-inline-radio2">M</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline mb-5">
                            <input class="custom-control-input" type="radio" name="sex" id="example-inline-radio3"
                                value="O">
                            <label class="custom-control-label" for="example-inline-radio3">Otro</label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <div class="form-material input-group floating">
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ $users->email }}">
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
                {{--  <div class="form-group row">
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
    </div>--}}
    <div class="form-group mt-4">
        <button type="submit" class="btn btn-sm btn-alt-success min-width-125"
            data-toggle="click-ripple">Actualizar</button>
    </div>
</div>
</form>
</div>
</div>
<!-- END Settings -->

@endsection

@push('js')

<!-- Page JS Code -->
<script src="{{ asset('/js/pages/be_forms_plugins.min.js') }}"></script>
<script src="{{ asset('/js/soft.delete.user.js') }}"></script>
<script src="{{ asset('/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('/js/plugins/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>
<script>
    let root_url_user_store = <?php echo json_encode(route('admin.inventory.technicians.store')) ?>;
    let root_url_user_index = <?php echo json_encode(route('admin.inventory.technicians.index')) ?>;
</script>

<!-- Page JS Helpers (Content Filtering helper) -->
<script>
    jQuery(function(){ Codebase.helpers('content-filter'); });
    jQuery(function(){ Codebase.helpers(['maxlength']); });
</script>

<script>
    $(document).ready( function() {
    $("#name").stringToSlug({
      setEvents: 'keyup keydown blur',
      getPut: '#slug',
      space: '-'
  });
});
</script>

@if(Session::has('info_success'))
<script>
    Swal.fire(
'Actualizado',
'{!! Session::get('info_success') !!}',
'success'
)
</script>
@endif

@if(Session::has('info_error'))
<script>
    Swal.fire(
'Upps! Ha ocurrido un error',
'{!! Session::get('info_error') !!}',
'error'
)
</script>
@endif

<script>
    $(document).ready(function(){
    @if($message = Session::get('message'))
    $('#modal-popin').modal('show');
    @endif
  })
</script>

@if(Session::has('update-message'))
<script>
    Swal.fire(
'Actualizado con Exito!',
'{!! Session::get('update-message') !!}',
'success'
)
</script>
@endif

@endpush