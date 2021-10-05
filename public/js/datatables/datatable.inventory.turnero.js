$(document).ready(function() {
    //getComputerData();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    function format(d) {
        return (
            '<div class="slider">' +
            '<table class="table-responsive td-slider" style="font-size:13">' +
            "<tr>" +
            "<td>Marca: " +
            '<span class="badge badge-pill badge-success">' +
            d.Marca +
            "</span>" +
            "<td>" +
            '<i class="fas fa-memory mr-2"></i>' +
            d.RanuraRamUno +
            "</td>" +
            "<td>" +
            '<i class="fas fa-memory mr-2"></i>' +
            d.RanuraRamDos +
            "</td>" +
            "<td>" +
            '<i class="fa fa-hdd mr-2"></i>' +
            d.PrimerUnidadAlmacenamiento +
            "</td>" +
            "<td>" +
            '<i class="fa fa-hdd mr-2"></i>' +
            d.SegundaUnidadAlmacenamiento +
            "</td>" +
            "<td>Número de serial monitor: " +
            d.SerialMonitor +
            "</td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "</tr>" +
            "<tr>" +
            "<td>Modelo: " +
            d.Modelo +
            "" +
            "<td>" +
            '<i class="fa fa-microchip fa-1x"></i>' +
            " " +
            d.Cpu +
            "</td>" +
            "<td>" +
            '<img class="img-fluid" width="24px" src="/media/dashboard/datatable/os/'+ d.IconoSistemaOperativo+'" alt="windows">' +
            "</img>" +
            " " +
            d.Os +
            "</td>" +
            "<td>Ubicación en la sede: " +
            d.Ubicacion +
            "</td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "</tr>" +
            "<tr>" +
            "<td>Tipo: " +
            d.TipoPc +
            "<td>Codigo de inventario: " +
            d.CodigoInventario +
            "</td>" +
            "<td>Nombre del equipo: " +
            d.NombreEquipo +
            "</td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "</tr>" +
            "<tr>" +
            "<td>" +
            '<i class="fa fa-ticket fa-4x text-gray-dark"></i>' +
            //'<img class="img-fluid no-gutters" width="160px" src="/media/dashboard/datatable/image_pc/'+ d.ImagenPc +'">' +
            //'<img class="img-fluid no-gutters" width="160px" src="'+ d.ImagenPc +'">' +
            "</img>" +
            "</td>" +
            "<td>Observaciones: " +
            "<p>"+d.Observacion +"</p>"+
            "</td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "</tr>" +
            "</table>" +
            "</div>"
        );
    }

    function getComputerData() {
        $.ajax({
            url: root_url,
            type: "GET",
            data: {}
        }).done(function(data) {
            //alert(data);
        });
    }

    $(document).ready(function() {
        let dt = $("#dt").DataTable({
            processing: true,
            serverSide: true,
            ajax: root_url_turnero,
            language: {
                lengthMenu: "Mostrar _MENU_ registros",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "Ningún dato disponible en esta tabla",
                //info: "Mostrando página _PAGE_ de _PAGES_",
                info: "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                infoEmpty:
                    "Mostrando registros del 0 al 0 de un total de 0 registros",
                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                search: "Buscar",
                loadingRecords: "Loading...",
                processing:
                    "<img src='/media/dashboard/datatable/load.gif' width='32px'> Procesando...",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Siguiente",
                    previous: "Atras"
                },
                error: {
                    system:
                        'Ha ocurrido un error en el sistema (<a target="\\" rel="\\ nofollow" href="\\">Más información&lt;\\/a&gt;).</a>'
                }
            },
            columns: [
                {
                    class: "details-control",
                    orderable: false,
                    data: null,
                    defaultContent: ""
                },
                {
                    data: "FechaCreacion",
                    visible: false,
                    orderable: false,
                    searchable: false
                },
                {
                    data: "NombreEquipo",
                    visible: false,
                    orderable: false,
                    searchable: true
                },
                {
                    data: "Ubicacion",
                    visible: false,
                    orderable: false,
                    searchable: true
                },
                {
                    data: "Serial",
                    visible: true,
                    searcheable: true
                },
                {
                    data: "ActivoFijo",
                    visible: true,
                    searcheable: true
                },
                {
                    data: "Ip",
                    searcheable: true
                },
                {
                    data: "Mac",
                    searcheable: true
                },
                {
                    data: "Anydesk",
                    searcheable: true
                    //visible: false
                },
                {
                    data: "Sede",
                    searcheable: true
                },
                {
                    data: "EstadoPC",
                    searcheable: true
                },
                {
                    data: "action",
                    searcheable: false,
                    orderable: false
                }
            ],
            order: [[1, "desc"]]
        });

        $(document).on("click", "#btn-delete", function(e) {
            //console.log(e);
            Swal.fire({
                title: "Estas seguro?",
                text: "No se podra revertir esto!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, borrar!",
                cancelButtonText: "No, cancelar"
            }).then(result => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    let id = $(this).attr("data-id");
                    //console.log(id);
                    $.ajax({
                        url: root_url_turnero_store + "/" + id,
                        type: "DELETE",
                        data: {
                            _token: $('input[name="_token"]').val()
                        },
                        success: function(response) {
                            console.log(
                                response.result[0]["inventory_code_number"]
                            );
                            let msg =
                                response.result[0]["inventory_code_number"];
                            Swal.fire(
                                `Numero de inventario #${msg}`,
                                response.message,
                                "success"
                            );
                            $("#dt")
                                .DataTable()
                                .ajax.reload();
                            //console.log(id);
                            //getComputerData();
                        }
                    });
                }
            });
            return false;
        });

        // Array to track the ids of the details displayed rows
        $("#dt tbody").on("click", "td.details-control", function() {
            let tr = $(this).closest("tr");
            let row = dt.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                $("div.slider", row.child()).slideUp(function() {
                    row.child.hide();
                    tr.removeClass("shown");
                });
            } else {
                // Open this row
                row.child(format(row.data()), "no-padding").show();
                tr.addClass("shown");

                $("div.slider", row.child()).slideDown();
            }
        });
    });
});
