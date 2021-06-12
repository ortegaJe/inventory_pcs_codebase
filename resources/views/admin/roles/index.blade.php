@extends('layouts.backend')

@section('title', 'Admin Dashboard')

@section('content')

@if(session('info'))
<div class="alert alert-success">
  <strong>{{ session('info') }}</strong>
</div>
@endif

<!-- Striped Table -->
<div class="block">
  <div class="block-header bg-gray-light">
    <h2 class="h4 font-w300 mb-0">Lista de Roles</h2>
    <div class="block-options">
      <div class="block-options-item">
        <div class="col-sm-6 col-xl-4">
          <button type="button" onclick="window.location='{{ route('admin.inventory.roles.create') }}'"
            class="btn btn-sm btn-alt-warning min-width-125" data-toggle="click-ripple">
            <i class="si si-badge"></i> Nuevo Rol
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="block-content">
    <table class="table table-striped table-hover table-vcenter">
      <thead>
        <tr>
          <th class="text-center" style="width: 50px;">#</th>
          <th class="d-none d-sm-table-cell" style="width: 15%;">Rol</th>
          <th>Descripción</th>
          <th class="text-center" style="width: 100px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($roles as $role)
        <tr>
          <th class="text-center" scope="row">{{ $role->id }}</th>
          <td>
            <span class="badge badge-warning"><i class="si si-badge"></i> {{ $role->name }}</span>
          </td>
          <td class="d-none d-sm-table-cell"></td>
          <td class="text-center">
            <form acton="{{ route('admin.inventory.roles.destroy', $role) }}" method="POST">
              @csrf
              @method('DELETE')
              <div class="btn-group">
                <button type="button" onclick="window.location='{{ route('admin.inventory.roles.edit', $role) }}'"
                  class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Editar">
                  <i class="fa fa-pencil"></i>
                </button>
                <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Borrar">
                  <i class="fa fa-times"></i>
                </button>
              </div>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
<!-- END Striped Table -->
@endsection