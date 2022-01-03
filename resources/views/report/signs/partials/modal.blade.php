<!-- Pop Out Modal -->
<div class="modal fade" id="modal-sign-admin-{{ $admin->SedeID }}" tabindex="-1" role="dialog"
  aria-labelledby="modal-popout" aria-hidden="true">
  <div class="modal-dialog modal-xs modal-dialog-popout" role="document">
    <div class="modal-content">
      <div class="block block-themed block-transparent mb-0">
        <div class="block-header bg-gray-darker">
          <h3 class="block-title">Información sede: {{ $admin->NombreSede }}</h3>
          <div class="block-options">
            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
              <i class="si si-close"></i>
            </button>
          </div>
        </div>
        <div class="block-content" style="background-color: #f0f2f5">
          <p class="mb-4">
            <strong>Región:</strong>
            <span class="text-muted"></span>
          </p>
          <p>
            <strong>Abreviado de la sede:</strong>
            <span class="badge badge-pill badge-primary">{{ $admin->AbreviadoSede }}</span>
          </p>
          <p>
            <strong>Dirección:</strong>
            <span class="text-muted">{{ $admin->DireccionSede }}</span>
          </p>
          <p>
            <strong>Telefonos:</strong>
            <span class="text-muted">{{ $admin->TelefonoSede }}</span>
          </p>
          <p>
            <strong>Administrador:</strong>
            <span class="text-muted">{{ Str::title($admin->NombreApellidoAdmin) }}</span>
          </p>
          <p><strong>Firma administrador:</strong></p>
          <div class="form-row mx-auto">
            <img src="{{ Storage::url($admin->FirmaAdmin) }}" alt="" style="height:auto;
                                                                                max-width:100%;
                                                                                border:none;
                                                                                display:block;">
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