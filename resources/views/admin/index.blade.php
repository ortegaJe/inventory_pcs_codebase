@extends('layouts.backend')

@section('title', 'Admin Dashboard')

@section('css')
<link href="{{ asset('/css/datatable.admin.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.css') }}">

@section('content')
<!-- Page Content -->
<div class="content">
  <div class="row invisible" data-toggle="appear">
    <!-- Row #1 -->
    <div class="col-6 col-xl-3">
      <a class="block block-link-shadow text-right" href="javascript:void(0)">
        <div class="block-content block-content-full clearfix">
          <div class="float-left mt-10 d-none d-sm-block">
            <i class="si si-screen-desktop fa-3x text-body-bg-dark"></i>
          </div>
          <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="{{ $global_pc_count }}">0
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">pc de escritorio</div>
        </div>
      </a>
    </div>
    <div class="col-6 col-xl-3">
      <a class="block block-link-shadow text-right" href="javascript:void(0)">
        <div class="block-content block-content-full clearfix">
          <div class="float-left mt-10 d-none d-sm-block">
            <i class="si si-wallet fa-3x text-body-bg-dark"></i>
          </div>
          <div class="font-size-h3 font-w600">$<span data-toggle="countTo" data-speed="1000" data-to="780">0</span>
          </div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">Earnings</div>
        </div>
      </a>
    </div>
    <div class="col-6 col-xl-3">
      <a class="block block-link-shadow text-right" href="javascript:void(0)">
        <div class="block-content block-content-full clearfix">
          <div class="float-left mt-10 d-none d-sm-block">
            <i class="si si-envelope-open fa-3x text-body-bg-dark"></i>
          </div>
          <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="15">0</div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">Messages</div>
        </div>
      </a>
    </div>
    <div class="col-6 col-xl-3">
      <a class="block block-link-shadow text-right" href="javascript:void(0)">
        <div class="block-content block-content-full clearfix">
          <div class="float-left mt-10 d-none d-sm-block">
            <i class="si si-users fa-3x text-body-bg-dark"></i>
          </div>
          <div class="font-size-h3 font-w600" data-toggle="countTo" data-speed="1000" data-to="4252">0</div>
          <div class="font-size-sm font-w600 text-uppercase text-muted">Online</div>
        </div>
      </a>
    </div>
    <div class="col-md-6 col-xl-3">
      <a class="block block-link-shadow block-link-shadow" data-toggle="modal" data-target="#modal-popout">
        <div class=" block-content block-content-full block-sticky-options">
          <div class="block-options">
            <div class="block-options-item">
              <i class="si si-screen-desktop fa-2x text-success-light"></i>
            </div>
          </div>
          <div class="py-20 text-center">
            <div class="font-size-h2 font-w700 mb-0 text-success">
              <i class="fa fa-plus"></i>
            </div>
            <div class="font-size-sm font-w600 text-uppercase text-muted">Nuevo equipo</div>
          </div>
        </div>
      </a>
    </div>
    <!-- END Row #1 -->
  </div>
  <!-- Pop Out Modal -->
  <div class="block">
    <div class="block-header block-header-default">
      <h3 class="block-title">Pop Out <small>Effect</small></h3>
    </div>
    <div class="block-content block-content-full">
      <button type="button" class="btn btn-alt-warning">Launch
        Modal</button>
    </div>
  </div>
  <!-- END Pop Out Modal -->
  <!-- Pop Out Modal -->
  <div class="modal fade" id="modal-popout" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
      <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
          <div class="block-header bg-gray-darker">
            <h3 class="block-title">Registrar nuevo equipo</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                <i class="si si-close"></i>
              </button>
            </div>
          </div>
          <div class="block-content">
            <div class="row">
              <!-- Row #6 -->
              <div class="col-md-6 col-xl-3">
                <a class="block block-transparent bg-primary" href="javascript:void(0)">
                  <div class="block-content block-content-full text-center">
                    <div class="p-20 mb-10">
                      <i class="fa fa-3x fa-desktop text-black-op"></i>
                    </div>
                    <p class="font-size-lg font-w600 text-white mb-0">
                      545 Games
                    </p>
                    <p class="font-size-sm text-uppercase font-w600 text-white-op mb-0">
                      de escritrio
                    </p>
                  </div>
                </a>
              </div>
              <div class="col-md-6 col-xl-3">
                <a class="block block-transparent bg-earth" href="javascript:void(0)">
                  <div class="block-content block-content-full text-center">
                    <div class="p-20 mb-10">
                      <i class="fa fa-3x fa-laptop text-black-op"></i>
                    </div>
                    <p class="font-size-lg font-w600 text-white mb-0">
                      120 Albums
                    </p>
                    <p class="font-size-sm text-uppercase font-w600 text-white-op mb-0">
                      portatil
                    </p>
                  </div>
                </a>
              </div>
              <div class="col-md-6 col-xl-3">
                <a class="block block-transparent bg-pulse" href="javascript:void(0)">
                  <div class="block-content block-content-full text-center">
                    <div class="p-20 mb-10">
                      <i class="fa fa-3x fa-desktop text-black-op"></i>
                    </div>
                    <p class="font-size-lg font-w600 text-white mb-0">
                      14 Videos
                    </p>
                    <p class="font-size-sm text-uppercase font-w600 text-white-op mb-0">
                      Youtube
                    </p>
                  </div>
                </a>
              </div>
              <div class="col-md-6 col-xl-3">
                <a class="block block-transparent bg-gray-dark" href="javascript:void(0)">
                  <div class="block-content block-content-full text-center">
                    <div class="p-20 mb-10">
                      <img src="{{ asset('media/photos/noun_Raspberry Pi_125961.svg') }}" alt="" width="36px">
                    </div>
                    <p class="font-size-lg font-w600 text-white mb-0">
                      17 Stories
                    </p>
                    <p class="font-size-sm text-uppercase font-w600 text-white-op mb-0">
                      Medium
                    </p>
                  </div>
                </a>
              </div>
              <!-- END Row #6 -->
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-alt-success" data-dismiss="modal">
            <i class="fa fa-check"></i> Perfect
          </button>
        </div>
      </div>
    </div>
  </div>
  <!-- END Pop Out Modal -->
  <div class="col-md-14">
    <div class="block block-rounded block-bordered">
      <div class="block-header block-header-default border-b">
        <h3 class="block-title">
          Lista<small> | Equipos informaticos</small>
        </h3>
        <div class="block-options">
          <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle"
            data-action-mode="demo">
            <i class="si si-refresh"></i>
          </button>
          <button type="button" class="btn-block-option">
            <i class="si si-wrench"></i>
          </button>
        </div>
      </div>
      <div class="block-content block-content-full">
        <div class="table-responsive">
          <table id="dt" class="table table-hover" style="width:100%">
            <thead>
              <tr>
                <th></th>
                <th>fecha de creación</th>
                <th>serial</th>
                <th>ip</th>
                <th>mac</th>
                <th>
                  <img class="img-fluid" width="80px" src="https://go.anydesk.com/_static/img/logos/anydesk-logo.svg"
                    alt="anydesk">
                </th>
                <th>sede</th>
                <th>estado</th>
                <th>Action</th>
              </tr>
            </thead>
            <tfoot>
              <tr>
                <th></th>
                <th>FECHA DE CREACIÓN</th>
                <th>SERIAL</th>
                <th>IP</th>
                <th>MAC</th>
                <th>
                  <img class="img-fluid" width="80px" src="https://go.anydesk.com/_static/img/logos/anydesk-logo.svg"
                    alt="anydesk">
                </th>
                <th>SEDE</th>
                <th>ESTADO</th>
                <th>ACTION</th>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- End Page Content -->

@endsection

@push('js')
<script src="/js/datatable.admin.js"></script>
<script src="{{ asset('/js/pages/be_tables_datatables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script>
  let root_url = <?php echo json_encode(route('admin.pcs.index')) ?>;
</script>

<script>
  let root_url_delete = <?php echo json_encode(url('admin/dashboard/pcs/delete')) ?>;
</script>
@endpush