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
            {{-- <div class="col-md-6 col-xl-3">
              <a class="block block-link-pop text-center" href="javascript:void(0)">
                <div class="block-content block-content-full">
                  <i class="si si-screen-desktop fa-4x text-gray-dark"></i>
                </div>
                <div class="block-content block-content-full bg-body-light">
                  <div class="font-w600 mb-5">Carol Ray</div>
                  <div class="font-size-sm text-muted">Web Designer</div>
                </div>
              </a>
            </div> --}}
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
                href="{{ route('admin.pcs.allinone_create') }}">
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
        <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
<!-- END Pop Out Modal -->