@extends('layouts.backend')

@section('title', 'Admin Dashboard')

@section('css')
<link href="{{ asset('/css/datatable.admin.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.css') }}">

@section('content')
<!-- Page Content -->
<div class="content">
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
            <div class="font-size-h2 font-w700 mb-0 text-info" data-toggle="countTo" data-to="{{ $globalPcCount }}">0
            </div>
            <div class="font-size-sm font-w600 text-uppercase text-muted">de escritorios</div>
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
    <div class="col-md-6 col-xl-2">
      <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
        <div class="block-content block-content-full block-sticky-options">
          <div class="block-options">
            <div class="block-options-item">
              <i class="fa fa-warning fa-2x text-danger-light"></i>
            </div>
          </div>
          <div class="py-20 text-center">
            <div class="font-size-h2 font-w700 mb-0 text-danger" data-toggle="countTo" data-to="30">0</div>
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
              data-to="{{ $globalTurneroPcCount }}">0</div>
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
              <i class="fa fa-warning fa-2x" style="color: #c51d4a"></i>
            </div>
          </div>
          <div class="py-20 text-center">
            <div class="font-size-h2 font-w700 mb-0" style="color: #c51d4a" data-toggle="countTo" data-to="30">0
            </div>
            <div class="font-size-sm font-w600 text-uppercase text-muted">raspberry's</div>
          </div>
        </div>
      </a>
    </div>
    <!-- END Raspberry PI -->

    <!-- Add Product -->
    <div class="col-md-6 col-xl-2">
      <a class="block block-link-shadow block-link-shadow" data-toggle="modal" data-target="#modal-popout">
        <div class="block-content block-content-full block-sticky-options">
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
    <!-- END Add Product -->
  </div>
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
          <div class="block-content" style="background-color: #f0f2f5">
            <div class="row">
              <!-- Row #2 -->
              <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-transparent text-center bg-image"
                  style="background-image: url('{{ asset('/media/photos/lenovo-desktop.png') }}');"
                  href="{{ route('admin.pcs.create') }}">
                  <div class=" block-content block-content-full">
                    <span class="img-avatar"></span>
                  </div>
                  <div class="block-content block-content-full block-content-sm bg-black-op">
                    <div class="font-w600 text-white mb-5">De escritorios</div>
                    <div class="font-size-sm text-white-op"></div>
                  </div>
                </a>
              </div>
              <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-transparent text-center bg-image"
                  style="background-image: url('{{ asset('/media/photos/lenovo-all-in-one.png') }}');"
                  href="{{ route('admin.pcs.create_allinone') }}">
                  <div class="block-content block-content-full">
                    <span class="img-avatar"></span>
                  </div>
                  <div class="block-content block-content-full block-content-sm bg-black-op">
                    <div class="font-w600 text-white mb-5">All in one</div>
                    <div class="font-size-sm text-white-op"></div>
                  </div>
                </a>
              </div>
              <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-transparent text-center bg-image"
                  style="background-image: url('{{ asset('/media/photos/atril-turnero.png') }}');"
                  href="{{ route('admin.pcs.turnero_create') }}">
                  <div class="block-content block-content-full">
                    <span class="img-avatar"></span>
                  </div>
                  <div class="block-content block-content-full block-content-sm bg-black-op">
                    <div class="font-w600 text-white mb-5">Tuneros</div>
                    <div class="font-size-sm text-white-op"></div>
                  </div>
                </a>
              </div>
              <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-transparent text-center bg-image"
                  style="background-image: url('{{ asset('/media/photos/raspberry-pi.png') }}');"
                  href="{{ route('admin.pcs.raspberry_create') }}">
                  <div class="block-content block-content-full">
                    <span class="img-avatar"></span>
                  </div>
                  <div class="block-content block-content-full block-content-sm bg-black-op">
                    <div class="font-w600 text-white mb-5">Raspberry´s</div>
                    <div class="font-size-sm text-white-op"></div>
                  </div>
                </a>
              </div>
              <div class="col-md-6 col-xl-3">
                <a class="block block-rounded block-transparent text-center bg-image"
                  style="background-image: url('{{ asset('/media/photos/laptop-lenovo.png') }}');"
                  href="javascript:void(0)">
                  <div class="block-content block-content-full">
                    <span class="img-avatar"></span>
                  </div>
                  <div class="block-content block-content-full block-content-sm bg-black-op">
                    <div class="font-w600 text-white mb-5">Portátiles</div>
                    <div class="font-size-sm text-white-op"></div>
                  </div>
                </a>
              </div>
              <!-- END Row #2 -->
            </div>
          </div>
        </div>
        <div class="modal-footer" style="background-color: #f0f2f5">
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
                <th>marca</th>
                <th>tipo</th>
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
                <th>MARCA</th>
                <th>TIPO</th>
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
  let root_url_store = <?php echo json_encode(route('admin.pcs.store')) ?>;
</script>
@endpush