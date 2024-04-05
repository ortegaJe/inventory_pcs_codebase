class ListDevicesSelect {

    static RedirectToCategory() {
        function getCategoryOptions() {
            return {
                1: "ALL IN ONE",
                2: "DE ESCRITORIOS",
                3: "MINI PC SAT",
                4: "PORTATILES",
                5: "RASPBERRY",
                6: "TABLETS",
                7: "TELEFONOS IP",
                8: "ATRILES"
            };
        }
    
        function showCategoryModal() {
            return Swal.fire({
                title: "Categorias de Equipos",
                input: "select",
                icon: "question",
                showCancelButton: true,
                buttonsStyling: false,
                customClass: {
                    confirmButton: "btn btn-alt-success m-1",
                    cancelButton: "btn btn-alt-secondary m-1"
                },
                confirmButtonText: "Go!",
                cancelButtonText: "Cancel",
                inputPlaceholder: "Selecciona categoría",
                inputOptions: getCategoryOptions(),
                html: false,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        resolve(value ? undefined : "Seleccione una opción válida :)");
                    });
                },
            });
        }
    
        function getUrlCategory(url) {
            return fetch(url, {
                method: "GET",
                headers: {
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.url;
            });
        }
    
        function redirectToCategory(selectedValue) {
            if (!selectedValue) {
                Swal.close();
                return;
            }
    
            const originalCategory = getCategoryOptions()[selectedValue];
            const categorySlug = originalCategory.toLowerCase().replace(/\s+/g, '-');
            const url = `/tecnico/dashboard/inventario/${categorySlug}/registrar`;
    
            Swal.fire({
                title: "Redireccionando...",
                text: "Por favor, espera mientras es redirigido a la categoría seleccionada.",
                icon: "info",
                allowOutsideClick: false,
                onBeforeOpen: () => {
                    Swal.showLoading();
                }
            });
    
            getUrlCategory(url)
                .then(urlCategory => {
                    // Batch DOM operations
                    const href = window.location.href;
                    window.location.href = urlCategory;
                    if (href === window.location.href) {
                        // Close modal if the page did not change
                        Swal.close();
                    }
                })
                .catch(error => {
                    console.error('Error al redirigir a la categoría:', error);
                    Swal.close();
                    Swal.fire(
                        "Error!",
                        `Ocurrió un error al redirigir a la categoría.</br>${error}`,
                        "warning"
                    );
                });
        }
    
        jQuery("#btnSelectCategory").on("click", () => {
            showCategoryModal()
                .then(result => redirectToCategory(result.value));
        });
    }
     

    /*
     * Init functionality
     *
     */
    static init() {
        this.RedirectToCategory();
    }
}

// Initialize when page loads
jQuery(() => {
    ListDevicesSelect.init();
});
