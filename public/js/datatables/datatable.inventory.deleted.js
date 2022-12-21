$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    let table = $("#dt-deleted");
    table
        .DataTable({
            processing: true,
            info: true,
            ajax: root_url_get_list_devices,
            pageLength: 5,
            aLengthMenu: [
                [5, 10, 25, 50, -1],
                [5, 10, 25, 50, "All"],
            ],
            columns: [
                // {data:'id', name:'id'},
                {
                    data: "checkbox",
                    name: "checkbox",
                    orderable: false,
                    searchable: false,
                },
                { data: "serial_number", name: "serial_number" },
                { data: "campu", name: "campu" },
                {
                    data: "is_deleted",
                    name: "is_deleted",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "actions",
                    name: "actions",
                    orderable: false,
                    searchable: false,
                },
            ],
        })
        .on("draw", function () {
            $('input[name="device_checkbox"]').each(function () {
                this.checked = false;
            });
            $('input[name="main_checkbox"]').prop("checked", false);
            $("button#deleteAllBtn").addClass("d-none");
        });

    $(document).on("click", 'input[name="main_checkbox"]', function () {
        if (this.checked) {
            $('input[name="device_checkbox"]').each(function () {
                this.checked = true;
            });
        } else {
            $('input[name="device_checkbox"]').each(function () {
                this.checked = false;
            });
        }
        toggledeleteAllBtn();
    });

    $(document).on("change", 'input[name="device_checkbox"]', function () {
        if (
            $('input[name="device_checkbox"]').length ==
            $('input[name="device_checkbox"]:checked').length
        ) {
            $('input[name="main_checkbox"]').prop("checked", true);
        } else {
            $('input[name="main_checkbox"]').prop("checked", false);
        }
        toggledeleteAllBtn();
    });

    function toggledeleteAllBtn() {
        if ($('input[name="device_checkbox"]:checked').length > 1) {
            $("button#deleteAllBtn")
                .text(
                    "Restaurar (" +
                        $('input[name="device_checkbox"]:checked').length +
                        ")"
                )
                .removeClass("d-none");
        } else {
            $("button#deleteAllBtn").addClass("d-none");
        }
    }

    //RESTORE RECORD
    $(document).on("click", "#restore_device_btn", function () {
        let device_id = $(this).data("id");
        let url = root_url_retore_device;

        swal.fire({
            title: "¿Estas seguro?",
            html: "¿Quieres restaurar este equipo?",
            showCancelButton: true,
            showCloseButton: true,
            icon: "info",
            cancelButtonText: "Cancel",
            confirmButtonText: "Si, Restaurar",
            cancelButtonColor: "#d33",
            confirmButtonColor: "#3085d6",
            width: 400,
            allowOutsideClick: false,
        }).then(function (result) {
            if (result.value) {
                $.post(
                    url,
                    { device_id: device_id },
                    function (data) {
                        if (data.code == 1) {
                            table.DataTable().ajax.reload(null, false);
                            $("#dt").DataTable().ajax.reload(null, true);
                            console.log(data.result);
                        } else {
                            console.error(data.msg);
                        }
                    },
                    "json"
                );
            }
        });
    });

    //RESTORE SELECTED RECORDS
    $(document).on("click", "button#deleteAllBtn", function () {
        let checkedDevices = [];
        $('input[name="device_checkbox"]:checked').each(function () {
            checkedDevices.push($(this).data("id"));
        });

        let url = root_url_restore_selected_devices;
        if (checkedDevices.length > 0) {
            swal.fire({
                title: "¿Estas seguro?",
                html:
                    "Quieres restaurar <b> " +
                    checkedDevices.length +
                    "</b> equipos a tu lista de inventario",
                icon: "warning",
                showCancelButton: true,
                showCloseButton: true,
                confirmButtonText: "Si, Restaurar",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                //width: 300,
                allowOutsideClick: false,
            }).then(function (result) {
                if (result.value) {
                    $.post(
                        url,
                        { devices_id: checkedDevices },
                        function (data) {
                            if (data.code == 1) {
                                table.DataTable().ajax.reload(null, true);
                                $("#dt").DataTable().ajax.reload(null, true);
                                console.log(data.msg + data.result);
                            }
                        },
                        "json"
                    );
                }
            });
        }
    });

    $(document).on("click", "#btn-refresh1", function (e) {
        $("#dt").DataTable().ajax.reload(null, true);
        //console.log(e);
    });

    $(document).on("click", "#btn-refresh2", function (e) {
        table.DataTable().ajax.reload(null, true);
        //console.log(e);
    });
});
