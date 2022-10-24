@extends('layouts.backend')

@section('title', 'Dashboard')

@section('css')
<link href="{{ asset('/css/datatables/datatable.inventory.pc.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.css') }}">

@section('content')
{{--<div class="block block-rounded">
	<div class="block-content block-content-full bg-pattern"
		style="background-image: url('{{ asset('/media/various/bg-pattern-inverse.png') }}');">
		<div class="py-20 text-center">
			<h2 class="font-w700 text-black mb-10">
				Busqueda por Serial
			</h2>
			<div class="row justify-content-center">
				<div class="col-md-10 col-lg-8 col-xl-6">
					<form action="be_pages_hosting_support.html" method="POST">
						<div class="input-group input-group-lg">
							<input type="text" class="form-control" placeholder="Serial equipo..">
							<div class="input-group-append">
								<button type="submit" class="btn btn-secondary">
									<i class="fa fa-search"></i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>--}}
@hasrole('super_admin|admin_view')
<div class="col-xl-6">
	<div class="block">
		<div class="block-content block-content-full text-center bg-primary">
			<div class="p-20 mb-10">
				<i class="fa fa-3x fa-building text-white-op"></i>
			</div>
			<p class="font-size-lg font-w600 text-white mb-0">
				Numero de equipos por sede registrados
			</p>
			<p class="font-size-sm text-uppercase font-w600 text-white-op mb-0">
			</p>
		</div>
		<div class="block-content block-content-full">
			<table id="dt" class="table table-hover" style="width:100%">
				<thead>
					<tr>
						<th><i class="si si-user fa-2x"></i></th>
						<th><i class="si si-screen-smartphone fa-2x"></i></th>
						<th><i class="fa fa-building-o fa-2x"></i></th>
						<th><i class="si si-screen-desktop fa-2x"></i></th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
@endhasrole
@endsection

@push('js')
<script src="{{ asset('/js/datatables/datatable.inventory.campus.less.devices.js') }}"></script>
<script src="{{ asset('/js/pages/be_tables_datatables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
	let root_url = <?php echo json_encode(route('get.campus.fewer.devices')) ?>;
	let root_url_show = <?php echo json_encode(route('admin.inventory.technicians.store')) ?>;
</script>
@endpush