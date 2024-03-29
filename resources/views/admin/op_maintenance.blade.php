<!doctype html>
<html lang="en" class="no-focus">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <title>InventarioPC</title>

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
  <!-- END Icons -->

  <!-- Stylesheets -->

  <!-- Fonts and Codebase framework -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700&display=swap">
  <link rel="stylesheet" id="css-main" href="{{ asset('/css/codebase.min.css') }}">

  <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
  <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
  <!-- END Stylesheets -->
</head>

<body>

  <!-- Page Container -->
  <!--
            Available classes for #page-container:

        GENERIC

            'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Template._uiHandleTheme())

        SIDEBAR & SIDE OVERLAY

            'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
            'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
            'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
            'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
            'sidebar-inverse'                           Dark themed sidebar

            'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
            'side-overlay-o'                            Visible Side Overlay by default

            'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

            'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

        HEADER

            ''                                          Static Header if no class is added
            'page-header-fixed'                         Fixed Header

        HEADER STYLE

            ''                                          Classic Header style if no class is added
            'page-header-modern'                        Modern Header style
            'page-header-inverse'                       Dark themed Header (works only with classic Header style)
            'page-header-glass'                         Light themed Header with transparency by default
                                                        (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
            'page-header-glass page-header-inverse'     Dark themed Header with transparency by default
                                                        (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

        MAIN CONTENT LAYOUT

            ''                                          Full width Main Content if no class is added
            'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
            'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
        -->
  <div id="page-container" class="main-content-boxed">

    <!-- Main Container -->
    <main id="main-container">

      <!-- Page Content -->
      <div class="hero bg-white bg-pattern"
        style="background-image: url('{{asset('/media/various/bg-pattern-inverse.png')}}');">
        <div class="hero-inner">
          <div class="content content-full">
            <div class="py-30 text-center">
              <i class="si si-chemistry text-primary display-3"></i>
              <h1 class="h2 font-w700 mt-30 mb-10">We’ll be back soon!</h1>
              <h2 class="h3 font-w400 text-muted mb-50">We’re currently down for maintenance..</h2>
              <a class="btn btn-hero btn-noborder btn-rounded btn-alt-primary"
                href="{{ route('admin.inventory.campus.show', $campus) }}">
                <i class="fa fa-arrow-left mr-10"></i> Go Back to Dashboard
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- END Page Content -->

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
</body>

</html>