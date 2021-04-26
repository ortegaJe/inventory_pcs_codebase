

    function format(d) {
        return (
            '<div class="slider">' +
            '<table class="table-responsive" style="font-size:13">' +
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
            "<td>Codigo: " +
            d.CodigoInventario +
            "</td>" +
            "<td>" +
            "</td>" +
            "<td></td>" +
            "<td></td>" +
            "</td>" +
            "</tr>" +
            "<tr>" +
            "<td>" +
            '<img class="img-fluid no-gutters" width="160px" src="/media/dashboard/photos/M710q.png">' +
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
    
    /*function btnDelete($id) {
        console.log($id);
        //let id = $(this).attr("id");
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then(result => {
            if (result.isConfirmed) {
                $.ajax({
                    route: root_url_delete,
                    method: "post",
                    data: { $id: $id },
                    success: function (response) {
                        //alert(response);
                        $("#dt")
                            .DataTable()
                            .ajax.reload();
                    }
                });
                Swal.fire("Deleted!", "Your file has been deleted.", "success");
            }
        });
    }*/

    /*if (confirm("Are you sure you want to DELETE this data?")) {
        $.ajax({
            url: root_url_delete,
            type: "GET",
            data: {
                id: id
            },
            success: function(data) {
                alert(data);
                $("#dt")
                    .DataTable()
                    .ajax.reload();
            }
        });
    } else {
        return false;
    }*/

    function get_computer_data() {
    
	$.ajax({
        url: root_url,
        type:'GET',
    	data: { }
    }).done(function (data) {
        //alert(data.data);
        //table_data_row(data.data)
	});
    }

        $(document).ready(function () {
            let dt = $("#dt").DataTable({
                processing: true,
                serverSide: true,
                ajax: root_url,
                language: {
                    lengthMenu: "Mostrar _MENU_ registros",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    //info: "Mostrando página _PAGE_ de _PAGES_",
                    info: "Mostrando de _START_ a _END_ de _TOTAL_ entradas",
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
                        orderable: true
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
                        data: "Sede"
                    },
                    {
                        data: "EstadoPC",
                        visible: true,
                        orderable: true,
                        searchable: true
                        /*render: function (data, type, row) {
                             if (data === 'rendimiento óptimo') {
                                 console.log(data);
                                 return '' + row.data + '';
                            }else if (data === 'rendimiento bajo') {
                                 console.log(data);   
                                 return '' + row.data + '';
                             }
        
                        }*/
                    },
                    {
                        data: "action"
                    }
                ],
                order: [[1, "desc"]]
            });
    

            /*$("#dt tbody").on("click", "td .btn-delete", function() {
                //alert("Element clicked through function!");
                let id = $(this).attr("id");
                btnDelete(id);
                //console.log(id);
            });*/

            $(document).on('click', '#btn-delete', function (e) {
    console.log(e);
    //let id = $(this).attr('id');
        if(!confirm("Do you really want to do this?")) {
                return false;
        }

        event.preventDefault();
    let id = $(this).attr('data-id');
    console.log(id);

        $.ajax(
            {
            url: root_url_store+'/'+id,
            type: 'DELETE',
                data:
                {
                    _token: $('input[name="_token"]').val()
                },
            success: function (response){
                Swal.fire(
                'Remind!',
                'Company deleted successfully!',
                'success'
                )
                //console.log(id);
                $('data-id'+id).remove();
                 $("#dt").DataTable().ajax.reload();
                get_computer_data();
            }
        });
        return false;
});

            // Array to track the ids of the details displayed rows
            $("#dt tbody").on("click", "td.details-control", function () {
                var tr = $(this).closest("tr");
                var row = dt.row(tr);

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