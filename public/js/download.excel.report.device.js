class AlertActivity {
    static sweetAlert2() {
        let getExportExcellDevice = url_export_excel_device;
        let getExportExcelAllDevice = url_export_excel_all_device;

        // Set default properties
        let toast = Swal.mixin({
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-alt-success m-5",
                cancelButton: "btn btn-alt-danger m-5",
                input: "form-control"
            }
        });

        // Init an example confirm alert on button click
        jQuery(".download-excel").on("click", e => {

            // Captura el valor del atributo "id" del elemento <p> dentro del div con la clase "campuName"
            const getCampuName = e.currentTarget.querySelector(".campuName .font-w600").getAttribute("id");
            const campuName = getCampuName.toUpperCase();

            toast
                .fire({
                    title:`${campuName}`,
                    text: `Deseas descargar el inventario de esta sede en un archivo Excel?`,
                    icon: "warning",
                    showCancelButton: true,
                    customClass: {
                        confirmButton: "btn btn-alt-success m-1",
                        cancelButton: "btn btn-alt-secondary m-1"
                    },
                    confirmButtonText: "Si, descargar!",
                    cancelButtonText: "Cancelar",
                    html: false,
                    timer: 10000,
                    timerProgressBar: true,
                    preConfirm: e => {

                        return new Promise(resolve => {
                            // Muestra el modal de carga
                            Swal.fire({
                                title: "Descargando...",
                                text: "Por favor, espera mientras se descarga el archivo.",
                                icon: "info",
                                allowOutsideClick: false,
                                onBeforeOpen: () => {
                                    Swal.showLoading();
                                }
                            })
                                setTimeout(() => {
                                    resolve();
                                }, 2000);
                        });
                    }
                })
                .then(result => {
                    if (result.value) {
                        // Captura el valor del atributo "id"
                        const campuId = e.currentTarget.getAttribute("id");

                        // Formateo el nombre de la sede reemplazando los espacios por underscore y colcamos el nombre del archivo excel.
                        const applyunderscore = campuName.replace(/\s/g, '_').toLowerCase();
                        const fileCampuName = `export_${applyunderscore}.xlsx`;

                        $.ajax({
                            url: getExportExcellDevice  + "/" + campuId,
                            type: "GET",
                            xhrFields: {
                                responseType: 'blob'
                            },
                            success: function (response) {
                                //console.log(response);
                                let blob = new Blob([response]);
                                let link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                link.download = fileCampuName;
                                link.click();
                                //window.URL.revokeObjectURL(url);

                                /// Cierra el modal de carga
                                Swal.close();

                                // Muestra el modal de éxito
                                 toast.fire(
                                    "Descargado con exito!",
                                    "El inventario en archivo Excel se descargo correctamente.",
                                    "success"
                                );
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log('Error: No se pudo exportar el archivo excel correctamente');
                                console.log('Error: ' + errorThrown);
                                console.log('Status: ' + textStatus);
                                console.log('Response: ' + jqXHR.responseText);

                                // Cierra el modal de carga en caso de error
                                Swal.close();

                                // Muestra el modal de error
                                toast.fire(
                                    "Error!",
                                    `Ocurrío un error en la descarga.</br>${errorThrown}</br>${jqXHR.responseText}`,
                                    "warning"
                                );
                            }
                        });
                        // result.dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                    } else if (result.dismiss === "cancelar") {
                        // Cierra el modal de carga si se cancela
                        Swal.close();

/*                         toast.fire(
                            "Cancelled",
                            "Your imaginary file is safe :)",
                            "error"
                        ); */
                    }
                });
        });

        jQuery(".download-all-excel").on("click", e => {

            //const userId = e.currentTarget.getAttribute("id");
            //console.log(userId);

            toast
                .fire({
                    title:``,
                    text: `Deseas descargar el inventario de todas tus sedes asignadas en un archivo Excel?`,
                    icon: "warning",
                    showCancelButton: true,
                    customClass: {
                        confirmButton: "btn btn-alt-success m-1",
                        cancelButton: "btn btn-alt-secondary m-1"
                    },
                    confirmButtonText: "Si, descargar!",
                    cancelButtonText: "Cancelar",
                    html: false,
                    timer: 10000,
                    timerProgressBar: true,
                    preConfirm: e => {

                        return new Promise(resolve => {
                            // Muestra el modal de carga
                            Swal.fire({
                                title: "Descargando...",
                                text: "Por favor, espera mientras se descarga el archivo.",
                                icon: "info",
                                allowOutsideClick: false,
                                onBeforeOpen: () => {
                                    Swal.showLoading();
                                }
                            })
                                setTimeout(() => {
                                    resolve();
                                }, 2000);
                        });
                    }
                })
                .then(result => {
                    if (result.value) {
                        // Captura el valor del atributo "id"
                        const userId = e.currentTarget.getAttribute("id");
                        //console.log(userId);

                        $.ajax({
                            url: getExportExcelAllDevice  + "/" + userId,
                            type: "GET",
                            xhrFields: {
                                responseType: 'blob'
                            },
                            success: function (response) {
                                //console.log(response);
                                let blob = new Blob([response]);
                                let link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                link.download = 'export_all_inventory_devices.xlsx';
                                link.click();
                                //window.URL.revokeObjectURL(url);

                                /// Cierra el modal de carga
                                Swal.close();

                                // Muestra el modal de éxito
                                 toast.fire(
                                    "Descargado con exito!",
                                    "El inventario en archivo Excel se descargo correctamente.",
                                    "success"
                                );
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log('Error: No se pudo exportar el archivo excel correctamente');
                                console.log('Error: ' + errorThrown);
                                console.log('Status: ' + textStatus);
                                console.log('Response: ' + jqXHR.responseText);

                                // Cierra el modal de carga en caso de error
                                Swal.close();

                                // Muestra el modal de error
                                toast.fire(
                                    "Error!",
                                    `Ocurrío un error en la descarga.</br>${errorThrown}</br>${jqXHR.responseText}`,
                                    "warning"
                                );
                            }
                        });
                        // result.dismiss can be 'overlay', 'cancel', 'close', 'esc', 'timer'
                    } else if (result.dismiss === "cancelar") {
                        // Cierra el modal de carga si se cancela
                        Swal.close();

/*                         toast.fire(
                            "Cancelled",
                            "Your imaginary file is safe :)",
                            "error"
                        ); */
                    }
                });
        });
    }

    static init() {
        this.sweetAlert2();
    }
}

jQuery(() => {
    AlertActivity.init();
});
