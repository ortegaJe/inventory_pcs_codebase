<!doctype html>
<html lang="en" class="no-focus">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>InventoryPC | @yield('title')</title>
    <meta name="description"
        content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="Codebase">
    <meta property="og:description"
        content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="">
    <link rel="icon" type="image/png" sizes="192x192" href="">
    <link rel="apple-touch-icon" sizes="180x180" href="">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">

    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('/js/plugins/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('/js/plugins/slick/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('/js/plugins/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('/js/plugins/sweetalert2/sweetalert2.min.css') }}">
    @yield('css')
    <!-- Fonts and Codebase framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700&display=swap">
    <link rel="stylesheet" id="css-main" href="{{ asset('/css/codebase.min.css') }}">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
    <!-- END Stylesheets -->
    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
</head>

<body>
    @auth
        <div id="page-loader" class="bg-gd-sea show"></div>
        <!-- Page Container -->
        <div id="page-container"
            class="sidebar-o enable-page-overlay side-scroll page-header-enabled side-trans-enabled sidebar-inverse enable-cookies">
            <!-- START Sidebar -->
            <nav id="sidebar">
                <!-- Sidebar Content -->
                <div class="sidebar-content">
                    <!-- Side Header -->
                    <div class="content-header content-header-fullrow px-15">
                        <!-- Mini Mode -->
                        <div class="content-header-section sidebar-mini-visible-b">
                            <!-- Logo -->
                            <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                                <span class="text-dual-primary-dark">i</span><span class="text-primary">pc</span>
                            </span>
                            <!-- END Logo -->
                        </div>
                        <!-- END Mini Mode -->

                        <!-- Normal Mode -->
                        <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                            <!-- Close Sidebar, Visible only on mobile screens -->
                            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r"
                                data-toggle="layout" data-action="sidebar_close">
                                <i class="fa fa-times text-danger"></i>
                            </button>
                            <!-- END Close Sidebar -->

                            <!-- Logo -->
                            <div class="content-header-item">
                                <a class="link-effect font-w700" href="javascript:void(0)">
                                    <i class="si si-screen-desktop text-primary"></i>
                                    <span class="font-size-xl text-dual-primary-dark">Inventario</span><span
                                        class="font-size-xl text-primary">PC</span>
                                </a>
                            </div>
                            <!-- END Logo -->
                        </div>
                        <!-- END Normal Mode -->
                    </div>
                    <!-- END Side Header -->

                    <!-- Side User -->
                    <div class="content-side content-side-full content-side-user px-10 align-parent">
                        <!-- Visible only in mini mode -->
                        <div class="sidebar-mini-visible-b align-v animated fadeIn">
                            <img class="img-avatar img-avatar32" src="{{ asset('/media/avatars/avatar15.jpg') }}"
                                alt="">
                        </div>
                        <!-- END Visible only in mini mode -->

                        <!-- Visible only in normal mode -->
                        <div class="sidebar-mini-hidden-b text-center">
                            <a class="img-link" href="{{ route('admin.inventory.technicians.profiles', Auth::id()) }}">
                                <img class="img-avatar" src="{{ asset('/media/avatars/avatar15.jpg') }}" alt="">
                            </a>
                            <ul class="list-inline mt-10">
                                <li class="list-inline-item">
                                    <a class="link-effect text-dual-primary-dark font-size-sm font-w600 text-uppercase"
                                        href="{{ route('admin.inventory.technicians.profiles', Auth::id()) }}">{{ Auth::user()->nick_name }}
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a class="link-effect text-dual-primary-dark" href="#" id="logout-link">
                                        <i class="si si-logout"></i>
                                    </a>
                                    <form id="logout-form-side" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </div>
                        <!-- END Visible only in normal mode -->
                    </div>
                    <!-- END Side User -->

                    <!-- Side Navigation -->
                    <div class="content-side content-side-full">
                        @can('user.inventory.desktop.index')
                            <button type="button"
                                class="btn btn-block btn-alt-success push d-flex align-items-center justify-content-between"
                                id="btnSelectCategory">
                                <span>Añadir Equipo</span>
                                <i class="fa fa-plus float-right"></i>
                            </button>
                        @endcan
                        <ul class="nav-main">
                            <li>
                                <a class="{{ request()->is('/') ? ' active' : '' }}" href="{{ route('dashboard') }}">
                                    <i class="si si-home"></i><span class="sidebar-mini-hide">Home</span>
                                </a>
                            </li>
                            <li class="open">
                                <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i
                                        class="si si-cup"></i>
                                    <span class="sidebar-mini-hide">Dashboard</span>
                                </a>
                                <ul>
                                    @can('admin.inventory.desktop.index')
                                        <li>
                                            <a class="{{ request()->is('admin/dashboard/inventario') ? 'active' : '' }}"
                                                href="{{ route('admin.inventory.dash.index') }}">Inventario
                                                <span class="badge badge-pill bg-gray-darker">
                                                    <i class="si si-screen-desktop"></i>
                                                    @php
                                                        $globalPcCount = DB::table('devices')
                                                            ->where('is_active', true)
                                                            ->where('deleted_at', null)
                                                            ->whereIn('statu_id', [1, 2, 3, 5, 6, 7, 8])
                                                            ->count();
                                                    @endphp
                                                    {{ $globalPcCount ?? '0' }}
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('admin.inventory.tecnicos.index')
                                        <li class="{{ request()->is('admin/dashboard/inventario/tecnicos') ? 'open' : '' }}">
                                            <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                                                <span class="sidebar-mini-hide">Usuarios</span>
                                                <span class="badge badge-pill bg-gray-darker"><i class="si si-users"></i>
                                                    @php
                                                        $globalUsersCount = DB::table('users as u')
                                                            ->join('profile_users as pu', 'pu.user_id', 'u.id')
                                                            ->where('profile_id', 2)
                                                            ->where('u.is_active', true)
                                                            ->where('u.deleted_at', null)
                                                            ->count();
                                                    @endphp
                                                    {{ $globalUsersCount ?? '0' }}
                                                </span>
                                            </a>
                                            <ul>
                                                <li>
                                                    <a class="{{ request()->is('admin/dashboard/inventario/tecnicos') ? 'active' : '' }}"
                                                        href="{{ route('admin.inventory.technicians.index') }}">Técnicos
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="{{ request()->is('admin/dashboard/inventario/historial-tecnicos') ? 'active' : '' }}"
                                                        href="{{ route('technicians.history') }}">Historial de Técnicos
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="{{ request()->is('admin/dashboard/inventario/roles') ? 'active' : '' }}"
                                                        href="{{ route('admin.inventory.roles.index') }}">Roles & Permisos
                                                    </a>
                                            </ul>
                                        </li>
                                    @endcan
                                    @can('admin.inventory.campus.index')
                                        <li>
                                            <a class="{{ request()->is('admin/dashboard/inventario/sedes') ? 'active' : '' }}"
                                                href="{{ route('admin.inventory.campus.index') }}">Sedes
                                                <span class="badge badge-pill bg-gray-darker"><i class="fa fa-building-o"></i>
                                                    @php
                                                        $globalCampusCount = DB::table('campus')
                                                            ->where('is_active', true)
                                                            ->count();
                                                    @endphp
                                                    {{ $globalCampusCount ?? '0' }}
                                                </span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('user.inventory.desktop.index')
                                        <li
                                            class="{{ request()->is('tecnico/dashboard/inventario/de-escritorios') ? 'open' : '' }}           
                            {{ request()->is('tecnico/dashboard/inventario/de-escritorios') ? 'open' : '' }}            
                            {{ request()->is('tecnico/dashboard/inventario/portatiles') ? 'open' : '' }}              
                            {{ request()->is('tecnico/dashboard/inventario/all-in-one') ? 'open' : '' }}              
                            {{ request()->is('tecnico/dashboard/inventario/turneros') ? 'open' : '' }}                
                            {{ request()->is('tecnico/dashboard/inventario/raspberry') ? 'open' : '' }}               
                            {{ request()->is('tecnico/dashboard/inventario/telefonos-ip') ? 'open' : '' }}
                            {{ request()->is('tecnico/dashboard/inventario/mini-pc-sat') ? 'open' : '' }}
                            {{ request()->is('tecnico/dashboard/inventario/tablets') ? 'open' : '' }}            
                            {{ request()->is('tecnico/dashboard/inventario/de-escritorios/registrar') ? 'open' : '' }}
                            {{ request()->is('tecnico/dashboard/inventario/portatiles/registrar') ? 'open' : '' }}    
                            {{ request()->is('tecnico/dashboard/inventario/all-in-one/registrar') ? 'open' : '' }}
                            {{ request()->is('tecnico/dashboard/inventario/turneros/registrar') ? 'open' : '' }}
                            {{ request()->is('tecnico/dashboard/inventario/raspberry/registrar') ? 'open' : '' }}
                            {{ request()->is('tecnico/dashboard/inventario/telefonos-ip/registrar') ? 'open' : '' }}
                            {{ request()->is('tecnico/dashboard/inventario/equipos-eliminados') ? 'open' : '' }}
                            {{ request()->is('tecnico/dashboard/inventario/mini-pc-sat/registrar') ? 'open' : '' }}
                            {{ request()->is('tecnico/dashboard/inventario/tablets/registrar') ? 'open' : '' }}">
                                            <a class="nav-submenu" data-toggle="nav-submenu" href="javascript:void(0)">
                                                <span class="sidebar-mini-hide">Equipos</span>
                                                <span class="badge badge-pill bg-gray-darker"><i
                                                        class="si si-screen-desktop"></i>
                                                    @php
                                                        $globalDeviceCount = DB::table('view_all_devices')
                                                            ->where('TecnicoID', Auth::id())
                                                            ->count();
                                                    @endphp
                                                    {{ $globalDeviceCount ?? '0' }}
                                                </span>
                                            </a>
                                            <ul>
                                                @can('user.inventory.allinone.index')
                                                    <li>
                                                        <a class="{{ request()->is('tecnico/dashboard/inventario/all-in-one') ? 'active' : '' }} ||
                                  {{ request()->is('tecnico/dashboard/inventario/all-in-one/registrar') ? 'active' : '' }}"
                                                            href="{{ route('user.inventory.allinone.index') }}">All In One</a>
                                                    </li>
                                                @endcan
                                                <li>
                                                    <a class="{{ request()->is('tecnico/dashboard/inventario/de-escritorios') ? 'active' : '' }} ||
                                  {{ request()->is('tecnico/dashboard/inventario/de-escritorios/registrar') ? 'active' : '' }}"
                                                        href="{{ route('user.inventory.desktop.index') }}">Escritorios
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="{{ request()->is('tecnico/dashboard/inventario/mini-pc-sat') ? 'active' : '' }} ||
                                  {{ request()->is('tecnico/dashboard/inventario/mini-pc-sat/registrar') ? 'active' : '' }}"
                                                        href="{{ route('minipc.index') }}">MiniPC SAT
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('user.inventory.laptop.index')
                                                <li>
                                                    <a class="{{ request()->is('tecnico/dashboard/inventario/portatiles') ? 'active' : '' }} ||
                                  {{ request()->is('tecnico/dashboard/inventario/portatiles/registrar') ? 'active' : '' }}"
                                                        href="{{ route('user.inventory.laptop.index') }}">Portátiles</a>
                                                </li>
                                            @endcan
                                            @can('user.inventory.raspberry.index')
                                                <li>
                                                    <a class="{{ request()->is('tecnico/dashboard/inventario/raspberry') ? 'active' : '' }} ||
                                  {{ request()->is('tecnico/dashboard/inventario/raspberry/registrar') ? 'active' : '' }}"
                                                        href="{{ route('user.inventory.raspberry.index') }}">Raspberry</a>
                                                </li>
                                            @endcan
                                            @can('user.inventory.turnero.index')
                                                <li>
                                                    <a class="{{ request()->is('tecnico/dashboard/inventario/tablets') ? 'active' : '' }} ||
                                  {{ request()->is('tecnico/dashboard/inventario/tablets/registrar') ? 'active' : '' }}"
                                                        href="{{ route('tablet.index') }}">Tablets</a>
                                                </li>
                                                <li>
                                                    <a class="{{ request()->is('tecnico/dashboard/inventario/telefonos-ip') ? 'active' : '' }} ||
                                  {{ request()->is('tecnico/dashboard/inventario/telefonos-ip/registrar') ? 'active' : '' }}"
                                                        href="{{ route('user.inventory.phones.index') }}">Telefonos IP</a>
                                                </li>
                                                <li>
                                                    <a class="{{ request()->is('tecnico/dashboard/inventario/turneros') ? 'active' : '' }} ||
                                  {{ request()->is('tecnico/dashboard/inventario/turneros/registrar') ? 'active' : '' }}"
                                                        href="{{ route('user.inventory.turnero.index') }}">Atriles</a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </li>
                                </ul>
                                @can('get.stock')
                                    <ul>
                                        <li>
                                            <a class="{{ request()->is('dashboard/inventario/stock') ? 'active' : '' }}"
                                                href="{{ route('get.stock') }}">Stock
                                                <span class="badge badge-pill bg-gray-darker"><i class="fa fa-cubes"></i>
                                                    @php
                                                        $globalDeviceCount = DB::table('view_all_devices')
                                                            ->where('TecnicoID', Auth::id())
                                                            ->where('EstadoPc', 'stock')
                                                            ->count();
                                                    @endphp
                                                    {{ $globalDeviceCount ?? '0' }}
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan
                                @can('inventory.report.index')
                                    <ul>
                                        <li>
                                            <a class="{{ request()->is('dashboard/inventario/reportes') ? 'active' : '' }}"
                                                href="{{ route('inventory.report.index') }}">Reportes
                                                <span class="badge badge-pill bg-gray-darker"><i
                                                        class="fa fa-file-text-o"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                @endcan
                            </li>
                        </ul>
                    </div>
                    <!-- END Side Navigation -->
                </div>
                <!-- Sidebar Content -->
            </nav>
            <!-- END Sidebar -->

            <!-- Header -->
            <header id="page-header">
                <!-- Header Content -->
                <div class="content-header">
                    <!-- Left Section -->
                    <div class="content-header-section">
                        <!-- Toggle Sidebar -->
                        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                        <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout"
                            data-action="sidebar_toggle">
                            <i class="fa fa-navicon"></i>
                        </button>
                        <!-- END Toggle Sidebar -->
                    </div>
                    <!-- END Left Section -->

                    <!-- Right Section -->
                    <div class="content-header-section">
                        <!-- Notifications -->
                        {{-- <div class="btn-group" role="group">
            <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-notifications"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-flag"></i>
              <span class="badge badge-primary badge-pill">5</span>
            </button>
            <div class="dropdown-menu dropdown-menu-right min-width-300" aria-labelledby="page-header-notifications">
              <h5 class="h6 text-center py-10 mb-0 border-b text-uppercase">Notifications</h5>
              <ul class="list-unstyled my-20">
                <li>
                  <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                    <div class="ml-5 mr-15">
                      <i class="fa fa-fw fa-check text-success"></i>
                    </div>
                    <div class="media-body pr-10">
                      <p class="mb-0">You’ve upgraded to a VIP account successfully!</p>
                      <div class="text-muted font-size-sm font-italic">15 min ago</div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                    <div class="ml-5 mr-15">
                      <i class="fa fa-fw fa-exclamation-triangle text-warning"></i>
                    </div>
                    <div class="media-body pr-10">
                      <p class="mb-0">Please check your payment info since we can’t validate them!
                      </p>
                      <div class="text-muted font-size-sm font-italic">50 min ago</div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                    <div class="ml-5 mr-15">
                      <i class="fa fa-fw fa-times text-danger"></i>
                    </div>
                    <div class="media-body pr-10">
                      <p class="mb-0">Web server stopped responding and it was automatically
                        restarted!</p>
                      <div class="text-muted font-size-sm font-italic">4 hours ago</div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                    <div class="ml-5 mr-15">
                      <i class="fa fa-fw fa-exclamation-triangle text-warning"></i>
                    </div>
                    <div class="media-body pr-10">
                      <p class="mb-0">Please consider upgrading your plan. You are running out of
                        space.</p>
                      <div class="text-muted font-size-sm font-italic">16 hours ago</div>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="text-body-color-dark media mb-15" href="javascript:void(0)">
                    <div class="ml-5 mr-15">
                      <i class="fa fa-fw fa-plus text-primary"></i>
                    </div>
                    <div class="media-body pr-10">
                      <p class="mb-0">New purchases! +$250</p>
                      <div class="text-muted font-size-sm font-italic">1 day ago</div>
                    </div>
                  </a>
                </li>
              </ul>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item text-center mb-0" href="javascript:void(0)">
                <i class="fa fa-flag mr-5"></i> View All
              </a>
            </div>
          </div> --}}
                        <!-- END Notifications -->
                        @php
                            $campusTec = DB::table('users AS U')
                                ->select('C.name AS SedeTecnico')
                                ->join('campu_users AS CU', 'CU.user_id', 'U.id')
                                ->join('campus AS C', 'C.id', 'CU.campu_id')
                                ->where('CU.is_principal', 1)
                                ->where('U.id', Auth::id())
                                ->first();
                        @endphp

                        <!-- User Dropdown -->
                        <input type="hidden" id="user-id" value="{{ Auth::id() }}">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-rounded btn-dual-secondary"
                                id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fa fa-user d-sm-none"></i>
                                <span class="d-none d-sm-inline-block">{{ Str::title(Auth::user()->nick_name) }}</span>
                                <i class="fa fa-angle-down ml-5"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right min-width-200"
                                aria-labelledby="page-header-user-dropdown">
                                <h5 class="h6 mb-5 text-center text-uppercase">{{ Auth::user()->name }}
                                    {{ Auth::user()->last_name }}
                                </h5>
                                <h5 class="h6 py-10 mb-5 border-b">
                                    @if ($campusTec ? $campusTec->SedeTecnico : 0)
                                        <i class="fa fa-building-o mr-5"></i>{{ $campusTec->SedeTecnico }}
                                    @else
                                    @endif
                                </h5>
                                <a class="dropdown-item"
                                    href="{{ route('admin.inventory.technicians.profiles', Auth::id()) }}">
                                    <i class="si si-user mr-5"></i> Perfil
                                </a>
                                <!--<div class="dropdown-divider"></div>
                                                                       END Side Overlay -->

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" id="logout-link">
                                    <i class="si si-logout mr-5"></i> Sign Out
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                        <!-- END User Dropdown -->
                    </div>
                    <!-- END Right Section -->
                </div>
                <!-- END Header Content -->

                <!-- Header Loader -->
                <!-- Please check out the Activity page under Elements category to see examples of showing/hiding it -->
                <div id="page-header-loader" class="overlay-header bg-primary">
                    <div class="content-header content-header-fullrow text-center">
                        <div class="content-header-item">
                            <i class="fa fa-sun-o fa-spin text-white"></i>
                        </div>
                    </div>
                </div>
                <!-- END Header Loader -->
            </header>
            <!-- END Header -->

            <!-- Main Container -->
            <main id="main-container">
                <div class="content">
                    @yield('content')
                </div>
            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->
    @endauth
</body>

<!--
            Codebase JS Core

            Vital libraries and plugins used in all pages. You can choose to not include this file if you would like
            to handle those dependencies through webpack. Please check out assets/_es6/main/bootstrap.js for more info.

            If you like, you could also include them separately directly from the assets/js/core folder in the following
            order. That can come in handy if you would like to include a few of them (eg jQuery) from a CDN.

            assets/js/core/jquery.min.js
            assets/js/core/bootstrap.bundle.min.js
            assets/js/core/simplebar.min.js
            assets/js/core/jquery-scrollLock.min.js
            assets/js/core/jquery.appear.min.js
            assets/js/core/jquery.countTo.min.js
            assets/js/core/js.cookie.min.js
        -->
<script src="{{ asset('/js/codebase.core.min.js') }}"></script>

<!--
            Codebase JS

            Custom functionality including Blocks/Layout API as well as other vital and optional helpers
            webpack is putting everything together at assets/_es6/main/app.js
        -->
<script src="{{ asset('/js/codebase.app.min.js') }}"></script>
<script src="https://kit.fontawesome.com/bb00059a3e.js" crossorigin="anonymous"></script>

<!-- Page JS Plugins -->
<script src="{{ asset('/js/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('/js/plugins/chartjs/Chart.bundle.min.js') }}"></script>
<script src="{{ asset('/js/plugins/slick/slick.min.js') }}"></script>
<script src="{{ asset('/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js') }}"></script>
<script src="{{ asset('/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/js/plugins/jquery-validation/additional-methods.js') }}"></script>
<script src="{{ asset('/js/pages/be_forms_wizard.min.js') }}"></script>
<script src="{{ asset('/js/pages/be_forms_validation.min.js') }}"></script>
<script src="{{ asset('/js/datatables/datatable.inventory.deleted.js') }}"></script>
<script src="{{ asset('/js/list.category.devices.select.js') }}"></script>

<!-- Page JS Code -->
<script>
    let root_url_get_list_devices = <?php echo json_encode(route('get.devices.list')); ?>;
    let root_url_retore_device = <?php echo json_encode(route('restore.device')); ?>;
    let root_url_restore_selected_devices = <?php echo json_encode(route('restore.selected.devices')); ?>;
    let route_select_category_device = <?php echo json_encode(route('select_category_device')); ?>;
</script>
<script>
    jQuery(function() {
        Codebase.helpers(['select2', 'slick']);
    });
</script>
<script>
    document.querySelectorAll('#logout-link').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            Swal.fire({
                title: '¿Estás seguro de que quieres cerrar sesión?',
                //text: "¡Tus cambios no guardados se perderán!",
                icon: 'warning',
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-alt-success m-5",
                    cancelButton: "btn btn-alt-danger m-5",
                    input: "form-control"
                },
                confirmButtonText: 'Sí, cerrar sesión',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    document.getElementById('logout-form').submit();
                }
            });
        });
    });
</script>
@stack('js')
</body>

</html>
