@extends('layouts.backend')

@section('title', 'Sedes')

@section('content')

@if(session('info'))
<div class="alert alert-success">
  <strong>{{ session('info') }}</strong>
</div>
@endif

<form action="{{ route('admin.inventory.campus.index') }}" method="GET">
  <div class="input-group input-group-lg">
    <input type="text" class="form-control" id="search" name="search" placeholder="Buscar sede..">
    <div class="input-group-append">
      <button type="submit" class="btn btn-secondary">
        <i class="fa fa-search"></i>
      </button>
    </div>
  </div>
</form>

<!-- Overview -->
<div class="content-heading">
  <div class="d-flex justify-content-between align-items-center mt-50 mb-20">
    <h2 class="h4 font-w300 mb-0">Sedes <small class="d-none d-sm-inline">VIVA 1A IPS</small></h2>
    <div class="col-md-10 col-lg-8 col-xl-6">
    </div>
    <button type="button" class="btn btn-sm btn-alt-primary min-width-125" data-toggle="click-ripple"
      onclick="Codebase.blocks('#cb-add-server', 'open');">
      <i class="fa fa-building-o mr-1"></i> Agregar sede
    </button>
  </div>
  <div id="cb-add-server" class="block bg-body-light animated fadeIn d-none">
    <div class="block-header">
      <h3 class="block-title">Nueva sede</h3>
      <div class="block-options">
        <button type="button" class="btn-sm btn-block-option" data-toggle="block-option" data-action="close">
          <i class="si si-close"></i>
        </button>
      </div>
    </div>
    <div class="block-content">
      <form action="{{ route('admin.inventory.campus.index') }}" method="POST">
        @csrf
        @method('POST')
        <div class="form-group row gutters-tiny mb-0 items-push">
          <div class="col-md-2">
            <input type="text" class="js-maxlength form-control" id="abreviature" name="abreviature" maxlength="4"
              placeholder="Abreviado sede" data-always-show="true" data-pre-text="Used " data-separator=" of "
              data-post-text=" letters" onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('abreviature')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="col-md-5">
            <input type="text" class="form-control" id="name" name="name" placeholder="Nombre de la sede"
              onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="col-md-5">
            <input type="text" class="form-control" id="slug" name="slug" placeholder="Slug sede" readonly
              onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('slug')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="col-md-3">
            <input type="text" class="form-control" id="address" name="address" placeholder="Dirección"
              onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('address')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          <div class="col-md-3">
            <input type="text" class="form-control" id="phone" name="phone" placeholder="Telefono"
              onkeyup="javascript:this.value=this.value.toUpperCase();">
            @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
          </div>
          {{--  <div class="col-md-4">
            <select class="js-select2 form-control" id="tecnicos" name="tecnicos" style="width: 100%;"
              data-placeholder="Asignar técnico..">
              <option></option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
              @forelse ($users as $tecnico)
              <option value="{{ $tecnico->id }}">{{ Str::title($tecnico->name) }} {{ Str::title($tecnico->last_name) }}
          </option>
          @empty
          <option>TECNICOS NO DISPONIBLES</option>
          @endforelse
          </select>
          @error('tecnicos')<small class="text-danger">{{ $message }}</small>@enderror
        </div>--}}
        <div class="col-md-2">
          <button type="submit" class="btn btn-alt-success btn-block" data-toggle="click-ripple">
            <i class="fa fa-plus mr-1"></i> Crear
          </button>
        </div>
    </div>
    </form>
  </div>
</div>
</div>
<!-- END Overview -->

<div class="row">
  @foreach ($campus as $campu )
  <div class="col-md-6 col-xl-4">
    <a class="block block-link-pop text-center"
      href="{{ route('admin.inventory.campus.show', [$campu, '=', trim($campu->slug)]) }}">
      <div class="block-content text-center">
        <div class="item item-circle bg-primary-lighter text-primary mx-auto my-10">
          <i class="fa fa-building-o"></i>
        </div>
        {{-- <divclass="font-size-smtext-muted">equipos --}}
      </div>
      <div class="block-content bg-body-light">
        <p class="font-w600">
          {{ Str::upper($campu->name) }}
        </p>
      </div>
    </a>
  </div>
  @endforeach
</div>
<div class="d-flex float-right mb-4">
  {!! $campus->links("pagination::bootstrap-4") !!}
</div>

@endsection

@push('js')
<!-- Page JS Code -->
<script src="{{ asset('/js/pages/be_forms_plugins.min.js') }}"></script>
<script src="{{ asset('/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('/js/plugins/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap3-typeahead.min.js') }}"></script>
<!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins) -->
<script>
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

@if(Session::has('info_error'))
<script>
  Swal.fire(
'ERROR',
'{!! Session::get('info_error') !!}',
'error'
)
</script>
@endif

<script>
  let route = "{{ route('admin.inventory.campus.search') }}";

        $('#search').typeahead({
            source: function (query, process) {
                return $.get(route, {
                    query: query
                }, function (data) {
                    return process(data);
                });
            }
        });
</script>

@endpush