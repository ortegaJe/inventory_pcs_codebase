@extends('layouts.backend')

@section('title', '')

@section('css')
<link rel="stylesheet" href="{{ asset('/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('/js/plugins/flatpickr/flatpickr.min.css') }}">

@section('content')
<nav class="breadcrumb bg-white push">
  <a class="breadcrumb-item" href="{{ route('inventory.report.index') }}">Reportes</a>
  <a class="breadcrumb-item" href="{{ route('inventory.report.resumes.index') }}">Reporte de hoja de vida</a>
  <span class="breadcrumb-item active">Generar reporte</span>
</nav>
<div class="block-content">
  <div class="content-heading">
    @if($report_resume_count <= 0) <form action="{{ route('inventory.report.resumes.store') }}" method="POST">
      @csrf
      @method('POST')
      <input type="hidden" name="device-id" value="{{ $device->id }}">
      <button type="submit" class="btn btn-sm btn-alt-success float-right">
        <i class="fa fa-file-text-o text-success mr-5"></i>Generar hoja de vida
      </button>
      </form>
      @endif
      Reporte de hoja de vida | Serial del equipo: {{ $device->serial_number }}
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
          @forelse($report_resumes as $repo)
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
              {{--<div class="btn-group">
                <a class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Imprimir Reporte"
                  href="{{ route('inventory.report.maintenance.pdf', [$repo->repo_id]) }}" target="_blank">
                  <i class="fa fa-print"></i>
                </a>
              </div>--}}
              <div class="btn-group">
                <a class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Imprimir Reporte"
                  href="{{ route('inventory.report.resumes.generated', $repo->repo_id) }}" target="_blank">
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
@if($report_resume_count <= 0) @include('report.resumes.partials.modal_maintenance') <div class="block-content">
  <div class="content-heading">
    <button type="button" class="btn btn-sm btn-alt-success float-right" data-toggle="modal"
      data-target="#modal-popin-up-resume">
      <i class="fa fa-plus text-success mr-5"></i>Generar
    </button>
    Mantenimientos
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
            <th style="width: 200px;">FECHA</th>
            <th class="d-none d-sm-table-cell">REPORTE GENERADO</th>
            <th class="d-none d-sm-table-cell text-center">ACCIONES</th>
          </tr>
        </thead>
        <tbody style="font-size: 14px">
          @foreach($report_maintenances as $repo)
          @if($repo->maintenance_date == '' && $repo->observation == '')
          <tr>
            <td colspan="4" class="text-center">
              REPORTE DE MANTENIMIENTO AUN SIN REGISTRAR
            </td>
          </tr>
          @else
          <tr>
            <td class="d-none d-sm-table-cell">
              {{ $repo->maintenance_date }}
            </td>
            <td class="d-none d-sm-table-cell">
              <i class="fa fa-file-pdf-o text-danger mr-5"></i>
              MTO-{{ $repo->serial_number }}
            </td>
            <td class="d-none d-sm-table-cell text-center">
              <div class="btn-group">
                <a class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Imprimir Reporte"
                  href="{{ route('inventory.report.maintenance.generated', [$repo->repo_id]) }}" target="_blank">
                  <i class="fa fa-print"></i>
                </a>
              </div>
            </td>
          </tr>
          @endif
          @endforeach
        </tbody>
      </table>
      <!-- END Orders Table -->
    </div>
  </div>
  </div>
  @endif
  @endsection

  @push('js')

  <!-- Page JS Code -->
  <script src="{{ asset('/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js ')}}"></script>
  <script src="{{ asset('/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

  <!-- Page JS Helpers (Flatpickr + BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins) -->
  <script>
    jQuery(function() {
      Codebase.helpers(['flatpickr', 'datepicker', 'maxlength', 'select2']);
    });
  </script>

  @if(Session::has('report_created'))
  <script>
    Swal.fire(
      'Reporte creado con Exito!',
      '{!! Session::get('
      report_created ') !!}',
      'success'
    )
  </script>
  @endif

  @endpush