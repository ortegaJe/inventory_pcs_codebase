<div class="modal fade" id="modal-popout" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
  <div class="modal-dialog modal-dialog-popout" role="document">
    <div class="modal-content">
      <div class="block block-themed block-transparent mb-0">
        <div class="block-header bg-gray-darker">
          <h3 class="block-title">Asignar técnico</h3>
          <div class="block-options">
            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
              <i class="si si-close"></i>
            </button>
          </div>
        </div>
        <div class="block-content">
          <form action="{{ route('admin.inventory.assing-user-campu', $campus) }}" method="POST">
            <input type="hidden" name="campu-id" value="{{ $campus->id }}">
            @csrf
            @method('POST')
            <div class="form-group row">
              <div class="col-12">
                <div class="form-material">
                  <select class="js-select2 form-control" id="list_users" name="list_users" style="width: 100%;" data-placeholder="Seleccionar técnico..">
                    <option></option>
                    <!--  for data-placeholder attribute to work with Select2 plugin -->
                    @forelse ($userLists as $user )
                    <option value="{{ $user->id }}">{{ Str::title($user->name) }} {{ Str::title($user->last_name) }}
                    </option>
                    @empty
                    <option value=""></option>
                    @endforelse
                  </select>
                  <label for="list_users">Lista de técnicos</label>
                </div>
                @if($errors->has('list_users'))
                <small class="text-danger is-invalid">{{ $errors->first('list_users') }}</small>
                @endif
              </div>
            </div>
            <div class="modal-footer mt-4">
              <button type="submit" class="btn btn-alt-success">Aceptar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>