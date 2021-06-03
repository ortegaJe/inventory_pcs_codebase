@extends('layouts.backend')

@section('title', 'Admin Dashboard')

@section('css')
<link rel="stylesheet" href="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.css') }}">

@section('content')
<!-- Page Content -->
<div class="content">
  <div class="row gutters-tiny mb-2">
    <!-- Total equipos de escritorios -->
    <div class="col-md-6 col-xl-4">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full block-sticky-options">
          <div class="block-options">
            <div class="block-options-item">
              <i class="si si-screen-desktop fa-2x text-info-light"></i>
            </div>
          </div>
          <div class="py-20 text-center">
            <div class="font-size-h2 font-w700 mb-0 text-info" data-toggle="countTo"
              data-to="{{ $globalDesktopPcCount }}">0
            </div>
            <div class="font-size-sm font-w600 text-uppercase text-muted">de escritorios</div>
          </div>
        </div>
      </a>
    </div>
    <!-- END Total equipos de escritorios -->

    <!-- All In One -->
    <div class="col-md-6 col-xl-4">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full block-sticky-options">
          <div class="block-options">
            <div class="block-options-item">
              <i class="fa fa-desktop fa-2x text-warning-light"></i>
            </div>
          </div>
          <div class="py-20 text-center">
            <div class="font-size-h2 font-w700 mb-0 text-warning" data-toggle="countTo"
              data-to="{{ $globalAllInOnePcCount }}">0</div>
            <div class="font-size-sm font-w600 text-uppercase text-muted">all in one</div>
          </div>
        </div>
      </a>
    </div>
    <!-- END All In One -->

    <!-- Portatiles -->
    <div class="col-md-6 col-xl-4">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full block-sticky-options">
          <div class="block-options">
            <div class="block-options-item">
              <i class="fa fa-warning fa-2x text-danger-light"></i>
            </div>
          </div>
          <div class="py-20 text-center">
            <div class="font-size-h2 font-w700 mb-0 text-danger" data-toggle="countTo"
              data-to="{{ $globalLaptopPcCount }}">0</div>
            <div class="font-size-sm font-w600 text-uppercase text-muted">portátiles</div>
          </div>
        </div>
      </a>
    </div>
    <!-- END Portatiles -->

    <!-- Turnero -->
    <div class="col-md-6 col-xl-4">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full block-sticky-options">
          <div class="block-options">
            <div class="block-options-item">
              <i class="fa fa-ticket fa-2x text-danger-light"></i>
            </div>
          </div>
          <div class="py-20 text-center">
            <div class="font-size-h2 font-w700 mb-0 text-danger" data-toggle="countTo"
              data-to="{{ $globalTurneroPcCount }}">0</div>
            <div class="font-size-sm font-w600 text-uppercase text-muted">Turneros</div>
          </div>
        </div>
      </a>
    </div>
    <!-- END Turnero -->

    <!-- Raspberry PI -->
    <div class="col-md-6 col-xl-4">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full block-sticky-options">
          <div class="block-options">
            <div class="block-options-item">
              <i class="fa fa-warning fa-2x" style="color: #c51d4a"></i>
            </div>
          </div>
          <div class="py-20 text-center">
            <div class="font-size-h2 font-w700 mb-0" style="color: #c51d4a" data-toggle="countTo"
              data-to="{{ $globalRaspberryPcCount }}">0
            </div>
            <div class="font-size-sm font-w600 text-uppercase text-muted">raspberry's</div>
          </div>
        </div>
      </a>
    </div>
    <!-- END Raspberry PI -->
  </div>
</div>
<!-- End Page Content -->

@endsection

@push('js')
<script src="{{ asset('/js/pages/be_tables_datatables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
@endpush