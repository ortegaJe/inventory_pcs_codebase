@extends('layouts.backend')

@section('title', 'Asignar Rol')

@section('css')

@section('content')

@if(session('info'))
<div class="alert alert-success">
    <strong>{{ session('info') }}</strong>
</div>
@endif

<div class="col-xl-12">
    <!-- Roles -->
    <form action="{{ route('admin.inventory.technicians.update', $user->id) }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="block pull-r-l">
            <div class="block-header bg-gray-light">
                <h3 class="block-title">
                    <i class="si si-badge fa-2x font-size-default mr-5"></i>Asignar Rol | {{ $user->name }}
                    {{ $user->last_name }}
                </h3>
                <div class="block-options">
                    <button type="button" class="btn btn-sm btn-alt-success min-width-125" data-toggle="click-ripple">
                        <i class="si si-energy"></i> Asignar
                    </button>
                </div>
            </div>
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
        <!-- END Roles -->
    </form>
</div>

@endsection

@push('js')

@endpush