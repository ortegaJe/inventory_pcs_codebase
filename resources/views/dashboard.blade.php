@extends('layouts.backend')

@section('title', 'Dashboard')

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
<div class="col-xl-6">
	<div class="block">
		<div class="block-content block-content-full text-center bg-primary">
			<div class="p-20 mb-10">
				<i class="fa fa-3x fa-youtube-play text-white-op"></i>
			</div>
			<p class="font-size-lg font-w600 text-white mb-0">
				Best TV Shows
			</p>
			<p class="font-size-sm text-uppercase font-w600 text-white-op mb-0">
				Top 5
			</p>
		</div>
		<div class="block-content block-content-full">
			<table class="table table-borderless table-striped table-hover mb-0">
				<tbody>
					<tr>
						<td class="text-center" style="font-size: 14px">01</td>
						<td>
							<i class="fa fa-trophy fa-1x text-warning"></i>
						</td>
						<td>
							<strong>Alberto Cortes</strong>
						</td>
						<td>
							<strong style="width: 60px;">VIVA 1A IPS MACARENA</strong>
						</td>
						<td class="text-center" style="width: 40px;">
							<strong class="text-success">95</strong>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="block-content block-content-full text-center bg-body-light">
			<a class="btn btn-alt-secondary" href="javascript:void(0)">
				<i class="fa fa-eye mr-5"></i> Show all..
			</a>
		</div>
	</div>
</div>
@endsection