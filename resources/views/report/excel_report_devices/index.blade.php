@extends('layouts.backend')

@section('title', 'Reportes')

@section('content')
    <nav class="breadcrumb bg-white push">
        <a class="breadcrumb-item" href="{{ route('inventory.report.index') }}">Reportes</a>
        <span class="breadcrumb-item active">Descargar inventario en Excel</span>
        <div class="ml-auto">
            <button type="button" class="btn btn-sm btn-noborder btn-alt-primary min-width-125 js-click-ripple download-all-excel"
                    id="{{ $campus[0]->user_id }}"
                    data-toggle="click-ripple">
                <i class="fa fa-download mr-5"></i>
                Descargar todas las sedes
            </button>
        </div>
    </nav>

    <div class="row">
        @forelse ($campus as $campu)
            <div class="col-md-6 col-xl-4">
                <a class="block block-link-pop text-center download-excel" href="javascript:void(0)"
                    id="{{ $campu->campu_id }}">
                    <div class="block-content text-center">
                        <div class="item item-circle bg-primary-lighter text-primary mx-auto my-10">
                            <i class="fa fa-building-o"></i>
                        </div>
                        <div class="font-size-sm text-muted">{{ $campu->countDevice }} Equipos</div>
                    </div>
                    <div class="block-content bg-body-light campuName">
                        <p class="font-w600" id="{{ Str::lower($campu->campu_name) }}">
                            {{ $campu->campu_name }}
                        </p>
                    </div>
                </a>
            </div>
        @empty
        @endforelse
    </div>

@endsection
@push('js')
    <script>
        let url_export_excel_device = <?php echo json_encode(route('download.excel.report.device')); ?>;
        let url_export_excel_all_device = <?php echo json_encode(route('download.excel.report.all.device')); ?>;
    </script>

    <script src="{{ asset('/js/download.excel.report.device.js') }}"></script>
@endpush
