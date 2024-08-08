class UserCardManager 
{
    static createUserCard(campu, campuCount) {
        // Crear contenedor principal
        const colDiv = document.createElement('div');
        colDiv.classList.add('col-md-6', 'col-xl-3');
        //rowDiv.appendChild(colDiv);

        const blockDiv = document.createElement('div');
        blockDiv.classList.add('block', 'block-rounded', 'text-center');
        colDiv.appendChild(blockDiv);

        // Contenido principal del bloque
        const blockContentFullDiv = document.createElement('div');
        blockContentFullDiv.classList.add('block-content', 'block-content-full');
        blockDiv.appendChild(blockContentFullDiv);

        const icon = document.createElement('i');
        icon.classList.add('fa', 'fa-user', 'fa-4x', 'text-primary', 'mr-5');
        blockContentFullDiv.appendChild(icon);

        // Contenido con fondo claro
        const blockContentBgDiv = document.createElement('div');
        blockContentBgDiv.classList.add('block-content', 'block-content-full', 'block-content-sm', 'bg-body-light');
        blockDiv.appendChild(blockContentBgDiv);

        const nameDiv = document.createElement('div');
        nameDiv.classList.add('font-w600', 'mb-5');
        const name = campu.NombreCompletoTecnico.toUpperCase();
        nameDiv.textContent = name;
        blockContentBgDiv.appendChild(nameDiv);

        const roleDiv = document.createElement('div');
        roleDiv.classList.add('font-size-sm', 'text-muted');
        roleDiv.textContent = `${campu.CargoTecnico.toUpperCase()}`;
        blockContentBgDiv.appendChild(roleDiv);

        const campuCountSpan = document.createElement('span');
        campuCountSpan.classList.add('badge', 'badge-pill', 'badge-primary', 'ml-5');
        campuCountSpan.innerHTML = `<i class="fa fa-building-o mr-5"></i>${campuCount} Sedes`;
        blockContentBgDiv.appendChild(campuCountSpan);

        // Botones
        const blockContentActionsDiv = document.createElement('div');
        blockContentActionsDiv.classList.add('block-content', 'block-content-full');
        blockDiv.appendChild(blockContentActionsDiv);

        const removeBtn = document.createElement('a');
        removeBtn.classList.add('btn', 'btn-rounded', 'btn-alt-danger', 'mr-5');
        removeBtn.id = 'btn-remove';
        removeBtn.setAttribute('data-id', campu.UserID);
        removeBtn.href = 'javascript:void(0)';
        removeBtn.innerHTML = '<i class="fa fa-times mr-5"></i>Retirar';
        blockContentActionsDiv.appendChild(removeBtn);

        const profileButton = document.createElement('a');
        profileButton.classList.add('btn', 'btn-rounded', 'btn-alt-primary');
        profileButton.href = `/admin/dashboard/inventario/tecnicos/${campu.UserID}`;
        profileButton.innerHTML = '<i class="fa fa-user-circle mr-5"></i>Perfil';
        blockContentActionsDiv.appendChild(profileButton);

        return colDiv;
    }

    static createNoAssignedCard() {
        // Crear contenedor principal
        const colDiv = document.createElement('div');
        colDiv.classList.add('col-md-6', 'col-xl-3');
        //rowDiv.appendChild(colDiv);

        const blockDiv = document.createElement('div');
        blockDiv.classList.add('block', 'block-rounded', 'text-center');
        colDiv.appendChild(blockDiv);

        // Contenido principal del bloque
        const blockContentFullDiv = document.createElement('div');
        blockContentFullDiv.classList.add('block-content', 'block-content-full');
        blockDiv.appendChild(blockContentFullDiv);

        const icon = document.createElement('i');
        icon.classList.add('fa', 'fa-user', 'fa-4x', 'text-muted', 'mr-5');
        blockContentFullDiv.appendChild(icon);

        // Contenido con fondo claro
        const blockContentBgDiv = document.createElement('div');
        blockContentBgDiv.classList.add('block-content', 'block-content-full', 'block-content-sm', 'bg-body-light');
        blockDiv.appendChild(blockContentBgDiv);

        const noAssignDiv = document.createElement('div');
        noAssignDiv.classList.add('font-w600', 'mb-5');
        noAssignDiv.textContent = 'No Asignada';
        blockContentBgDiv.appendChild(noAssignDiv);

        // Botones
        const blockContentActionsDiv = document.createElement('div');
        blockContentActionsDiv.classList.add('block-content', 'block-content-full');
        blockDiv.appendChild(blockContentActionsDiv);

        const assignButton = document.createElement('a');
        assignButton.classList.add('btn', 'btn-rounded', 'btn-alt-primary');
        assignButton.href = 'javascript:void(0)';
        assignButton.setAttribute('data-toggle', 'modal');
        assignButton.setAttribute('data-target', '#modal-popout');
        assignButton.innerHTML = 'Asignar';
        blockContentActionsDiv.appendChild(assignButton);

        return colDiv;
    }

    static async fetchUserData() {
        try {
            const response = await fetch('/admin/dashboard/inventario/userCardCampu'); // URL a modificar según tu backend
            if (!response.ok) throw new Error('Network response was not ok.');
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Fetch error:', error);
        }
    }

    static async init() {
        const userData = await this.fetchUserData();
        const container = document.getElementById('colUserCard'); // ID del contenedor donde se insertarán los elementos

        container.innerHTML = ''; // Limpiar el contenedor
        let assignedUsersExist = false;

        if (userData.campuUser && userData.campuUser.length > 0) {
            userData.campuUser.forEach(campu => {
                if (campu.hasOwnProperty('NombreCompletoTecnico') && campu.NombreCompletoTecnico) {
                    assignedUsersExist = true;
                    const userCard = this.createUserCard(campu, userData.campuCount);
                    container.appendChild(userCard);
                }
            });
        }
        if (!assignedUsersExist) {
            const noAssignedCard = this.createNoAssignedCard();
            container.appendChild(noAssignedCard);
        }
    }
}

class removeUserCampu {
    static bindRemoveButtonEvent() {
        document.addEventListener('click', async (e) => {
            if (e.target && e.target.id === 'btn-remove') {
                e.preventDefault();
                const userId = e.target.getAttribute('data-id');
                const result = await Swal.fire({
                    title: "¿Estás seguro?",
                    text: "¡No se podrá revertir esto!",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: "btn btn-alt-danger m-1",
                        cancelButton: "btn btn-alt-secondary m-1"
                    },
                    confirmButtonText: "Sí, retirar!",
                    cancelButtonText: "No, cancelar"
                });

                if (result.value) {
                    await this.deleteUser(userId);
                    UserCardManager.init(); // Actualizar la lista de usuarios sin recargar la página
                }
            }
        });
    }

    static async deleteUser(userId) {
        try {
            const response = await fetch(`/admin/dashboard/inventario/removeUserCampu`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ userId })
            });

            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }

            const result = await response.json();
            const nameUser = result.result[0]["NombreCompletoTecnico"];
            const nameCampu = result.result[0]["NombreSede"];

            Swal.fire({
                title: `${nameUser}`,
                text: `${result.message} ${nameCampu}`,
                icon: "success",
                //showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-alt-success m-1",
                    //cancelButton: "btn btn-alt-secondary m-1"
                }
            });
            //Swal.fire(`${msg}`, result.message, "success");
        } catch (error) {
            console.error('Error:', error);
            Swal.fire('Error', error.message, 'error');
        }
    }

    static init() {
        this.bindRemoveButtonEvent();
    }
}

// Initialize when page loads
jQuery(() => {
    UserCardManager .init();
    removeUserCampu.init();
});