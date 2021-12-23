<!-- Pop Out Modal -->
<form action="{{ route('upload.sign.user', $users->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="modal fade" id="modal-sign" tabindex="-1" role="dialog" aria-labelledby="modal-popout"
        aria-hidden="true">
        <div class="modal-dialog modal-xs modal-dialog-popout" role="document">
            <div class="modal-content">
                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-gray-darker">
                        <h3 class="block-title">Actualizar mi firma</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="si si-close"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content" style="background-color: #f0f2f5">
                        <div class="row">
                            <!-- Row #2 -->
                            <img src="{{ Storage::url($users->sign) }}" alt="" width="150" height="100">

                            <div class="form-group">
                                <label for="sign">
                                    <i class="fa fa-pencil text-primary mr-5"></i> Cargar firma
                                </label>
                                <div>
                                    <input type="file" id="sign" name="sign" accept="image/*">
                                </div>
                                @if($errors->has('sign'))
                                <small class="text-danger is-invalid">{{ $errors->first('sign') }}</small>
                                @endif
                            </div>
                            <!-- END Row #2 -->
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: #f0f2f5">
                    <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-alt-success"><i class="fa fa-upload"></i> Actualizar</button>
                </div>
            </div>
        </div>
    </div>
</form>
<!-- END Pop Out Modal -->