@extends('layouts.backend')

@section('title', 'Crear Rol')

@section('css')

@section('content')

<div class="col-xl-12">
    <!-- Roles -->
    <form action="{{ route('admin.inventory.roles.store') }}" method="POST">
        @csrf
        @method('POST')
        <div class="block pull-r-l">
            <div class="block-header bg-gray-light">
                <h3 class="block-title">
                    <i class="si si-badge fa-2x font-size-default mr-5"></i>Crear Rol
                </h3>
                <div class="block-options">
                </div>
            </div>
            <div class="block-content">
                <div class="row gutters-tiny">
                    <div class="col-12">
                        <div class="form-material floating">
                            <input type="text" class="form-control" id="name" name="name">
                            <label for="name">Nombre del rol</label>
                            @error('name')
                            <small class="text-danger">
                                {{ $message }}
                            </small>
                            @enderror
                        </div>
                    </div>
                    <h2 class="block-title mt-4">
                        <i class="si si-lock fa-2x font-size-default mr-5"></i>Lista de permisos
                    </h2>
                    @foreach ($permissions as $permission)
                    <div class="col-6 mb-2">
                        <label class="css-control css-control-success css-checkbox">
                            <input type="checkbox" class="css-control-input" name="permiso[]"
                                value="{{ $permission->id }} ">
                            <span class="css-control-indicator"></span> {{ $permission->name }}
                        </label>
                    </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-sm btn-alt-success min-width-125 mt-4 mb-4"
                    data-toggle="click-ripple">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
        </div>
        <!-- END Roles -->
    </form>
</div>

@endsection

@push('js')

@endpush