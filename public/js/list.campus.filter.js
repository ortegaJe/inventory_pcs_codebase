class BeUICampus {

    static titleSearch() {
        let searchItems = jQuery(".js-icon-list");
        let searchValue = "";

        // Disable form submission
        jQuery(".js-form-icon-search").on("submit", () => false);

        // When user types
        jQuery(".js-icon-search").on("keyup", e => {
            searchValue = jQuery(e.currentTarget).val().toLowerCase();

            if (searchValue.length > 2) {
                // If more than 2 characters, search the icons
                searchItems.hide();

                jQuery("code", searchItems).each((index, element) => {
                    let el = jQuery(element);

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

    static async getCampus(url) {
        try {
            let response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            return await response.json();
        } catch (error) {
            Swal.fire({
                title: "Error",
                text: `Error al cargar los datos de las sedes: ${error.message}`,
                icon: "error",
                confirmButtonText: "OK",
            });
            return []; // Retorna un array vacío en caso de error
        }
    }

    static async fetchUCampusByRegional(url) {
        try {
            let response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            return await response.json();
        } catch (error) {
            Swal.fire({
                title: "Error",
                text: `Error al obtener los datos de las regionales de sedes: ${error.message}`,
                icon: "error",
                confirmButtonText: "OK",
            });
            return []; // Retorna un array vacío en caso de error
        }
    }

    static async displayCampus(data) {
        const userList = document.getElementById("campuList");
        userList.innerHTML = "";

        data.forEach(campu => {
            //console.log(campu);

            const element = document.createElement("div");
            element.classList.add("col-md-6", "col-xl-4", "campus");

            const a = document.createElement("a");
            a.classList.add("block", "block-bordered", "block-rounded", "block-link-pop", "text-center");
            a.href = `/admin/dashboard/inventario/sedes/${campu.campu_id}`;
            element.appendChild(a);

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
            p.textContent = campu.campu_name;
            div03.appendChild(p);

            if (campu.new_campu === "Nuevo") {
                const span = document.createElement("span");
                span.classList.add(
                    "badge",
                    "badge-pill",
                    "badge-primary",
                    "ml-2"
                );
                span.textContent = campu.new_campu;
                p.appendChild(span);
            }

            userList.appendChild(element);
        });

        // Actualizar la lista de búsqueda después de mostrar las sedes
        BeUICampus.searchItems = document.querySelectorAll(".campus");
        // Actualizar el contador de usuarios
        BeUICampus.updateUserCount(data.length);
    }

    static updateUserCount(count) {
        const campuCountBadge = document.getElementById("campuCount");
            campuCountBadge.textContent = count;
    }

    static async updateUsers() {
        const regionalSelect = document.getElementById("regionalSelect");
        const selectedRegional = regionalSelect.value;
        let url = selectedRegional === "0" 
            ? '/admin/dashboard/inventario/getCampus'
            : `/admin/dashboard/inventario/campus-by-regional/${selectedRegional}`;

        let data = await BeUICampus.fetchUCampusByRegional(url);
        await BeUICampus.displayCampus(data);
        document.querySelector(".js-icon-search").value = "";

        if (selectedRegional === "0") {
            document.getElementById("campuCount").style.display = "none";
        } else {
            const id = document.getElementById("campuCount");
            
            const i = document.createElement("i");
            i.classList.add("fa", "fa-building-o", "ml-2");

            id.appendChild(i);
            id.style.display = "inline-block";
        }
    }

    static async filterByRegional() {
        let urlAllCampu = '/admin/dashboard/inventario/getCampus';
        let urlRegional = '/users-by-regional/'; // Suponiendo esta ruta para regionales

        // Cargar sedes al cargar la página
        let data = await BeUICampus.getCampus(urlAllCampu);
        await BeUICampus.displayCampus(data);

        // Evento al cambiar la regional
        const regionalSelect = document.getElementById("regionalSelect");
        regionalSelect.addEventListener("change", BeUICampus.updateUsers);

        // Disable form submission
        jQuery(".js-form-icon-search").on("submit", () => false);

        // Cuando el usuario escribe en el campo de búsqueda
        // Evento al buscar sedes
        jQuery(".js-icon-search").on("keyup", function (e) {
            const searchValue = jQuery(e.currentTarget).val().toLowerCase();
            const searchItems = document.querySelectorAll(".campus");

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
    }

    // Función para obtener las opciones de las regionales
    static async getRegionalOptions() {
        try {
            const response = await fetch("/admin/dashboard/inventario/getRegionals");
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            const data = await response.json();
            return data;
        } catch (error) {
            Swal.fire({
                title: "Error",
                text: `Error al cargar los datos de las regionales: ${error.message}`,
                icon: "error",
                confirmButtonText: "OK",
            });
            return ""; // Retorna un string vacío en caso de error
        }
    }

    // Función para mostrar el SweetAlert para regionales
    static async showRegionalSweetAlert() {
        try {
            const { regionals }  = await BeUICampus.getRegionalOptions();
            //console.log(regionals);

            const regionalOptions = regionals.map(region => `<option value="${region.id}">${region.name}</option>`).join("");

            const html = `<select class="swal2-select" id="regionalList">${regionalOptions}</select>`;

            const { value: selection } = await Swal.fire({
                title: "Selecciona Regional",
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
                    const regionalElement = document.getElementById("regionalList");
                    const regional = regionalElement.value;
                    const regionalName = regionalElement.options[regionalElement.selectedIndex].text;
                    //console.log('data:', regionalElement, regional, regionalName);
                    return { regionalName, regional };
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

                if (selection.regional === "0") {
                    BeUICampus.downloadAllCampu();
                } else {
                    BeUICampus.downloadByRegional(selection.regionalName, selection.regional);
                }
            }

        } catch (error) {
            console.error("Error:", error);
            // Manejar el error si es necesario
        }
    }

    static async downloadByRegional(regionalName, regional) {
        
        try {
            const response = await fetch("/admin/dashboard/inventario/exportCampuByRegional", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                body: JSON.stringify({ regional })
            });

            if (response.status === 404) {
                throw new Error("No se encontró información para esta regional");
            }

            if (response.status === 500) {
                throw new Error("Error al procesar la solicitud");
            }
            
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || "Error en la solicitud AJAX");
            }

            // Cierra el SweetAlert de carga
            Swal.close();

            // Muestra el SweetAlert de éxito
            Swal.fire({
                title: "Descargado con éxito!",
                text: "El archivo Excel se descargó correctamente.",
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

            const underscore = regionalName.replaceAll(' ', '_');
            const regionalNameFormatted = underscore.toLowerCase();

            const fileName = `export_sedes_regionales_${regionalNameFormatted}_${date}`;
            link.download = `${fileName}.xlsx`;
            link.click();

        } catch (error) {
            console.error("Error:", error);
            // Cierra el SweetAlert de carga
            Swal.close();
            Swal.fire("Aviso", error.message, "error");
        }
    }

    static async downloadAllCampu() {
        try {
            const response = await fetch(`/admin/dashboard/inventario/exportAllCampuByRegional`, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                }
            });

            if (response.status === 404) {
                throw new Error("No se encontró información de todas las regionales");
            }

            if (response.status === 500) {
                throw new Error("Error al procesar la solicitud");
            }

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || "Error en la solicitud AJAX");
            }

            // Cierra el SweetAlert de carga
            Swal.close();

            // Muestra el SweetAlert de éxito
            Swal.fire({
                title: "Descargado con éxito!",
                text: "El archivo Excel se descargó correctamente.",
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

            const fileName = `export_all_campus_regional_${date}`;
            link.download = `${fileName}.xlsx`;
            link.click();

        } catch (error) {
            console.error("Error:", error);
            // Cierra el SweetAlert de carga
            Swal.close();
            Swal.fire("Aviso", error.message, "error");
        }
    }

    // Función para inicializar la descarga por regional
    static  downloadCampuByRegional() {
        jQuery(".downloadCampuByRegion").on("click", BeUICampus.showRegionalSweetAlert);
    }

    /*
     * Init functionality
     *
     */
    static init() {
        this.downloadCampuByRegional();
        this.filterByRegional();
    }
}

// Initialize when page loads
jQuery(() => {
    BeUICampus.init();
});
