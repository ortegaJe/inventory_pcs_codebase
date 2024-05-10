function showMultiSelect() {
    // Función para obtener las opciones de las sedes
    function getCampus() {
        const url = "/dashboard/inventario/reportes/mto/getCampus";

        return fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error(
                        `Network response was not ok: ${response.status}`
                    );
                }
                return response.json();
            })
            .catch(error => {
                console.error("Fetch error:", error);
                return []; // Return an empty array or handle the error accordingly
            });
    }

    // Función para mostrar el SweetAlert con los tres select
    function showSweetAlert() {
        getCampus()
            .then(campusOptions => {
                console.log(campusOptions);

                const dataCampus = campusOptions.campus;
                const dataYears = campusOptions.years;
                // Obtener las opciones de sedes y luego mostrar el SweetAlert
                const html = `
                <select id="campus">
                    ${dataCampus
                        .map(
                            option =>
                                `<option value="${option.id}">${option.name}</option>`
                        )
                        .join("")}
                </select>
                <select id="years">
                    ${dataYears
                        .map(
                            option =>
                                `<option value="${option.year}">${option.year}</option>`
                        )
                        .join("")}
                </select>
            `;
                Swal.fire({
                    title: "Selecciona Sede y Año",
                    html: html,
                    showCancelButton: true,
                    confirmButtonText: "Enviar",
                    cancelButtonText: "Cancelar",
                    preConfirm: () => {
                        const campus = document.getElementById("campus").value;
                        const year = document.getElementById("years").value;
                        //const semester = document.getElementById('semesters').value;
                        // Enviar los valores seleccionados al controlador de Laravel utilizando fetch y una solicitud POST
                        enviarDatosAlControlador(campus, year);
                    }
                });
            })
            .catch(error => {
                console.error("Error:", error);
                // Manejar el error si es necesario
            });
    }

    showSweetAlert();

    function enviarDatosAlControlador(campus, year) {
        // Hacer una solicitud AJAX al controlador de Laravel
        const url = "/dashboard/inventario/reportes/mto/mtoDownload";

        fetch(url, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                campus: campus,
                year: year
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error en la solicitud AJAX");
                }
                return response.blob();
            })
            .then(blob => {
                console.log("Respuesta del servidor:", blob);
                let link = document.createElement("a");
                //const campuName = campus.value;
                //console.log(getRegionName);
                //const regionName = getRegionName.toLowerCase();
                link.href = window.URL.createObjectURL(blob);
                link.download = `export_mto.pdf`;
                link.click();
            })
            .catch(error => {
                console.error("Error:", error);
            });
    }
}
