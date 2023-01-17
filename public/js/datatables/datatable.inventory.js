$(document).ready(function () {
    //getComputerData();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    function format(d) {
        //let url = '{{ route("admin.inventory.technicians.show", ":id") }}';
        //url = url.replace(':id', d.TecnicoID);

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
            '<img class="img-fluid" width="24px" src="/media/dashboard/datatable/os/' +
            d.IconoSistemaOperativo +
            '" alt="windows">' +
            "</img>" +
            " " +
            d.Os +
            "</td>" +
            "<td>Ubicación en la sede: " +
            d.Ubicacion +
            "</td>" +
            //"<td>Número de serial: " +
            //d.Serial +
            //"</td>" +
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
            "</tr>" +
            "<tr>" +
            "<td>" +
            '<i class="si si-screen-desktop fa-4x text-gray-dark"></i>' +
            //'<img class="img-fluid no-gutters" width="160px" src="/media/dashboard/datatable/image_pc/'+ d.ImagenPc +'">' +
            //'<img class="img-fluid no-gutters" width="160px" src="'+ d.ImagenPc +'">' +
            "</img>" +
            "</td>" +
            "<td>Observaciones: " +
            "<p>" +
            d.Observacion +
            "</p>" +
            "</td>" +
            "<td>" +
            "<div>Registrado por:</div>" +
            '<span class="badge badge-primary mb-5"><i class="si si-user mr-5"></i>' +
            d.NombreTecnico +
            "</span>" +
            "<div>Hora del registro:</div>" +
            '<span class="badge badge-primary"><i class="si si-clock mr-5"></i>' +
            d.FechaCreacionUsuario +
            "</span>" +
            "</td>" +
            "<td>" +
            "<div>Asignando a:</div>" +
            d.NombreCustodio +
            "<div>Acta de entrega:</div>" +
            '<a type="button" class="btn btn-alt-danger js-tooltip-enabled" data-toggle="tooltip" data-placement="left" title="" target="_blanck" href="http://inventory.viva1a.com.co/storage/' +
            d.file_path +
            '" data-original-title="Descargar Inventario">' +
            '<i class="fa fa-file-pdf-o" aria-hidden="true"></i>' +
            "</a>" +
            "</td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "</tr>" +
            "</table>" +
            "</div>"
        );
    }

    $(document).ready(function () {
        let dt = $("#dt").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            aLengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Todos"],
            ],
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
                    previous: "Atras",
                },
                error: {
                    system: 'Ha ocurrido un error en el sistema (<a target="\\" rel="\\ nofollow" href="\\">Más información&lt;\\/a&gt;).</a>',
                },
            },
            initComplete: function () {
                this.api()
                    .columns([10])
                    .every(function () {
                        let column = this;
                        let select = $(
                            '<select class="form-control"><option id="result0" value=""></option></select>'
                        )
                            .appendTo($(column.footer()).empty())
                            .on("change", function () {
                                let val = $.fn.dataTable.util.escapeRegex(
                                    $(this).val()
                                );

                                column
                                    .search(
                                        val ? "^" + val + "$" : "",
                                        true,
                                        false
                                    )
                                    .draw();
                            });

                        column
                            .data()
                            .unique()
                            .sort()
                            .each(function (d, j) {
                                select.append(
                                    `<option id="result" value="${d}">${d}</option>`
                                );
                            });

                        console.log(document.getElementById("result"));
                    });
            },
            columnDefs: [
                {
                    render: function (data, type, row) {
                        if (type === "display") {
                            return `<span class="badge badge-pill ${row.ColorEstado} btn-block">
                                        ${row.EstadoPc}
                                    </span>`;
                        }

                        return data;
                    },
                    targets: 10,
                    visible: true,
                },
            ],
            columns: [
                {
                    class: "details-control",
                    orderable: false,
                    data: null,
                    defaultContent: "",
                },
                {
                    data: "FechaCreacion",
                    visible: false,
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "NombreEquipo",
                    visible: false,
                    orderable: false,
                    searchable: true,
                },
                {
                    data: "Ubicacion",
                    visible: false,
                    orderable: false,
                    searchable: true,
                },
                {
                    data: "Serial",
                    visible: true,
                    searcheable: true,
                },
                {
                    data: "ActivoFijo",
                    visible: true,
                    searcheable: true,
                },
                {
                    data: "Ip",
                    searcheable: true,
                },
                {
                    data: "Mac",
                    searcheable: true,
                },
                {
                    data: "Anydesk",
                    searcheable: true,
                },
                {
                    data: "Sede",
                    searcheable: true,
                },
                {
                    data: "EstadoPC",
                    searcheable: true,
                },
            ],
            order: [[1, "desc"]],
        });

        // Array to track the ids of the details displayed rows
        $("#dt tbody").on("click", "td.details-control", function () {
            let tr = $(this).closest("tr");
            let row = dt.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                $("div.slider", row.child()).slideUp(function () {
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
