<!-- Pop In Modal -->
<form action="{{ route('inventory.report.maintenance.store') }}" method="POST">
  @csrf
  @method('POST')
  <div class="modal fade" id="modal-popin-up-resume" tabindex="-1" role="dialog" aria-labelledby="modal-popin"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin" role="document">
      <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
          <div class="block-header bg-primary-dark">
            <h3 class="block-title">MANTENIMIENTOS</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                <i class="si si-close"></i>
              </button>
            </div>
          </div>
          <div class="block-content mb-4">
            <div class="block pull-r-l">
              <div class="block-content">
                <input type="text" name="device-id" value="{{ $device->id }}">
                <input type="text" name="repo-id" value="{{ $repo->repo_id}}">
                <div class="form-group row">
                  <div class="col-md-6">
                    <div class="form-material">
                      <input type="text" class="js-flatpickr form-control" id="maintenance-date" name="maintenance-date"
                        placeholder="d-m-Y" data-allow-input="true" maxlength="10">
                      <label for="maintenance-date">Fecha de mantenimiento</label>
                    </div>
                    @if($errors->has('maintenance-date'))
                    <small class="text-danger is-invalid">{{ $errors->first('maintenance-date') }}</small>
                    @endif
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12">
                    <div class="form-material">
                      <textarea class="js-maxlength form-control" id="observation" name="observation" rows="3"
                        maxlength="255" placeholder="Escriba aqui una observación" data-always-show="true"
                        data-warning-class="badge badge-primary" data-limit-reached-class="badge badge-warning"
                        onkeyup="javascript:this.value=this.value.toUpperCase();"
                        value="{{ old('observation') }}"></textarea>
                      <label for="observation">Observación</label>
                    </div>
                  </div>
                  @if($errors->has('observation'))
                  <small class="text-danger is-invalid">{{ $errors->first('observation') }}</small>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-alt-success">
            <i class="fa fa-save"></i> Guardar
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- END Pop In Modal -->

@push('js')

<script>
  $(document).ready(function(){
    @if($message = Session::get('message'))
    $('#modal-popin-up-resume').modal('show');
    @endif
  })
</script>

@endpush