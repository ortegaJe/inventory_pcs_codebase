/*
 *  Document   : be_ui_icons.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Icons Page
 */

class BeUIIcons {
    /*
     * Icon Search functionality
     *
     */
    static iconSearch() {
        let searchItems = jQuery(".js-icon-list");
        let searchItems_ = jQuery(".js-icon-list > div");
        let searchValue = "",
            el;

        // Disable form submission
        jQuery(".js-form-icon-search").on("submit", () => false);

        // When user types
        jQuery(".js-icon-search").on("keyup", e => {
            searchValue = jQuery(e.currentTarget)
                .val()
                .toLowerCase();

            if (searchValue.length > 2) {
                // If more than 2 characters, search the icons
                searchItems.hide();

                jQuery("code", searchItems).each((index, element) => {
                    el = jQuery(element);

                    if (el.text().match(searchValue)) {
                        el.parent("div").fadeIn(250);
                    }
                });
            } else if (searchValue.length === 0) {
                // If text was deleted, show all icons
                searchItems.show();
            }
        });
    }

    static filterByRegional() {
        let getAllCampu = url_all_campus;
        let urlGetAllCampu = getAllCampu.replace(/\\/g, "/");
        let getRegionalUrl = campu_by_regional;
        let urlRegional = getRegionalUrl.replace(/\\/g, "/");
        let getShowCampus = index_campus;

        // Cargar sedes al cargar la página
        fetch(urlGetAllCampu)
        .then(response => response.json())
        .then(data => {

            // Función para cargar y mostrar las sedes
            function displaySedes(data) {
                sedeList.innerHTML = "";

                data.forEach(sede => {
                    const sedeElement = document.createElement("div");
                    sedeElement.classList.add("col-md-6", "col-xl-4", "sedes");

                    const a = document.createElement("a");
                    a.classList.add("block", "block-bordered", "block-rounded", "block-link-pop", "text-center");
                    a.href = `${getShowCampus}/${sede.campu_id}`;
                    sedeElement.appendChild(a);

                    const div01 = document.createElement("div");
                    div01.classList.add("block-content", "text-center");
                    a.appendChild(div01);

                    const div02 = document.createElement("div");
                    div02.classList.add(
                        "item",
                        "item-circle",
                        "bg-primary-lighter",
                        "text-primary",
                        "mx-auto",
                        "my-10"
                    );
                    div01.appendChild(div02);

                    const i = document.createElement("i");
                    i.classList.add("fa", "fa-building-o");
                    div02.appendChild(i);

                    const div03 = document.createElement("div");
                    div03.classList.add("block-content", "bg-body-light");
                    a.appendChild(div03);

                    const p = document.createElement("p");
                    p.classList.add("font-w600", "font-size-xs");
                    p.textContent = sede.campu_name;
                    div03.appendChild(p);

                    if (sede.new_campu === "Nuevo") {
                        const span = document.createElement("span");
                        span.classList.add(
                            "badge",
                            "badge-pill",
                            "badge-primary",
                            "ml-2"
                        );
                        span.textContent = sede.new_campu;
                        p.appendChild(span);
                    }

                    sedeList.appendChild(sedeElement);
                });

                // Actualizar la lista de búsqueda después de mostrar las sedes
                searchItems = document.querySelectorAll(".sedes");
            }

            // Actualizar sedes cuando se selecciona una regional o se realiza una búsqueda
            function updateSedes() {
                const selectedRegional = regionalSelect.value;
                let url = selectedRegional === "0" ? urlGetAllCampu : `${urlRegional}/${selectedRegional}`;

                fetch(url)
                    .then(response => response.json())
                    .then(data => {
                        displaySedes(data);
                        document.querySelector(".js-icon-search").value = "";
                    })
                    .catch(error => {
                        console.error("Error al obtener los datos de las sedes: " + error);
                    });
            }

            // Evento al cambiar la regional
            regionalSelect.addEventListener("change", updateSedes);
    
            // Disable form submission
            jQuery(".js-form-icon-search").on("submit", () => false);
    
            // Cuando el usuario escribe en el campo de búsqueda
            // Evento al buscar sedes
            jQuery(".js-icon-search").on("keyup", function (e) {
                const searchValue = jQuery(e.currentTarget).val().toLowerCase();

                if (searchValue.length > 2) {
                    // Si hay más de 2 caracteres, buscar las sedes por nombre
                    searchItems.forEach(item => {
                        const sedeName = item.querySelector(".font-w600").textContent.toLowerCase();
                        item.style.display = sedeName.includes(searchValue) ? "block" : "none";
                    });
                } else {
                    // Si no hay suficientes caracteres, mostrar todas las sedes
                    searchItems.forEach(item => {
                        item.style.display = "block";
                    });
                }
            });
    
            // Cargar sedes al cargar la página
            const sedeList = document.getElementById("sedeList");
            let searchItems = document.querySelectorAll(".sedes");

            fetch(urlGetAllCampu)
                .then(response => response.json())
                .then(data => {
                    displaySedes(data);
                })
                .catch(error => {
                    console.error("Error al cargar las sedes: " + error);
                });
        })
        .catch(error => {
            console.error("Error al cargar las sedes: " + error);
        });
    }

    static downloadCampuByRegional() {

        // Función para obtener las opciones del select
        function getRegionalOptions() {
            return {
                //id hardcoreados desde la base de datos cambiar que consulte en la db
                0: "Todas",
                4: "Antioquia",
                5: "Costa",
                1: "Bogotá",
                6: "Manizales",
                2: "Tolima",
                3: "Valle del Cauca"
            };
        }

        // Función para mostrar el modal de descarga
        function showDownloadModal() {
            return Swal.fire({
                title: "Descargar sede por regionales Excel",
                input: "select",
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-alt-success m-1",
                    cancelButton: "btn btn-alt-secondary m-1"
                },
                confirmButtonText: "Descargar",
                cancelButtonText: "Cancelar",
                inputPlaceholder: "Seleccione regional",
                inputOptions: getRegionalOptions(),
                html: false,
                preConfirm: (selectedValue) => {
                    return new Promise(resolve => {
                        // Muestra el modal de carga
                        Swal.fire({
                            title: "Descargando...",
                            text: "Por favor, espera mientras se descarga el archivo.",
                            icon: "warning",
                            allowOutsideClick: false,
                            onBeforeOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        setTimeout(() => {
                            resolve(selectedValue);
                        }, 2000);
                    });
                }
            })
        }

        // Función para descargar el archivo usando fetch
        function downloadFile(selectedValue) {
            let exportCampuByRegional    = export_campus_by_regional;
            let exportAllCampuByRegional = export_all_campus_by_regional;
            let url = selectedValue.value !== "0" ? `${exportCampuByRegional}/${selectedValue.value}` : exportAllCampuByRegional;

            return fetch(url, {
                method: "GET",
                headers: {
                    'Content-Type': 'application/json',
                    // Puedes agregar otras cabeceras si es necesario
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.blob();
            })
            .then(blob => {
                let link = document.createElement('a');
                const getRegionName = `${getRegionalOptions()[selectedValue.value]}`;
                const regionName = getRegionName.toLowerCase();
                link.href = window.URL.createObjectURL(blob);
                link.download = `export_regional_${regionName}.xlsx`;
                link.click();
                // Cierra el modal de carga
                Swal.close();
            })
            .catch(error => {
                console.error('Error al descargar el archivo:', error);
                // Cierra el modal de carga en caso de error
                Swal.close();
                // Muestra el modal de error
                Swal.fire(
                    "Error!",
                    `Ocurrió un error en la descarga.</br>${error}`,
                    "warning"
                );
            });
        }

        // Init an example confirm alert on button click
        jQuery(".downloadCampuByRegion").on("click", () => {
            showDownloadModal()
                .then(selectedValue => {
                    if (selectedValue.value !== undefined) {
                        //console.log(selectedValue);
                        // Muestra el modal de éxito
                        Swal.fire(
                            "Descargado con éxito!",
                            "El archivo Excel se descargó correctamente.",
                            "success"
                        );
                        return downloadFile(selectedValue);
                    } else {
                        // Cierra el modal de carga si se cancela
                        Swal.close();
                        // También puedes manejar la cancelación aquí si es necesario
                    }
                });
        });

    }

    /*
     * Init functionality
     *
     */
    static init() {
        //this.iconSearch();
        this.downloadCampuByRegional();
        this.filterByRegional();
    }
}

// Initialize when page loads
jQuery(() => {
    BeUIIcons.init();
});
