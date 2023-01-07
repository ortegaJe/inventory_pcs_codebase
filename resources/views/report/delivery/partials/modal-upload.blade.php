<!-- Pop Out Modal -->
<form action="{{ route('upload.file.delivery', $repo->repo_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('POST')
    <div class="modal fade" id="modal-upload" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
        aria-hidden="true">
        <div class="modal-dialog modal-xs modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gray-darker">
                        <h3 class="block-title">CARGAR REPORTE ACTA DE ENTREGA FIRMADO</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content" style="background-color: #f0f2f5">
                        <div class="row">
                            <!-- Row #2 -->
                            <div class="form-group mt-2">
                                <label for="file_upload"></label>
                                <div>
                                    <input type="file" id="file_upload" name="file_upload"
                                        accept=".jpeg, .jpg, .png, .pdf">
                                </div>
                                @if($errors->has('file_upload'))
                                <small class="text-danger is-invalid">{{ $errors->first('file_upload') }}</small>
                                @endif
                            </div>
                            <!-- END Row #2 -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f0f2f5">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-alt-success"><i class="fa fa-upload"></i> Cargar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END Pop Out Modal -->