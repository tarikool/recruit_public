<script>
    $(document).ready(function () {

        "use strict"

        $("#educationContainer").czMore({
            onAdd: function () {
            },
            styleOverride: true
        });
        $("#experienceContainer").czMore({
            onAdd: function () {
            },
            styleOverride: true
        });

        $(document).on('click', ".current_institution", function () {
            let checkbox = $(this);
            checkbox.closest(".parent-container").prev().find('.edu_end_month, .edu_end_year').val("").prop("disabled", checkbox.prop('checked'));
        });

        $(document).on('click', ".current_workplace", function () {
            let checkbox = $(this);
            checkbox.closest(".parent-container").prev().find('.end_month, .end_year').val("").prop("disabled", checkbox.prop('checked'));
        });

    });

</script>
