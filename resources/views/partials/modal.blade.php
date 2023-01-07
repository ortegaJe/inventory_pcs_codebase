<!-- Pop Out Modal -->
<div class="modal fade" id="modal-popout" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
  <div class="modal-dialog modal-dialog-popin" role="document">
    <div class="modal-content">
      <div class="block block-themed block-transparent mb-0">
        <div class="block-header bg-primary-dark">
          <h3 class="block-title">Información</h3>
          <div class="block-options">
            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
              <i class="si si-close"></i>
            </button>
          </div>
        </div>
        <div class="block-content">
          @foreach ($deviceBorrowed as $devices)
          <div class="py-20">
            <i class="si si-screen-desktop fa-4x text-primary"></i>
            <div class="font-size-sm text-muted">
              {{ $devices->device }}
            </div>
            <div class="font-size-sm text-muted">{{ $devices->custodian }}</div>
            <div class="font-size-sm text-muted">{{ $devices->campu }}</div>
          </div>
          <div id="accordion2" role="tablist" aria-multiselectable="true">
            <div class="block block-bordered block-rounded mb-2">
              <div class="block-header" role="tab" id="accordion2_h1">
                <a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q1"
                  aria-expanded="true" aria-controls="accordion2_q1">
                  {{ $devices->date }}
                </a>
              </div>
              <div id="accordion2_q1" class="collapse show" role="tabpanel" aria-labelledby="accordion2_h1">
                <div class="block-content">
                  <button type="button" class="btn btn-sm btn-alt-success min-width-125" data-toggle="click-ripple"
                    onclick="window.location='{{ Storage::url($devices->file_path) }}'">
                    <i class="fa fa-download mr-5"></i>
                    ACTA DE ENTREGA - BRIAN ADKINS DELEON
                  </button>
                </div>
              </div>
            </div>
            @endforeach
            <div class="block block-bordered block-rounded mb-2">
              <div class="block-header" role="tab" id="accordion2_h2">
                <a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q2"
                  aria-expanded="true" aria-controls="accordion2_q2">08/08/2022</a>
              </div>
              <div id="accordion2_q2" class="collapse" role="tabpanel" aria-labelledby="accordion2_h2">
                <div class="block-content">
                  <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet
                    adipiscing luctus
                    mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus
                    lobortis tortor tincidunt
                    himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti
                    vestibulum quis in sit
                    varius lorem sit metus mi.</p>
                </div>
              </div>
            </div>
            <div class="block block-bordered block-rounded mb-2">
              <div class="block-header" role="tab" id="accordion2_h3">
                <a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q3"
                  aria-expanded="true" aria-controls="accordion2_q3">08/08/2022</a>
              </div>
              <div id="accordion2_q3" class="collapse" role="tabpanel" aria-labelledby="accordion2_h3">
                <div class="block-content">
                  <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet
                    adipiscing luctus
                    mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus
                    lobortis tortor tincidunt
                    himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti
                    vestibulum quis in sit
                    varius lorem sit metus mi.</p>
                </div>
              </div>
            </div>
            <div class="block block-bordered block-rounded mb-2">
              <div class="block-header" role="tab" id="accordion2_h4">
                <a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q4"
                  aria-expanded="true" aria-controls="accordion2_q4">08/08/2022</a>
              </div>
              <div id="accordion2_q4" class="collapse" role="tabpanel" aria-labelledby="accordion2_h4">
                <div class="block-content">
                  <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet
                    adipiscing luctus
                    mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus
                    lobortis tortor tincidunt
                    himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti
                    vestibulum quis in sit
                    varius lorem sit metus mi.</p>
                </div>
              </div>
            </div>
            <div class="block block-bordered block-rounded">
              <div class="block-header" role="tab" id="accordion2_h5">
                <a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q5"
                  aria-expanded="true" aria-controls="accordion2_q5">08/08/2022</a>
              </div>
              <div id="accordion2_q5" class="collapse" role="tabpanel" aria-labelledby="accordion2_h5">
                <div class="block-content">
                  <p>Dolor posuere proin blandit accumsan senectus netus nullam curae, ornare laoreet
                    adipiscing luctus
                    mauris adipiscing pretium eget fermentum, tristique lobortis est ut metus
                    lobortis tortor tincidunt
                    himenaeos habitant quis dictumst proin odio sagittis purus mi, nec taciti
                    vestibulum quis in sit
                    varius lorem sit metus mi.</p>
                </div>
              </div>
            </div>
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