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
                    <h3 class="block-title">INFORMACIÓN DEL EQUIPO</h3>
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
                    <div class="block">
                        <div class="block-content">
                            <p>
                                <span class="badge badge-pill badge-primary" id="hidecpu">
                                    <i class="fa fa-microchip"></i>
                                    <span class="badge badge-pill badge-primary" id="cpu" name="cpu"></span>
                                </span>
                                <span class="badge badge-pill badge-primary" id="hidehd0">
                                    <i class="fas fa-hdd"></i>
                                    <span class="badge badge-pill badge-primary" id="hdd01" name="hdd01"></span>
                                </span>
                                <span class="badge badge-pill badge-primary" id="hidehd1">
                                    <i class="fas fa-hdd"></i>
                                    <span class="badge badge-pill badge-primary" id="hdd02" name="hdd02"></span>
                                </span>
                                <span class="badge badge-pill badge-primary" id="hideram0">
                                    <i class="fas fa-memory"></i>
                                    <span class="badge badge-pill badge-primary" id="ram0" name="ram0"></span>
                                </span>
                                <span class="badge badge-pill badge-primary" id="hideram1">
                                    <i class="fas fa-memory"></i>
                                    <span class="badge badge-pill badge-primary" id="ram1" name="ram1"></span>
                                </span>
                                <span class="badge badge-pill badge-primary">
                                    <i class="fas fa-info"></i>
                                    <span class="badge badge-pill badge-primary pillcolor" id="device-statu"
                                        name="device-statu"></span>
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="content-heading">Red</div>
                    <div class="block">
                        <div class="block-content">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-material floating">
                                        <input type="text" class="form-control" disabled>Direccíon IP
                                        <label for="ip" id="ip" name="ip"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-material floating">
                                        <input type="text" class="form-control" disabled>Direccíon MAC
                                        <label for="mac" id="mac" name="mac"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-material floating">
                                        <input type="text" class="form-control" disabled>Anydesk
                                        <label for="anydesk" id="anydesk" name="anydesk"></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-material floating">
                                        <input type="text" class="form-control" disabled>Dominio
                                        <label for="domain_name" id="domain_name" name="domain_name"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    //LISTAR EQUIPOS
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

    //MODAL DE INFORMACION DEL EQUIPO
    $('#detail-modal').modal('hide');

    //MOSTRAR INFORMACION DEL EQUIPO EN MODAL
    $(document).on('click', '#detail-btn', function() {
        let id = $(this).attr('data-id');
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
                $('#type-device').text(data[0]["type_device"]);
                $('#model').text(data[0]["model"]);
                $('#brand').text(data[0]["brand"]);
                $('#serial_number').text(data[0]["serial_number"]);
                $('#monitor_serial_number').text(data[0]["monitor_serial_number"]);
                if (data[0]["ram0"] == "NO APLICA" || data[0]["ram0"] == "DISPONIBLE" || data[0]["ram0"] == "NO DISPONIBLE") {
                    document.getElementById('hideram0').style.display = 'none';
                }else {
                    $('#ram0').text(data[0]["ram0"]);
                }
                if (data[0]["ram1"] == "NO APLICA" || data[0]["ram1"] == "DISPONIBLE" || data[0]["ram1"] == "NO DISPONIBLE") {
                    document.getElementById('hideram1').style.display = 'none';
                }else {
                $('#ram1').text(data[0]["ram1"]);
                }                
                if (data[0]["hdd01"] == "NO APLICA" || data[0]["hdd01"] == "DISPONIBLE") {
                    document.getElementById('hidehd0').style.display = 'none';
                }else {
                    $('#hdd01').text(data[0]["hdd01"]);
                }                
                if (data[0]["hdd02"] == "NO APLICA" || data[0]["hdd02"] == "DISPONIBLE") {
                    document.getElementById('hidehd1').style.display = 'none';
                }else {
                    $('#hdd02').text(data[0]["hdd02"]);
                }
                $('#device-statu').text(data[0]["device_statu"]);
                $('#cpu').text(data[0]["cpu"]);
                $('#ip').text(data[0]["ip"] == null ? "NO REGISTRA" : data[0]["ip"]);
                $('#mac').text(data[0]["mac"] == null ? "NO REGISTRA" : data[0]["mac"]);
                $('#anydesk').text(data[0]["anydesk"] == null ? "NO REGISTRA" : data[0]["anydesk"]);
                $('#domain_name').text(data[0]["domain_name"]);
            }
        })
    });
</script>

@endpush