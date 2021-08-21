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
            "<td>Memoria RAM(ranura 01): " +
            d.RanuraRamUno +
            "</td>" +
            "<td>Memoria RAM(ranura 02): " +
            d.RanuraRamDos +
            "</td>" +
            "<td>Primer almacenamiento: " +            
            d.PrimerUnidadAlmacenamiento +
            '<i class="fa fa-hdd-o fa-1x"></i>' +
            "</td>" +
            "<td>Segundo almacenamiento: " +            
            d.SegundaUnidadAlmacenamiento +
            '<i class="fa fa-hdd-o fa-1x"></i>' +
            "</td>" +
            "<td>Número de serial monitor: " +
            d.SerialMonitor +
            "</td>" +
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
            "<td>Ubicación: " +
            d.Ubicacion +
            "</td>" +
            //"<td>Número de serial: " +
            //d.Serial +
            //"</td>" +
            "<td></td>" +
            "<td></td>" +
            "</tr>" +
            "<tr>" +
            "<td>Tipo: " +
            d.TipoPc +
            "<td>Codigo: " +
            d.CodigoInventario +
            "</td>" +
            "<td>Nombre del equipo: " +
            d.NombreEquipo +
            "</td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "</td>" +
            "</tr>" +
            "<tr>" +
            "<td>" +
            '<i class="si si-screen-desktop fa-4x text-gray-dark"></i>' +
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
            "</tr>" +
            "</table>" +
            "</div>"
        );
    }

    $(document).ready(function() {
        let dt = $("#dt").DataTable({
            processing: true,
            serverSide: true,
            ajax: root_url_dashboard,
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
                    data: "Serial",
                    visible: true,
                    searcheable: true
                },
                {
                    data: "ActivoFijo",
                    visible: false,
                    searcheable: false
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
                }
            ],
            order: [[1, "desc"]]
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
