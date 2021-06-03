<!doctype html>
<html lang="en" class="no-focus">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <title>InventarioPC | @yield('title')</title>
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

  <!-- Icons -->
  <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
  <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
  <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
  <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
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
    window.Laravel = {!! json_encode(['csrfToken' => csrf_token(),]) !!};
  </script>
</head>

<body>
  <div id="page-loader" class="bg-gd-sea show"></div>
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
            <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout"
              data-action="sidebar_close">
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
            <img class="img-avatar img-avatar32" src="{{ asset('/media/avatars/avatar15.jpg') }}" alt="">
          </div>
          <!-- END Visible only in mini mode -->

          <!-- Visible only in normal mode -->
          <div class="sidebar-mini-hidden-b text-center">
            <a class="img-link" href="javascript:void(0)">
              <img class="img-avatar" src="{{ asset('/media/avatars/avatar15.jpg') }}" alt="">
            </a>
            <ul class="list-inline mt-10">
              <li class="list-inline-item">
                <a class="link-effect text-dual-primary-dark font-size-sm font-w600 text-uppercase"
                  href="javascript:void(0)">{{ Auth::user()->nick_name }}</a>
              </li>
              <li class="list-inline-item">
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="link-effect text-dual-primary-dark" data-toggle="layout"
                  data-action="sidebar_style_inverse_toggle" href="javascript:void(0)">
                  <i class="si si-drop"></i>
                </a>
              </li>
              <li class="list-inline-item">
                <a class="link-effect text-dual-primary-dark" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form-side').submit();">
                  <i class="si si-logout"></i>
                </a>
                <form id="logout-form-side" action="{{ route('logout') }}" method="POST" class="d-none">
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
          <ul class="nav-main">
            <li>
              <a class="{{ request()->is('/') ? ' active' : '' }}" href="{{ route('dashboard') }}">
                <i class="si si-home"></i><span class="sidebar-mini-hide">Home</span>
              </a>
            </li>
            <li class="open">
              <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-cup"></i>
                <span class="sidebar-mini-hide">Dashboard</span>
              </a>
              <ul>
                <li class="{{ request()->is('admin/dashboard/inventario/de-escritorios') ? 'open' : '' }} || 
                  {{ request()->is('admin/dashboard/inventario/portatiles') ? 'open' : '' }}">
                  <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                    <span class="sidebar-mini-hide">Equipos</span>
                    <span class="badge badge-pill bg-gray-darker"><i class="si si-screen-desktop"></i>
                      @php $globalPcCount = DB::table('computers')->select('id')
                      //->whereIn('statu_id',[1,2,3,5,6,7,8])
                      ->where('is_active',[1])
                      ->where('deleted_at', null)
                      ->count(); @endphp
                      {{ $globalPcCount ?? '0' }}
                    </span>
                  </a>
                  <ul>
                    <li>
                      <a class="{{ request()->is('admin/dashboard/inventario/de-escritorios') ? 'active' : '' }}"
                        href="{{ route('admin.inventory.desktop.index') }}">De escritorios
                      </a>
                    </li>
                    <li>
                      <a class="{{ request()->is('admin/dashboard/inventario/portatiles') ? 'active' : '' }}"
                        href="{{ route('admin.inventory.laptop.index') }}">Portátiles</a>
                    </li>
                    {{--<li>
                      <a class="{{ request()->is('admin/dashboard/inventario/all-ine-one') ? 'active' : '' }}"
                    href="{{ route('admin.inventario.allinone_index') }}">All in one</a>
                </li>
                <li>
                  <a class="{{ request()->is('pages/slick') ? ' active' : '' }}" href="#">Turneros</a>
                </li>
                <li>
                  <a class="{{ request()->is('pages/blank') ? ' active' : '' }}" href="#">Raspberry's</a>
                </li>
                <li>
                  <a class="nav-submenu" data-toggle="nav-submenu" href="#">Sub Level 2</a>
                  <ul>
                    <li>
                      <a href="#">Link 2-1</a>
                    </li>
                    <li>
                      <a href="#">Link 2-2</a>
                    </li>
                    <li>
                      <a class="nav-submenu" data-toggle="nav-submenu" href="#">Sub Level 3</a>
                      <ul>
                        <li>
                          <a href="#">Link 3-1</a>
                        </li>
                        <li>
                          <a href="#">Link 3-2</a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li> --}}
              </ul>
            <li class="{{ request()->is('admin/dashboard/inventario/tecnicos') ? 'open' : '' }}">
              <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                <span class="sidebar-mini-hide">Usuarios</span>
                <span class="badge badge-pill bg-gray-darker"><i class="si si-users"></i>
                  {{-- @php $globalPcCount = DB::table('computers')->select('id')
                                              ->whereIn('statu_id',[1,2,3,5,6,7,8])
                                              ->where('is_active',[1])
                                              ->where('deleted_at', null)
                                              ->count(); @endphp
                                              {{ $globalPcCount ?? '0' }} --}}
                </span>
              </a>
              <ul>
                <li>
                  <a class="{{ request()->is('admin/dashboard/inventario/tecnicos') ? 'active' : '' }}"
                    href="{{ route('admin.inventory.technicians.index') }}">Lista de Usuarios
                  </a>
                </li>
                <li>
                  <a class="" href="#">Roles
                  </a>
              </ul>
            </li>
            <li>
              <a class="nav-submenu" data-toggle="nav-submenu" href="#">
                <span class="sidebar-mini-hide">Sedes</span>
                <span class="badge badge-pill bg-gray-darker"><i class="fa fa-stethoscope"></i>
                  {{-- @php $globalPcCount = DB::table('computers')->select('id')
                        ->whereIn('statu_id',[1,2,3,5,6,7,8])
                        ->where('is_active',[1])
                        ->where('deleted_at', null)
                        ->count(); @endphp
                        {{ $globalPcCount ?? '0' }} --}}
                </span>
              </a>
              <ul>
                <li>
                  <a class="active" href="#">Lista de Sedes
                  </a>
                </li>
                <li>
                  <a class="nav-submenu" data-toggle="nav-submenu" href="#">Costa</a>
                  <ul>
                    <li style="font-size: 10px">
                      <a href="#">VIVA 1A IPS CALLE 30</a>
                    </li>
                    <li style="font-size: 10px">
                      <a href="#">VIVA 1A IPS CARRERA 16</a>
                    </li>
                    <li style="font-size: 10px">
                      <a href="#">VIVA 1A IPS COUNTRY</a>
                    </li>
                    <li style="font-size: 10px">
                      <a href="#">VIVA 1A IPS MACARENA</a>
                    </li>
                    <li style="font-size: 10px">
                      <a href="{{ route('admin.inventory.campu.temporal.create') }}">TEMPORAL</a>
                    </li>
                    <li style="font-size: 10px">
                      <a href="#">VIVA 1A IPS SAN JOSE</a>
                    </li>
                    <li style="font-size: 10px">
                      <a href="#">VIVA 1A IPS MATRIZ</a>
                    </li>
                  </ul>
                </li>
              </ul>
            </li>
          </ul>
          </li>
          <li class="nav-main-heading">
            <span class="sidebar-mini-visible">AS</span><span class="sidebar-mini-hidden">asignaciones</span>
          </li>
          {{-- <li class="{{ request()->is('pages/*') ? ' open' : '' }}">
          <a class="nav-submenu" data-toggle="nav-submenu" href="#"><i class="si si-bulb"></i><span
              class="sidebar-mini-hide">Examples</span></a>
          <ul>
            <li>
              <a class="{{ request()->is('pages/datatables') ? ' active' : '' }}"
                href="/pages/datatables">DataTables</a>
            </li>
            <li>
              <a class="{{ request()->is('pages/slick') ? ' active' : '' }}" href="/pages/slick">Slick Slider</a>
            </li>
            <li>
              <a class="{{ request()->is('pages/blank') ? ' active' : '' }}" href="/pages/blank">Blank</a>
            </li>
          </ul>
          </li>--}}
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
          {{--<div class="btn-group" role="group">
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
          </div>--}}
          <!-- END Notifications -->

          <!-- User Dropdown -->
          <div class="btn-group" role="group">
            <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown"
              data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-user d-sm-none"></i>
              <span class="d-none d-sm-inline-block">{{ Auth::user()->nick_name }}</span>
              <i class="fa fa-angle-down ml-5"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
              <h5 class="h6 text-center py-10 mb-5 border-b text-uppercase">{{ Auth::user()->name }}
                {{ Auth::user()->last_name }}</h5>
              <a class="dropdown-item" href="be_pages_generic_profile.html">
                <i class="si si-user mr-5"></i> Perfil
              </a>
              <div class="dropdown-divider"></div>
              <!-- END Side Overlay -->

              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
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

  <!-- Page JS Plugins -->
  <script src="{{ asset('/js/plugins/chartjs/Chart.bundle.min.js') }}"></script>
  <script src="{{ asset('/js/plugins/slick/slick.min.js') }}"></script>
  <script src="{{ asset('/js/plugins/select2/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js') }}"></script>
  <script src="{{ asset('/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('/js/plugins/jquery-validation/additional-methods.js') }}"></script>

  <!-- Page JS Code -->
  <script src="{{ asset('/js/pages/be_pages_dashboard.min.js') }}"></script>
  <script src="{{ asset('/js/pages/be_forms_wizard.min.js') }}"></script>
  <script src="{{ asset('/js/pages/be_forms_validation.min.js') }}"></script>

  <!-- Page JS Helpers (Select2 plugin) -->
  <script>
    jQuery(function(){ Codebase.helpers('select2'); });
  </script>
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  @stack('js')
</body>

</html>