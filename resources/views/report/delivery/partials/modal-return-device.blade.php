<!-- Pop In Modal -->
<form action="{{ route('inventory.report.deliverys.store') }}" method="POST">
  @csrf
  @method('POST')
  <div class="modal fade" id="return-device" tabindex="-1" role="dialog" aria-labelledby="modal-popin"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-popin" role="document">
      <div class="modal-content">
        <div class="block block-themed block-transparent mb-0">
          <div class="block-header bg-primary-dark">
            <h3 class="block-title">RETORNO DE EQUIPO</h3>
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
                <div class="form-group row">
                  <div class="col-md-6">
                    <div class="form-material floating input-group">
                      <input type="text" class="form-control" id="name" name="name" value="" maxlength="100"
                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                      <label for="name">Nombre del custodio</label>
                    </div>
                    @if($errors->has('name'))
                    <small class="text-danger is-invalid">{{ $errors->first('name') }}</small>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <div class="form-material floating input-group">
                      <input type="text" class="form-control" id="middle_name" name="middle_name" value=""
                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                      <label for="middle_name">Segundo Nombre del custodio</label>
                    </div>
                    @if($errors->has('middle_name'))
                    <small class="text-danger is-invalid">{{ $errors->first('middle_name') }}</small>
                    @endif
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-6">
                    <div class="form-material floating input-group">
                      <input type="text" class="form-control" id="last_name" name="last_name" value=""
                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                      <label for="last_name">Apellido del custodio</label>
                    </div>
                    @if($errors->has('last_name'))
                    <small class="text-danger is-invalid">{{ $errors->first('last_name') }}</small>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <div class="form-material floating input-group">
                      <input type="text" class="form-control" id="second_last_name" name="second_last_name" value=""
                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                      <label for="second_last_name">Segundo Apellido del custodio</label>
                    </div>
                    @if($errors->has('second_last_name'))
                    <small class="text-danger is-invalid">{{ $errors->first('second_last_name') }}</small>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <div class="form-material floating input-group">
                      <input type="text" class="form-control" id="position" name="position" value=""
                        onkeyup="javascript:this.value=this.value.toUpperCase();">
                      <label for="position">Cargo del custodio</label>
                    </div>
                    @if($errors->has('position'))
                    <small class="text-danger is-invalid">{{ $errors->first('position') }}</small>
                    @endif
                  </div>
                </div>
                <div class="form-group row mt-4">
                  <div class="col-md-3">
                    <label class="css-control css-control-primary css-switch css-switch-square disabled">
                      <input type="checkbox" class="css-control-input" id="is_borrowed" name="is_borrowed">
                      <span class="css-control-indicator"></span> EN PRESTAMO
                    </label>
                  </div>
                </div>
                <div class="form-group row text-center">
                  <label class="col-12 font-size-h3 font-w400">Accesorios</label>
                  <div class="col-12">
                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                      <input class="custom-control-input" type="checkbox" name="keyboard" id="keyboard" value="1">
                      <label class="custom-control-label" for="keyboard">Teclado</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                      <input class="custom-control-input" type="checkbox" name="mouse" id="mouse" value="1">
                      <label class="custom-control-label" for="mouse">Mouse</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                      <input class="custom-control-input" type="checkbox" name="webcam" id="webcam" value="1">
                      <label class="custom-control-label" for="webcam">Web Cam</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                      <input class="custom-control-input" type="checkbox" name="cover" id="cover" value="1">
                      <label class="custom-control-label" for="cover">Funda</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                      <input class="custom-control-input" type="checkbox" name="briefcase" id="briefcase" value="1">
                      <label class="custom-control-label" for="briefcase">Maletín</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                      <input class="custom-control-input" type="checkbox" name="padlock" id="padlock" value="1">
                      <label class="custom-control-label" for="padlock">Candando</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline mb-5">
                      <input class="custom-control-input" type="checkbox" name="power_charger" id="power_charger"
                        value="1">
                      <label class="custom-control-label" for="power_charger">Adaptador</label>
                    </div>
                  </div>
                  <div>
                    @if($errors->has('keyboard'))
                    <small class="text-danger is-invalid">{{ $errors->first('keyboard') }}</small>
                    @endif
                    <br />
                    @if($errors->has('mouse'))
                    <small class="text-danger is-invalid">{{ $errors->first('mouse') }}</small>
                    @endif
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-md-6">
                    <div class="form-material floating input-group">
                      <input type="text" class="form-control" id="serial_keyboard" name="serial_keyboard"
                        value="{{ old('serial_keyboard') }}" onkeyup="javascript:this.value=this.value.toUpperCase();"
                        onkeypress="return /[0-9a-zA-Z]/i.test(event.key)">
                      <label for="serial_keyboard">Serial teclado</label>
                    </div>
                    @if($errors->has('serial_keyboard'))
                    <small class="text-danger is-invalid">{{ $errors->first('serial_keyboard') }}</small>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <div class="form-material floating input-group">
                      <input type="text" class="form-control" id="serial_mouse" name="serial_mouse"
                        value="{{ old('serial_mouse') }}" onkeyup="javascript:this.value=this.value.toUpperCase();"
                        onkeypress="return /[0-9a-zA-Z]/i.test(event.key)">
                      <label for="serial_mouse">Serial mouse</label>
                    </div>
                    @if($errors->has('serial_mouse'))
                    <small class="text-danger is-invalid">{{ $errors->first('serial_mouse') }}</small>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <div class="form-material floating input-group">
                      <input type="text" class="form-control" id="serial_power_charger" name="serial_power_charger"
                        value="{{ old('serial_power_charger') }}"
                        onkeyup="javascript:this.value=this.value.toUpperCase();"
                        onkeypress="return /[0-9a-zA-Z]/i.test(event.key)">
                      <label for="serial_power_charger">Serial adaptador de corriente</label>
                    </div>
                    @if($errors->has('serial_power_charger'))
                    <small class="text-danger is-invalid">{{ $errors->first('serial_power_charger') }}</small>
                    @endif
                  </div>
                  <div class="col-md-6">
                    <div class="form-material floating input-group">
                      <input type="text" class="form-control" id="other_accesories" name="other_accesories"
                        value="{{ old('other_accesories') }}" onkeyup="javascript:this.value=this.value.toUpperCase();"
                        onkeypress=" return /[0-9a-zA-Z ]/i.test(event.key)">
                      <label for="other_accesories">Otros accesorios</label>
                    </div>
                    @if($errors->has('other_accesories'))
                    <small class="text-danger is-invalid">{{ $errors->first('other_accesories') }}</small>
                    @endif
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-12">
                    <div class="form-material floating">
                      <textarea class="form-control" id="material-textarea-small2" name="material-textarea-small2"
                        rows="3"></textarea>
                      <label for="material-textarea-small2">Observacíon</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-material floating input-group">
                      <input type="text" class="form-control" id="delivery_date" name="delivery_date" value="" disabled>
                      <label for="delivery_date">Fecha de entrega</label>
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div class="form-material">
                      <input type="text" class="js-flatpickr form-control" id="return_date" name="return_date"
                        placeholder="d-m-Y" data-allow-input="true" maxlength="10">
                      <label for="return_date">Fecha de retorno</label>
                    </div>
                    @if($errors->has('return_date'))
                    <small class="text-danger is-invalid">{{ $errors->first('return_date') }}</small>
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
            <i class="fa fa-save"></i> Guardar
          </button>
        </div>
      </div>
    </div>
  </div>
</form>
<!-- END Pop In Modal -->