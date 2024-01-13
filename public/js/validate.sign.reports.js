class AlertActivity {
    static sweetAlert2() {
        
        let url = validate_sign;
        let signUser = route_sign_user;
        let signAdmin = route_sign_admin;
        let userId = user_id;
        let currentroute = currentRoute;

        // Set default properties
        let toast = Swal.mixin({
            icon: 'warning',
            title: 'Oops... Sin firmas para los Reportes.',
            //confirmButtonText: 'Ok',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-alt-success m-5',
                cancelButton: 'btn btn-alt-danger m-5',
                input: 'form-control'
            }
        });

        $.ajax({
            url: url,
            type: "GET",
            success: function(response) {
                $(document).on("click", ".btn-campu-id", function(e) {
                    const campuId = this.id;

                    let collect = response.map(function(element) {

                        if (campuId == element.campu_id && element.admin_sign == null) {
                            e.preventDefault();
                            
                            return toast.fire({
                                        html: `Por favor cargue la firma del <strong>administrador de la sede ${element.campus}</strong> para los <strong>reportes</strong>, de lo contrario no se podra generar los reportes.`,
                                        footer: `<a href="${signAdmin}"><strong>Ir a Reportes</strong><i class="fa fa-arrow-right ml-5"></i><strong> Firmas</strong></a>`,
                                        buttonsStyling: false,
                                        showConfirmButton: false,
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                    });
                        }
                    });
                    //alert(this.id);
                });           
            }
        });
    }

    static init() {
        this.sweetAlert2();
    }
}

jQuery(() => {
    AlertActivity.init();
});
