$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    function format(d) {
/*         return (
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
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "<td></td>" +
            "</tr>" +
            "</table>" +
            "</div>"
        ); */
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
            ajax: root_url_user_history,
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
            columns: [
                {
                    class: "details-control",
                    orderable: false,
                    data: null,
                    defaultContent: "",
                },
                {
                    data: "user_name",
                    visible: true,
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "user_name",
                    visible: true,
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "campu",
                    visible: true,
                    orderable: true,
                    searchable: true,
                },
                {
                    data: "department",
                    visible: true,
                    orderable: true,
                    searcheable: true,
                },
                {
                    data: "action",
                    visible: true,
                    searcheable: false,
                    orderable: false,
                },
            ],
            columnDefs: [{
                targets: -1,
                render: function (data, type, row, meta) {
                    return type === 'display' ? `<button type="button" class="btn btn-sm btn-danger btn-action" id="user_id" data-id="${row.user_id}">Retirar</button>` : ''
                }
            },
            {
                targets: 2,
                render: function (data, type, row, meta) {
                    return type === 'display' ? `<button type="button" class="btn btn-sm btn-alt-primary" id="btn-history" data-id="${row.user_id}" data-toggle="click-ripple">
                                                    <i class="fa fa-code-fork"></i>
                                                        </button>` : ''
                    }
                }
            ],
            order: [[1, "desc"]],
        });

        $('#dt tbody').on('click', '.btn-action', function () {
            var data = dt.row($(this).parents('tr')).data();
            console.log(data);
        alert(data.user_name + " fue retirado de la sede : " + data.campu);
        });
        
        $('#dt tbody').on('click', '#btn-histor', function () {
        $('#btn-save').val("add");
        $('#myForm').trigger("reset");
        $('#formModal').modal('show');
    });
    // CREATE
/*      $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });
        e.preventDefault();
        var formData = {
            title: jQuery('#title').val(),
            description: jQuery('#description').val(),
        };
        var state = jQuery('#btn-save').val();
        var type = "POST";
        var todo_id = jQuery('#todo_id').val();
        var ajaxurl = 'todo';
        $.ajax({
            type: type,
            url: ajaxurl,
            data: formData,
            dataType: 'json',
            success: function (data) {
                var todo = '<tr id="todo' + data.id + '"><td>' + data.id + '</td><td>' + data.title + '</td><td>' + data.description + '</td>';
                if (state == "add") {
                    jQuery('#todo-list').append(todo);
                } else {
                    jQuery("#todo" + todo_id).replaceWith(todo);
                }
                jQuery('#myForm').trigger("reset");
                jQuery('#formModal').modal('hide')
            },
            error: function (data) {
                console.log(data);
            }
        });
     }); */
        
        //SHOW
        $(document).on('click', '#btn-history', function (e) {
            e.preventDefault();
            let id = $(this).attr('data-id');
            console.log(id);
            $.ajax({
                url: `http://127.0.0.1:8000/admin/dashboard/inventario/historial-cambios/${id}`,
                type: 'GET',
                data: {
                    "id" : id
                },
                success: function (data) {
                    const listaContenedor = document.getElementById('lista');

                    function crearItem(data)
                    {
                        const item = document.createElement('li');

                        listaContenedor.appendChild(item);
                    }

                    data.forEach(crearItem);

/*                     console.log(`Nombre técnico: ${data[0].user_name}
                                Sede: ${data[0].campu}
                                Sede Principal: ${data[0].principal_campu}
                                Departamento: ${data[0].department}
                                Municipio: ${data[0].town}`                                      
                    ); */
                        
                    //$('#info-remove-user').html(`${data.user_name} ha sido retirado de la sede.`);
                    $('#formModal').modal("show");
                },
/*                 complete: function() {
                    $('#loader').hide();
                },*/
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    //alert("Page " + href + " cannot open. Error:" + error);
                    //$('#loader').hide();
                },
                timeout: 8000 
            })
        });

        $(document).on("click", "#btn-delete", function (e) {
            //console.log(e);
            Swal.fire({
                title: "Estas seguro?",
                text: "Se eliminara de la lista este equipo y sera enviado a la lista de eliminados!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, eliminar!",
                cancelButtonText: "No, cancelar",
            }).then((result) => {
                if (result.isConfirmed) {
                    event.preventDefault();
                    let id = $(this).attr("data-id");
                    //console.log(id);
                    $.ajax({
                        url: root_url_desktop_store + "/" + id,
                        type: "DELETE",
                        data: {
                            _token: $('input[name="_token"]').val(),
                        },
                        success: function (response) {
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
                            $("#dt").DataTable().ajax.reload(null, true);
                            $("#dt-deleted")
                                .DataTable()
                                .ajax.reload(null, true);
                        },
                    });
                }
            });
            return false;
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
