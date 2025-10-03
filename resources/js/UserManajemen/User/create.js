$('input[type="checkbox"][name="roles[]"]').on("change", function () {
    let selectedRoles = $('input[name="roles[]"]:checked')
        .map(function () {
            return $(this).val();
        })
        .get();

    if (selectedRoles.includes("admin_unit") || selectedRoles.includes("pimpinan_unit")) {
        $("#unit-section").removeClass("d-none");
        $("#unit").prop("disabled", false);
    } else {
        $("#unit-section").addClass("d-none");
        $("#unit").prop("disabled", true);
    }
});
