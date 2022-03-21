@extends('layouts.backend')

@section('title', 'Reportes')

@section('content')
<nav class="breadcrumb bg-white push">
  <a class="breadcrumb-item" href="{{ route('inventory.report.index') }}">Reportes</a>
  <a class="breadcrumb-item" href="{{ route('inventory.report.maintenance.index') }}">Mantenimientos</a>
  <span class="breadcrumb-item active">Generar reporte</span>
</nav>
<div class="block-content">
  <div class="content-heading">
    @include('report.maintenances.partials.modal')
    Reporte Mantenimientos <small class="d-none d-sm-inline">Serial Equipo: {{ $device->serial_number }}</small>
    @if(count($report_maintenances) < 1) <button type="button" class="btn btn-sm btn-alt-success float-right"
      data-toggle="modal" data-target="#modal-mto">
      <i class="fa fa-plus text-success mr-5"></i>Generar
      </button>
      @endif
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
          @forelse($report_maintenances as $repo)
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
                  @if($repo->FechaMto01Realizado == now()->isoformat('M'))
                  @if(Storage::exists('pdf/mantenimientos/primer-semestre/'.Str::slug($repo->campu).'/'.$repo->report_code_number.'.pdf'))
                  href="{{Storage::url('pdf/mantenimientos/primer-semestre/'.Str::slug($repo->campu).'/'.$repo->report_code_number.'.pdf')}}"
                  @else
                  href="{{ route('inventory.report.maintenance.generated', [$repo->repo_id, $repo->report_rowguid]) }}"
                  @endif
                  @endif
                  @if($repo->FechaMto02Realizado == now()->isoformat('M'))
                  @if(Storage::exists('pdf/mantenimientos/segundo-semestre/'.Str::slug($repo->campu).'/'.$repo->report_code_number.'.pdf'))
                  href="{{Storage::url('pdf/mantenimientos/segundo-semestre/'.Str::slug($repo->campu).'/'.$repo->report_code_number.'.pdf')}}"
                  @else
                  href="{{ route('inventory.report.maintenance.generated', [$repo->repo_id, $repo->report_rowguid]) }}"
                  @endif
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
              REPORTE AUN SIN REGISTRAR
            </td>
          </tr>
          @endif
        </tbody>
      </table>
      <!-- END Orders Table -->
    </div>
  </div>
  <!-- END Orders Table -->
</div>
@endsection

@push('js')

<script>
  jQuery(function() {
      Codebase.helpers(['maxlength']);
    });
</script>

@endpush