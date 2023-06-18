<div class="row gutters-tiny mb-2">
  <!-- Total equipos de escritorios -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="si si-screen-desktop fa-2x text-info-light"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-info" data-toggle="countTo" data-to="{{ $globalDesktopCount }}">0
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">escritorios</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Total equipos de escritorios -->

  <!-- All In One -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="fa fa-desktop fa-2x text-elegance-lighter"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-elegance-light" data-toggle="countTo"
            data-to="{{ $globalAllInOneCount }}">0
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">all in one</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END All In One -->

  <!-- Portatiles -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="fa fa-laptop fa-2x text-flat-lighter"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-flat" data-toggle="countTo" data-to="{{ $globalLaptopCount }}">0
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">portátiles</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Portatiles -->

  <!-- Turnero -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="fa fa-ticket fa-2x text-danger-light"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-danger" data-toggle="countTo"
            data-to="{{ $globalTurneroCount }}">0</div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">Turneros</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Turnero -->

  <!-- Raspberry PI -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <img width="30px" src="{{ asset('media/various/raspberry-pi-0.svg') }}" alt="raspberry-pi.svg">
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0" style="color: #c51d4a" data-toggle="countTo"
            data-to="{{ $globalRaspberryCount }}">0
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">raspberry</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Raspberry PI -->

  <!-- Telefonos IP -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <i class="fa fa-phone fa-2x text-warning-light"></i>
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0 text-warning" data-toggle="countTo"
            data-to="{{ $globalIpPhoneCount }}">
            0
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">Telefonos IP</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Telefonos IP -->

  <!-- Mini PC -->
  <div class="col-md-6 col-xl-2">
    <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
      <div class="block-content block-content-full block-sticky-options">
        <div class="block-options">
          <div class="block-options-item">
            <img style="opacity: 0.5;" width="30px" src="{{ asset('media/various/enrutador.png') }}" alt="enrutador.png">
          </div>
        </div>
        <div class="py-20 text-center">
          <div class="font-size-h2 font-w700 mb-0" style="color: #636262" data-toggle="countTo"
            data-to="{{ $globalMiniPcSatCount }}">
            0
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">MiniPC SAT</div>
        </div>
      </div>
    </a>
  </div>
  <!-- END Mini PC -->
</div>