<!-- Pop In Modal -->
<form action="{{ route('inventory.report.maintenance.store') }}" method="POST">
  @csrf
  @method('POST')
  <div class="modal fade" id="modal-mto" tabindex="-1" role="dialog" aria-labelledby="modal-popin" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin" role="document">
      <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
          <div class="block-header bg-primary-dark">
            <h3 class="block-title">Registrar Mantenimiento</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                <i class="si si-close"></i>
              </button>
            </div>
          </div>
          <div class="block-content mb-4">
            <div class="block pull-r-l">
              <div class="block-content">
                <input type="hidden" name="device_id" value="{{ $device->id }}">
                <input type="hidden" name="campu_id" value="{{ $device->campu_id }}">
                <div class="form-row">
                  <div class="col-md-12">
                    <div class="form-material">
                      <textarea class="js-maxlength form-control" id="description" name="description" rows="3"
                        maxlength="255" placeholder="Escriba aqui el mantenimiento realizado" data-always-show="true"
                        data-warning-class="badge badge-primary" data-limit-reached-class="badge badge-warning"
                        onkeyup="javascript:this.value=this.value.toUpperCase();"
                        value="{{ old('description') }}"></textarea>
                      <label for="description">Descripción del mantenimiento</label>
                    </div>
                  </div>
                  @if($errors->has('description'))
                  <small class="text-danger is-invalid">{{ $errors->first('description') }}</small>
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
    $('#modal-mto').modal('show');
    @endif
  })
</script>

@endpush