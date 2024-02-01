class AlertValidateCalendarMto {
  
    static showAlert() {
        const url = `/dashboard/inventario/reportes/validate-calendar-mto`;

        function hasPagination() {
          const urlParams = new URLSearchParams(window.location.search);
          return urlParams.has('page');
      }

        // Set default properties
        let toast = Swal.mixin({
            icon: "warning",
            title: "Importante",
            confirmButtonText: "Entendido",
            heightAuto: true,
            buttonsStyling: false,
            customClass: {
                confirmButton: "btn btn-alt-success m-5"
                //cancelButton: 'btn btn-alt-danger m-5',
                //input: 'form-control'
            }
        });

        fetch(url, {
            method: "GET"
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error(
                        `Network response was not ok: ${response.status}`
                    );
                }
                return response.json();
            })
            .then(data => {
                // Validar si la respuesta contiene la información necesaria
                /*                 const sedes = data.map(campus => {
                  console.log(campus.name);
                });
                if (!Array.isArray(data) || data.length === 0) {
                    toast.fire({
                      icon: 'info',
                      title: 'Información',
                      text: `No hay datos de mantenimiento para la sede X disponibles para mostrar.`
                      });
                    // Salir de la función si no hay datos
                    return;
                } */

                // Manejar la respuesta exitosa
                //console.log(data);

                const traductions = {
                    January: "Enero",
                    February: "Febrero",
                    March: "Marzo",
                    April: "Abril",
                    May: "Mayo",
                    June: "Junio",
                    July: "Julio",
                    August: "Agosto",
                    September: "Septiembre",
                    October: "Octubre",
                    November: "Noviembre",
                    December: "Diciembre"
                };

                // Mensaje principal
                const mainMessage = `<div style="text-align: justify;">
                                    Queremos recordarles la importancia de programar y llevar a cabo el mantenimiento regular
                                    de nuestros equipos informáticos para garantizar su óptimo rendimiento y seguridad.
                                    Como parte de nuestras prácticas estándar, el mantenimiento de los equipos se realiza en meses
                                    específicos a lo largo del año, uno por cada semestre o dependiendo del caso de cada sede.
                                    </br></br>
                                    Queremos resaltar la relevancia de seguir este calendario para evitar posibles inconvenientes y
                                    mantener la eficiencia operativa de nuestros sistemas.
                                    </br></br>
                                    Por favor, revisar el calendario de mantenimiento adjunto y programar las fechas de mantenimiento pendientes.
                                    </br></br>
                                    Los mantenimientos programados para sus sedes son en los meses:
                                  </div></br>`;

                const campusList = data
                    .map(campus => {
                        const mto01MoName = traductions[campus.mto01MoName] || campus.mto01MoName;
                        const mto02MoName = traductions[campus.mto02MoName] || campus.mto02MoName;
                        const badgeClass = campus.statuMto === 0
                                            ? "badge-danger"
                                            : "badge-success";
                                    const haveMto = `<table class="table table-borderless d-flex justify-content-between font-w600">
                                                        <tbody>
                                                            <tr>
                                                                <td scope="row">${campus.name}</td>
                                                                <td>
                                                                    ${campus.statuMto === 0
                                                                        ? `<span class="badge badge-pill ${badgeClass}">No programado</span>`
                                                                        : `<span class="badge badge-pill ${badgeClass}">${mto01MoName}</span> 
                                                                            <span class="badge badge-pill ${badgeClass}">${mto02MoName}</span>`
                                                                        }
                                                                    </span>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>`;

                        return haveMto;
                    })
                    .join("");

                const finalMessage = `${mainMessage} ${campusList}`;

              if (!hasPagination() && window.location.pathname === '/dashboard/inventario/reportes/mantenimientos') {
                toast.fire({
                    html: finalMessage
                });
            }

          }).catch(error => {
            // Manejar errores de red o errores en el servidor
            if (error.message.includes('No calendar maintenances records found')) {
                toast.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'No se encontraron registros de mantenimiento para esta sede.'
                });
            }
            console.error('Fetch error:', error);
          });
    }

    static init() {
        this.showAlert();
    }
}

jQuery(() => {
    AlertValidateCalendarMto.init();
    // Ejecutar la función solo en la página principal
});
