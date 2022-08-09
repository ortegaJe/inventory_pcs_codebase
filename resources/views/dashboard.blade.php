@extends('layouts.backend')

@section('title', 'Dashboard')

@section('content')
<div class="block block-rounded">
    <div class="block-content block-content-full bg-pattern"
        style="background-image: url('{{ asset('/media/various/bg-pattern-inverse.png') }}');">
        <div class="py-20 text-center">
            <h2 class="font-w500 text-black mb-10">
                Busqueda por Serial de Equipo
            </h2>
        </div>
    </div>
</div>

<div id="search_list"></div>
<!-- Pop Out Modal -->
<div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-labelledby="modal-popout" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title" id="product-title"></h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="si si-close"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-material floating">
                                <input type="text" class="form-control" disabled>Tipo de equipo
                                <label for="type-device" id="type-device" name="type-device"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-material floating">
                                <input type="text" class="form-control" disabled>Marca
                                <label for="brand" id="brand" name="brand"></label>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-material floating">
                                <input type="text" class="form-control" disabled>Modelo
                                <label for="model" id="model" name="model"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-material floating">
                                <input type="text" class="form-control" disabled>Serial
                                <label for="serial_number" id="serial_number" name="serial_number"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-material floating">
                                <input type="text" class="form-control" disabled>Serial monitor
                                <label for="monitor_serial_number" id="monitor_serial_number"
                                    name="monitor_serial_number"></label>
                            </div>
                        </div>
                    </div>
                    <div class="content-heading">Hardware</div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-material floating">
                                <input type="text" class="form-control" disabled>Memoria RAM #1
                                <label for="ram0" id="ram0" name="ram0"></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-material floating">
                                <input type="text" class="form-control" disabled>Memoria RAM #2
                                <label for="ram1" id="ram1" name="ram1"></label>
                            </div>
                        </div>
                    </div>
                    <div class="content-heading">Red</div>
                    <div class="content-heading">Ubicación</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-alt-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-alt-success" data-dismiss="modal">
                    <i class="fa fa-check"></i> Perfect
                </button>
            </div>
        </div>
    </div>
</div>
<!-- END Pop Out Modal -->
@endsection

@push('js')

<script>
    $(document).ready(function() {
        $('#search').keyup(function() {
            if ($(this).val().length > 1) {
                let query = $(this).val();
                $.ajax({
                    url: '{{ route('search.serial') }}',
                    type: "GET",
                    data: {
                        'search': query
                    },
                    success: function(data) {
                        $('#search_list').html(data);
                    }
                });
            } else {
                $('#search_list').html('')
            }
        });
    });

    $('#detail-modal').modal('hide');

    $(document).on("click", "#detail-btn", function() {
        let id = $(this).attr("data-id");
        let url = '{{ route("device.detail", ":id") }}';
        url = url.replace(':id', id);
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                "id": id
            },
            success: function(data) {
                console.log(data);
                $('#product-title').html("INFORMACIÓN DEL EQUIPO: " + data[0]["serial_number"]);
                $('#type-device').text(data[0]["type_device"]);
                $('#model').text(data[0]["model"]);
                $('#brand').text(data[0]["brand"]);
                $('#serial_number').text(data[0]["serial_number"]);
                $('#monitor_serial_number').text(data[0]["monitor_serial_number"]);
                $('#ram0').text(data[0]["ram0"]);
                $('#ram1').text(data[0]["ram1"]);
            }
        })
    });
</script>

@endpush