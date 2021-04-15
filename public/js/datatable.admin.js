function format(d) {
    return (
        '<div class="slider">' +
        '<table table-responsive style="font-size:13">' +
        "<tr>" +
        "<td>Marca: " +
        '<span class="badge badge-pill badge-success">' +
        d.Marca +
        "</span>" +
        "<td>Memoria RAM(ranura 01): " +
        d.Ram0 +
        "</td>" +
        "<td>Memoria RAM(ranura 02): " +
        d.Ram1 +
        "</td>" +
        "<td>Disco Duro: " +
        d.HddPeso +
        "" +
        d.HddTipo +
        "</td>" +
        "<td>S/N monitor: " +
        d.SerialMonitor +
        "</td>" +
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
        '<img class="img-fluid" width="24px" src="https://cdn.svgporn.com/logos/microsoft-windows.svg" alt="windows">' +
        "</img>" +
        " " +
        d.Os +
        "</td>" +
        "<td>Ubicación: " +
        d.Ubicacion +
        "</td>" +
        "<td></td>" +
        "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>Tipo: " +
        d.TipoMaquina +
        "<td>Dirección IP: " +
        d.Ip +
        "</td>" +
        "<td>Direccion MAC: " +
        d.Mac +
        "</td>" +
        "<td></td>" +
        "<td></td>" +
        "</td>" +
        "</tr>" +
        "<tr>" +
        "<td>" +
        '<img class="img-fluid" width="160px" src="/media/dashboard/photos/M710q.png">' +
        "</img>" +
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

$(document).ready(function() {
    var dt = $("#dt").DataTable({
        processing: true,
        serverSide: true,
        ajax: root_url,
        language: {
            lengthMenu: "Display _MENU_ records per page",
            zeroRecords: "Registro no encontrado",
            info: "Showing page _PAGE_ of _PAGES_",
            infoEmpty: "No records available",
            infoFiltered: "(filtered from _MAX_ total records)",
            search: "Buscar"
        },
        columns: [
            {
                class: "details-control",
                orderable: false,
                data: null,
                defaultContent: ""
            },
            {
                data: "CodigoInventario"
            },
            {
                data: "Serial",
                visible: false
            },
            {
                data: "Ip"
            },
            {
                data: "Mac"
            },
            {
                data: "Anydesk"
                //visible: false
            },
            {
                data: "FechaCreacion"
            },
            {
                data: "Sede"
            },
            {
                data: "EstadoPC"
            },
            {
                data: "action"
            }
        ],
        order: [[1, "asc"]]
    });

    // Array to track the ids of the details displayed rows
    $("#dt tbody").on("click", "td.details-control", function() {
        var tr = $(this).closest("tr");
        var row = dt.row(tr);

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
