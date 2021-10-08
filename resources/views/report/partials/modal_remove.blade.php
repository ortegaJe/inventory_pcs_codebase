<!-- Pop In Modal -->
<form action="{{ route('inventory.report.removes.store') }}" method="POST">
  @csrf
  @method('POST')
  <div class="modal fade" id="modal-popin-up-remove" tabindex="-1" role="dialog" aria-labelledby="modal-popin"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin" role="document">
      <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
          <div class="block-header bg-primary-dark">
            <h3 class="block-title">REPORTE DE SOLICITUD DE BAJA</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                <i class="si si-close"></i>
              </button>
            </div>
          </div>
          <div class="block-content mb-4">
            <div class="block pull-r-l">
              <div class="block-content">
                <input type="hidden" name="device-id" value="{{ $device->id }}">
                <div class="form-group row">
                  <div class="col-12">
                    <div class="form-material">
                      <select class="js-select2 form-control" id="val-select2-tec-solutions"
                        name="val-select2-tec-solutions" style="width: 100%;"
                        data-placeholder="Seleccionar solución técnica.." required>
                        <option></option>
                        <!--  for data-placeholder attribute to work with Select2 plugin -->
                        @forelse ($technician_solutions as $tec_solution)
                        <option value="{{ $tec_solution->id }}">
                          {{ Str::upper($tec_solution->name) }}
                        </option>
                        @empty
                        <option>NO EXISTEN SOLUCIONES TÉCNICAS REGISTRADAS</option>
                        @endforelse
                      </select>
                      <label for="val-select2-tec-solutions">Alternativas para solucion
                        técnica</label>
                    </div>
                    @if($errors->has('val-select2-tec-solutions'))
                    <small class="text-danger is-invalid">{{ $errors->first('val-select2-tec-solutions') }}</small>
                    @endif
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12">
                    <div class="form-material">
                      <textarea class="js-maxlength form-control" id="diagnostic" name="diagnostic" rows="4"
                        maxlength="500" placeholder="Escriba aqui una diagnóstico" data-always-show="true"
                        data-warning-class="badge badge-primary" data-limit-reached-class="badge badge-warning"
                        onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
                      <label for="diagnostic">Diagnóstico</label>
                    </div>
                  </div>
                  @if($errors->has('diagnostic'))
                  <small class="text-danger is-invalid">{{ $errors->first('diagnostic') }}</small>
                  @endif
                </div>
                <div class="form-row">
                  <div class="col-md-12">
                    <div class="form-material">
                      <textarea class="js-maxlength form-control" id="observation" name="observation" rows="3"
                        maxlength="255" placeholder="Escriba aqui una observación" data-always-show="true"
                        data-warning-class="badge badge-primary" data-limit-reached-class="badge badge-warning"
                        onkeyup="javascript:this.value=this.value.toUpperCase();"></textarea>
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
<script src="{{ asset('/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>

<script>
  jQuery(function(){ Codebase.helpers(['maxlength', 'select2',]); });
</script>

@endpush