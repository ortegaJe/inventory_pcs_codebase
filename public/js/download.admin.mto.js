function showMultiSelect() {
    // Función para obtener las opciones de las sedes y los años
    async function getOptions() {
        try {
            const response = await fetch("/admin/dashboard/inventario/mto/getCampus");
            if (!response.ok) {
                throw new Error(`Network response was not ok: ${response.status}`);
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error("Fetch error:", error);
            return { campus: [], years: [] }; // Devolver un objeto vacío en caso de error
        }
    }

    // Función para mostrar el SweetAlert con los tres select
    async function showSweetAlert() {
        try {
            const {campus, years } = await getOptions();

            const campusOptions = campus.map(option => `<option value="${option.id}">${option.name}</option>`).join("");
            const yearsOptions = years.map(option => `<option value="${option.year}">${option.year}</option>`).join("");

            const html = `
                <select class="swal2-select" id="campus">${campusOptions}</select>
                <select class="swal2-select" id="years">${yearsOptions}</select>
            `;

            const { value: selection } = await Swal.fire({
                title: "Selecciona Sede y Año",
                html: html,
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-alt-success m-1",
                    cancelButton: "btn btn-alt-secondary m-1"
                },
                confirmButtonText: "Descargar",
                cancelButtonText: "Cancelar",
                preConfirm: () => {
                    const campusElement = document.getElementById("campus");
                    const campus = campusElement.value;
                    const campusName = campusElement.options[campusElement.selectedIndex].text;
                    const year = document.getElementById("years").value;
                    return { campusName, campus, year };
                }
            });

            if (selection) {
                // Muestra el SweetAlert de carga
                Swal.fire({
                    title: "Descargando...",
                    text: "Por favor, espera mientras se descarga el archivo.",
                    icon: "warning",
                    allowOutsideClick: false,
                    showCancelButton: false,
                    onBeforeOpen: () => {
                        Swal.showLoading();
                    }
                });

                downloadMtoBy(selection.campusName, selection.campus, selection.year);
            }
            
        } catch (error) {
            console.error("Error:", error);
            // Manejar el error si es necesario
        }
    }

    showSweetAlert();

    async function downloadMtoBy(campusName, campus, year) {
        //console.log('id sede:',campus,'año:'year);
        try {
            const response = await fetch("/admin/dashboard/inventario/mto/mtoDownload", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                },
                body: JSON.stringify({ campus, year })
            });

            if (response.status === 404) {
                throw new Error("No se encontró información de mantenimientos para esta sede");
            }

            if (response.status === 500) {
                throw new Error("Error al procesar la solicitud");
            }
            
            if (!response.ok) {
                //throw new Error(`HTTP error! Status: ${response.status} Error en la solicitud AJAX`);
                const errorData = await response.json();
                throw new Error(errorData.message || "Error en la solicitud AJAX");
            }

            // Cierra el SweetAlert de carga
            Swal.close();

            // Muestra el SweetAlert de éxito
            Swal.fire({
                title: "Descargado con éxito!",
                text: "El archivo PDF se descargó correctamente.",
                icon: "success",
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-alt-success m-1"
                }
            });
            
            const blob = await response.blob();
            const url = window.URL.createObjectURL(blob);
            const link = document.createElement("a");
            link.href = url;

            const d = new Date();
            const date = d.getDate() + '' + (d.getMonth() + 1) + '' + d.getFullYear();

            const underscore = campusName.replaceAll(' ', '_');
            const campuName = underscore.toLowerCase();

            const fileName = `export_mto_${year}_${campuName}_${date}`;
            link.download = `${fileName}.pdf`;
            link.click();

        } catch (error) {
            console.error("Error:", error);
            // Cierra el SweetAlert de carga
            Swal.close();
            Swal.fire("Aviso", error.message, "error");
        }
    }
}