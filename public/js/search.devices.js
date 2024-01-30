class BeUIDevices {
    static SearchDevicesBySerialNumber() {

        const url = "/search-devices";
        const deviceList = document.getElementById("deviceList");
        let searchItems = document.querySelectorAll(".devices");

        // Función para cargar y mostrar las equipos
        function displayDevices(data) {

            deviceList.innerHTML = "";

            data.forEach(device => {
                const deviceElement = document.createElement("div");
                deviceElement.classList.add("col-md-6", "col-xl-2", "devices");

                const div01 = document.createElement("div");
                div01.classList.add(
                                    "block",
                                    "block-rounded", 
                                    "ribbon",
                                    "ribbon-modern",
                                    "ribbon-primary",
                                    "text-center"
                                    );
                deviceElement.appendChild(div01);

                const div02 = document.createElement("div");
                div02.classList.add("ribbon-box");
                div02.textContent = device.brand
                div01.appendChild(div02);

                const div03 = document.createElement("div");
                div03.classList.add("block-content", "block-content-full");
                div01.appendChild(div03);

                const div04 = document.createElement("div");
                div04.classList.add(
                                    "item",
                                    "item-circle",
                                    "bg-primary-lighter",
                                    "text-primary",
                                    "mx-auto",
                                    "my-20"
                                    );
                div03.appendChild(div04);

                const i = document.createElement("i");
                i.classList.add("si", "si-screen-desktop");
                div04.appendChild(i);

                const div05 = document.createElement("div");
                div05.classList.add("font-w600");
                div05.textContent = device.type
                div03.appendChild(div05);

                const div06 = document.createElement("div");
                div06.classList.add(
                                    "block-content",
                                    "block-content-full",
                                    "block-content-sm",
                                    "bg-body-light"
                                    );
                div01.appendChild(div06);

                const div07 = document.createElement("div");
                div07.classList.add("font-w600", "mb-2", "serial");
                div07.textContent = device.serial_number
                div06.appendChild(div07);

                const div08 = document.createElement("div");
                div08.classList.add("font-size-sm", "text-muted");
                div08.textContent = device.campu
                div06.appendChild(div08);

                const div09 = document.createElement("div");
                div09.classList.add("font-size-sm", "text-muted");
                div09.textContent = `Registrado: ${device.date_created}`
                div06.appendChild(div09);

                const div10 = document.createElement("div");
                div10.classList.add("block-content", "block-content-full");
                div01.appendChild(div10);

                const statusColors = {
                    "rendimiento óptimo": "badge-success",
                    "rendimiento bajo": "badge-warning",
                    "hurtado": "badge-warning",
                    "eliminado": "badge-danger",
                    "dado de bajo": "badge-secondary",
                    "averiado": "badge-warning",
                    "retirado": "badge-secondary",
                    "reparado": "badge-primary",
                };

                const span = document.createElement("span");
                span.classList.add("badge", "badge-pill");
                const status = device.status.toLowerCase();
                const color = statusColors[status] || "badge-secondary";
                span.classList.add(color);
                span.textContent = device.status
                div10.appendChild(span);

                deviceList.appendChild(deviceElement);

                // Ocultar todos los equipos al cargar la página
                deviceElement.style.display = "none";

            });

        }

        // Cargar equipos al cargar la página
        fetch(url)
            .then(response => response.json())
            .then(data => {
                //console.log(data);
                displayDevices(data);
            })
            .catch(error => {
                console.error("Error al cargar los equipos: " + error);
            });

        // Cuando el usuario escribe en el campo de búsqueda
        // Evento al buscar equipos
        jQuery(".js-icon-search").on("keyup", function(e) {
            const searchValue = jQuery(e.currentTarget)
                .val()
                .toLowerCase();

                searchItems = document.querySelectorAll(".devices");

                if (searchValue.length > 2) {
                    let foundDevice = false; // Variable para rastrear si se encontró algún dispositivo
            
                    // Si hay más de 2 caracteres, buscar los equipos por número de serie
                    searchItems.forEach(item => {
                        const SerialNumber = item
                            .querySelector(".serial")
                            .textContent.toLowerCase();
            
                        if (SerialNumber.includes(searchValue)) {
                            item.style.display = "block";
                            foundDevice = true; // Se encontró al menos un dispositivo
                        } else {
                            item.style.display = "none";
                        }
                    });
            
                     // Mostrar el mensaje "Serial no encontrado" si no se encontraron dispositivos
                    const noDeviceMessage = deviceList.querySelector(".no-device-message");
                    if (!foundDevice && !noDeviceMessage) {
                        const noDeviceMessage = document.createElement("div");
                        noDeviceMessage.classList.add("col-md-12","no-device-message"); // Agregar una clase para identificar el mensaje
                        
                        const div01 = document.createElement("div");
                        div01.classList.add("alert", "alert-info", "alert-dismissable");
                        noDeviceMessage.appendChild(div01);

                        const h3 = document.createElement("h3");
                        h3.classList.add("alert-heading", "font-size-h4", "font-w400");
                        h3.textContent = "Número de Serial no encontrado :(";
                        div01.appendChild(h3);

                        const p = document.createElement("p");
                        p.classList.add("mb-0");
                        div01.appendChild(p);

                        deviceList.appendChild(noDeviceMessage);
                    } else if (foundDevice && noDeviceMessage) {
                        noDeviceMessage.remove(); // Eliminar el mensaje si se encontraron dispositivos y el mensaje estaba presente
                    }
                } else {
                    // Si no se ha ingresado suficientes caracteres, ocultar todos los equipos y el mensaje
                    searchItems.forEach(item => {
                        item.style.display = "none";
                    });
                    // Eliminar el mensaje "Serial no encontrado" si estaba presente
                    const noDeviceMessage = deviceList.querySelector(".no-device-message");
                    if (noDeviceMessage) {
                        noDeviceMessage.remove();
                    }
                }
        });
    }

    /*
     * Init functionality
     *
     */
    static init() {
        this.SearchDevicesBySerialNumber();
    }
}

// Initialize when page loads
jQuery(() => {
    BeUIDevices.init();
});
