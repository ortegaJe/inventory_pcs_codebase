@extends('layouts.backend')

@section('title', 'Reportes')

@section('content')
<div class="row">
    <div class="col-md-6 col-xl-4">
        <a class="block block-link-pop text-center" href="{{ route('inventory.report.removes.index') }}">
            <div class="block-content text-center">
                <div class="item item-circle bg-primary-lighter text-primary mx-auto my-10">
                    <i class="fa fa-file-text-o"></i>
                </div>
                {{-- <divclass="font-size-smtext-muted">equipos --}}
            </div>
            <div class="block-content bg-body-light">
                <p class="font-w600">
                    DE BAJA
                </p>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-4">
        <a class="block block-link-pop text-center" href="{{ route('inventory.report.maintenance.index') }}">
            <div class="block-content text-center">
                <div class="item item-circle bg-primary-lighter text-primary mx-auto my-10">
                    <i class="fa fa-file-text-o"></i>
                </div>
                {{-- <divclass="font-size-smtext-muted">equipos --}}
            </div>
            <div class="block-content bg-body-light">
                <p class="font-w600">
                    MANTENIMIENTOS
                </p>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-4">
        <a class="block block-link-pop text-center" href="{{ route('inventory.report.delivery.index') }}">
            <div class="block-content text-center">
                <div class="item item-circle bg-primary-lighter text-primary mx-auto my-10">
                    <i class="fa fa-file-text-o"></i>
                </div>
                {{-- <divclass="font-size-smtext-muted">equipos --}}
            </div>
            <div class="block-content bg-body-light">
                <p class="font-w600">
                    ACTA DE ENTREGA
                </p>
            </div>
        </a>
    </div>
    <div class="col-md-6 col-xl-4">
        <a class="block block-link-pop text-center" href="{{ route('sign.index') }}">
            <div class="block-content text-center">
                <div class="item item-circle bg-primary-lighter text-primary mx-auto my-10">
                    <i class="fa fa-pencil"></i>
                </div>
            </div>
            <div class="block-content bg-body-light">
                <p class="font-w600">
                    FIRMAS
                </p>
            </div>
        </a>
    </div>
</div>
@php
  $currenturl = url()->current();
  $user_id = Auth::id();
  $currentRoute = Route::currentRouteName()
@endphp
@endsection

@push('js')
<script>
    let validate_sign = <?php echo json_encode(route('validate_sign')) ?>;
    let route_sign_admin = <?php echo json_encode(route('sign.index')) ?>;
    let route_sign_user = <?php echo json_encode(route('admin.inventory.technicians.profiles')) ?>;
    let user_id = <?php echo json_encode($user_id) ?>;
    let currentRoute = <?php echo json_encode($currentRoute) ?>;
</script>

<script src="{{ asset('/js/validate.sign.reports.js') }}"></script>

@endpush