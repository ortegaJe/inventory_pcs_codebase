<!-- Pop In Modal -->
<form action="{{ route('admin.inventory.technicians.update-profile', $users->id) }}" method="POST">
  @csrf
  @method('PATCH')
  <div class="modal fade" id="modal-popin-up-profile" tabindex="-1" role="dialog" aria-labelledby="modal-popin"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin" role="document">
      <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
          <div class="block-header bg-primary-dark">
            <h3 class="block-title">Update Profile</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                <i class="si si-close"></i>
              </button>
            </div>
          </div>
          <div class="block-content mb-4">
            <div class="form-group row">
              <div class="col-12">
                <div class="form-material">
                  <select class="js-select2 form-control" id="val-select2-change-profile"
                    name="val-select2-change-profile" style="width: 100%;" data-placeholder="Seleccionar cargo.."
                    required>
                    <option></option>
                    <!--  for data-placeholder attribute to work with Select2 plugin -->
                    @forelse ($profiles as $profile)
                    <option value="{{ $profile->id }}">
                      {{ Str::upper($profile->name) }}
                    </option>
                    @empty
                    <option>NO EXISTEN CARGOS REGISTRADOS</option>
                    @endforelse
                  </select>
                  <label for="val-select2-change-profile">Cargos de trabajo</label>
                </div>
                @if($errors->has('val-select2-change-profile'))
                <small class="text-danger is-invalid">{{ $errors->first('val-select2-change-profile') }}</small>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-alt-success">
            <i class="fa fa-check"></i> Update
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- END Pop In Modal -->