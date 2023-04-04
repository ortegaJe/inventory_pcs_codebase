class AlertActivity {
    static sweetAlert2() {
        
        let url = validate_sign;
        let signUser = route_sign_user;
        let signAdmin = route_sign_admin;
        let userId = user_id;

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
            data: {
                _token: $('input[name="_token"]').val()
            },
            success: function(response) {
                let modifiedArr = response.map(function(element) {
                    //return `sede: ${element.campus}, firmas admin: ${element.admin_sign}`

                    if (element.user_sign == null) {
                        return toast.fire({
                                    html: 'Por favor cargue su firma de su sedes asignadas para los <strong>reportes</strong>, de lo contrario no se podra generar los reportes.',
                                    footer: `<a href="${signUser}/${userId}"><strong>Ir a Perfil</strong><i class="fa fa-arrow-right ml-5"></i><strong> Mis Datos</strong></a>`,
                                });
                    }

                    if (element.admin_sign == null) {
                        return toast.fire({
                                    html: 'Por favor cargue la firmas de los <strong>administradores</strong> de su sedes asignadas para los <strong>reportes</strong>, de lo contrario no se podra generar los reportes.',
                                    footer: `<a href="${signAdmin}"><strong>Ir a Reportes</strong><i class="fa fa-arrow-right ml-5"></i><strong> Firmas</strong></a>`,
                                });
                    }
                });
                //console.log(modifiedArr);
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
