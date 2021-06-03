@section('css_before')
<!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('js/plugins/magnific-popup/magnific-popup.css') }}">
@endsection

@section('js_after')
<!-- Page JS Plugins -->
<script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.js') }}"></script>
<script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>
<!-- Page JS Helpers (Magnific Popup plugin) -->
<script>
    jQuery(function(){ Codebase.helpers('magnific-popup'); });
</script>
@endsection

<div class="row items-push js-gallery img-fluid-100 js-gallery-enabled">
    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="{{ asset('media/photos/photo17@2x.jpg') }}">
            <img class="img-fluid" src="{{ asset('media/photos/photo17.jpg') }}" alt="">
        </a>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="assets/media/photos/photo18@2x.jpg">
            <img class="img-fluid" src="assets/media/photos/photo18.jpg" alt="">
        </a>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="assets/media/photos/photo19@2x.jpg">
            <img class="img-fluid" src="assets/media/photos/photo19.jpg" alt="">
        </a>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="assets/media/photos/photo20@2x.jpg">
            <img class="img-fluid" src="assets/media/photos/photo20.jpg" alt="">
        </a>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="assets/media/photos/photo21@2x.jpg">
            <img class="img-fluid" src="assets/media/photos/photo21.jpg" alt="">
        </a>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="assets/media/photos/photo22@2x.jpg">
            <img class="img-fluid" src="assets/media/photos/photo22.jpg" alt="">
        </a>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="assets/media/photos/photo23@2x.jpg">
            <img class="img-fluid" src="assets/media/photos/photo23.jpg" alt="">
        </a>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="assets/media/photos/photo24@2x.jpg">
            <img class="img-fluid" src="assets/media/photos/photo24.jpg" alt="">
        </a>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="assets/media/photos/photo25@2x.jpg">
            <img class="img-fluid" src="assets/media/photos/photo25.jpg" alt="">
        </a>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="assets/media/photos/photo26@2x.jpg">
            <img class="img-fluid" src="assets/media/photos/photo26.jpg" alt="">
        </a>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="assets/media/photos/photo27@2x.jpg">
            <img class="img-fluid" src="assets/media/photos/photo27.jpg" alt="">
        </a>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-3 animated fadeIn">
        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="assets/media/photos/photo28@2x.jpg">
            <img class="img-fluid" src="assets/media/photos/photo28.jpg" alt="">
        </a>
    </div>
</div>