<!-- Pop In Modal -->
<form action="{{ route('inventory.report.download.mto.campu') }}" method="GET">
    <div class="modal fade" id="modal-download-all" tabindex="-1" role="dialog" aria-labelledby="modal-popin"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-popin" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Descargar Mantenimientos</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content mb-4">
                        <div class="block pull-r-l">
                            <div class="block-content">
                                {{-- <input type="hidden" name="device_id" value="{{ $device->id }}">
                                <input type="hidden" name="campu_id" value="{{ $device->campu_id }}">
                                --}}
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <div class="form-material">
                                            {{-- @foreach ($campu_users as $campu)
                                            <input type="text" id="campus" name="campus" value="{{ $campu->campu_id }}">
                                            @endforeach --}}
                                            <select class="js-select2 form-control" id="campus" name="campus"
                                                style="width: 100%;" data-placeholder="Seleccionar sede.." required>
                                                <option disabled selected></option>
                                                <!-- Empty value for demostrating material select box -->
                                                @forelse ($campu_users as $campu)
                                                <option value="{{ $campu->campu_id }}">{{ $campu->name }}</option>
                                                @empty
                                                <option>NO EXISTEN SEDES REGISTRADAS</option>
                                                @endforelse
                                                <option value="0">TODAS MIS SEDES</option>
                                            </select>
                                            <label for="campus">Sedes</label>
                                        </div>
                                        @if($errors->has('campus'))
                                        <small class="text-danger is-invalid">{{ $errors->first('campus')}}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-alt-success">
                        <i class="fa fa-download"></i>
                        Descargar
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
    $('#modal-download-all').modal('show');
    @endif
  })
</script>

@endpush