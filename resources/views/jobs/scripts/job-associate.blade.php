<script>
    $(document).ready(function () {

        "use strict";

        const el_tabs = '#profile-tabs';
        const el_tabs_content = "#profile-tabs-content";
        let primaryCheckedAssignedCandidates;

        // Check if two array are same
        function areArraysEqualSets(a1, a2) {
            let superSet = {};
            for (let i = 0; i < a1.length; i++) {
                const e = a1[i].candidate_id + "-" + a1[i].candidate_status;
                superSet[e] = 1;
            }

            for (let i = 0; i < a2.length; i++) {
                const e = a2[i].candidate_id + "-" + a2[i].candidate_status;

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
            $('.assignedCandidatesDiv input[type="checkbox"]').prop('checked', this.checked)
        });

        getAllSelectedCandidates();


        $(document).on('click', "#jobAssignBtn", function () {
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

            let candidateStatusNotFound = false;
            let checkedAssignedCandidates = $('.custom-candidate-checkbox:checkbox:checked').map(function () {
                let candidate_status = $("#candidate-status-"+this.value).val();
                if(candidate_status.length == 0){
                    candidateStatusNotFound = true;
                }
                return {candidate_id: this.value, candidate_status: candidate_status};
            }).get();

            if(candidateStatusNotFound){
                swal("{{__('Please select candidate status')}}", {icon: "error"});
                $.unblockUI();
                return false;
            }


            if (areArraysEqualSets(primaryCheckedAssignedCandidates, checkedAssignedCandidates)) {
                swal("You didn't make any changes yet.", {icon: "warning"});
                $.unblockUI();
            } else {
                const data_route = $(this).data('route');
                let jobId = $(this).data('job');
                let paginationStartId = $("#paginationStartId").val();
                let paginationEndId = $("#paginationEndId").val();

                axios.post(data_route, {
                    newCandidates: checkedAssignedCandidates,
                    job: jobId,
                    paginationStartId: paginationStartId,
                    paginationEndId: paginationEndId
                }).then((response) => {
                    $.unblockUI();

                    if (response.status == 202) {
                        swal(response.data.message, {icon: "warning"});
                    } else {
                        swal(response.data.message, {icon: "success"});
                        getAllSelectedCandidates();
                    }
                }, (error) => {
                    $.unblockUI();
                    console.log(error);
                });

            }

        });

        // Push all selected value into array
        function getAllSelectedCandidates() {
            primaryCheckedAssignedCandidates = $('.custom-candidate-checkbox:checkbox:checked').map(function () {
                let candidate_status = $("#candidate-status-"+this.value).val();
                return {candidate_id: this.value, candidate_status: candidate_status};
            }).get();
        }

    })
</script>
