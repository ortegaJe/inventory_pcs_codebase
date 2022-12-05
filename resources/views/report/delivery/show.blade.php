@extends('layouts.backend')

@section('title', 'Reportes')

@section('content')
<nav class="breadcrumb bg-white push">
    <a class="breadcrumb-item" href="{{ route('inventory.report.index') }}">Reportes</a>
    <a class="breadcrumb-item" href="{{ route('inventory.report.delivery.index') }}">Acta de entrega</a>
    <span class="breadcrumb-item active">Generar</span>
</nav>
<div class="block-content">
    @include('report.delivery.partials.modal')
    <div class="content-heading">
        <button type="button" class="btn btn-sm btn-alt-success float-right" data-toggle="modal"
            data-target="#modal-popin-up-delivery">
            <i class="fa fa-plus text-success mr-5"></i>Generar
        </button>
        Reportes Acta De Entrega <small class="d-none d-sm-inline">Serial Equipo: {{ $device->serial_number }}</small>
    </div>
    <!-- Device Table -->
    <div class="block block-rounded">
        <div class="block-content bg-body-light">
            <br>
        </div>
        <div class="block-content">
            <!-- Device Table -->
            <table class="table table-borderless table-striped">
                <thead>
                    <tr>
                        <th style="width: 100px;">CODIGO</th>
                        <th style="width: 200px;">FECHA</th>
                        <th class="d-none d-sm-table-cell">REPORTE GENERADO</th>
                        <th class="d-none d-sm-table-cell text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody style="font-size: 14px">
                    @forelse($report_deliveries as $repo)
                    <tr>
                        <td class="d-none d-sm-table-cell">
                            {{ $repo->report_code_number }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{ $repo->date_created }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <i class="fa fa-file-pdf-o text-danger mr-5"></i>
                            {{ $repo->report_name }}
                        </td>
                        <td class="d-none d-sm-table-cell text-center">
                            <div class="btn-group">
                                <a class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Imprimir Reporte"
                                    @if(Storage::exists('pdf/acta_de_entrega/'.$repo->report_code_number.'.pdf'))
                                    href="{{ Storage::url('pdf/acta_de_entrega/'.$repo->report_code_number.'.pdf') }}"
                                    @else
                                    href="{{ route('inventory.report.delivery.generated', [$repo->repo_id,
                                    $repo->rowguid]) }}"
                                    @endif
                                    target="_blank">
                                    <i class="fa fa-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            REPORTES AUN SIN REGISTRAR
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- END Orders Table -->
            <div>
                <ul class="pagination justify-content-end">
                    {{-- {!! $report_deliveries->links("pagination::bootstrap-4") !!} --}} </ul>
            </div>
        </div>
    </div>
</div>

@if ($report_deliveries->count_report > 0)
<div class="block-content">
    @include('report.delivery.partials.modal_upload')
    <div class="content-heading">
        <button type="button" class="btn btn-sm btn-alt-success float-right" data-toggle="modal"
            data-target="#modal-upload">
            <i class="fa fa-upload text-success mr-5"></i>Cargar
        </button>
        Cargar Reportes Acta De Entrega
    </div>
    <!-- Device Table -->
    <div class="block block-rounded">
        <div class="block-content bg-body-light">
            <br>
        </div>
        <div class="block-content">
            <!-- Device Table -->
            <table class="table table-borderless table-striped">
                <thead>
                    <tr>
                        <th style="width: 100px;">CODIGO</th>
                        <th style="width: 200px;">FECHA</th>
                        <th class="d-none d-sm-table-cell">REPORTE FIRMADO</th>
                        <th class="d-none d-sm-table-cell text-center">ACCIONES</th>
                    </tr>
                </thead>
                <tbody style="font-size: 14px">
                    @forelse($file_upload_reports as $repo)
                    <tr>
                        <td class="d-none d-sm-table-cell">
                            {{ $repo->report_code_number }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{ $repo->upload_date }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <i class="fa fa-file-pdf-o text-danger mr-5"></i>
                            {{ $repo->report_name }}
                        </td>
                        <td class="d-none d-sm-table-cell text-center">
                            <div class="btn-group">
                                <a class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Imprimir Reporte"
                                    href="{{ Storage::url($repo->file_path) }}" target="_blank">
                                    <i class="fa fa-print"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            SIN REPORTES CARGADOS
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <!-- END Orders Table -->
            {{-- <div>
                <ul class="pagination justify-content-end">
                    {!! $file_uploads_report_deliveries->links("pagination::bootstrap-4") !!}
                </ul>
            </div> --}}
        </div>
    </div>
</div>
@endif

@endsection

@push('js')

@if(Session::has('report_created'))
<script>
    Swal.fire(
    'Creado con Exito!',
    '{!! Session::get('report_created') !!}',
    'success'
  )
</script>
@endif

@if(Session::has('success_upload_sign'))
<script>
    Swal.fire(
'Firma cargada con éxito!',
'{!! Session::get('success_upload_sign') !!}',
'success'
)
</script>
@endif

@if(Session::has('fail_upload_sign'))
<script>
    Swal.fire(
'Archivo debe ser de tipo imagen(.jpeg, .jpg, .png) o archivo(.pdf)',
'{!! Session::get('fail_upload_sign') !!}',
'error'
)
</script>
@endif

@endpush