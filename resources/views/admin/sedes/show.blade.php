@extends('layouts.backend')

@section('title', 'Sede ' . $campus->name)

@section('content')
    @include('admin.sedes.partials.modal')
    <!-- Hero -->
    <div class="bg-gray-lighter">
        <div class="bg-black-op-12">
            <div class="content content-top text-center">
                <div class="mb-20">
                    <i class="fa fa-building-o fa-4x text-muted"></i>
                    <h1 class="h3 text-primary-light font-w700 mb-10">
                        {{ Str::upper($campus->name) }}
                    </h1>
                    <h2 class="h5 text-black-op">
                        Inventario de <a class="text-primary-light link-effect" href="javascript:void(0)">
                            {{ $campusCount ?? '0' }} Equipos
                        </a>
                        @if ($campusCount <= 0)
                        @else
                            <button type="button" class="btn btn-sm btn-alt-success mr-4" data-toggle="tooltip"
                                data-placement="bottom" title="Descargar Inventario"
                                onclick="window.location='{{ route('admin.inventory.export-campu-computers', [$campus->id, $campus->name]) }}'">
                                <i class="fa fa-file-excel-o"></i>
                            </button>
                        @endif
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
                <a class="breadcrumb-item" href="{{ route('admin.inventory.campus.index') }}">Sede</a>
                <span class="breadcrumb-item active">{{ Str::lower($campus->name) }}</span>
            </nav>
        </div>
    </div>
    <!-- END Breadcrumb -->

    <!-- Overview -->
    <div class="content-heading">
        <h2 class="h4 font-w300 mb-0">Asignada a:</h2>
    </div>
    <div class="row items-push" id="colUserCard">
    </div>
    <!-- END Overview -->

    <!-- Settings -->
    <div class="content-heading">
        <h2 class="h4 font-w300 mb-0">Configuraciones</h2>
    </div>
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                <i class="fa fa-building fa-fw mr-5 text-muted"></i> Información de la Sede
            </h3>
        </div>
        <div class="block-content">
            <form action="{{ route('admin.inventory.campus.update', [$campus->id, $campus->slug]) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="col-lg-12">
                    <div class="form-group row">
                        <div class="col-4">
                            <div class="form-material">
                                <input type="text" class="js-maxlength form-control" id="abreviature" name="abreviature"
                                    maxlength="4" placeholder="4 letras es el limite.." data-always-show="true"
                                    data-pre-text="Used " data-separator=" of " data-post-text=" characters"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    value="{{ trim($campus->abreviature) }}">
                                <label for="abreviature">Abreviado</label>
                                @error('abreviature')
                                    <small class="text-danger"> {{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-material floating">
                                <input type="text" class="form-control" id="name" name="name"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    value="{{ trim($campus->name) }}">
                                <label for="name">Nombre</label>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-material floating">
                                <input type="text" class="form-control" id="region" name="region"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    value="{{ trim($campus->regional) }}" readonly>
                                <label for="region">Regional</label>
                                @error('region')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-4">
                            <div class="form-material floating">
                                <input type="text" class="form-control" id="name" name="name"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    value="{{ trim($campus->admin_name) }} {{ trim($campus->admin_last_name) }}">
                                <label for="name">Administrador</label>
                                @error('name')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-material floating">
                                <input type="text" class="form-control" id="address" name="address"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    value="{{ trim($campus->address) }}">
                                <label for="address">Dirección</label>
                                @error('address')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-material floating">
                                <input type="text" class="form-control" id="phone" name="phone"
                                    onkeyup="javascript:this.value=this.value.toUpperCase();"
                                    value="{{ trim($campus->phone) }}">
                                <label for="phone">Telefono</label>
                                @error('phone')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-4">
                        <button type="submit" class="btn btn-hero btn-alt-success min-width-125"
                            data-toggle="click-ripple">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Settings -->

    <!-- Timeouts -->
    <div class="content-heading">
        <div class="row">
            @forelse ($typeDevices as $typeDevice)
                <div class="col-sm-3">
                    <div class="block block-bordered block-rounded invisible" data-toggle="appear" data-offset="-200">
                        <div class="block-content block-content-full">
                            <div class="py-30 text-center">
                                <div class="item item-2x item-circle bg-primary-lighter text-white mx-auto">
                                    <i class="si si-screen-desktop text-primary"></i>
                                </div>
                                <div class="font-size-h5 font-w600 pt-20 mb-0">
                                    {{ Str::title($typeDevice->nameTypeDevice) }}
                                </div>
                                <span class="badge badge-pill badge-primary">{{ $typeDevice->numberTypeDevice }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
    <!-- END Timeouts -->

    <!-- Files Filtering -->
    {{-- <h2 class="content-heading">Files <small>Filtering with slower animation</small></h2>

<!-- Content Filtering (.js-filter class is initialized in Helpers.contentFilter()) -->
<!-- You can set the animation duration through data-speed="speed_in_ms" -->
<div class="js-filter" data-speed="400">
  <div class="p-10 bg-white push">
    <ul class="nav nav-pills">
      <li class="nav-item">
        <a class="nav-link active" href="#" data-category-link="all">
          <i class="fa fa-fw fa-folder-open-o mr-5"></i> All
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" data-category-link="movies">
          <i class="fa fa-fw fa-file-movie-o mr-5"></i> Movies
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" data-category-link="photos">
          <i class="fa fa-fw fa-file-photo-o mr-5"></i> Photos
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" data-category-link="music">
          <i class="fa fa-fw fa-file-audio-o mr-5"></i> Music
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" data-category-link="books">
          <i class="fa fa-fw fa-file-text-o mr-5"></i> Books
        </a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-6 col-xl-3" data-category="books">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full text-center">
          <div class="item item-circle bg-warning-light text-warning mx-auto my-20">
            <i class="fa fa-book"></i>
          </div>
          <div class="font-size-lg">The Martian.epub</div>
          <div class="font-size-sm text-muted">~ 7 hrs | 426 pages</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3" data-category="photos">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full text-center">
          <div class="item item-circle bg-info-light text-info mx-auto my-20">
            <i class="fa fa-image"></i>
          </div>
          <div class="font-size-lg">DSC00018.jpg</div>
          <div class="font-size-sm text-muted">12 mp | 3 mb</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3" data-category="books">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full text-center">
          <div class="item item-circle bg-warning-light text-warning mx-auto my-20">
            <i class="fa fa-book"></i>
          </div>
          <div class="font-size-lg">Learn HTML.epub</div>
          <div class="font-size-sm text-muted">~ 4 hrs | 330 pages</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3" data-category="music">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full text-center">
          <div class="item item-circle bg-success-light text-success mx-auto my-20">
            <i class="fa fa-music"></i>
          </div>
          <div class="font-size-lg">Intro.mp3</div>
          <div class="font-size-sm text-muted">2 min | 384 kbps</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3" data-category="movies">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full text-center">
          <div class="item item-circle bg-danger-light text-danger mx-auto my-20">
            <i class="fa fa-film"></i>
          </div>
          <div class="font-size-lg">Iron Man 3.mov</div>
          <div class="font-size-sm text-muted">124 min | 1080p</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3" data-category="photos">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full text-center">
          <div class="item item-circle bg-info-light text-info mx-auto my-20">
            <i class="fa fa-image"></i>
          </div>
          <div class="font-size-lg">DSC00100.jpg</div>
          <div class="font-size-sm text-muted">32 mp | 12 mb</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3" data-category="music">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full text-center">
          <div class="item item-circle bg-success-light text-success mx-auto my-20">
            <i class="fa fa-music"></i>
          </div>
          <div class="font-size-lg">Immposible Day.mp3</div>
          <div class="font-size-sm text-muted">6 min | 384 kbps</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3" data-category="movies">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full text-center">
          <div class="item item-circle bg-danger-light text-danger mx-auto my-20">
            <i class="fa fa-film"></i>
          </div>
          <div class="font-size-lg">CA: Civil War.mov</div>
          <div class="font-size-sm text-muted">154 min | 1080p</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3" data-category="movies">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full text-center">
          <div class="item item-circle bg-danger-light text-danger mx-auto my-20">
            <i class="fa fa-film"></i>
          </div>
          <div class="font-size-lg">The Hobbit.mov</div>
          <div class="font-size-sm text-muted">180 min | 1080p</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3" data-category="music">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full text-center">
          <div class="item item-circle bg-success-light text-success mx-auto my-20">
            <i class="fa fa-music"></i>
          </div>
          <div class="font-size-lg">Stranger Things.mp3</div>
          <div class="font-size-sm text-muted">5 min | 384 kbps</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3" data-category="photos">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full text-center">
          <div class="item item-circle bg-info-light text-info mx-auto my-20">
            <i class="fa fa-image"></i>
          </div>
          <div class="font-size-lg">DSC00025.jpg</div>
          <div class="font-size-sm text-muted">24 mp | 6 mb</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3" data-category="books">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full text-center">
          <div class="item item-circle bg-warning-light text-warning mx-auto my-20">
            <i class="fa fa-book"></i>
          </div>
          <div class="font-size-lg">Start a business.epub</div>
          <div class="font-size-sm text-muted">~ 10 hrs | 590 pages</div>
        </div>
      </a>
    </div>
  </div>
</div> --}}
    <!-- END Files Filtering -->

@endsection

@push('js')
    <!-- Page JS Code -->
    <script src="{{ asset('/js/pages/be_forms_plugins.min.js') }}"></script>
    <script src="{{ asset('/js/remove.user.campu.js') }}"></script>
    <script src="{{ asset('/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
    <script src="{{ asset('/js/plugins/jQuery-Plugin-stringToSlug-1.3/jquery.stringToSlug.min.js') }}"></script>

    <!-- Page JS Helpers (Content Filtering helper) -->
    <script>
        jQuery(function() {
            Codebase.helpers('content-filter');
        });
        jQuery(function() {
            Codebase.helpers(['maxlength']);
        });
    </script>

    <script>
        $(document).ready(function() {
            $("#name").stringToSlug({
                setEvents: 'keyup keydown blur',
                getPut: '#slug',
                space: '-'
            });
        });
    </script>

    @if (Session::has('assigned'))
        <script>
            Swal.fire(
                'Usuario Asignado con Exito!',
                '{!! Session::get('assigned') !!}',
                'success',
            )
        </script>
    @endif
@endpush
