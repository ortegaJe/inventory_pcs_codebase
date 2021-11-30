@extends('layouts.backend')

@section('title', 'Reportes')

@section('content')
<nav class="breadcrumb bg-white push">
    <a class="breadcrumb-item" href="{{ route('inventory.report.index') }}">Reportes</a>
    <a class="breadcrumb-item" href="{{ route('inventory.report.removes.index') }}">De baja</a>
    <span class="breadcrumb-item active">Generar</span>
</nav>
<div class="block-content">
    @include('report.removes.partials.modal_remove')
    <div class="content-heading">
        <button type="button" class="btn btn-sm btn-alt-success float-right" data-toggle="modal"
            data-target="#modal-popin-up-remove">
            <i class="fa fa-plus text-success mr-5"></i>Generar
        </button>
        Reporte de solicitud de baja | Serial del equipo: {{ $device->serial_number }}
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
                    @forelse($report_removes as $repo)
                    <tr>
                        <td class="d-none d-sm-table-cell">
                            {{ $repo->report_code_number }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            {{ $repo->date_created }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                            <i class="fa fa-file-pdf-o text-danger mr-5"></i>
                            {{ $repo->repo_name }}
                        </td>
                        <td class="d-none d-sm-table-cell text-center">
                            <div class="btn-group">
                                <a class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Imprimir Reporte"
                                    href="{{ route('inventory.report.removes.generated', [$repo->repo_id, $repo->rowguid]) }}"
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

            <!-- Navigation 
        <nav aria-label="Orders navigation">
            <ul class="pagination justify-content-end">
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                        <span aria-hidden="true">
                            <i class="fa fa-angle-left"></i>
                        </span>
                        <span class="sr-only">Previous</span>
                    </a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="javascript:void(0)">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)">2</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link" href="javascript:void(0)">...</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)">8</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)">9</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" aria-label="Next">
                        <span aria-hidden="true">
                            <i class="fa fa-angle-right"></i>
                        </span>
                        <span class="sr-only">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
         END Navigation -->
        </div>
    </div>
    <!-- END Orders Table -->

    <!-- Navigation 
            <nav aria-label="Orders navigation">
                <ul class="pagination justify-content-end">
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" aria-label="Previous">
                            <span aria-hidden="true">
                                <i class="fa fa-angle-left"></i>
                            </span>
                            <span class="sr-only">Previous</span>
                        </a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="javascript:void(0)">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)">2</a>
                    </li>
                    <li class="page-item disabled">
                        <a class="page-link" href="javascript:void(0)">...</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)">8</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)">9</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="javascript:void(0)" aria-label="Next">
                            <span aria-hidden="true">
                                <i class="fa fa-angle-right"></i>
                            </span>
                            <span class="sr-only">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
             END Navigation -->
</div>

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

@endpush