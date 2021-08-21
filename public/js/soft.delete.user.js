$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
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
                        url: root_url_user_store + "/" + id,
                        type: "DELETE",
                        data: {
                            _token: $('input[name="_token"]').val()
                        },
                        success: function(response) {
                            console.log(
                                response.result[0]["name", "last_name"]
                            );
                            let msg =
                                response.result[0]["name", "last_name"];
                            Swal.fire(
                                `Usuario #${msg}`,
                                response.message,
                                "success"
                            );
                             window.location.href = root_url_user_index;
                        }
                    });
                }
            });
            return false;
        });
    
});