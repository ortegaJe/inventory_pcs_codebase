@extends('layouts.backend')

@section('title', 'Sede '.$campus->name)

@section('content')
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
            <a class="breadcrumb-item" href="{{ route('admin.inventory.campus.index') }}">Sedes</a>
            <span class="breadcrumb-item active">{{ Str::title($campus->name) }}</span>
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
                    @forelse($campuAssigned as $campu)
                    <div class="font-size-h4 font-w600">{{ Str::title($campu->NombreCompletoTecnico) }}</div>
                    <div class="text-muted">{{ Str::title($campu->CargoTecnico) }} |
                        <span class="badge badge-pill badge-primary"><i class="fa fa-building-o"></i>
                            {{ $campuAssignedCount }} Sedes</span>
                    </div>
                    @empty
                    <div class="font-size-h4 font-w600">Sin técnico asignado aún</div>
                    <div class="text-muted">
                    </div>
                    @endforelse
                    <div class="pt-20">
                        <a class="btn btn-rounded btn-alt-primary" href="javascript:void(0)">
                            <i class="fa fa-eye mr-5"></i> Ver Perfil
                        </a>
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
                    <span class="badge badge-pill badge-primary">{{ $campus->abreviature }}</span>
                </p>
                <p>
                    <strong>Dirección:</strong>
                    <span class="text-muted">{{ $campus->address }}</span>
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
            <i class="fa fa-pencil fa-fw mr-5 text-muted"></i> Profile
        </h3>
    </div>
    <div class="block-content">
        <div class="row items-push">
            <div class="col-lg-3">
                <p class="text-muted">
                    Your account’s vital info. Your name should match your public ID.
                </p>
            </div>
            <div class="col-lg-7 offset-lg-1">
                <div class="form-group">
                    <label for="hosting-settings-profile-name">Name</label>
                    <input type="text" class="form-control form-control-lg" id="hosting-settings-profile-name"
                        name="hosting-settings-profile-name" placeholder="Enter your name.." value="John Smith">
                </div>
                <div class="form-group">
                    <label for="hosting-settings-profile-email">Email Address</label>
                    <input type="email" class="form-control form-control-lg" id="hosting-settings-profile-email"
                        name="hosting-settings-profile-email" placeholder="Enter your email.."
                        value="hosting@example.com">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-alt-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">
            <i class="fa fa-lock fa-fw mr-5 text-muted"></i> Security
        </h3>
    </div>
    <div class="block-content">
        <div class="row items-push">
            <div class="col-lg-3">
                <p class="text-muted">
                    Keep your account as secure and as private as you like.
                </p>
            </div>
            <div class="col-lg-7 offset-lg-1">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input"
                                    id="hosting-settings-security-status" name="hosting-settings-security-status">
                                <label class="custom-control-label" for="hosting-settings-security-status">Online
                                    Status</label>
                            </div>
                            <div class="text-muted">Show your status to all</div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input"
                                    id="hosting-settings-security-verify" name="hosting-settings-security-verify"
                                    checked>
                                <label class="custom-control-label" for="hosting-settings-security-verify">Verify on
                                    Login</label>
                            </div>
                            <div class="text-muted">Most secure option</div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input"
                                    id="hosting-settings-security-updates" name="hosting-settings-security-updates"
                                    checked>
                                <label class="custom-control-label" for="hosting-settings-security-updates">Auto
                                    Updates</label>
                            </div>
                            <div class="text-muted">Keep app updated</div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input"
                                    id="hosting-settings-security-notifications"
                                    name="hosting-settings-security-notifications">
                                <label class="custom-control-label"
                                    for="hosting-settings-security-notifications">Notifications</label>
                            </div>
                            <div class="text-muted">For every upgrade</div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="hosting-settings-security-api"
                                    name="hosting-settings-security-api" checked>
                                <label class="custom-control-label" for="hosting-settings-security-api">API
                                    Access</label>
                            </div>
                            <div class="text-muted">Enable access from third party apps</div>
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox mb-5">
                                <input type="checkbox" class="custom-control-input" id="hosting-settings-security-2fa"
                                    name="hosting-settings-security-2fa" checked>
                                <label class="custom-control-label" for="hosting-settings-security-2fa">Two Factor
                                    Auth</label>
                            </div>
                            <div class="text-muted">Using an authenticator</div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-alt-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="block">
    <div class="block-header block-header-default">
        <h3 class="block-title">
            <i class="fa fa-building fa-fw mr-5 text-muted"></i> Address
        </h3>
    </div>
    <div class="block-content">
        <div class="row items-push">
            <div class="col-lg-3">
                <p class="text-muted">
                    Your personal information is only used for invoices.
                </p>
            </div>
            <div class="col-lg-7 offset-lg-1">
                <div class="form-row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="hosting-settings-address-firstname">Firstname</label>
                            <input type="text" class="form-control form-control-lg"
                                id="hosting-settings-address-firstname" name="hosting-settings-address-firstname"
                                value="John" disabled>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="hosting-settings-address-lastname">Lastname</label>
                            <input type="text" class="form-control form-control-lg"
                                id="hosting-settings-address-lastname" name="hosting-settings-address-lastname"
                                value="Smith" disabled>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="hosting-settings-address-street-1">Street Address 1</label>
                    <input type="text" class="form-control form-control-lg" id="hosting-settings-address-street-1"
                        name="hosting-settings-address-street-1">
                </div>
                <div class="form-group">
                    <label for="hosting-settings-address-street-2">Street Address 2</label>
                    <input type="text" class="form-control form-control-lg" id="hosting-settings-address-street-2"
                        name="hosting-settings-address-street-2">
                </div>
                <div class="form-group">
                    <label for="hosting-settings-address-city">City</label>
                    <input type="text" class="form-control form-control-lg" id="hosting-settings-address-city"
                        name="hosting-settings-address-city">
                </div>
                <div class="form-group row">
                    <div class="col-6">
                        <label for="hosting-settings-address-postal">Postal code</label>
                        <input type="text" class="form-control form-control-lg" id="hosting-settings-address-postal"
                            name="hosting-settings-address-postal">
                    </div>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-alt-primary">Update</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END Settings -->

<!-- Files Filtering -->
<h2 class="content-heading">Files <small>Filtering with slower animation</small></h2>

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
</div>
<!-- END Files Filtering -->

@endsection

@push('js')

<!-- Page JS Helpers (Content Filtering helper) -->
<script>
    jQuery(function(){ Codebase.helpers('content-filter'); });
</script>

@endpush