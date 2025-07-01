// var base_url = $("#base_url").val();
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

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
