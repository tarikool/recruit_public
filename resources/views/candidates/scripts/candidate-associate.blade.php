<script>
    $(document).ready(function () {

        "use strict"

        const el_tabs = '#profile-tabs';
        const el_tabs_content = "#profile-tabs-content";
        let primaryCheckedAssignedJobs;

        // Check if two array are same
        function areArraysEqualSets(a1, a2) {
            let superSet = {};
            for (let i = 0; i < a1.length; i++) {
                const e = a1[i] + typeof a1[i];
                superSet[e] = 1;
            }

            for (let i = 0; i < a2.length; i++) {
                const e = a2[i] + typeof a2[i];
                if (!superSet[e]) {
                    return false;
                }
                superSet[e] = 2;
            }

            for (let e in superSet) {
                if (superSet[e] === 1) {
                    return false;
                }
            }

            return true;
        }

        $(document).on('click', '.checkbox-select-all', function () {
            $('.assignedJobsDiv input[type="checkbox"]').prop('checked', this.checked)
        });
        getAllSelectedJobs();


        $(document).on('click', "#candidateAssignJobBtn", function () {
            $.blockUI({
                css: {
                    border: 'none',
                    padding: '15px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .5,
                    color: '#fff'
                }
            });

            let checkedAssignedJobs = $('.custom-job-checkbox:checkbox:checked').map(function () {
                return this.value;
            }).get();

            if (areArraysEqualSets(primaryCheckedAssignedJobs, checkedAssignedJobs)) {
                swal("You didn't made any changes yet.", {icon: "warning"});
                $.unblockUI();
            } else {
                const data_route = $(this).data('route');
                let data_candidate = $(this).data('candidate');
                let paginationStartId = $("#paginationStartId").val();
                let paginationEndId = $("#paginationEndId").val();

                axios.post(data_route, {
                    'selectedAssignedJobs': checkedAssignedJobs,
                    'candidate': data_candidate,
                    'paginationStartId': paginationStartId,
                    'paginationEndId': paginationEndId
                }).then((response) => {
                    $.unblockUI();
                    console.log(response.data);
                    if (response.status == 202) {
                        swal(response.data.message, {icon: "warning"});
                    } else {
                        swal(response.data.message, {icon: "success"});
                        getAllSelectedJobs();
                    }
                }, (error) => {
                    $.unblockUI();
                    console.log(error);
                });
                console.log(checkedAssignedJobs.join(","));
            }

        });

        // Push all selected value into array
        function getAllSelectedJobs() {
            primaryCheckedAssignedJobs = $('.custom-job-checkbox:checkbox:checked').map(function () {
                return this.value;
            }).get();
        }

    })
</script>
