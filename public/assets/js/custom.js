// var base_url = $("#base_url").val();
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

function handleServerError(formName, errors) {
    $("form[name='" + formName + "']")
        .find(".text-danger.serverside_error")
        .remove();
    $.each(errors, function (field, messages) {
        var $input = $("form[name='" + formName + "']").find(
            "[name='" + field + "']"
        );
        $.each(messages, function (index, message) {
            $input.after(
                '<span class="text-danger serverside_error">' +
                    message +
                    "</span>"
            );
        });
    });
}

$(".toggle-password").on("click", function () {
    const $icon = $(this);
    const $input = $icon.siblings("input");

    const isHidden = $input.attr("type") === "password";
    $input.attr("type", isHidden ? "text" : "password");

    // Set the correct icon
    if (isHidden) {
        $icon.removeClass("fa-eye").addClass("fa-eye-slash");
    } else {
        $icon.removeClass("fa-eye-slash").addClass("fa-eye");
    }
});

$(document).on("change", ".changestatus", function () {
    var $this = $(this);
    var previousStatus = $this.prop("checked");
    var datastatus = $this.is(":checked") ? "unblock" : "block";
    var dataId = $this.data("id");
    var datatable = $this.data("datatable");
    var text = $this.data("text");
    Swal.fire({
        title: "Are you sure?",
        text: "It will be " + datastatus + " " + text + " !",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        allowOutsideClick: false,
        confirmButtonText: "Yes, " + datastatus + " it!",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: STATUS_UPDATE_ROUTE,
                type: "POST",
                data: {
                    dataId: dataId,
                    datastatus: datastatus,
                },
                success: function (response) {
                    if (response.status) {
                        if (response.type == 1) {
                            Swal.fire("Unblock!", response.msg, "success");
                        } else {
                            Swal.fire("Block", response.msg, "success");
                        }
                    } else {
                        Swal.fire("Oops !", response.msg, "error");
                        if (previousStatus == false) {
                            $this.prop("checked", true);
                        } else {
                            $this.prop("checked", false);
                        }
                    }
                    $("#" + datatable)
                        .DataTable()
                        .ajax.reload();
                },
                error: function (xhr, status, error) {
                    Swal.fire(
                        "Error",
                        "Status process encountered an error. Your file is safe :)",
                        "error"
                    );
                },
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            if (previousStatus == false) {
                $this.prop("checked", true);
            } else {
                $this.prop("checked", false);
            }
        }
    });
});

$(document).on("click", ".delete_btn", function () {
    var dataId = $(this).data("id");
    var datatable = $(this).data("datatable");
    var url = $(this).data("url");
    var text = $(this).data("text");
    // var ajax_type = $(this).data("method") ?? "POST";
    Swal.fire({
        title: "Are you sure?",
        text: "you want to permanently delete this " + text + " ?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
        allowOutsideClick: false,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                type: "POST",
                data: { dataId: dataId },
                success: function (response) {
                    if (response.status == "success") {
                        Swal.fire("Deleted!", response.msg, "success");
                    } else {
                        Swal.fire(
                            "Error",
                            "Deletion failed. Your file is safe",
                            "error"
                        );
                    }
                    $("#" + datatable)
                        .DataTable()
                        .ajax.reload();
                },
                error: function (xhr, status, error) {
                    Swal.fire(
                        "Error",
                        "Deletion process encountered an error. Your file is safe :)",
                        "error"
                    );
                },
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
        }
    });
});
