{{ $query->id }}

<div class="col-xl-6 mt-4">
    <!-- Status Checkboxes -->
    <div class="block">
        <div class="block-header block-header-default">
            <h3 class="block-title">Estado del equipo</h3>
        </div>
        <div class="block-content">
            <div class="row no-gutters items-push">
                <div class="col-6">
                    <label class="css-control css-control-success css-checkbox">
                        <input type="checkbox" class="css-control-input" name="estado-pc[]" value="rendimiento optimo">
                        <span class="css-control-indicator"></span> Rendimiento Óptimo
                    </label>
                </div>
                <div class="col-6">
                    <label class="css-control css-control-warning css-checkbox">
                        <input type="checkbox" class="css-control-input" name="estado-pc[]" value="rendimiento bajo">
                        <span class="css-control-indicator"></span> Rendimiento bajo
                    </label>
                </div>
                <div class="col-6">
                    <label class="css-control css-control-info css-checkbox">
                        <input type="checkbox" class="css-control-input" name="estado-pc[]" value="hurtado">
                        <span class="css-control-indicator"></span> Hurtado
                    </label>
                </div>
                <div class="col-6">
                    <label class="css-control css-control-secondary css-checkbox">
                        <input type="checkbox" class="css-control-input" name="estado-pc[]" value="dado de baja">
                        <span class="css-control-indicator"></span> Dado de baja
                    </label>
                </div>
            </div>
            @if($errors->has('estado-pc'))
            <small class="text-danger is-invalid">{{ $errors->first('estado-pc') }}</small>
            @endif
        </div>
    </div>
    <!-- END Status Checkboxes -->
</div>