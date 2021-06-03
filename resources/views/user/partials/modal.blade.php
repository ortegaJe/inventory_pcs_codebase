<!-- Pop Out Modal -->
<div class="modal fade" id="modal-popout" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
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
              <a class="block block-link-pop text-center" href="{{ route('tec.inventory.campu.desktop.create') }}">
                <div class="block-content">
                  <i class="si si-screen-desktop fa-4x text-gray-dark"></i>
                </div>
                <div class="block-content bg-body-light">
                  <p class="font-w600">
                    De Escritorios
                  </p>
                </div>
              </a>
            </div>
            {{--  <div class="col-md-6 col-xl-3">
              <a class="block block-link-pop text-center" href="{{ route('admin.inventory.allinone_create') }}">
            <div class="block-content">
              <i class="fa fa-desktop fa-4x text-gray-dark"></i>
            </div>
            <div class="block-content bg-body-light">
              <p class="font-w600">
                All In One
              </p>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-xl-3">
            <a class="block block-link-pop text-center" href="{{ route('admin.inventory.turnero_create') }}">
              <div class="block-content">
                <i class="fa fa-ticket fa-4x text-gray-dark"></i>
              </div>
              <div class="block-content bg-body-light">
                <p class="font-w600">
                  Turneros
                </p>
              </div>
            </a>
          </div>
          <div class="col-md-6 col-xl-3">
            <a class="block block-link-pop text-center" href="{{ route('admin.inventory.raspberry_create') }}">
              <div class="block-content" width="5px">
                <img class="img-avatar" src="{{ asset('media/various/raspberry-pi.svg') }}" alt="raspberry-pi.svg">
              </div>
              <div class="block-content bg-body-light">
                <div class="font-w600 mb-5">Raspberry's</div>
              </div>
            </a>
          </div>--}}
          <div class="col-md-6 col-xl-3">
            <a class="block block-link-pop text-center" href="{{ route('admin.inventory.laptop.create') }}">
              <div class="block-content">
                <i class="fa fa-laptop fa-4x text-gray-dark"></i>
              </div>
              <div class="block-content bg-body-light">
                <p class="font-w600">
                  Portátiles
                </p>
              </div>
            </a>
          </div>
          <!-- END Row #2 -->
        </div>
      </div>
    </div>
    <div class="modal-footer" style="background-color: #f0f2f5">
      <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Cerrar</button>
    </div>
  </div>
</div>
</div>
<!-- END Pop Out Modal -->