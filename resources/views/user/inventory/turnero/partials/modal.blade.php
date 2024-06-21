<div class="modal fade" id="viewImageModal-{{ $file->id }}" tabindex="-1" role="dialog"
    aria-labelledby="viewImageModalLabel-{{ $file->id }}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewImageModalLabel-{{ $file->id }}">Imagen del Atril</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <img src="{{ Storage::url($file->file_path) }}" class="img-fluid" alt="Archivo del dispositivo">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
