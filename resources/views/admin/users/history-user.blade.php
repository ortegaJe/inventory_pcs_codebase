@extends('layouts.backend')

@section('title', 'Historial de técnicos')

@section('css')
<link href="{{ asset('/css/datatables/datatable.inventory.pc.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.css') }}">

@section('content')
<!-- Page Content -->
<div class="col-md-12">
    <!-- Add Product -->
    <div class="row gutters-tiny mb-2">
        <div class="col-md-6 col-xl-2">
            <a class="block block-rounded block-link-shadow" href="{{ route('user.inventory.desktop.create') }}">
                <div class="block-content block-content-full block-sticky-options">
                    <div class="block-options">
                        <div class="block-options-item">
                        </div>
                    </div>
                    <div class="py-20 text-center">
                        <div class="font-size-h2 font-w700 mb-3 text-success">
                            <i class="fa fa-plus"></i>
                        </div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Nuevo equipo</div>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <!-- End Add Product -->
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
        <div class="block-header block-header-default border-b">
            <h3 class="block-title">
                Historial de Técnicos<small> | Lista</small>
            </h3>
            <div class="block-options">
                <button type="button" id="btn-refresh1" class="btn-block-option" data-toggle="block-option"
                    data-action="state_toggle" data-action-mode="demo">
                    <i class="si si-refresh"></i>
                </button>
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table id="dt" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th></th>
                            <th>nombre y apellido</th>
                            <th>historial</th>
                            <th>sede</th>
                            <th>region</th>
                            <th>acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>NOMBRE Y APELLIDO</th>
                            <th>HISTORIAL</th>
                            <th>SEDE</th>
                            <th>REGION</th>
                            <th>ACCIONES</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- End Partial Table -->
{{-- <div class="modal fade" id="#" aria-hidden="true">
    <di class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="formModalLabel">Create Todo</h4>
            </div>
            <div class="modal-body">
                <form id="myForm" name="myForm" class="form-horizontal" novalidate="">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter title"
                            value="">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" class="form-control" id="description" name="description"
                            placeholder="Enter Description" value="">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="btn-save" value="add">Save changes
                </button>
                <input type="hidden" id="todo_id" name="todo_id" value="0">
            </div>
        </div>
    </di>
</div>--}}
<!-- Pop Out Modal -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Historial</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content" style="background-color: #f0f2f5">
                    <p id="info"></p>
                    <!-- Timeline Modern Style -->
                    <h2 class="content-heading" id="info-heading"></h2>
                    <div class="block">
                        <div class="block-header block-header-default">
                            <h3 class="block-title"></h3>
                            {{-- <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option"
                                    data-action="fullscreen_toggle"></button>
                                <button type="button" class="btn-block-option" data-toggle="block-option"
                                    data-action="state_toggle" data-action-mode="demo">
                                    <i class="si si-refresh"></i>
                                </button>
                                <button type="button" class="btn-block-option" data-toggle="block-option"
                                    data-action="content_toggle"></button>
                            </div> --}}
                        </div>
                        <div class="block-content block-content-full">
                            <ul class="list list-timeline list-timeline-modern pull-t">
                                <li>
                                    <div class="list-timeline-time">50 min ago</div>
                                    <i class="list-timeline-icon si si-user-following bg-success"></i>
                                    <div class="list-timeline-content">
                                        <p class="font-w600" id="info-new-user"></p>
                                        <p></p>
                                    </div>
                                </li>

                                <li>
                                    <div class="list-timeline-time">5 days ago</div>
                                    <i class="list-timeline-icon si si-user-unfollow bg-danger"></i>
                                    <div class="list-timeline-content">
                                        <p class="font-w600" id="info-remove-user"></p>
                                        <p></p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- END Timeline Modern Style -->
                </div>
            </div>
            <div class="modal-footer" style="background-color: #f0f2f5">
                <button type="button" class="btn btn-alt-secondary" id="btn-save" value="add"
                    data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-alt-success" data-dismiss="modal">
                    <i class="fa fa-check"></i> Perfect
                </button>
                <input type="hidden" id="todo_id" name="todo_id" value="0">
            </div>
        </div>
    </div>
</div>
<!-- END Pop Out Modal -->
<!-- End Page Content -->
@endsection

@push('js')
<script src="{{ asset('/js/datatables/datatable.inventory.history.user.js') }}"></script>
<script src="{{ asset('/js/pages/be_tables_datatables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>

<script>
    let root_url_user_history = <?php echo json_encode(route('technicians.history')) ?>;
</script>

@if(Session::has('pc_created'))
<script>
    Swal.fire(
            'Creado con Exito!',
            '{!! Session::get('pc_created') !!}',
            'success'
            )
</script>
@endif

@if(Session::has('info_error'))
<script>
    Swal.fire(
            'Ha Ocurrido Un Error Al Crear El Equipo!',
            '{!! Session::get('info_error') !!}',
            'warning'
            )
</script>
@endif

@if(Session::has('pc_updated'))
<script>
    Swal.fire(
            'Actualizado con Exito!',
            '{!! Session::get('pc_updated') !!}',
            'success'
            )
</script>
@endif
@endpush