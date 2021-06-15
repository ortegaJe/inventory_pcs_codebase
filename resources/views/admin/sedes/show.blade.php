@extends('layouts.backend')

@section('title', 'Sedes')

@section('content')
<!-- Hero -->
<div class="bg-gray-lighter">
    <div class="bg-black-op-12">
        <div class="content content-top text-center">
            <div class="mb-20">
                <i class="fa fa-building-o fa-4x text-muted"></i>
                </a>
                <h1 class="h3 text-primary-light font-w700 mb-10">
                    {{ $campus }}
                </h1>
                <h2 class="h5 text-black-op">
                    Premium Member with <a class="text-primary-light link-effect" href="javascript:void(0)">39
                        Orders</a>
                </h2>
            </div>
        </div>
    </div>
</div>
<!-- END Hero -->

<!-- Breadcrumb -->
<div class="bg-body-light border-b">
    <div class="content py-5 text-center">
        <nav class="breadcrumb bg-body-light mb-0">
            <a class="breadcrumb-item" href="be_pages_ecom_dashboard.html">e-Commerce</a>
            <a class="breadcrumb-item" href="javascript:void(0)">Customers</a>
            <span class="breadcrumb-item active">John Smith</span>
        </nav>
    </div>
</div>
<!-- END Breadcrumb -->

@endsection