<!-- Pop In Modal -->
<form action="{{ route('admin.inventory.assingned-role', $users->id) }}" method="POST">
  @csrf
  @method('PATCH')
  <div class="modal fade" id="modal-popin-assing-rol" tabindex="-1" role="dialog" aria-labelledby="modal-popin"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin" role="document">
      <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
          <div class="block-header bg-primary-dark">
            <h3 class="block-title">Assign Rol</h3>
            <div class="block-options">
              <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                <i class="si si-close"></i>
              </button>
            </div>
          </div>
          <div class="block-content mb-4">
            <h3 class="block-title">
              <i class="si si-user fa-2x text-primary font-size-default mr-5"></i>
              {{ Str::title($users->name) }}
              {{ Str::title($users->last_name) }}
            </h3>
            <div class="block pull-r-l">
              <div class="block-content">
                <div class="row gutters-tiny">
                  @foreach ($roles as $rol)
                  <div class="col-6 mb-2">
                    <label class="css-control css-control-success css-checkbox">
                      <input type="checkbox" class="css-control-input" name="rol[]" value="{{ $rol->id }} ">
                      <span class="css-control-indicator"></span> {{ $rol->name }}
                    </label>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-alt-success">
            <i class="si si-energy"></i> Assing
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- END Pop In Modal -->