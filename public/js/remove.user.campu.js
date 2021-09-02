$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

        $(document).on("click", "#btn-remove", function(e) {
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
                        url: root_url_remove_user_campu,
                        type: "DELETE",
                        data: {
                            _token: $('input[name="_token"]').val()
                        },
                        success: function(response) {
                            console.log(
                                response.result[0]["NombreSede", "NombreCompletoTecnico"]
                            );
                            let msg = response.result[0]["NombreCompletoTecnico"];
                            Swal.fire(
                                `Usuario ${msg}`,
                                response.message,
                                "success"
                            );

                            location.reload();
                            //window.location.href = root_url_user_campu;
                        }
                    });
                }
                else {
                    Swal.fire({
                        title: "The database was not changed",
                        icon: "info"
                    });
                }
                                            //window.setTimeout(function(){ } ,6000);
                                //location.reload();
            });
            return false;
        });
    
});