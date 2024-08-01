class UserCardManager 
{
    static createUserCard(campu, campuCount) {
        // Crear los elementos HTML para el usuario
        const py20Div = document.createElement('div');
        py20Div.classList.add('py-20', 'text-center');

        const mb20Div = document.createElement('div');
        mb20Div.classList.add('mb-20');
        py20Div.appendChild(mb20Div);

        const icon = document.createElement('i');
        icon.classList.add('si', 'si-user', 'fa-4x', 'text-primary');
        mb20Div.appendChild(icon);

        const nameDiv = document.createElement('div');
        nameDiv.classList.add('font-size-h4', 'font-w600');
        nameDiv.textContent = campu.NombreCompletoTecnico;
        py20Div.appendChild(nameDiv);

        const detailsDiv = document.createElement('div');
        detailsDiv.classList.add('text-muted');
        detailsDiv.innerHTML = `${campu.CargoTecnico.toUpperCase()} | <span class="badge badge-pill badge-primary"><i class="fa fa-building-o"></i> ${campuCount} Sedes</span>`;
        py20Div.appendChild(detailsDiv);

        const btnContainer = document.createElement('div');
        btnContainer.classList.add('pt-20');
        py20Div.appendChild(btnContainer);

        const removeBtn = document.createElement('a');
        removeBtn.classList.add('btn', 'btn-rounded', 'btn-alt-danger', 'btn-block', 'mr-5');
        removeBtn.id = 'btn-remove';
        removeBtn.setAttribute('data-id', campu.UserID);
        removeBtn.href = 'javascript:void(0)';
        removeBtn.innerHTML = '<i class="fa fa-times mr-5"></i> Retirar';
        btnContainer.appendChild(removeBtn);

        const viewProfileBtn = document.createElement('a');
        viewProfileBtn.classList.add('btn', 'btn-rounded', 'btn-alt-primary', 'btn-block');
        viewProfileBtn.href = `/admin/dashboard/inventario/tecnicos/${campu.UserID}`;
        viewProfileBtn.innerHTML = '<i class="fa fa-eye mr-5"></i> Ver Perfil';
        btnContainer.appendChild(viewProfileBtn);

        return py20Div;
    }

    static createNoAssignedCard() {
        // Crear los elementos HTML para la opción "No Asignada"
        const blockDiv = document.createElement('div');
        blockDiv.classList.add('block');

        const blockContentDiv = document.createElement('div');
        blockContentDiv.classList.add('block-content', 'block-content-full');
        blockDiv.appendChild(blockContentDiv);

        const py20Div = document.createElement('div');
        py20Div.classList.add('py-20', 'text-center');
        blockContentDiv.appendChild(py20Div);

        const mb20Div = document.createElement('div');
        mb20Div.classList.add('mb-20');
        py20Div.appendChild(mb20Div);

        const icon = document.createElement('i');
        icon.classList.add('si', 'si-user', 'fa-4x', 'text-primary');
        mb20Div.appendChild(icon);

        const noAssignDiv = document.createElement('div');
        noAssignDiv.classList.add('font-size-h4', 'font-w600');
        noAssignDiv.id = 'box';
        noAssignDiv.textContent = 'No Asignada';
        py20Div.appendChild(noAssignDiv);

        const btnContainer = document.createElement('div');
        btnContainer.classList.add('pt-20', 'mb-2');
        py20Div.appendChild(btnContainer);

        const assignBtn = document.createElement('a');
        assignBtn.classList.add('btn', 'btn-rounded', 'btn-alt-primary', 'btn-block');
        assignBtn.href = 'javascript:void(0)';
        assignBtn.setAttribute('data-toggle', 'modal');
        assignBtn.setAttribute('data-target', '#modal-popout');
        assignBtn.textContent = 'Asignar';
        btnContainer.appendChild(assignBtn);

        return blockDiv;
    }

    static async fetchUserData() {
        try {
            const response = await fetch('/admin/dashboard/inventario/UserCardManager'); // URL a modificar según tu backend
            if (!response.ok) throw new Error('Network response was not ok.');
            const data = await response.json();
            return data;
        } catch (error) {
            console.error('Fetch error:', error);
        }
    }

    static async init() {
        const userData = await this.fetchUserData();
        const container = document.getElementById('user-card'); // ID del contenedor donde se insertarán los elementos

        container.innerHTML = ''; // Limpiar el contenedor

        userData.campuUser.forEach(campu => {
            if (campu.hasOwnProperty('NombreCompletoTecnico')) {
                const userCard = this.createUserCard(campu, userData.campuCount);
                container.appendChild(userCard);
            } else {
                const noAssignedCard = this.createNoAssignedCard();
                console.log(container);
                container.appendChild(noAssignedCard);
            }
        });
    }
}

class removeUserCampu {
    static bindRemoveButtonEvent() {
        document.addEventListener('click', async (e) => {
            if (e.target && e.target.id === 'btn-remove') {
                e.preventDefault();
                const id = e.target.getAttribute('data-id');
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
                    await this.deleteUser(id);
                    UserCardManager.init(); // Actualizar la lista de usuarios sin recargar la página
                }
            }
        });
    }

    static async deleteUser(id) {
        try {
            const response = await fetch(`/admin/dashboard/inventario/removeUserCampu/${id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }

            const result = await response.json();
            const msg = result.result[0]["NombreCompletoTecnico"];
            Swal.fire(`Usuario ${msg}`, result.message, "success");
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