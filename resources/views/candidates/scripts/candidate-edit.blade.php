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
            let isChecked = checkbox.prop('checked');

            let allChecked = isChecked;
            let allDisabled = isChecked;
            $(".current_institution").prop('checked', !allChecked);
            $('.edu_end_month, .edu_end_year').prop("disabled", !allDisabled)

            checkbox.closest(".parent-container").prev().find('.edu_end_month, .edu_end_year').val("").prop("disabled", isChecked);
        });

        $(document).on('click', ".current_workplace", function () {
            let checkbox = $(this);
            checkbox.closest(".parent-container").prev().find('.end_month, .end_year').val("").prop("disabled", checkbox.prop('checked'));
        });


        $(document).on("click", ".existingEducationRowRemoveBtn", function () {
            let educationRemoveId = $(this).data('remove-id');
            let educationDataRoute = $(this).data('route');
            swal({
                title: "Are you sure?",
                text: "Selected Education Field Will Be Removed",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios({
                        method: 'DELETE',
                        url: educationDataRoute,
                        data: {
                            candidate_education_id: educationRemoveId
                        }
                    }).then(function (response) {
                        if (response.status == 200) {
                            swal({
                                title: "Success",
                                text: response.data.message,
                                icon: "info",
                            }).then((refresh) => {
                                let refreshVal = refresh ? location.reload() : null;
                            });
                            $(this).parents('.recordset').fadeOut('slow').remove();
                        }

                    })
                        .catch(function (error) {
                        })
                        .then(function () {
                        });

                }
            });
        });

        $(document).on("click", ".existingExperienceRowRemoveBtn", function () {
            let experienceRemoveId = $(this).data('remove-id');
            let experienceDataRoute = $(this).data('route');
            console.log("experienceRemoveId: ", experienceRemoveId);
            swal({
                title: "Are you sure?",
                text: "Selected Experience Field Will Be Removed",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    axios({
                        method: 'DELETE',
                        url: experienceDataRoute,
                        data: {
                            candidate_experience_id: experienceRemoveId
                        }
                    }).then(function (response) {
                        if (response.status == 200) {
                            swal({
                                title: "Success",
                                text: response.data.message,
                                icon: "info",
                            }).then((refresh) => {
                                let refreshVal = refresh ? location.reload() : null;
                            });
                            $(this).parents('.recordset').fadeOut('slow').remove();

                        }

                    })
                        .catch(function (error) {
                        })
                        .then(function () {
                        });
                }
            });
        });
    });

</script>
