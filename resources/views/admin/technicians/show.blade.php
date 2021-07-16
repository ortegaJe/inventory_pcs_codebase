@extends('layouts.backend')

@section('title', 'Usuario')

@section('content')
<!-- Hero -->
<div class="bg-gray-lighter">
    <div class="bg-black-op-12">
        <div class="content content-top text-center">
            <div class="mb-20">
                <i class="fa fa-building-o fa-4x text-muted"></i>
                <h1 class="h3 text-primary-light font-w700 mb-10">
                </h1>
                <h2 class="h5 text-black-op">
                    Inventario de <a class="text-primary-light link-effect" href="javascript:void(0)">
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
            <a class="breadcrumb-item" href="{{ route('admin.inventory.technicians.index') }}">Sedes</a>
            <span class="breadcrumb-item active"></span>
        </nav>
    </div>
</div>
<!-- END Breadcrumb -->

<!-- Overview -->
<h2 class="h4 font-w300 mt-50">Asignada a:</h2>
<div class="row invisible" data-toggle="appear">
    <!-- Row #1 -->
    <div class="col-md-4">
        <div class="block">
            <div class="block-content block-content-full">
                <div class="py-20 text-center">
                    <div class="mb-20">
                        <i class="si si-user fa-4x text-primary"></i>
                    </div>
                    <div class="font-size-h4 font-w600"></div>
                    <div class="text-muted"> |
                        <span class="badge badge-pill badge-primary"><i class="fa fa-building-o"></i>
                            Sedes</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END Row #1 -->
    <div class="col-md-4">
        <div class="block">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <i class="fa fa-building-o fa-fw mr-5 text-muted"></i> Información de la sede
                </h3>
            </div>
            <div class="block-content block-content-full">
                <p class="mb-4">
                    <strong>Región:</strong>
                    <span class="text-muted"></span>
                </p>
                <p>
                    <strong>Abreviado de la sede:</strong>
                    <span class="badge badge-pill badge-primary"></span>
                </p>
                <p>
                    <strong>Dirección:</strong>
                    <span class="text-muted"></span>
                </p>
                <p>
                    <strong>Telefonos:</strong>
                    <span class="text-muted"></span>
                </p>

            </div>
        </div>
    </div>
</div>
<!-- END Overview -->

<!-- Settings -->
<h2 class="h4 font-w300 mt-50">Configuraciones</h2>
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">
            <i class="fa fa-building fa-fw mr-5 text-muted"></i> Actualizar datos
        </h3>
    </div>
    <div class="block-content">
        <form action="" method="POST">
            @csrf
            @method('PATCH')
            <div class="col-lg-12">
                <div class="form-group row">
                    <div class="col-4">
                        <div class="form-material">
                            <input type="text" class="js-maxlength form-control" id="abreviature" name="abreviature"
                                maxlength="4" placeholder="4 letras es el limite.." data-always-show="true"
                                data-pre-text="Used " data-separator=" of " data-post-text=" characters"
                                onkeyup="javascript:this.value=this.value.toUpperCase();" value="">
                            <label for="abreviature">Abreviado de la sede</label>
                            @error('abreviature')<small class="text-danger"> {{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="name" name="name"
                                onkeyup="javascript:this.value=this.value.toUpperCase();" value="">
                            <label for="name">Nombre de la sede</label>
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-material">
                            <input type="text" class="form-control" id="slug" name="slug" readonly value="">
                            <label for="slug">Slug de la sede</label>
                            @error('slug')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-4">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="address" name="address"
                                onkeyup="javascript:this.value=this.value.toUpperCase();" value="">
                            <label for="address">Dirección</label>
                            @error('address')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="phone" name="phone"
                                onkeyup="javascript:this.value=this.value.toUpperCase();" value="">
                            <label for="phone">Telefono</label>
                            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    {{--  <div class="col-4 mt-3">
                        <button type="button" class="btn btn-hero btn-alt-primary btn-block" data-toggle="click-ripple">
                            <i class="si si-user-follow mr-1"></i> Asignar nuevo técnico
                        </button>
                    </div>--}}
                </div>
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
<script src="{{ asset('/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('/js/plugins/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>

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

@endpush