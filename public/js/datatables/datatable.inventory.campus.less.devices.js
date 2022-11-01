$(document).ready(function () {
    //getComputerData();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    $(document).ready(function () {
        let dt = $("#dt").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 5,
            aLengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "Todos"],
            ],
            ajax: root_url,
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
            columnDefs: [
                {
                    render: function (data, type, row) {
                        if (type === "display") {
                            return `<span class="badge badge-pill ${row.color} btn-block">
                                        ${row.numero_equipos}
                                    </span>`;
                        }

                        return data;
                    },
                    targets: 3,
                    visible: true,
                },
                {
                    render: function (data, type, row) {
                        if (row.user_id === null) {
                            return `<span class="disabled">${row.nombre_tecnico}</span>`;
                        }
                        if (type === "display") {
                            return `<a href ="${root_url_show}/${row.user_id}">${row.nombre_tecnico}</a>`;
                        }

                        return data;
                    },
                    targets: 0,
                    visible: true,
                },
            ],
            columns: [
                {
                    data: "nombre_tecnico",
                    visible: true,
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "telefono",
                    visible: false,
                    searchable: true,
                    orderable: false,
                },
                {
                    data: "nombre_sede",
                    visible: true,
                    orderable: false,
                    searchable: true,
                },
                {
                    data: "numero_equipos",
                    visible: true,
                    orderable: true,
                    searcheable: false,
                },
            ],
            order: [[3, "asc"]],
        });
    });
});
