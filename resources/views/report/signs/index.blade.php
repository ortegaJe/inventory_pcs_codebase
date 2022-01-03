@extends('layouts.backend')

@section('title', 'Firmas')

@section('content')
<nav class="breadcrumb bg-white push">
	<a class="breadcrumb-item" href="{{ route('inventory.report.index') }}">Reportes</a>
	<span class="breadcrumb-item active">Firmas</span>
</nav>
<!-- Partial Table -->
<div class="block">
	<div class="block-header block-header-default">
		<h3 class="block-title">Administradores</h3>
	</div>
	<div class="block-content">
		<table class="table table-striped table-vcenter">
			<thead>
				<tr>
					<th class="text-center" style="width: 100px;"><i class="si si-user"></i></th>
					<th>Nombres y apellidos</th>
					<th class="d-none d-sm-table-cell" style="width: 30%;">Sede</th>
					<th class="d-none d-md-table-cell" style="width: 15%;">Estado</th>
					<th class="text-center" style="width: 100px;">Acciones</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($campu_administrators as $admin )
				<tr>
					<td class="text-center">
						<img class="img-avatar img-avatar48" src="{{ asset('/media/avatars/avatar11.jpg') }}" alt="">
					</td>
					<td class="font-w600">@if($admin->NombreApellidoAdmin == null) ADMINISTRADOR SIN REGISTRAR
						@else {{ Str::title($admin->NombreApellidoAdmin) }} @endif</td>
					<td class="d-none d-sm-table-cell">{{ $admin->NombreSede }}</td>
					@if($admin->FirmaAdmin != '')
					<td class="d-none d-md-table-cell">
						<span class="badge badge-success">
							<i class="fa fa-check"></i>
							<i class="fa fa-pencil"></i>
						</span>
					</td>
					@elseif($admin->FirmaAdmin == null)
					<td class="d-none d-md-table-cell">
						<span class="badge badge-warning">
							<i class="fa fa-close"></i>
							<i class="fa fa-pencil"></i>
						</span>
					</td>
					@endif
					@include('report.signs.partials.modal')
					<td class="text-center">
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-secondary" title="Editar"
								onclick="window.location='{{ route('sign.edit', [$admin->SedeID, $admin->slug]) }}'">
								<i class="fa fa-pencil"></i>
							</button>
						</div>
						<div class="btn-group">
							<button type="button" class="btn btn-sm btn-secondary" title="Ver información"
								data-toggle="modal" data-target="#modal-sign-admin-{{ $admin->SedeID }}">
								<i class="fa fa-eye"></i>
							</button>
						</div>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
<!-- END Partial Table -->

@endsection

@push('js')

@if(Session::has('success_upload_sign'))
<script>
	Swal.fire(
'Información actualizada!',
'{!! Session::get('success_upload_sign') !!}',
'success'
)
</script>
@endif

@if(Session::has('empty_upload_sign'))
<script>
	Swal.fire(
'No has seleccionado un archivo imagen para la firma digital',
'{!! Session::get('empty_upload_sign') !!}',
'warning'
)
</script>
@endif

<!-- Page JS Code -->
<script src="{{ asset('/js/pages/be_forms_plugins.min.js') }}"></script>

@endpush