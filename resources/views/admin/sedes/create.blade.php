@extends('layouts.backend')

@section('title', 'Crear Sede')

@section('css')

@section('content')

@if(session('info'))
<div class="alert alert-success">
  <strong>{{ session('info') }}</strong>
</div>
@endif

<div class="col-xl-12">
  <form action="{{ route('admin.inventory.campus.store') }}" method="POST">
    @csrf
    @method('POST')
    <div class="block pull-r-l">
      <div class="block-header bg-gray-light">
        <h3 class="block-title">
          <i class="fa fa-building fa-2x font-size-default mr-5"></i>Nueva Sede
        </h3>
        <div class="block-options">
          <button type="submit" class="btn btn-sm btn-alt-success min-width-125" data-toggle="click-ripple">
            Crear
          </button>
        </div>
      </div>
      <div class="block-content">
        <div class="form-group row">
          <div class="col-6">
            <div class="form-material">
              <input type="text" class="js-maxlength form-control" id="campu-abrev" name="campu-abrev" maxlength="4"
                placeholder="4 letras es el limite.." data-always-show="true" data-pre-text="Used "
                data-separator=" of " data-post-text=" characters"
                onkeyup="javascript:this.value=this.value.toUpperCase();">
              <label for="campu-abrev">Abreviado de la sede</label>
              @error('campu-abrev')
              <small class="text-danger">
                {{ $message }}
              </small>
              @enderror
            </div>
          </div>
          <div class="col-6 mb-2">
            <div class="form-material floating">
              <input type="text" class="form-control" id="description" name="description"
                onkeyup="javascript:this.value=this.value.toUpperCase();">
              <label for="description">Nombre de la sede</label>
              @error('description')
              <small class="text-danger">
                {{ $message }}
              </small>
              @enderror
            </div>
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
@endsection

@push('js')
<!-- Page JS Code -->
<script src="{{ asset('/js/pages/be_forms_plugins.min.js') }}"></script>
<script src="{{ asset('/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('/js/plugins/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>

<!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins) -->
<script>
  jQuery(function(){ Codebase.helpers(['maxlength']); });
</script>

<script>
  $(document).ready( function() {
    $("#description").stringToSlug({
      setEvents: 'keyup keydown blur',
      getPut: '#slug',
      space: '-'
  });
});
</script>
@endpush