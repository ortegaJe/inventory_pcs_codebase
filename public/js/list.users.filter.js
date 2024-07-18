class BeUIUsers {

    static iconSearch() {
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

    static async getUsers(url) {
        try {
            let response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            return await response.json();
        } catch (error) {
            Swal.fire({
                title: "Error",
                text: `Error al cargar los datos de los usuarios: ${error.message}`,
                icon: "error",
                confirmButtonText: "OK",
            });
            return []; // Retorna un array vacío en caso de error
        }
    }

    static async fetchUsersByRegional(url) {
        try {
            let response = await fetch(url);
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            return await response.json();
        } catch (error) {
            Swal.fire({
                title: "Error",
                text: `Error al obtener los datos de las sedes: ${error.message}`,
                icon: "error",
                confirmButtonText: "OK",
            });
            return []; // Retorna un array vacío en caso de error
        }
    }

    static async displayUsers(data) {
        const userList = document.getElementById("userList");
        userList.innerHTML = "";

        data.forEach(user => {
            //console.log(user);

            const element = document.createElement("div");
            element.classList.add("col-md-6", "col-xl-4", "users");

            const a = document.createElement("a");
            a.classList.add("block", "block-bordered", "block-rounded", "block-link-pop", "text-center");
            a.href = `/admin/dashboard/inventario/tecnicos/${user.id}`;
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
            i.classList.add("fa", "fa-user");
            div02.appendChild(i);

            const div03 = document.createElement("div");
            div03.classList.add("block-content", "bg-body-light");
            a.appendChild(div03);

            const p = document.createElement("p");
            p.classList.add("font-w600", "font-size-xs");
            const name = user.name.charAt(0).toUpperCase() + user.name.slice(1);
            const lastName = user.last_name.charAt(0).toUpperCase() + user.last_name.slice(1);
            const userName = name +' '+ lastName;
            p.textContent = userName;
            div03.appendChild(p);

            if (user.new_user === "Nuevo") {
                const span = document.createElement("span");
                span.classList.add(
                    "badge",
                    "badge-pill",
                    "badge-primary",
                    "ml-2"
                );
                span.textContent = user.new_user;
                p.appendChild(span);
            }

            userList.appendChild(element);
        });

        // Actualizar la lista de búsqueda después de mostrar las sedes
        BeUIUsers.searchItems = document.querySelectorAll(".users");
        // Actualizar el contador de usuarios
        BeUIUsers.updateUserCount(data.length);
    }

    static updateUserCount(count) {
        const userCountBadge = document.getElementById("userCount");
            userCountBadge.textContent = count;
    }

    static async updateUsers() {
        const regionalSelect = document.getElementById("regionalSelect");
        const selectedRegional = regionalSelect.value;
        let url = selectedRegional === "0" 
            ? '/admin/dashboard/inventario/getUsers'
            : `/admin/dashboard/inventario/users-by-regional/${selectedRegional}`;

        let data = await BeUIUsers.fetchUsersByRegional(url);
        await BeUIUsers.displayUsers(data);
        document.querySelector(".js-icon-search").value = "";

        if (selectedRegional === "0") {
            document.getElementById("userCount").style.display = "none";
        } else {
            const id = document.getElementById("userCount");
            
            const i = document.createElement("i");
            i.classList.add("fa", "fa-users", "ml-2");

            id.appendChild(i);
            id.style.display = "inline-block";
        }
    }

    static async filterByRegional() {
        let urlAllCampu = '/admin/dashboard/inventario/getUsers';
        let urlRegional = '/users-by-regional/'; // Suponiendo esta ruta para regionales

        // Cargar sedes al cargar la página
        let data = await BeUIUsers.getUsers(urlAllCampu);
        await BeUIUsers.displayUsers(data);

        // Evento al cambiar la regional
        const regionalSelect = document.getElementById("regionalSelect");
        regionalSelect.addEventListener("change", BeUIUsers.updateUsers);

        // Disable form submission
        jQuery(".js-form-icon-search").on("submit", () => false);

        // Cuando el usuario escribe en el campo de búsqueda
        // Evento al buscar sedes
        jQuery(".js-icon-search").on("keyup", function (e) {
            const searchValue = jQuery(e.currentTarget).val().toLowerCase();
            const searchItems = document.querySelectorAll(".users");

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

    static init() {
        this.filterByRegional();
    }
}

// Initialize when page loads
jQuery(() => {
    BeUIUsers.init();
});